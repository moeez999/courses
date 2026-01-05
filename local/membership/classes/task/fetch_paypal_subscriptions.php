<?php
namespace local_membership\task;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/membership/braintree/paypal.php');
require_once(__DIR__ . '/../../braintree/paypal.php');

class fetch_paypal_subscriptions extends \core\task\scheduled_task {
    public function get_name() {
        return get_string('fetch_paypal_subscriptions', 'local_membership');
    }

    /** Unified insert/update for a PayPal subscription payload from get_subscription_data(). */
    private function upsert_subscription(array $d) {
        global $DB;

        if (empty($d['id'])) {
            mtrace("⚠️ upsert skipped: missing id");
            return 'skipped';
        }

        $now = time();
        $fields = (object)[
            'subscription_id'   => $d['id'],
            'name'              => $d['name'] ?? '',
            'email'             => $d['email'] ?? '',
            'status'            => $d['status'] ?? '',
            'price'             => $d['price'] ?? 0,
            'start_date'        => $d['startDate'] ?? null,
            'end_date'          => $d['endDate'] ?? null,
            'billing_frequency' => $d['billingFrequency'] ?? null,
        ];
        
       

        if ($DB->record_exists('paypal_subscriptions', ['subscription_id' => $d['id']])) {
            // Update
            $record = $DB->get_record('paypal_subscriptions', ['subscription_id' => $d['id']], '*', MUST_EXIST);
            $record->name              = $fields->name;
            $record->email             = $fields->email;
            $record->status            = $fields->status;
            $record->price             = $fields->price;
            $record->start_date        = $fields->start_date;
            $record->end_date          = $fields->end_date;
            $record->billing_frequency = $fields->billing_frequency;
            //$record->created_at       = $now;
            $fields->created_at = date('Y-m-d H:i:s', $now);
             $fields->method = 'paypal';
            $fields->cohort = 0;

            $DB->update_record('paypal_subscriptions', $record);
            mtrace("🔄 Updated: {$d['id']} | Status: {$fields->status} | Price: {$fields->price}");
            return 'updated';
        } else {
            // Insert
            //$fields->created_at = $now;
            $fields->created_at = date('Y-m-d H:i:s', $now);
            $fields->method = 'paypal';
            $fields->cohort = 0;
            $DB->insert_record('paypal_subscriptions', $fields);
            mtrace("🆕 Inserted: {$d['id']} | Status: {$fields->status}");
            return 'inserted';
        }
    }
    
    /** Fetch & upsert one PayPal subscription by ID. */
private function fetch_one_by_id(string $sid, string $accessToken) : void {
    mtrace("🔎 Force-fetch single subscription: {$sid}");
   $details = $this->get_paypal_subscription($sid, $accessToken);
    if (!$details) {
        mtrace("❌ No details returned for {$sid}");
        return;
    }
    $data = get_subscription_data($details);
    $this->upsert_subscription($data);
    mtrace("✅ Force-fetch completed for {$sid}");
}


private function get_paypal_subscription(string $sid, string $accessToken, ?bool $sandbox = null): ?array {
    // Decide environment: config flag beats parameter; default to LIVE
    if ($sandbox === null) {
        // Set this with: php admin/cli/cfg.php --component=local_membership --name=paypal_sandbox --set=1
        $sandbox = (bool) get_config('local_membership', 'paypal_sandbox');
    }

    $base = $sandbox ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com';
    $url  = $base . '/v1/billing/subscriptions/' . rawurlencode($sid);

    // Debug: show exactly what we’re calling
    mtrace("🔗 PayPal GET {$url} (env=" . ($sandbox ? 'SANDBOX' : 'LIVE') . ")");

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer {$accessToken}",
        "Content-Type: application/json",
        "Accept: application/json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $resp = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    mtrace("ℹ️ PayPal details HTTP={$http}");

    if ($err) {
        mtrace("PayPal details CURL error for {$sid}: {$err}");
        return null;
    }
    if ($http < 200 || $http >= 300 || empty($resp)) {
        mtrace("PayPal details failed for {$sid}. HTTP {$http}. Body: {$resp}");
        return null;
    }
    $data = json_decode($resp, true);
    if (!is_array($data)) {
        mtrace("PayPal details JSON decode failed for {$sid}. Body: {$resp}");
        return null;
    }
    return $data;
}

    public function execute() {
        global $DB;

        // Create a manual lock (avoid stuck cron lock errors)
        // $factory = \core\lock\lock_config::get_lock_factory('cron');
        // $lock = $factory->get_lock('local_membership_fetch_paypal', 900); // 15-minute lock
        
        $factory = \core\lock\lock_config::get_lock_factory('cron');
        $lock = $factory->get_lock('local_membership_fetch_paypal', 30); // was 900

        if (!$lock) {
            mtrace("❌ Could not acquire lock. Task already running.");
            return;
        }

        try {
            ini_set('max_execution_time', 0);
            set_time_limit(0);

            $accessToken = get_paypal_token();
            
//             $this->fetch_one_by_id('I-DTV32C0FR6MB', $accessToken);
// return;

            // -----------------------------------------------------------------
            // STEP 1: Refresh/verify all subscriptions that are already in DB
            // -----------------------------------------------------------------
            // $subscriptions = $DB->get_records('paypal_subscriptions');
            // $s1updated = 0; $s1inserted = 0; $s1skipped = 0;

            // foreach ($subscriptions as $sub) {
            //     mtrace("➡ Checking: {$sub->subscription_id}");

            //     $details = get_paypal_subscription_details($sub->subscription_id, $accessToken);
            //     if (!$details) {
            //         mtrace("❌ No details returned for {$sub->subscription_id}");
            //         sleep(1);
            //         continue;
            //     }

            //     $data = get_subscription_data($details);
            //     $res  = $this->upsert_subscription($data);

            //     if ($res === 'updated')   $s1updated++;
            //     elseif ($res === 'inserted') $s1inserted++;
            //     else $s1skipped++;

            //     sleep(1); // throttle to avoid PayPal rate limits
            // }
            // mtrace("✔ STEP 1 summary: updated=$s1updated, inserted=$s1inserted, skipped=$s1skipped");

            // -----------------------------------------------------------------
            // STEP 2: Discover & ingest NEW PayPal subscriptions (not yet in DB)
            // (keeps your working logic with the 'statuses' fallback)
            // -----------------------------------------------------------------
            try {
                // Resume window: default 30 days back on first run, then continue from last checkpoint.
                $lastsync = (int) get_config('local_membership', 'paypal_newsubs_last_sync');
                if (empty($lastsync)) {
                    $lastsync = time() - (30 * 24 * 60 * 60); // 30 days
                }
                // $startIso = gmdate('Y-m-d\TH:i:s\Z', $lastsync);
                // $endIso   = gmdate('Y-m-d\TH:i:s\Z');
                
                
                $windowStartTs = time() - (100 * DAYSECS);
                $startIso = gmdate('Y-m-d\TH:i:s\Z', $windowStartTs);
                $endIso   = gmdate('Y-m-d\TH:i:s\Z');

                $pageSize  = 20;     // per PayPal docs (1..20)
                $inserted  = 0;
                $seenTotal = 0;

                // Try with single status; if rejected, drop statuses entirely.
                $tryStatuses = ['ACTIVE'];
                $usedFallbackNoStatus = false;

                foreach ($tryStatuses as $singleStatus) {
                    $page = 1;

                    while (true) {
                        $query = [
                            'created_after'  => $startIso,
                            'created_before' => $endIso,
                            'page_size'      => $pageSize,
                            'page'           => $page,
                        ];
                        if (!$usedFallbackNoStatus) {
                            $query['statuses'] = $singleStatus; // single value only
                        }

                        $listUrl = "https://api-m.paypal.com/v1/billing/subscriptions?" . http_build_query($query);

                        $ch = curl_init($listUrl);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            "Authorization: Bearer $accessToken",
                            "Content-Type: application/json"
                        ]);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

                        $resp    = curl_exec($ch);
                        $http    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        $curlErr = curl_error($ch);
                        curl_close($ch);

                        if ($curlErr) {
                            mtrace("⚠️ PayPal list error (page $page): $curlErr");
                            break;
                        }

                        if ($http < 200 || $http >= 300 || empty($resp)) {
                            $err = json_decode($resp, true);
                            $errField = $err['details'][0]['field'] ?? '';
                            $errIssue = $err['details'][0]['issue'] ?? '';
                            $errVal   = $err['details'][0]['value'] ?? '';
                            if (!$usedFallbackNoStatus && $http === 400 && $errField === 'statuses' && $errIssue === 'INVALID_PARAMETER_VALUE') {
                                mtrace("ℹ️ Dropping 'statuses' filter and retrying page $page (value '$errVal' rejected).");
                                $usedFallbackNoStatus = true; // retry without statuses
                                continue;
                            }

                            mtrace("⚠️ List subs HTTP $http. Body: $resp");
                            break; // stop paging this status
                        }

                        $data  = json_decode($resp, true);
                        $items = $data['subscriptions'] ?? [];

                        foreach ($items as $item) {
                            // print_r($items);
                            //         die;
                        
                            $seenTotal++;
                            $sid = $item['id'] ?? null;
                            if (!$sid) { continue; }

                            if (!$DB->record_exists('paypal_subscriptions', ['subscription_id' => $sid])) {
                                $details = get_paypal_subscription_details($sid, $accessToken);
                                if ($details) {
                                    $d   = get_subscription_data($details);
                                    $res = $this->upsert_subscription($d);
                                    if ($res === 'inserted') {
                                        $inserted++;
                                    }
                                } else {
                                    mtrace("⚠️ Could not fetch details for new candidate $sid");
                                }
                                sleep(1); // be gentle with the API
                            }
                        }

                        // Stop when fewer than page_size returned
                        if (count($items) < $pageSize) {
                            break;
                        }
                        $page++;
                    }

                    // If we had to fall back to no 'statuses', a single full-window pass is enough.
                    if ($usedFallbackNoStatus) {
                        break;
                    }
                }

                // Advance checkpoint AFTER successful pass.
                set_config('paypal_newsubs_last_sync', time(), 'local_membership');
                mtrace("📥 STEP 2 summary: seen=$seenTotal, inserted=$inserted. Window: $startIso → $endIso");
            } catch (\Throwable $e) {
                mtrace("💥 New-subscriptions discovery failed: " . $e->getMessage());
            }

            mtrace("✅ Task completed.");
        } catch (\Throwable $e) {
            mtrace("💥 Exception occurred: " . $e->getMessage());
            debugging("Task crashed: " . $e->getMessage(), DEBUG_DEVELOPER);
        } finally {
            $lock->release(); // always release the lock
            mtrace("🔓 Lock released.");
        }
    }
}