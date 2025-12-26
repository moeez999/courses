<?php
namespace local_membership\task;

defined('MOODLE_INTERNAL') || die();

use Braintree\Gateway;

class sync_braintree_subscriptions extends \core\task\scheduled_task {

    private const LOOKBACK      = 3 * DAYSECS;      // normal overlap
    private const CFGKEY_CURSOR = 'sync_bt_last_utc';
    private const SLICE_SEC     = 14 * DAYSECS;     // search window size (Braintree allows broad)
    // ===== BEGIN TEMP FORCE LAST 10 DAYS =====
    private const TEMP_FORCE_LAST_DAYS = 0;        // set to 0 after manual catch-up
    // ===== END TEMP FORCE LAST 10 DAYS =====

    public function get_name() {
        return 'Sync Braintree subscriptions → bt_subscriptions';
    }

    public function execute() {
        global $DB, $CFG;

        $factory = \core\lock\lock_config::get_lock_factory('cron');
        $lock = $factory->get_lock('local_membership_sync_bt', 3600);
        if (!$lock) { mtrace("❌ Braintree sync: could not acquire lock."); return; }

        try {
            @set_time_limit(0);
            require_once($CFG->dirroot . '/local/membership/sdk/braintree/lib/Braintree.php');

            // Use your helper if available, else inline gateway:
            if (function_exists('get_braintree_gateway')) {
                $gateway = get_braintree_gateway();
            } else {
                $gateway = new Gateway([
                    'environment' => 'production',
                    'merchantId'  => '8p7h9vxrqn7tg3y2',
                    'publicKey'   => 'jxbsqpmck8k8bh68',
                    'privateKey'  => 'fff157d00e1bd11f8f3c2f1cded28945',
                ]);
            }

            $now = time();
            $forced = false;
            $from = 0; $to = $now;

            // ===== BEGIN TEMP FORCE LAST 10 DAYS =====
            if (self::TEMP_FORCE_LAST_DAYS > 0) {
                $from   = $now - (self::TEMP_FORCE_LAST_DAYS * DAYSECS);
                $to     = $now;
                $forced = true;
                mtrace("🟡 Braintree FORCED window (last ".self::TEMP_FORCE_LAST_DAYS." days): ".gmdate('c',$from)." → ".gmdate('c',$to));
            } else {
            // ===== END TEMP FORCE LAST 10 DAYS =====
                $last = (int) get_config('local_membership', self::CFGKEY_CURSOR);
                if ($last <= 0) $last = $now - 365*DAYSECS;
                $from = max(0, $last - self::LOOKBACK);
                $to   = $now;
                mtrace("🟢 Braintree normal window: ".gmdate('c',$from)." → ".gmdate('c',$to));
            }

            $totalSeen = 0; $totalUpsert = 0; $errors = 0;
            $seenIds = [];
            $cands = []; // for payment_user_links

            $startDT = new \DateTime('@'.$from); $startDT->setTimezone(new \DateTimeZone('UTC'));
            $endDT   = new \DateTime('@'.$to);   $endDT->setTimezone(new \DateTimeZone('UTC'));

            // We perform TWO searches to cover both new and updated subscriptions.
            $collections = [];

            // A) createdAt in window
            $collections[] = $gateway->subscription()->search(function($s) use ($startDT, $endDT) {
                $s->createdAt()->between($startDT, $endDT);
            });

            // B) updatedAt in window (not all SDKs support this; catch and skip if not available)
            try {
                $collections[] = $gateway->subscription()->search(function($s) use ($startDT, $endDT) {
                    $s->updatedAt()->between($startDT, $endDT);
                });
            } catch (\Throwable $e) {
                mtrace("⚠️ Braintree: updatedAt search not supported by this SDK, skipping.");
            }

            foreach ($collections as $col) {
                foreach ($col as $sub) {
                    $sid = (string)($sub->id ?? '');
                    if ($sid === '' || isset($seenIds[$sid])) { continue; }
                    $seenIds[$sid] = true;
                    $totalSeen++;

                    // Best-effort enrich: payment method + customer
                    $pm = null; $cust = null; $custId = null;
                    try {
                        if (!empty($sub->paymentMethodToken)) {
                            $pm = $gateway->paymentMethod()->find($sub->paymentMethodToken);
                            if (!empty($pm->customerId)) { $custId = $pm->customerId; }
                        }
                    } catch (\Throwable $e) {}
                    try {
                        if (!$custId && !empty($sub->customerId)) { $custId = $sub->customerId; }
                        if ($custId) { $cust = $gateway->customer()->find($custId); }
                    } catch (\Throwable $e) {}

                    $row = $this->map_to_row($sub, $cust, $pm);
                    if (!$row) { continue; }

                    if ($this->upsert_bt($DB, $row)) {
                        $totalUpsert++;
                    } else {
                        $errors++;
                    }

                    // Link candidate
                    $email = $row->email ?? null;
                    if ($email) {
                        $name = trim(($row->first_name ?? '').' '.($row->last_name ?? '')) ?: null;
                        $cands[] = [
                            'email'                    => $this->norm_email($email),
                            'provider_user_id'         => (string)($row->customer_id ?? ''),
                            'provider_subscription_id' => (string)($row->subscription_id ?? ''),
                            'name'                     => $name,
                        ];
                    }

                    usleep(50000);
                }
            }

            // Link table updates
            $this->link_batch($DB, 'braintree', $cands);

            // Advance cursor
            set_config(self::CFGKEY_CURSOR, $now, 'local_membership');

            mtrace("✅ Braintree sync done. seen=$totalSeen, upserted=$totalUpsert, errors=$errors");

        } catch (\Throwable $e) {
            mtrace("💥 Braintree sync exception: " . $e->getMessage());
        } finally {
            $lock->release();
        }
    }
    
    
    private function tr(?string $s, int $max): ?string {
    if ($s === null) return null;
    $s = (string)$s;
    if (mb_strlen($s, 'UTF-8') <= $max) return $s;
    return mb_substr($s, 0, $max, 'UTF-8');
}
private function nz(?string $s, string $fallback): string {
    $s = trim((string)$s);
    return $s === '' ? $fallback : $s;
}

    /* =============================== Helpers =============================== */

    private function to_date($d): ?string {
        if (!$d) return null;
        if ($d instanceof \DateTimeInterface) {
            $copy = (new \DateTimeImmutable('@'.$d->getTimestamp()))->setTimezone(new \DateTimeZone('UTC'));
            return $copy->format('Y-m-d');
        }
        if (method_exists($d, 'format')) {
            return gmdate('Y-m-d', strtotime((string)$d));
        }
        return null;
    }

    private function to_datetime($d): ?string {
        if (!$d) return null;
        if ($d instanceof \DateTimeInterface) {
            $copy = (new \DateTimeImmutable('@'.$d->getTimestamp()))->setTimezone(new \DateTimeZone('UTC'));
            return $copy->format('Y-m-d H:i:s');
        }
        if (method_exists($d, 'format')) {
            return gmdate('Y-m-d H:i:s', strtotime((string)$d));
        }
        return null;
    }

    private function detect_payment_meta($pm): array {
        $type=null; $subtype=null; $last4=null; $expM=null; $expY=null;
        if (!$pm) return [null,null,null,null,null];

        $cls = is_object($pm) ? strtolower((new \ReflectionClass($pm))->getShortName()) : '';
        if (strpos($cls, 'creditcard') !== false) {
            $type='credit_card'; $subtype=$pm->cardType ?? null;
            $last4 = $pm->last4 ?? null;
            $expM  = isset($pm->expirationMonth) ? (int)$pm->expirationMonth : null;
            $expY  = isset($pm->expirationYear)  ? (int)$pm->expirationYear  : null;
        } elseif (strpos($cls, 'paypal') !== false) {
            $type='paypal'; $subtype='PayPal';
        } elseif (strpos($cls, 'venmo') !== false) {
            $type='venmo'; $subtype='Venmo';
        } elseif (strpos($cls, 'applepay') !== false) {
            $type='apple_pay'; $subtype='Apple Pay';
        } elseif (strpos($cls, 'googlepay') !== false) {
            $type='google_pay'; $subtype='Google Pay';
        }
        return [$type,$subtype,$last4,$expM,$expY];
    }

   private function map_to_row($sub, $customer, $pm): ?\stdClass {
    if (empty($sub) || empty($sub->id)) return null;


    $customerId = null;
    if (is_object($pm) && isset($pm->customerId))        $customerId = $pm->customerId;
    if (!$customerId && isset($sub->customerId))         $customerId = $sub->customerId;

    // 👇 add this fallback so DB never gets NULL for customer_id
    if (!$customerId) {
        // stable surrogate; won’t collide with real ids
        $customerId = 'sub:' . (string)$sub->id;
    }

    // $customerId = null;
    // if (is_object($pm) && isset($pm->customerId))        $customerId = $pm->customerId;
    // if (!$customerId && isset($sub->customerId))         $customerId = $sub->customerId;

    [$pmtype,$pmsubtype,$cardLast4,$cardExpM,$cardExpY] = $this->detect_payment_meta($pm);

    $paypalEmail = null; $paypalPayer = null; $venmoUser = null;
    if (is_object($pm)) {
        if ($pm instanceof \Braintree\PayPalAccount) { $paypalEmail = $pm->email ?? null; $paypalPayer = $pm->payerId ?? null; }
        if ($pm instanceof \Braintree\VenmoAccount)  { $venmoUser   = $pm->username ?? null; }
    }

    $email     = $customer->email     ?? $paypalEmail ?? null;
    $firstName = $customer->firstName ?? null;
    $lastName  = $customer->lastName  ?? null;

    $r = new \stdClass();
    // varchar(64)
    $r->subscription_id        = $this->tr((string)$sub->id, 64);
    $r->customer_id            = $this->tr($customerId, 64);
    $r->plan_id                = $this->tr($sub->planId            ?? null, 64);
    $r->merchant_account_id    = $this->tr($sub->merchantAccountId ?? null, 64);

    // names (varchar 128), email (varchar 254)
    $r->email                  = $this->tr($email, 254);
    $r->first_name             = $this->tr($firstName, 128);
    $r->last_name              = $this->tr($lastName, 128);
    $r->moodle_userid          = null;

    // status varchar(16) NOT NULL
    $statusRaw                 = (string)($sub->status ?? '');
    $r->status                 = $this->tr($this->nz($statusRaw, 'Unknown'), 16);

    // numeric
    $r->price                  = isset($sub->price) ? (string)$sub->price : null;
    $r->currency               = null; // Braintree subs don’t expose currency
    $r->quantity               = isset($sub->quantity) ? (int)$sub->quantity : null;
    $r->billing_day_of_month   = isset($sub->billingDayOfMonth) ? (int)$sub->billingDayOfMonth : null;

    // dates
    $r->first_billing_date     = $this->to_date($sub->firstBillingDate         ?? null);
    $r->billing_period_start   = $this->to_date($sub->billingPeriodStartDate   ?? null);
    $r->billing_period_end     = $this->to_date($sub->billingPeriodEndDate     ?? null);
    $r->next_billing_date      = $this->to_date($sub->nextBillingDate          ?? null);
    $r->paid_through_date      = $this->to_date($sub->paidThroughDate          ?? null);
    $r->cancelled_at           = $this->to_datetime($sub->canceledAt           ?? null);

    // trial
    $r->trial_period           = isset($sub->trialPeriod) ? (int)($sub->trialPeriod ? 1 : 0) : null;
    $r->trial_start_date       = null;
    $r->trial_end_date         = null;

    $r->balance                = isset($sub->balance) ? (string)$sub->balance : null;

    // PM snapshots (respect column widths)
    $r->payment_method_type        = $this->tr($pmtype, 32);
    $r->payment_instrument_subtype = $this->tr($pmsubtype, 32);
    $r->payment_method_token       = $this->tr($sub->paymentMethodToken ?? null, 64);
    $r->card_type                  = $this->tr($pmsubtype, 32);
    $r->card_last4                 = $this->tr($cardLast4, 4);
    $r->card_exp_month             = $cardExpM;
    $r->card_exp_year              = $cardExpY;
    $r->paypal_payer_email         = $this->tr($paypalEmail, 254);
    $r->paypal_payer_id            = $this->tr($paypalPayer, 64);
    $r->venmo_username             = $this->tr($venmoUser, 64);

    // operational
    $r->created_at             = $this->to_datetime($sub->createdAt ?? null) ?? gmdate('Y-m-d H:i:s');
    $r->updated_at             = $this->to_datetime($sub->updatedAt ?? null) ?? gmdate('Y-m-d H:i:s');
    $r->synced_at              = gmdate('Y-m-d H:i:s');

    return $r;
}

    private function upsert_bt(\moodle_database $DB, \stdClass $r): bool {
    $fields = [
        'subscription_id','customer_id','plan_id','merchant_account_id',
        'email','first_name','last_name','moodle_userid',
        'status','price','currency','quantity','billing_day_of_month',
        'first_billing_date','billing_period_start','billing_period_end',
        'next_billing_date','paid_through_date','cancelled_at',
        'trial_period','trial_start_date','trial_end_date','balance',
        'payment_method_type','payment_instrument_subtype','payment_method_token',
        'card_type','card_last4','card_exp_month','card_exp_year',
        'paypal_payer_email','paypal_payer_id','venmo_username',
        'created_at','updated_at','synced_at',
    ];
    $ph = implode(',', array_fill(0, count($fields), '?'));
    $updates = implode(',', array_map(fn($f)=>"$f=VALUES($f)", array_diff($fields, ['subscription_id'])));
    $sql = "INSERT INTO {bt_subscriptions} (".implode(',',$fields).") VALUES ($ph) ON DUPLICATE KEY UPDATE $updates";
    $params = array_map(fn($f)=>$r->$f ?? null, $fields);

    try {
        $DB->execute($sql, $params);
        return true;
    } catch (\dml_write_exception $e) {
        // Detailed error incl. debuginfo + lengths to spot the offending column quickly
        $lens = [];
        foreach ($fields as $f) {
            $v = $r->$f ?? null;
            $lens[$f] = is_string($v) ? mb_strlen($v, 'UTF-8') : (is_null($v) ? null : 0);
        }
        mtrace("  • upsert BT {$r->subscription_id}: ".$e->getMessage());
        if (!empty($e->debuginfo)) {
            mtrace("    debuginfo: ".$e->debuginfo);
        }
        mtrace("    lengths: ".json_encode($lens));
        return false;
    } catch (\Throwable $e) {
        mtrace("  • upsert BT {$r->subscription_id}: ".$e->getMessage());
        return false;
    }
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
