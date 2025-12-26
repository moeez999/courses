<?php
// Backfill payment_user_links by iterating Moodle users and matching ALL provider subscriptions by EMAIL.
// One row per (provider, provider_user_id, provider_subscription_id).

require(__DIR__ . '/../../config.php');

@ini_set('memory_limit', '1024M');
@set_time_limit(0);

header('Content-Type: text/plain; charset=utf-8');

// ---- table names ----
$TABLE_PAYPAL  = 'pp_subscriptions';
$TABLE_BT      = 'bt_subscriptions';
$TABLE_PATREON = 'pt_members';
$TABLE_LINKS   = 'payment_user_links';

// ---- helpers ----
function normalize_email(?string $s): string {
    $s = trim((string)$s);
    return $s === '' ? '' : mb_strtolower($s);
}

/**
 * Upsert row keyed by (provider, provider_user_id, provider_subscription_id).
 * Keeps first_seen_at, bumps last_seen_at, preserves higher confidence.
 */
function insert_link_row(moodle_database $DB, string $linktable, array $row): bool {
    $sql = "INSERT INTO {{$linktable}}
            (moodle_userid, provider, provider_user_id, provider_email, provider_name, provider_subscription_id,
             match_method, match_confidence, is_primary, notes)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
              moodle_userid = VALUES(moodle_userid),
              provider_email = COALESCE(VALUES(provider_email), provider_email),
              provider_name = COALESCE(VALUES(provider_name), provider_name),
              last_seen_at = NOW(),
              match_method = IF(match_method = 'id', match_method, VALUES(match_method)),
              match_confidence = GREATEST(match_confidence, VALUES(match_confidence))";
    $params = [
        $row['moodle_userid'],
        $row['provider'],
        $row['provider_user_id'],
        $row['provider_email'],
        $row['provider_name'],
        $row['provider_subscription_id'],
        $row['match_method'],
        $row['match_confidence'],
        $row['is_primary'],
        $row['notes'],
    ];
    try {
        $DB->execute($sql, $params);
        return true;
    } catch (\Throwable $e) {
        echo "upsert error ({$row['provider']} / {$row['provider_user_id']} / {$row['provider_subscription_id']}): " . $e->getMessage() . "\n";
        return false;
    }
}

// ----------------------------------------------------------------------------
// Build provider maps: EMAIL -> all (identity,subscription) rows
// Dedup per key to keep the freshest per (identity,subscription).
// ----------------------------------------------------------------------------
echo "Backfill payment identities (user-first) starting " . gmdate('c') . "\n\n";

$paypalByEmail    = []; // email => [ "payer|sub" => ['pid','subid','name','updated_at'] ]
$braintreeByEmail = []; // email => [ "cust|sub" => ['cid','subid','name','updated_at'] ]
$patreonByEmail   = []; // email => [ "uid|member" => ['uid','subid','name','updated_at'] ]

// PayPal: may have multiple subscriptions for same payer (subscriber_payer_id)
$ppsql = "SELECT subscriber_email, subscriber_payer_id, subscription_id,
                 subscriber_given_name, subscriber_surname, updated_at
            FROM {{$TABLE_PAYPAL}}
           WHERE subscriber_email IS NOT NULL AND subscriber_email <> ''";
$ppset = $DB->get_recordset_sql($ppsql);
foreach ($ppset as $r) {
    $email = normalize_email($r->subscriber_email);
    if ($email === '') continue;

    $pid   = (string)($r->subscriber_payer_id ?? '');
    $subid = (string)($r->subscription_id ?? '');
    if ($pid === '' || $subid === '') continue; // need both to create a unique link row

    $name  = trim(implode(' ', array_filter([$r->subscriber_given_name ?? null, $r->subscriber_surname ?? null]))) ?: null;
    $stamp = $r->updated_at ?: '1970-01-01 00:00:00';
    $key   = $pid . '|' . $subid;

    if (!isset($paypalByEmail[$email][$key]) || $stamp > $paypalByEmail[$email][$key]['updated_at']) {
        $paypalByEmail[$email][$key] = [
            'pid'        => $pid,
            'subid'      => $subid,
            'name'       => $name,
            'updated_at' => $stamp,
        ];
    }
}
$ppset->close();

// Braintree: multiple subscriptions per customer_id
$btsql = "SELECT email, customer_id, subscription_id, first_name, last_name, updated_at
            FROM {{$TABLE_BT}}
           WHERE email IS NOT NULL AND email <> ''";
$btset = $DB->get_recordset_sql($btsql);
foreach ($btset as $r) {
    $email = normalize_email($r->email);
    if ($email === '') continue;

    $cid   = (string)($r->customer_id ?? '');
    $subid = (string)($r->subscription_id ?? '');
    if ($cid === '' || $subid === '') continue;

    $name  = trim(implode(' ', array_filter([$r->first_name ?? null, $r->last_name ?? null]))) ?: null;
    $stamp = $r->updated_at ?: '1970-01-01 00:00:00';
    $key   = $cid . '|' . $subid;

    if (!isset($braintreeByEmail[$email][$key]) || $stamp > $braintreeByEmail[$email][$key]['updated_at']) {
        $braintreeByEmail[$email][$key] = [
            'cid'        => $cid,
            'subid'      => $subid,
            'name'       => $name,
            'updated_at' => $stamp,
        ];
    }
}
$btset->close();

// Patreon: identity is user_id (fallback member_id). Each member_id is effectively a subscription instance.
$ptsql = "SELECT email, user_id, member_id, full_name, updated_at
            FROM {{$TABLE_PATREON}}
           WHERE email IS NOT NULL AND email <> ''";
$ptset = $DB->get_recordset_sql($ptsql);
foreach ($ptset as $r) {
    $email = normalize_email($r->email);
    if ($email === '') continue;

    $uid   = (string)($r->user_id ?? '');
    if ($uid === '') $uid = (string)($r->member_id ?? '');
    $subid = (string)($r->member_id ?? '');
    if ($uid === '' || $subid === '') continue;

    $name  = trim((string)($r->full_name ?? '')) ?: null;
    $stamp = $r->updated_at ?: '1970-01-01 00:00:00';
    $key   = $uid . '|' . $subid;

    if (!isset($patreonByEmail[$email][$key]) || $stamp > $patreonByEmail[$email][$key]['updated_at']) {
        $patreonByEmail[$email][$key] = [
            'uid'        => $uid,
            'subid'      => $subid,
            'name'       => $name,
            'updated_at' => $stamp,
        ];
    }
}
$ptset->close();

$ppCount = array_sum(array_map('count', $paypalByEmail));
$btCount = array_sum(array_map('count', $braintreeByEmail));
$ptCount = array_sum(array_map('count', $patreonByEmail));

echo "PayPal email→subs:    {$ppCount}\n";
echo "Braintree email→subs: {$btCount}\n";
echo "Patreon email→subs:   {$ptCount}\n\n";

// ----------------------------------------------------------------------------
// Iterate Moodle users and insert 1 link per subscription for matching email
// ----------------------------------------------------------------------------
$totals = [
    'users_scanned' => 0,
    'paypal'    => ['linked'=>0],
    'braintree' => ['linked'=>0],
    'patreon'   => ['linked'=>0],
];

$usersql = "SELECT id, email FROM {user} WHERE deleted = 0 AND email <> ''";
$userset = $DB->get_recordset_sql($usersql);
foreach ($userset as $u) {
    $totals['users_scanned']++;
    $email = normalize_email($u->email);
    if ($email === '') continue;

    // PayPal
    if (!empty($paypalByEmail[$email])) {
        foreach ($paypalByEmail[$email] as $k => $pp) {
            if (insert_link_row($DB, $TABLE_LINKS, [
                'moodle_userid'            => (int)$u->id,
                'provider'                 => 'paypal',
                'provider_user_id'         => $pp['pid'],
                'provider_email'           => $email,
                'provider_name'            => $pp['name'],
                'provider_subscription_id' => $pp['subid'],
                'match_method'             => 'email',
                'match_confidence'         => 90,
                'is_primary'               => 1,
                'notes'                    => null,
            ])) {
                $totals['paypal']['linked']++;
            }
        }
    }

    // Braintree
    if (!empty($braintreeByEmail[$email])) {
        foreach ($braintreeByEmail[$email] as $k => $bt) {
            if (insert_link_row($DB, $TABLE_LINKS, [
                'moodle_userid'            => (int)$u->id,
                'provider'                 => 'braintree',
                'provider_user_id'         => $bt['cid'],
                'provider_email'           => $email,
                'provider_name'            => $bt['name'],
                'provider_subscription_id' => $bt['subid'],
                'match_method'             => 'email',
                'match_confidence'         => 90,
                'is_primary'               => 1,
                'notes'                    => null,
            ])) {
                $totals['braintree']['linked']++;
            }
        }
    }

    // Patreon
    if (!empty($patreonByEmail[$email])) {
        foreach ($patreonByEmail[$email] as $k => $pt) {
            if (insert_link_row($DB, $TABLE_LINKS, [
                'moodle_userid'            => (int)$u->id,
                'provider'                 => 'patreon',
                'provider_user_id'         => $pt['uid'],
                'provider_email'           => $email,
                'provider_name'            => $pt['name'],
                'provider_subscription_id' => $pt['subid'],
                'match_method'             => 'email',
                'match_confidence'         => 90,
                'is_primary'               => 1,
                'notes'                    => null,
            ])) {
                $totals['patreon']['linked']++;
            }
        }
    }
}
$userset->close();

// ----------------------------------------------------------------------------
echo "\nDone.\n";
echo "Users scanned: {$totals['users_scanned']}\n";
echo "PayPal linked:    {$totals['paypal']['linked']}\n";
echo "Braintree linked: {$totals['braintree']['linked']}\n";
echo "Patreon linked:   {$totals['patreon']['linked']}\n";
echo "Finished at " . gmdate('c') . "\n";
