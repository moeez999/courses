<?php
namespace local_membership\task;

defined('MOODLE_INTERNAL') || die();

class sync_patreon_members extends \core\task\scheduled_task {

    private const LOOKBACK      = 3 * DAYSECS;          // overlap
    private const CFGKEY_CURSOR = 'sync_pt_last_utc';
    // ===== BEGIN TEMP FORCE LAST 10 DAYS =====
    private const TEMP_FORCE_LAST_DAYS = 0;            // set to 0 after catch-up
    // ===== END TEMP FORCE LAST 10 DAYS =====

    public function get_name() {
        return 'Sync Patreon members → pt_members';
    }

    public function execute() {
        global $DB;

        $factory = \core\lock\lock_config::get_lock_factory('cron');
        $lock = $factory->get_lock('local_membership_sync_pt', 3600);
        if (!$lock) { mtrace("❌ Patreon sync: could not acquire lock."); return; }

        try {
            @set_time_limit(0);

            $token = $this->get_access_token_from_db($DB);
            if (!$token) { mtrace("💥 No Patreon access token in patreon_oauth2_tokens"); return; }

            $campaignId = $this->get_campaign_id($token);
            if (!$campaignId) { mtrace("💥 Could not resolve Patreon campaign id"); return; }

            $now = time(); $forced = false; $from=0; $to=$now;
            // ===== BEGIN TEMP FORCE LAST 10 DAYS =====
            if (self::TEMP_FORCE_LAST_DAYS > 0) {
                $from = $now - (self::TEMP_FORCE_LAST_DAYS * DAYSECS);
                $to   = $now;
                $forced = true;
                mtrace("🟡 Patreon FORCED window (last ".self::TEMP_FORCE_LAST_DAYS." days): ".gmdate('c',$from)." → ".gmdate('c',$to));
            } else {
            // ===== END TEMP FORCE LAST 10 DAYS =====
                $last = (int) get_config('local_membership', self::CFGKEY_CURSOR);
                if ($last <= 0) $last = $now - 365*DAYSECS;
                $from = max(0, $last - self::LOOKBACK);
                $to   = $now;
                mtrace("🟢 Patreon normal window: ".gmdate('c',$from)." → ".gmdate('c',$to));
            }

            $pageSize = 100;
            $cursor   = null;
            $seen     = 0; $upserted = 0;
            $cands    = []; // for payment_user_links

            $baseUrl  = "https://www.patreon.com/api/oauth2/v2/campaigns/" . rawurlencode($campaignId) . "/members";
            $queryStatic = [
                'page[count]'        => $pageSize,
                'fields[member]'     => implode(',', [
                    'campaign_lifetime_support_cents',
                    'currently_entitled_amount_cents',
                    'last_charge_date',
                    'last_charge_status',
                    'lifetime_support_cents',
                    'note',
                    'patron_status',
                    'pledge_cadence',
                    'pledge_relationship_start',
                    'email',
                ]),
                'fields[user]'       => implode(',', ['thumb_url','image_url','full_name']),
                'fields[address]'    => implode(',', ['city','state','line_1','line_2','addressee','postal_code','phone_number']),
                'include'            => implode(',', ['address','campaign','user','currently_entitled_tiers']),
            ];

            do {
                $q = $queryStatic;
                if (!empty($cursor)) $q['page[cursor]'] = $cursor;

                $url  = $baseUrl . '?' . http_build_query($q, '', '&', PHP_QUERY_RFC3986);
                $resp = $this->curl_get_json($url, $token);
                if (!$resp['ok']) {
                    if ($resp['http'] === 401) mtrace("🔑 401 Unauthorized. Refresh Patreon tokens.");
                    else mtrace("⚠️ Patreon list HTTP {$resp['http']} body={$resp['raw']}");
                    break;
                }

                $data     = $resp['json'];
                $included = isset($data['included']) && is_array($data['included']) ? $data['included'] : [];
                $items    = isset($data['data']) && is_array($data['data']) ? $data['data'] : [];

                foreach ($items as $member) {
                    $attr  = $member['attributes'] ?? [];
                    $d1    = !empty($attr['pledge_relationship_start']) ? strtotime($attr['pledge_relationship_start']) : null;
                    $d2    = !empty($attr['last_charge_date']) ? strtotime($attr['last_charge_date']) : null;
                    $touch = max($d1 ?: 0, $d2 ?: 0);

                    // Only process members whose "touch" falls inside our window (forced or normal)
                    if ($touch === 0 || $touch < $from || $touch > $to) continue;

                    $row = $this->map_member_to_row($member, $included, $campaignId);
                    if (!$row) continue;

                    if ($this->upsert_pt($DB, $row)) $upserted++;
                    $seen++;

                    // Link candidate
                    $email = $row->email ?? null;
                    if ($email) {
                        $pid = $row->user_id ?: $row->member_id; // prefer user_id, else member_id
                        $name = $row->full_name ?? null;
                        $cands[] = [
                            'email'                    => $this->norm_email($email),
                            'provider_user_id'         => (string)$pid,
                            'provider_subscription_id' => (string)($row->member_id ?? ''),
                            'name'                     => $name,
                        ];
                    }

                    usleep(150000);
                }

                $cursor = $data['meta']['pagination']['cursors']['next'] ?? null;
                usleep(250000);
            } while (!empty($cursor));

            // Link table updates
            $this->link_batch($DB, 'patreon', $cands);

            // Advance cursor
            set_config(self::CFGKEY_CURSOR, $now, 'local_membership');

            mtrace("✅ Patreon sync done. seen=$seen, upserted=$upserted");

        } catch (\Throwable $e) {
            mtrace("💥 Patreon sync exception: " . $e->getMessage());
        } finally {
            $lock->release();
        }
    }

    /* =============================== Helpers =============================== */

    private function get_access_token_from_db(\moodle_database $DB): ?string {
        $rec = $DB->get_record_sql("SELECT accesstoken FROM {patreon_oauth2_tokens} ORDER BY timestamp DESC LIMIT 1");
        return $rec && !empty($rec->accesstoken) ? $rec->accesstoken : null;
    }

    private function get_campaign_id(string $accessToken): ?string {
        $url  = 'https://www.patreon.com/api/oauth2/v2/campaigns?page[count]=1';
        $resp = $this->curl_get_json($url, $accessToken);
        if (!$resp['ok']) return null;
        $data = $resp['json'];
        return !empty($data['data'][0]['id']) ? (string)$data['data'][0]['id'] : null;
    }

    private function curl_get_json(string $url, string $accessToken): array {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer {$accessToken}",
                "Content-Type: application/json",
                "Accept: application/json",
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT        => 60,
        ]);
        $raw  = curl_exec($ch);
        $http = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);
        if ($err) return ['ok'=>false,'http'=>0,'json'=>null,'raw'=>"curl: $err"];
        if ($http < 200 || $http >= 300 || !$raw) return ['ok'=>false,'http'=>$http,'json'=>null,'raw'=>(string)$raw];
        $json = json_decode($raw, true);
        if (!is_array($json)) return ['ok'=>false,'http'=>$http,'json'=>null,'raw'=>(string)$raw];
        return ['ok'=>true,'http'=>$http,'json'=>$json,'raw'=>(string)$raw];
    }

    private function iso_to_mysql(?string $s): ?string {
        if (!$s) return null;
        $t = strtotime($s);
        return $t ? gmdate('Y-m-d H:i:s', $t) : null;
    }

    private function pick_included(array $included, string $type, string $id): ?array {
        foreach ($included as $it) {
            if (($it['type'] ?? '') === $type && (string)($it['id'] ?? '') === $id) return $it;
        }
        return null;
    }

    private function map_member_to_row(array $member, array $included, string $campaignId): ?\stdClass {
        if (empty($member['id'])) return null;

        $attr      = $member['attributes'] ?? [];
        $rels      = $member['relationships'] ?? [];
        $userRel   = $rels['user']['data'] ?? null;
        $addrRel   = $rels['address']['data'] ?? null;

        $userId    = $userRel['id'] ?? null;
        $userInc   = $userId ? $this->pick_included($included, 'user', $userId) : null;
        $userAttr  = $userInc['attributes'] ?? [];
        $fullName  = $userAttr['full_name'] ?? null;

        $firstName = null; $lastName = null;
        if (!empty($fullName)) {
            $parts = preg_split('/\s+/', trim($fullName), 2);
            $firstName = $parts[0] ?? null;
            $lastName  = $parts[1] ?? null;
        }

        $addrAttr  = [];
        if (!empty($addrRel['id'])) {
            $addrInc  = $this->pick_included($included, 'address', $addrRel['id']);
            $addrAttr = $addrInc['attributes'] ?? [];
        }

        $r = new \stdClass();
        $r->member_id                       = (string)$member['id'];
        $r->campaign_id                     = (string)$campaignId;
        $r->user_id                         = $userId ? (string)$userId : null;
        $r->email                           = $attr['email'] ?? null;
        $r->full_name                       = $fullName;
        $r->first_name                      = $firstName;
        $r->last_name                       = $lastName;
        $r->is_follower                     = null;
        $r->note                            = $attr['note'] ?? null;
        $r->patron_status                   = $attr['patron_status'] ?? 'unknown';
        $r->pledge_relationship_start       = $this->iso_to_mysql($attr['pledge_relationship_start'] ?? null);
        $r->last_charge_date                = $this->iso_to_mysql($attr['last_charge_date'] ?? null);
        $r->last_charge_status              = $attr['last_charge_status'] ?? null;
        $r->last_charge_cents               = null;
        $r->next_charge_date                = null;
        $r->currently_entitled_amount_cents = isset($attr['currently_entitled_amount_cents']) ? (int)$attr['currently_entitled_amount_cents'] : null;
        $r->lifetime_support_cents          = isset($attr['lifetime_support_cents']) ? (int)$attr['lifetime_support_cents'] : null;
        $r->will_pay_amount_cents           = null;
        $r->patron_currency                 = null;

        $r->address_line1                   = $addrAttr['line_1']       ?? null;
        $r->address_line2                   = $addrAttr['line_2']       ?? null;
        $r->address_city                    = $addrAttr['city']         ?? null;
        $r->address_state                   = $addrAttr['state']        ?? null;
        $r->address_postal_code             = $addrAttr['postal_code']  ?? null;
        $r->address_country_code            = null;
        $r->address_phone                   = $addrAttr['phone_number'] ?? null;

        $r->moodle_userid                   = null;
        $r->raw_json                        = json_encode(['member'=>$member,'included'=>$included], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        return $r;
    }

    private function upsert_pt(\moodle_database $DB, \stdClass $r): bool {
        $fields = [
            'member_id','campaign_id','user_id','email','full_name','first_name','last_name',
            'is_follower','note','patron_status','pledge_relationship_start','last_charge_date',
            'last_charge_status','last_charge_cents','next_charge_date',
            'currently_entitled_amount_cents','lifetime_support_cents','will_pay_amount_cents',
            'patron_currency','address_line1','address_line2','address_city','address_state',
            'address_postal_code','address_country_code','address_phone','moodle_userid','raw_json',
        ];
        $ph = implode(',', array_fill(0, count($fields), '?'));
        $updates = implode(',', array_map(fn($f)=>"$f=VALUES($f)", array_diff($fields, ['member_id'])));
        $sql = "INSERT INTO {pt_members} (".implode(',',$fields).") VALUES ($ph) ON DUPLICATE KEY UPDATE $updates";
        $params = array_map(fn($f)=>$r->$f ?? null, $fields);
        try { $DB->execute($sql, $params); return true; } catch (\Throwable $e) { mtrace("  • upsert PT {$r->member_id}: ".$e->getMessage()); return false; }
    }

    private function norm_email(?string $s): string {
        $s = trim((string)$s);
        return $s === '' ? '' : mb_strtolower($s);
    }

    private function fetch_userids_by_email(\moodle_database $DB, array $emails): array {
        $map = [];
        if (!$emails) return $map;
        $emails = array_values(array_unique(array_filter($emails, fn($e)=>$e!=='')));

        $chunk = 1000;
        for ($i=0; $i<count($emails); $i+=$chunk) {
            $slice = array_slice($emails, $i, $chunk);
            list($insql, $params) = $DB->get_in_or_equal($slice, SQL_PARAMS_QM, '', false);
            $recs = $DB->get_records_sql("
                SELECT id, LOWER(email) AS e
                  FROM {user}
                 WHERE deleted = 0 AND email <> '' AND LOWER(email) $insql
            ", $params);
            foreach ($recs as $r) $map[$r->e] = (int)$r->id;
        }
        return $map;
    }

    private function link_batch(\moodle_database $DB, string $provider, array $cands): void {
        $dedup = [];
        foreach ($cands as $c) {
            $email = $this->norm_email($c['email'] ?? '');
            $pid   = (string)($c['provider_user_id'] ?? '');
            if ($email === '' || $pid === '') continue;
            $dedup[$email.'|'.$pid] = [
                'email' => $email,
                'pid'   => $pid,
                'sid'   => (string)($c['provider_subscription_id'] ?? ''),
                'name'  => $c['name'] ?? null,
            ];
        }
        if (!$dedup) return;

        $emails = array_values(array_unique(array_map(fn($x)=>$x['email'], $dedup)));
        $uMap   = $this->fetch_userids_by_email($DB, $emails);

        $sql = "INSERT INTO {payment_user_links}
                (moodle_userid, provider, provider_user_id, provider_email, provider_name, provider_subscription_id,
                 match_method, match_confidence, is_primary, notes)
                VALUES (?, ?, ?, ?, ?, ?, 'email', 90, 1, NULL)
                ON DUPLICATE KEY UPDATE
                  moodle_userid = VALUES(moodle_userid),
                  provider_email = COALESCE(VALUES(provider_email), provider_email),
                  provider_name = COALESCE(VALUES(provider_name), provider_name),
                  provider_subscription_id = COALESCE(VALUES(provider_subscription_id), provider_subscription_id),
                  last_seen_at = NOW(),
                  match_method = IF(match_method='id', match_method, VALUES(match_method)),
                  match_confidence = GREATEST(match_confidence, VALUES(match_confidence))";

        foreach ($dedup as $d) {
            if (!isset($uMap[$d['email']])) continue;
            $DB->execute($sql, [
                $uMap[$d['email']], $provider, $d['pid'], $d['email'], $d['name'], $d['sid'] ?: null,
            ]);
        }
    }
}
