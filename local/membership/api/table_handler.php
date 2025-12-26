<?php
/**
 * Local plugin "membership" - Unified table data for dashboard (JSON)
 *
 * Priorities:
 *   1) Linked identities from {payment_user_links} (includes cohorts)
 *   1.5) Manual registrations (includes cohorts)
 *   2) Unlinked provider rows from {pp_subscriptions}, {bt_subscriptions}, {pt_members}
 *
 * Output columns (kept compatible with your frontend):
 *   name, email, method, status, price, startDate, endDate, billingFrequency,
 *   cohortColumn, cohortIds, cohort, action, subscriber_id, id, DT_RowId
 * Plus: interval (friendly label; same as billingFrequency)
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once(__DIR__ . '/../../../config.php');

global $DB;

require_login();

$start  = isset($_GET['start']) ? (int)$_GET['start'] : 0;
$length = isset($_GET['length']) ? (int)$_GET['length'] : 10;
$draw   = isset($_GET['draw']) ? (int)$_GET['draw'] : 1;


//old code 
// $braintreeData = get_braintree_subscriptions_data(is_siteadmin(), $USER->id);
// $paypalData = function_exists('get_paypal_subscriptions_data') ? get_paypal_subscriptions_data() : [];
// $patreonData = [];

// $patreonResponse = function_exists('getMembersData') ? getMembersData() : null;
// if ($patreonResponse && isset($patreonResponse['data'])) {
//     $patreonData = $patreonResponse['data'];
// }

// foreach ($patreonData as $entry) {
//     $existing = $DB->get_record('membership_patreon_subscriptions', [
//         'email' => $entry['email']
//     ]);

//     $record = new stdClass();
//     $record->name = $entry['name'] ?? '';
//     $record->email = $entry['email'] ?? '';
//     $record->method = 'patreon';
//     $record->planid = $entry['planId'] ?? '';
//     $record->status = $entry['status'] ?? '';
//     $record->price = floatval($entry['price'] ?? 0);
//     $record->discount = floatval($entry['discount'] ?? 0);
//     $record->startdate = !empty($entry['startDate']) ? $entry['startDate'] : null;
//     $record->enddate = !empty($entry['endDate']) ? $entry['endDate'] : null;
//     $record->billingfrequency = intval($entry['billingFrequency'] ?? 1);
//     $record->cohortcolumn = null;
//     $record->cohortids = is_array($entry['cohortIds']) ? implode(',', $entry['cohortIds']) : $entry['cohortIds'];
//     $record->cohort = $entry['cohort'] ?? null;
//     $record->action = $entry['action'] ?? '';
//      // Add the subscriber_id from Patreon API response
//     $record->subscriber_id = $entry['subscriber_id'] ?? null; // Assuming the subscriber_id is in user -> id

//   if ($existing) {
//     $record->id = $existing->id;  // Ensure the correct ID is set for updating
//   $DB->execute(
//     "UPDATE {membership_patreon_subscriptions}
//      SET status = ?,
//          email = ?,
//          planid = ?,
//          price = ?,
//          discount = ?,
//          startdate = ?,
//          enddate = ?,
//          billingfrequency = ?
//      WHERE id = ?",
//     [
//         $entry['status'] ?? '',
//         $entry['email'] ?? '',
//         $entry['planId'] ?? '',
//         isset($entry['price']) ? (float)$entry['price'] : 0.0,
//         isset($entry['discount']) ? (float)$entry['discount'] : 0.0,
//         !empty($entry['startDate']) ? $entry['startDate'] : null,   // use strtotime(...) if your DB stores UNIX timestamps
//         !empty($entry['endDate'])   ? $entry['endDate']   : null,   // use strtotime(...) if needed
//         isset($entry['billingFrequency']) ? (int)$entry['billingFrequency'] : 1,
//         $existing->id
//     ]
// );

// } else {
     
//     $DB->insert_record('membership_patreon_subscriptions', $record); // no id
// }
// }


// $manualRecords = $DB->get_records_sql("
//     SELECT u.id,
//           CONCAT(u.firstname, ' ', u.lastname) AS name,
//           u.email,
//           u.email,
//           mur.paymentmethod as method,
//           mur.status,
//           mur.price,
//           mur.start_date AS startDate,
//           mur.end_date AS endDate,
//           mur.intervaltype,
//           NULL AS cohortColumn,
//           '' AS cohortIds,
//           NULL AS cohort,
//           '' AS action,
//           mur.subscriber_id
//     FROM {manual_user_registrations} mur
//     JOIN {user} u ON mur.userid = u.id
// ");


// $manualData = [];

// foreach ($manualRecords as $i => $rec) {
//     $intervalTypeRaw = $rec->intervaltype ?? '';
//     $billingFrequency = '';

//     if (strtolower($intervalTypeRaw) === 'month') {
//         $billingFrequency = 'monthly';
//     } elseif (strtolower($intervalTypeRaw) === 'week') {
//         $billingFrequency = 'weekly';
//     }

//     // 🔍 Fetch cohort id and shortname for this user
//     $cohortRecord = $DB->get_record_sql("
//         SELECT c.id, c.shortname
//         FROM {cohort_members} cm
//         JOIN {cohort} c ON cm.cohortid = c.id
//         WHERE cm.userid = ?
//         ORDER BY c.id DESC
//         LIMIT 1
//     ", [$rec->id]);

//     $manualData[] = [
//         'id' => 'manual_' . $rec->id,
//         'name' => $rec->name ?? '',
//         'email' => $rec->email ?? '',
//         'method' => $rec->method ?? 'manual',
//         'status' => $rec->status ?? '',
//         'price' => $rec->price ?? '',
//         'startDate' => (!empty($rec->startdate) && is_numeric($rec->startdate)) ? date('Y-m-d', (int)$rec->startdate) : '',
//         'endDate' => (!empty($rec->enddate) && is_numeric($rec->enddate)) ? date('Y-m-d', (int)$rec->enddate) : '',
//         'billingFrequency' => $billingFrequency,
//         'cohortColumn' => $cohortRecord->shortname ?? '',
//         'cohortIds' => $cohortRecord->id ?? '',
//         'cohort' => $cohortRecord->shortname ?? '',
//         'action' => $rec->action ?? '',
//         'subscriber_id' => $rec->subscriber_id ?? ''
//     ];
// }

// // If you still need the original "id" later, DO NOT unset it—just copy it.
// // If you truly want to rename, keep the unset(..) lines.
// foreach ($braintreeData as &$row) {
//     if (is_object($row)) {
//         $row->subscriber_id = $row->id ?? null;
//         // unset($row->id); // uncomment to fully rename
//     } else { // associative array case
//         $row['subscriber_id'] = $row['id'] ?? null;
//         // unset($row['id']); // uncomment to fully rename
//     }
// }
// unset($row); // break the reference



// // If you truly want to rename, keep the unset(..) lines.
// foreach ($paypalData as &$row) {
//     if (is_object($row)) {
//         $row->subscriber_id = $row->id ?? null;
//         // unset($row->id); // uncomment to fully rename
//     } else { // associative array case
//         $row['subscriber_id'] = $row['id'] ?? null;
//         // unset($row['id']); // uncomment to fully rename
//     }
// }
// unset($row); // break the reference


// $combinedData = array_merge($braintreeData, $paypalData, $patreonData, $manualData);

// // $combinedData = array_merge($braintreeData, $paypalData, $patreonData);

// $allColumns = [
//     'name', 'email', 'method', 'status', 'price', 'startDate', 'endDate', 'billingFrequency',
//     'cohortColumn', 'cohortIds', 'cohort', 'action', 'subscriber_id', 'id'
// ];

// foreach ($combinedData as $i => &$row) {
//     foreach ($allColumns as $col) {
//         if (!isset($row[$col])) $row[$col] = '';
//     }
//     if (!isset($row['id']) || empty($row['id'])) {
//         $row['id'] = 'row_' . $i . '_' . uniqid();
//     }
//     $row['DT_RowId'] = $row['id'];
// }
// unset($row);

/* --------------------------- helpers --------------------------- */

function _fmt_date(?string $s): string {
    if (!$s) return '';
    $t = strtotime($s);
    return $t ? gmdate('Y-m-d', $t) : '';
}

function _full_name(?string $a, ?string $b): string {
    $parts = [];
    if (!empty($a)) $parts[] = $a;
    if (!empty($b)) $parts[] = $b;
    $n = trim(implode(' ', $parts));
    return $n === '' ? '' : $n;
}

/** normalize to: active | past_due | suspended | pending | cancelled | expired | none */
function _norm_status(string $provider, $r): string {
    switch ($provider) {
        case 'paypal':
            $raw = strtoupper((string)($r->status ?? ''));
            $failed = (int)($r->failed_payment_count ?? 0);
            $ob     = (float)($r->outstanding_balance ?? 0.0);
            if ($raw === 'ACTIVE') {
                if ($failed > 0 || $ob > 0.0) return 'past_due';
                return 'active';
            }
            if ($raw === 'SUSPENDED')                                return 'suspended';
            if ($raw === 'APPROVAL_PENDING' || $raw === 'APPROVED')  return 'pending';
            if ($raw === 'CANCELLED')                                 return 'cancelled';
            if ($raw === 'EXPIRED')                                   return 'expired';
            return 'none';

        case 'braintree':
            $raw = (string)($r->status ?? '');
            if ($raw === 'Active')     return 'active';
            if ($raw === 'Past Due')   return 'past_due';
            if ($raw === 'Pending')    return 'pending';
            if ($raw === 'Canceled')   return 'cancelled';
            if ($raw === 'Expired')    return 'expired';
            return 'none';

        case 'patreon':
            $ps  = (string)($r->patron_status ?? '');
            $lcs = strtolower((string)($r->last_charge_status ?? ''));
            if ($ps === 'active_patron') return 'active';
            if ($ps === 'declined_patron' || $lcs === 'declined') return 'past_due';
            if ($ps === 'former_patron') return 'cancelled';
            return 'none';
    }
    return 'none';
}

/** days → friendly label */
function _label_from_days(int $days): string {
    if ($days <= 0) return '';
    if ($days >= 355 && $days <= 375) return 'yearly';
    if ($days >= 26  && $days <= 35 ) return 'monthly';
    if ($days >= 13  && $days <= 20 ) return 'biweekly';
    if ($days >= 6   && $days <= 8  ) return 'weekly';
    // fallback for other custom cadences
    return $days . 'd';
}

/** compute diff-in-days between two date strings */
function _days_between(?string $from, ?string $to): ?int {
    if (!$from || !$to) return null;
    $a = strtotime($from);
    $b = strtotime($to);
    if (!$a || !$b) return null;
    $diff = abs($b - $a);
    return (int)round($diff / 86400);
}

/** infer interval for PayPal row */
function _interval_paypal($r): string {
    // best: last_payment_time → next_billing_time
    $d = _days_between($r->last_payment_time ?? null, $r->next_billing_time ?? null);
    if ($d !== null) return _label_from_days($d);

    // fallback: start_time → next_billing_time
    $d = _days_between($r->start_time ?? null, $r->next_billing_time ?? null);
    if ($d !== null) return _label_from_days($d);

    // as a last resort, assume monthly
    return 'monthly';
}

/** infer interval for Braintree row */
function _interval_braintree($r): string {
    // billing_period_start → billing_period_end normally captures plan cadence
    $d = _days_between($r->billing_period_start ?? null, $r->billing_period_end ?? null);
    if ($d !== null) return _label_from_days($d);

    // fallback: paid_through_date → next_billing_date
    $d = _days_between($r->paid_through_date ?? null, $r->next_billing_date ?? null);
    if ($d !== null) return _label_from_days($d);

    return 'monthly'; // common default for BT plans
}

/** infer interval for Patreon row (prefer pledge_cadence from raw_json) */
function _interval_patreon($r): string {
    // Try pledge_cadence in raw_json if present (months)
    if (!empty($r->raw_json)) {
        $json = json_decode($r->raw_json, true);
        if (is_array($json)) {
            // our backfill stored ['member'=>..], but also tolerate single resource
            $attr = null;
            if (isset($json['member']['attributes']) && is_array($json['member']['attributes'])) {
                $attr = $json['member']['attributes'];
            } elseif (isset($json['attributes']) && is_array($json['attributes'])) {
                $attr = $json['attributes'];
            }
            if ($attr && isset($attr['pledge_cadence'])) {
                $cad = (int)$attr['pledge_cadence']; // months
                if ($cad === 1)  return 'monthly';
                if ($cad === 3)  return 'quarterly';
                if ($cad === 12) return 'yearly';
                if ($cad > 0)    return $cad . 'm';
            }
        }
    }

    // Fallback: last_charge_date → next_charge_date (or pledge_relationship_start)
    $d = _days_between($r->last_charge_date ?? null, $r->next_charge_date ?? null);
    if ($d !== null) return _label_from_days($d);

    $d = _days_between($r->pledge_relationship_start ?? null, $r->next_charge_date ?? null);
    if ($d !== null) return _label_from_days($d);

    // Patreon is typically monthly
    return 'monthly';
}

/** latest PayPal row for one payer id */
function _pp_latest_for_payer($pid) {
    global $DB;
    return $DB->get_record_sql("
        SELECT *, COALESCE(status_update_time,last_payment_time,next_billing_time,create_time,updated_at) AS touchts
          FROM {pp_subscriptions}
         WHERE subscriber_payer_id = ?
      ORDER BY COALESCE(status_update_time,last_payment_time,next_billing_time,create_time,updated_at) DESC
         LIMIT 1
    ", [$pid]);
}

/** latest Braintree row for one customer id */
function _bt_latest_for_customer($cid) {
    global $DB;
    return $DB->get_record_sql("
        SELECT *, COALESCE(updated_at, paid_through_date, next_billing_date, billing_period_end, created_at) AS touchts
          FROM {bt_subscriptions}
         WHERE customer_id = ?
      ORDER BY COALESCE(updated_at, paid_through_date, next_billing_date, billing_period_end, created_at) DESC
         LIMIT 1
    ", [$cid]);
}

/** latest Patreon row for one identity (user_id or member_id) */
function _pt_latest_for_identity($id) {
    global $DB;
    return $DB->get_record_sql("
        SELECT *, COALESCE(last_charge_date, updated_at, pledge_relationship_start) AS touchts
          FROM {pt_members}
         WHERE user_id = ? OR member_id = ?
      ORDER BY COALESCE(last_charge_date, updated_at, pledge_relationship_start) DESC
         LIMIT 1
    ", [$id, $id]);
}

/** cohort info for a Moodle user (comma-separated; leave blank if none) */
function _cohort_info_for_user(int $userid): array {
    global $DB;
    $rec = $DB->get_record_sql("
        SELECT GROUP_CONCAT(c.id ORDER BY c.id)         AS ids,
               GROUP_CONCAT(c.shortname ORDER BY c.id)   AS names
          FROM {cohort_members} cm
          JOIN {cohort} c ON c.id = cm.cohortid
         WHERE cm.userid = ?
    ", [$userid]);
    return [
        'ids'   => ($rec && !empty($rec->ids))   ? (string)$rec->ids   : '',
        'names' => ($rec && !empty($rec->names)) ? (string)$rec->names : '',
    ];
}

function _interval_label(?string $s): string {
    $s = strtolower(trim((string)$s));
    if ($s === '') return '';
    if ($s === 'month') return 'monthly';
    if ($s === 'week')  return 'weekly';
    if ($s === 'year')  return 'yearly';
    return $s; // pass through any custom values
}

/* --------------------------- build rows --------------------------- */

$rows = [];

/* 1) PRIORITY: linked identities from payment_user_links */
$linksql = "
    SELECT pl.*, u.firstname, u.lastname, u.email AS moodle_email
      FROM {payment_user_links} pl
 LEFT JOIN {user} u ON u.id = pl.moodle_userid
  ORDER BY pl.last_seen_at DESC, pl.id DESC
";
$links = $DB->get_records_sql($linksql);

foreach ($links as $pl) {
    $provider = $pl->provider;
    $email    = $pl->moodle_email ?: $pl->provider_email;
    $fullname = _full_name($pl->firstname ?? null, $pl->lastname ?? null);

    $coh = _cohort_info_for_user((int)$pl->moodle_userid);
    $cohortIds   = $coh['ids'];
    $cohortNames = $coh['names'];

    if ($provider === 'paypal') {
        $r = _pp_latest_for_payer($pl->provider_user_id);
        if ($r) {
            $name     = $fullname ?: _full_name($r->subscriber_given_name ?? null, $r->subscriber_surname ?? null);
            $interval = _interval_paypal($r);
            $rows[] = [
                'name'             => $name,
                'email'            => $email,
                'method'           => 'paypal',
                'status'           => _norm_status('paypal', $r),
                'price'            => $r->last_payment_amount !== null ? (float)$r->last_payment_amount : '',
                'startDate'        => _fmt_date($r->start_time ?: $r->create_time),
                'endDate'          => _fmt_date($r->next_billing_time),
                'billingFrequency' => $interval,
                'interval'         => $interval,
                'cohortColumn'     => $cohortNames,
                'cohortIds'        => $cohortIds,
                'cohort'           => $cohortNames,
                'action'           => '',
                'subscriber_id'    => $r->subscription_id ?? '',
                'id'               => 'paypal_' . ($r->subscription_id ?? uniqid()),
                'DT_RowId'         => 'paypal_' . ($r->subscription_id ?? uniqid()),
            ];
        }
    } elseif ($provider === 'braintree') {
        $r = _bt_latest_for_customer($pl->provider_user_id);
        if ($r) {
            $name     = $fullname ?: _full_name($r->first_name ?? null, $r->last_name ?? null);
            $interval = _interval_braintree($r);
            $rows[] = [
                'name'             => $name,
                'email'            => $email ?: ($r->email ?? ''),
                'method'           => 'braintree',
                'status'           => _norm_status('braintree', $r),
                'price'            => $r->price !== null ? (float)$r->price : '',
                'startDate'        => _fmt_date($r->first_billing_date ?: $r->billing_period_start ?: $r->created_at),
                'endDate'          => _fmt_date($r->billing_period_end ?: $r->paid_through_date ?: $r->next_billing_date),
                'billingFrequency' => $interval,
                'interval'         => $interval,
                'cohortColumn'     => $cohortNames,
                'cohortIds'        => $cohortIds,
                'cohort'           => $cohortNames,
                'action'           => '',
                'subscriber_id'    => $r->subscription_id ?? '',
                'id'               => 'braintree_' . ($r->subscription_id ?? uniqid()),
                'DT_RowId'         => 'braintree_' . ($r->subscription_id ?? uniqid()),
            ];
        }
    } elseif ($provider === 'patreon') {
        $r = _pt_latest_for_identity($pl->provider_user_id);
        if ($r) {
            $name     = $fullname ?: (string)($r->full_name ?? '');
            $price    = isset($r->currently_entitled_amount_cents) ? ((int)$r->currently_entitled_amount_cents)/100.0 : '';
            $interval = _interval_patreon($r);
            $rows[] = [
                'name'             => $name,
                'email'            => $email ?: ($r->email ?? ''),
                'method'           => 'patreon',
                'status'           => _norm_status('patreon', $r),
                'price'            => $price,
                'startDate'        => _fmt_date($r->pledge_relationship_start),
                'endDate'          => _fmt_date($r->next_charge_date ?? $r->last_charge_date ?? null),
                'billingFrequency' => $interval,
                'interval'         => $interval,
                'cohortColumn'     => $cohortNames,
                'cohortIds'        => $cohortIds,
                'cohort'           => $cohortNames,
                'action'           => '',
                'subscriber_id'    => $r->member_id ?? '',
                'id'               => 'patreon_' . ($r->member_id ?? uniqid()),
                'DT_RowId'         => 'patreon_' . ($r->member_id ?? uniqid()),
            ];
        }
    }
}

/* 1.5) MANUAL registrations (have Moodle user IDs; include cohorts & interval) */
$manual = $DB->get_records_sql("
    SELECT mur.*, u.firstname, u.lastname, u.email AS moodle_email, u.id AS userid
      FROM {manual_user_registrations} mur
      JOIN {user} u ON u.id = mur.userid
  ORDER BY mur.id DESC
");

foreach ($manual as $m) {
    $email    = $m->moodle_email ?? '';
    $fullname = _full_name($m->firstname ?? null, $m->lastname ?? null);

    $coh = _cohort_info_for_user((int)$m->userid);
    $cohortIds   = $coh['ids'];
    $cohortNames = $coh['names'];

    $startDate = '';
    if (!empty($m->start_date)) {
        $startDate = is_numeric($m->start_date) ? gmdate('Y-m-d', (int)$m->start_date) : _fmt_date($m->start_date);
    }
    $endDate = '';
    if (!empty($m->end_date)) {
        $endDate = is_numeric($m->end_date) ? gmdate('Y-m-d', (int)$m->end_date) : _fmt_date($m->end_date);
    }

    $friendlyInterval = _interval_label($m->intervaltype ?? '');

    $rows[] = [
        'name'             => $fullname,
        'email'            => $email,
        'method'           => $m->paymentmethod ?? 'manual',
        'status'           => $m->status ?? '',
        'price'            => isset($m->price) ? (float)$m->price : '',
        'startDate'        => $startDate,
        'endDate'          => $endDate,
        'billingFrequency' => $friendlyInterval,
        'interval'         => $friendlyInterval,
        'cohortColumn'     => $cohortNames,
        'cohortIds'        => $cohortIds,
        'cohort'           => $cohortNames,
        'action'           => '',
        'subscriber_id'    => $m->subscriber_id ?? ('manual_' . $m->userid),
        'id'               => ($m->subscriber_id ?? $m->userid),
        'DT_RowId'         => ($m->subscriber_id ?? $m->userid),
    ];
}

/* 2) UNLINKED provider rows (exclude those already represented by links) */

// PayPal: rows with no link for same payer id
$pp_unlinked = $DB->get_recordset_sql("
    SELECT s.*
      FROM {pp_subscriptions} s
 LEFT JOIN {payment_user_links} pl
        ON pl.provider = 'paypal'
       AND pl.provider_user_id = s.subscriber_payer_id
     WHERE pl.id IS NULL
");
foreach ($pp_unlinked as $r) {
    $name     = _full_name($r->subscriber_given_name ?? null, $r->subscriber_surname ?? null);
    $interval = _interval_paypal($r);
    $rows[] = [
        'name'             => $name,
        'email'            => $r->subscriber_email ?? '',
        'method'           => 'paypal',
        'status'           => _norm_status('paypal', $r),
        'price'            => $r->last_payment_amount !== null ? (float)$r->last_payment_amount : '',
        'startDate'        => _fmt_date($r->start_time ?: $r->create_time),
        'endDate'          => _fmt_date($r->next_billing_time),
        'billingFrequency' => $interval,
        'interval'         => $interval,
        'cohortColumn'     => '',
        'cohortIds'        => '',
        'cohort'           => '',
        'action'           => '',
        'subscriber_id'    => $r->subscription_id ?? '',
        'id'               => 'paypal_' . ($r->subscription_id ?? uniqid()),
        'DT_RowId'         => 'paypal_' . ($r->subscription_id ?? uniqid()),
    ];
}
$pp_unlinked->close();

// Braintree: rows with no link for same customer id
$bt_unlinked = $DB->get_recordset_sql("
    SELECT b.*
      FROM {bt_subscriptions} b
 LEFT JOIN {payment_user_links} pl
        ON pl.provider = 'braintree'
       AND pl.provider_user_id = b.customer_id
     WHERE pl.id IS NULL
");
foreach ($bt_unlinked as $r) {
    $name     = _full_name($r->first_name ?? null, $r->last_name ?? null);
    $interval = _interval_braintree($r);
    $rows[] = [
        'name'             => $name,
        'email'            => $r->email ?? '',
        'method'           => 'braintree',
        'status'           => _norm_status('braintree', $r),
        'price'            => $r->price !== null ? (float)$r->price : '',
        'startDate'        => _fmt_date($r->first_billing_date ?: $r->billing_period_start ?: $r->created_at),
        'endDate'          => _fmt_date($r->billing_period_end ?: $r->paid_through_date ?: $r->next_billing_date),
        'billingFrequency' => $interval,
        'interval'         => $interval,
        'cohortColumn'     => '',
        'cohortIds'        => '',
        'cohort'           => '',
        'action'           => '',
        'subscriber_id'    => $r->subscription_id ?? '',
        'id'               => 'braintree_' . ($r->subscription_id ?? uniqid()),
        'DT_RowId'         => 'braintree_' . ($r->subscription_id ?? uniqid()),
    ];
}
$bt_unlinked->close();

// Patreon: rows with no link for user_id or member_id
$pt_unlinked = $DB->get_recordset_sql("
    SELECT p.*
      FROM {pt_members} p
 LEFT JOIN {payment_user_links} pl1
        ON pl1.provider = 'patreon'
       AND pl1.provider_user_id = p.user_id
 LEFT JOIN {payment_user_links} pl2
        ON pl2.provider = 'patreon'
       AND pl2.provider_user_id = p.member_id
     WHERE pl1.id IS NULL AND pl2.id IS NULL
");
foreach ($pt_unlinked as $r) {
    $name     = (string)($r->full_name ?? '');
    $price    = isset($r->currently_entitled_amount_cents) ? ((int)$r->currently_entitled_amount_cents)/100.0 : '';
    $interval = _interval_patreon($r);
    $rows[] = [
        'name'             => $name,
        'email'            => $r->email ?? '',
        'method'           => 'patreon',
        'status'           => _norm_status('patreon', $r),
        'price'            => $price,
        'startDate'        => _fmt_date($r->pledge_relationship_start),
        'endDate'          => _fmt_date($r->next_charge_date ?? $r->last_charge_date ?? null),
        'billingFrequency' => $interval,
        'interval'         => $interval,
        'cohortColumn'     => '',
        'cohortIds'        => '',
        'cohort'           => '',
        'action'           => '',
        'subscriber_id'    => $r->member_id ?? '',
        'id'               => 'patreon_' . ($r->member_id ?? uniqid()),
        'DT_RowId'         => 'patreon_' . ($r->member_id ?? uniqid()),
    ];
}
$pt_unlinked->close();

/* Optional server-side paging (disabled by default)
$recordsTotal = count($rows);
if ($length > 0) {
    $rows = array_slice($rows, $start, $length);
}
*/

echo json_encode([
    'draw'            => $draw,
    'recordsTotal'    => count($rows),
    'recordsFiltered' => count($rows),
    'data'            => $rows,
]);
exit;
