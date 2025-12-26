<?php
namespace local_membership\task;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/local/membership/braintree/paypal.php'); // get_paypal_token()

class sync_paypal_subscriptions extends \core\task\scheduled_task {

    // Rolling-cursor defaults.
    private const LOOKBACK       = 3 * DAYSECS;      // overlap for normal mode
    private const SLICE          = 30 * DAYSECS;     // list window size
    private const CFGKEY_CURSOR  = 'sync_pp_last_utc';

    // TEMP: force last N days (set to 0 to disable).
    private const TEMP_FORCE_LAST_DAYS = 0;

    // Safety: hard time budget per run (seconds). Keep below cron task timeout.
    private const TIME_BUDGET_SEC = 105;

    // Safety: cap refresh batch size when re-fetching “touched” rows in forced mode.
    private const REFRESH_LIMIT = 250;

    public function get_name() {
        return 'Sync PayPal subscriptions → pp_subscriptions';
    }

    public function execute() {
        global $DB;

        $factory = \core\lock\lock_config::get_lock_factory('cron');
        $lock = $factory->get_lock('local_membership_sync_pp', 3600);
        if (!$lock) { mtrace("❌ PayPal sync: could not acquire lock."); return; }

        // Ensure lock is released even if the process is terminated.
        $released = false;
        register_shutdown_function(function() use (&$lock, &$released) {
            if (!$released && $lock) {
                try { $lock->release(); } catch (\Throwable $e) {}
            }
        });

        $start = microtime(true);

        try {
            @set_time_limit(0);

            $access = get_paypal_token();
            if (empty($access)) { mtrace("💥 PayPal: empty access token"); return; }

            $sandbox = (bool) get_config('local_membership', 'paypal_sandbox');
            $base    = $sandbox ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com';

            // Decide window.
            $now    = time();
            $forced = false;
            $from   = 0;
            $to     = $now;

            if (self::TEMP_FORCE_LAST_DAYS > 0) {
                $from   = $now - (self::TEMP_FORCE_LAST_DAYS * DAYSECS);
                $to     = $now;
                $forced = true;
                mtrace("🟡 PayPal FORCED window (last ".self::TEMP_FORCE_LAST_DAYS." days): ".gmdate('c',$from)." → ".gmdate('c',$to));
            } else {
                $last = (int) get_config('local_membership', self::CFGKEY_CURSOR);
                if ($last <= 0) $last = $now - 365*DAYSECS;
                $from = max(0, $last - self::LOOKBACK);
                $to   = $now;
                mtrace("🟢 PayPal normal window: ".gmdate('c',$from)." → ".gmdate('c',$to));
            }

            $totalListed = 0; $totalDetailed = 0; $totalUpsert = 0;
            $seenIds = [];  // avoid re-fetching same id
            $cands   = [];  // candidates for payment_user_links

            // PHASE A: list-by-created windows.
            for ($ws = $from; $ws < $to; $ws += self::SLICE) {
                // Time budget guard.
                if ((microtime(true) - $start) > self::TIME_BUDGET_SEC) {
                    mtrace("⏹ Time budget reached during list phase; saving progress.");
                    break;
                }

                $we = min($ws + self::SLICE, $to);
                $startIso = gmdate('Y-m-d\TH:i:s\Z', $ws);
                $endIso   = gmdate('Y-m-d\TH:i:s\Z', $we);
                mtrace("PayPal window(list): $startIso → $endIso");

                $page = 1; $pagesize = 20;
                while (true) {
                    if ((microtime(true) - $start) > self::TIME_BUDGET_SEC) {
                        mtrace("⏹ Time budget reached inside page loop; breaking.");
                        break 2; // out of both while and for
                    }

                    $q = [
                        'created_after'  => $startIso,
                        'created_before' => $endIso,
                        'page_size'      => $pagesize,
                        'page'           => $page,
                    ];
                    $list = $this->curl_get_json($base . '/v1/billing/subscriptions?' . http_build_query($q), $access);
                    if (!$list['ok']) { mtrace("  • list fail HTTP {$list['http']}"); break; }

                    $items = (!empty($list['json']['subscriptions']) && is_array($list['json']['subscriptions']))
                        ? $list['json']['subscriptions'] : [];
                    $count = count($items);
                    $totalListed += $count;
                    if ($count === 0) break;

                    foreach ($items as $li) {
                        if ((microtime(true) - $start) > self::TIME_BUDGET_SEC) { mtrace("⏹ Budget reached mid-page."); break 3; }
                        $sid = $li['id'] ?? null;
                        if (!$sid || isset($seenIds[$sid])) continue;

                        $det = $this->curl_get_json($base . '/v1/billing/subscriptions/' . rawurlencode($sid), $access);
                        if (!$det['ok']) { mtrace("    • details fail $sid HTTP {$det['http']}"); continue; }

                        $j   = $det['json'];
                        $row = $this->map_details_to_row($j);
                        if (!$row) continue;

                        if ($this->upsert_pp($DB, $row)) $totalUpsert++;
                        $totalDetailed++;
                        $seenIds[$sid] = true;

                        // collect link candidate
                        $subscriber = $j['subscriber'] ?? [];
                        $name = trim(($subscriber['name']['given_name'] ?? '') . ' ' . ($subscriber['name']['surname'] ?? '')) ?: null;
                        $cands[] = [
                            'email'                    => $this->norm_email($row->subscriber_email ?? ''),
                            'provider_user_id'         => (string)($row->subscriber_payer_id ?? ''),
                            'provider_subscription_id' => (string)($row->subscription_id ?? ''),
                            'name'                     => $name,
                        ];

                        usleep(150000);
                    }

                    if ($count < $pagesize) break;
                    $page++;
                }
                usleep(200000);
            }

            // PHASE B (forced only): refresh “touched” local rows, but in a capped batch.
            if ($forced && (microtime(true) - $start) <= self::TIME_BUDGET_SEC) {
                $fromMy = gmdate('Y-m-d H:i:s', $from);
                $toMy   = gmdate('Y-m-d H:i:s', $to);

                $touch = $DB->get_records_sql("
                    SELECT subscription_id,
                           GREATEST(
                               COALESCE(status_update_time, '1970-01-01 00:00:00'),
                               COALESCE(last_payment_time, '1970-01-01 00:00:00'),
                               COALESCE(next_billing_time, '1970-01-01 00:00:00'),
                               COALESCE(updated_at,       '1970-01-01 00:00:00')
                           ) AS touchts
                      FROM {pp_subscriptions}
                     WHERE GREATEST(
                               COALESCE(status_update_time, '1970-01-01 00:00:00'),
                               COALESCE(last_payment_time, '1970-01-01 00:00:00'),
                               COALESCE(next_billing_time, '1970-01-01 00:00:00'),
                               COALESCE(updated_at,       '1970-01-01 00:00:00')
                           ) BETWEEN ? AND ?
                  ORDER BY touchts DESC
                     LIMIT " . (int)self::REFRESH_LIMIT . "
                ", [$fromMy, $toMy]);

                mtrace("PayPal refresh touched rows (capped): ".count($touch));

                foreach ($touch as $t) {
                    if ((microtime(true) - $start) > self::TIME_BUDGET_SEC) { mtrace("⏹ Budget reached in refresh; stopping."); break; }

                    $sid = $t->subscription_id ?? null;
                    if (!$sid || isset($seenIds[$sid])) continue;

                    $det = $this->curl_get_json($base . '/v1/billing/subscriptions/' . rawurlencode($sid), $access);
                    if (!$det['ok']) { mtrace("    • details fail (refresh) $sid HTTP {$det['http']}"); continue; }

                    $j   = $det['json'];
                    $row = $this->map_details_to_row($j);
                    if (!$row) continue;

                    if ($this->upsert_pp($DB, $row)) $totalUpsert++;
                    $totalDetailed++;
                    $seenIds[$sid] = true;

                    // link candidate
                    $subscriber = $j['subscriber'] ?? [];
                    $name = trim(($subscriber['name']['given_name'] ?? '') . ' ' . ($subscriber['name']['surname'] ?? '')) ?: null;
                    $cands[] = [
                        'email'                    => $this->norm_email($row->subscriber_email ?? ''),
                        'provider_user_id'         => (string)($row->subscriber_payer_id ?? ''),
                        'provider_subscription_id' => (string)($row->subscription_id ?? ''),
                        'name'                     => $name,
                    ];

                    usleep(100000);
                }
            }

            // Link table sync.
            $this->link_batch($DB, 'paypal', $cands);

            // Advance cursor only after successful run.
            set_config(self::CFGKEY_CURSOR, $now, 'local_membership');

            mtrace("✅ PayPal sync done. listed=$totalListed, detailed=$totalDetailed, upserted=$totalUpsert");

        } catch (\Throwable $e) {
            mtrace("💥 PayPal sync exception: " . $e->getMessage());
        } finally {
            try { $lock->release(); $released = true; } catch (\Throwable $e) {}
        }
    }

    /* ---------- helpers ---------- */

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

    private function map_details_to_row(array $j): ?\stdClass {
        if (empty($j['id'])) return null;
        $billing    = $j['billing_info'] ?? [];
        $lastPay    = $billing['last_payment'] ?? [];
        $outBal     = $billing['outstanding_balance'] ?? [];
        $subscriber = $j['subscriber'] ?? [];
        $name       = $subscriber['name'] ?? [];
        $email      = $subscriber['email_address'] ?? null;

        $r = new \stdClass();
        $r->subscription_id        = (string)$j['id'];
        $r->plan_id                = $j['plan_id'] ?? null;
        $r->status                 = $j['status'] ?? null;
        $r->status_update_time     = $this->iso_to_mysql($j['status_update_time'] ?? null);
        $r->start_time             = $this->iso_to_mysql($j['start_time'] ?? null);
        $r->create_time            = $this->iso_to_mysql($j['create_time'] ?? null);
        $r->next_billing_time      = $this->iso_to_mysql($billing['next_billing_time'] ?? null);
        $r->last_payment_time      = $this->iso_to_mysql($lastPay['time'] ?? null);
        $r->last_payment_amount    = isset($lastPay['amount']['value']) ? (float)$lastPay['amount']['value'] : null;
        $r->last_payment_currency  = $lastPay['amount']['currency_code'] ?? null;
        $r->failed_payment_count   = isset($billing['failed_payment_count']) ? (int)$billing['failed_payment_count'] : null;
        $r->outstanding_balance    = isset($outBal['value']) ? (float)$outBal['value'] : null;
        $r->outstanding_currency   = $outBal['currency_code'] ?? null;
        $r->subscriber_payer_id    = $subscriber['payer_id'] ?? null;
        $r->subscriber_email       = $email ? substr($email, 0, 254) : null;
        $r->subscriber_given_name  = $name['given_name'] ?? null;
        $r->subscriber_surname     = $name['surname'] ?? null;
        $r->moodle_userid          = null;
        $r->raw_json               = json_encode($j, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        $r->updated_at             = gmdate('Y-m-d H:i:s');
        return $r;
    }

    private function upsert_pp(\moodle_database $DB, \stdClass $r): bool {
        $fields = [
            'subscription_id','plan_id','status','status_update_time','start_time','create_time',
            'next_billing_time','last_payment_time','last_payment_amount','last_payment_currency',
            'failed_payment_count','outstanding_balance','outstanding_currency',
            'subscriber_payer_id','subscriber_email','subscriber_given_name','subscriber_surname',
            'moodle_userid','raw_json','updated_at',
        ];
        $ph = implode(',', array_fill(0, count($fields), '?'));
        $updates = implode(',', array_map(fn($f)=>"$f=VALUES($f)", $fields));
        $sql = "INSERT INTO {pp_subscriptions} (".implode(',',$fields).") VALUES ($ph) ON DUPLICATE KEY UPDATE $updates";
        $params = array_map(fn($f)=>$r->$f ?? null, $fields);
        try { $DB->execute($sql, $params); return true; } catch (\Throwable $e) { mtrace("  • upsert {$r->subscription_id}: ".$e->getMessage()); return false; }
    }

    /* --------- link table helpers --------- */

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
                 WHERE deleted = 0
                   AND email <> ''
                   AND LOWER(email) $insql
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
                $uMap[$d['email']],
                $provider,
                $d['pid'],
                $d['email'],
                $d['name'],
                $d['sid'] ?: null,
            ]);
        }
    }
}
