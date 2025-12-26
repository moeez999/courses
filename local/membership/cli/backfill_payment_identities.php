<?php
// local/membership/cli/backfill_payment_identities.php
// One-time backfill of local_payment_identities from paypal, braintree, patreon.
// Usage: php local/membership/cli/backfill_payment_identities.php

// define('CLI_SCRIPT', true);

require(__DIR__ . '/../../../config.php');
// require_once($CFG->libdir . '/clilib.php');

global $DB;

@ini_set('memory_limit', '512M');
@set_time_limit(0);

function norm_email(?string $s): ?string {
    if ($s === null) return null;
    $s = trim($s);
    if ($s === '') return null;
    return mb_strtolower($s, 'UTF-8');
}

function find_userid_by_email(string $emailLower, \moodle_database $DB): ?int {
    // Exact, case-insensitive match; ignore deleted users.
    $sql = "SELECT id
              FROM {user}
             WHERE deleted = 0
               AND " . $DB->sql_equal('LOWER(email)', '?');
    $rec = $DB->get_record_sql($sql, [$emailLower], IGNORE_MISSING);
    return $rec ? (int)$rec->id : null;
}

function upsert_identity(\moodle_database $DB, array $row): bool {
    // $row keys: provider, provider_user_id, provider_customer_id (nullable), email, userid
    // local_payment_identities columns assumed:
    // id, provider (varchar), provider_user_id (varchar), provider_customer_id (varchar null),
    // email (varchar), userid (bigint), created_at (ts/dt), updated_at (ts/dt)
    $existing = $DB->get_record('local_payment_identities', [
        'provider'          => $row['provider'],
        'provider_user_id'  => $row['provider_user_id'],
    ], '*', IGNORE_MISSING);

    $now = time();

    if ($existing) {
        $existing->userid               = $row['userid'];
        $existing->email                = $row['email'];
        if (property_exists($existing, 'provider_customer_id')) {
            $existing->provider_customer_id = $row['provider_customer_id'] ?? null;
        }
        if (property_exists($existing, 'updated_at')) {
            $existing->updated_at = $now;
        }
        $DB->update_record('local_payment_identities', $existing);
        return false; // updated, not inserted
    } else {
        $o = (object)[
            'provider'          => $row['provider'],
            'provider_user_id'  => $row['provider_user_id'],
            'email'             => $row['email'],
            'userid'            => $row['userid'],
        ];
        // Optional columns if you created them:
        if ($DB->get_manager()->table_exists('local_payment_identities')) {
            // Set provider_customer_id if column exists.
            $columns = $DB->get_columns('local_payment_identities');
            if (isset($columns['provider_customer_id'])) {
                $o->provider_customer_id = $row['provider_customer_id'] ?? null;
            }
            if (isset($columns['created_at'])) $o->created_at = $now;
            if (isset($columns['updated_at'])) $o->updated_at = $now;
        }

        $DB->insert_record('local_payment_identities', $o);
        return true; // inserted
    }
}

$totals = [
    'paypal'    => ['seen'=>0, 'skipped_no_email'=>0, 'no_user_match'=>0, 'inserted'=>0, 'updated'=>0],
    'braintree' => ['seen'=>0, 'skipped_no_email'=>0, 'no_user_match'=>0, 'inserted'=>0, 'updated'=>0],
    'patreon'   => ['seen'=>0, 'skipped_no_email'=>0, 'no_user_match'=>0, 'inserted'=>0, 'updated'=>0],
];

echo "=== Backfill local_payment_identities ===\n";

// ---------- PayPal ----------
if ($DB->get_manager()->table_exists('paypal')) {
    echo "\n[paypal] scanning…\n";
    // Prefer freshest first if you expect dups
    $rs = $DB->get_recordset_sql("SELECT * FROM {paypal} ORDER BY COALESCE(updated_at, create_time) DESC, id DESC");
    foreach ($rs as $r) {
        $totals['paypal']['seen']++;

        $email = norm_email($r->subscriber_email ?? null);
        if (!$email) { $totals['paypal']['skipped_no_email']++; continue; }

        $userid = find_userid_by_email($email, $DB);
        if (!$userid) { $totals['paypal']['no_user_match']++; continue; }

        $ins = upsert_identity($DB, [
            'provider'             => 'paypal',
            'provider_user_id'     => (string)($r->subscriber_payer_id ?? ''), // stable person id at PayPal
            'provider_customer_id' => null,
            'email'                => $email,
            'userid'               => $userid,
        ]);
        $totals['paypal'][$ins ? 'inserted' : 'updated']++;
    }
    $rs->close();
} else {
    echo "[paypal] table not found, skipping.\n";
}

// ---------- Braintree ----------
if ($DB->get_manager()->table_exists('braintree')) {
    echo "\n[braintree] scanning…\n";
    $rs = $DB->get_recordset_sql("SELECT * FROM {braintree} ORDER BY COALESCE(updated_at, created_at) DESC, id DESC");
    foreach ($rs as $r) {
        $totals['braintree']['seen']++;

        $email = norm_email($r->email ?? null);
        if (!$email) { $totals['braintree']['skipped_no_email']++; continue; }

        $userid = find_userid_by_email($email, $DB);
        if (!$userid) { $totals['braintree']['no_user_match']++; continue; }

        $ins = upsert_identity($DB, [
            'provider'             => 'braintree',
            'provider_user_id'     => (string)($r->customer_id ?? ''),      // BT person-level id
            'provider_customer_id' => (string)($r->subscription_id ?? ''),  // keep sub id if you want it
            'email'                => $email,
            'userid'               => $userid,
        ]);
        $totals['braintree'][$ins ? 'inserted' : 'updated']++;
    }
    $rs->close();
} else {
    echo "[braintree] table not found, skipping.\n";
}

// ---------- Patreon ----------
if ($DB->get_manager()->table_exists('patreon')) {
    echo "\n[patreon] scanning…\n";
    // Process newest first (Patreon often has multiple rows per person)
    $rs = $DB->get_recordset_sql("SELECT * FROM {patreon} ORDER BY updated_at DESC, id DESC");
    foreach ($rs as $r) {
        $totals['patreon']['seen']++;

        $email = norm_email($r->email ?? null);
        if (!$email) { $totals['patreon']['skipped_no_email']++; continue; }

        $userid = find_userid_by_email($email, $DB);
        if (!$userid) { $totals['patreon']['no_user_match']++; continue; }

        $ins = upsert_identity($DB, [
            'provider'             => 'patreon',
            'provider_user_id'     => (string)($r->user_id ?? ''),       // Patreon "user" id = person id
            'provider_customer_id' => (string)($r->member_id ?? ''),     // Patreon "member" id = membership
            'email'                => $email,
            'userid'               => $userid,
        ]);
        $totals['patreon'][$ins ? 'inserted' : 'updated']++;
    }
    $rs->close();
} else {
    echo "[patreon] table not found, skipping.\n";
}

// ---------- Summary ----------
echo "\n=== Summary ===\n";
foreach ($totals as $prov => $t) {
    echo sprintf(
        "%-10s seen=%d, inserted=%d, updated=%d, skipped_no_email=%d, no_user_match=%d\n",
        $prov, $t['seen'], $t['inserted'], $t['updated'], $t['skipped_no_email'], $t['no_user_match']
    );
}
echo "Done.\n";
