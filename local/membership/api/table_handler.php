<?php

/**
 * Local plugin "membership" - Table handler file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once('../../../config.php');
require_once($CFG->dirroot . '/local/membership/lib.php');
require_once($CFG->dirroot . '/local/membership/braintree/paypal.php');

global $CFG, $DB, $PAGE, $USER, $SESSION;

require_login();

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$length = isset($_GET['length']) ? intval($_GET['length']) : 10;
$draw = isset($_GET['draw']) ? intval($_GET['draw']) : 1;

$braintreeData = get_braintree_subscriptions_data(is_siteadmin(), $USER->id);
$paypalData = function_exists('get_paypal_subscriptions_data') ? get_paypal_subscriptions_data() : [];
$patreonData = [];

$patreonResponse = function_exists('getMembersData') ? getMembersData() : null;
if ($patreonResponse && isset($patreonResponse['data'])) {
    $patreonData = $patreonResponse['data'];
}

foreach ($patreonData as $entry) {
    $existing = $DB->get_record('membership_patreon_subscriptions', [
        'email' => $entry['email']
    ]);

    $record = new stdClass();
    $record->name = $entry['name'] ?? '';
    $record->email = $entry['email'] ?? '';
    $record->method = 'patreon';
    $record->planid = $entry['planId'] ?? '';
    $record->status = $entry['status'] ?? '';
    $record->price = floatval($entry['price'] ?? 0);
    $record->discount = floatval($entry['discount'] ?? 0);
    $record->startdate = !empty($entry['startDate']) ? $entry['startDate'] : null;
    $record->enddate = !empty($entry['endDate']) ? $entry['endDate'] : null;
    $record->billingfrequency = intval($entry['billingFrequency'] ?? 1);
    $record->cohortcolumn = null;
    $record->cohortids = is_array($entry['cohortIds']) ? implode(',', $entry['cohortIds']) : $entry['cohortIds'];
    $record->cohort = $entry['cohort'] ?? null;
    $record->action = $entry['action'] ?? '';
     // Add the subscriber_id from Patreon API response
    $record->subscriber_id = $entry['subscriber_id'] ?? null; // Assuming the subscriber_id is in user -> id

  if ($existing) {
    $record->id = $existing->id;  // Ensure the correct ID is set for updating
   $DB->execute(
    "UPDATE {membership_patreon_subscriptions} 
     SET subscriber_id = ? 
     WHERE id = ?",
    [$entry['subscriber_id'], $existing->id]
);
} else {
     
    $DB->insert_record('membership_patreon_subscriptions', $record); // no id
}
}


$manualRecords = $DB->get_records_sql("
    SELECT u.id,
           CONCAT(u.firstname, ' ', u.lastname) AS name,
           u.email,
           u.email,
           mur.paymentmethod as method,
           mur.status,
           mur.price,
           mur.start_date AS startDate,
           mur.end_date AS endDate,
           mur.intervaltype,
           NULL AS cohortColumn,
           '' AS cohortIds,
           NULL AS cohort,
           '' AS action,
           mur.subscriber_id
    FROM {manual_user_registrations} mur
    JOIN {user} u ON mur.userid = u.id
");


$manualData = [];

foreach ($manualRecords as $i => $rec) {
    $intervalTypeRaw = $rec->intervaltype ?? '';
    $billingFrequency = '';

    if (strtolower($intervalTypeRaw) === 'month') {
        $billingFrequency = 'monthly';
    } elseif (strtolower($intervalTypeRaw) === 'week') {
        $billingFrequency = 'weekly';
    }

    // 🔍 Fetch cohort id and shortname for this user
    $cohortRecord = $DB->get_record_sql("
        SELECT c.id, c.shortname
        FROM {cohort_members} cm
        JOIN {cohort} c ON cm.cohortid = c.id
        WHERE cm.userid = ?
        ORDER BY c.id DESC
        LIMIT 1
    ", [$rec->id]);

    $manualData[] = [
        'id' => 'manual_' . $rec->id,
        'name' => $rec->name ?? '',
        'email' => $rec->email ?? '',
        'method' => $rec->method ?? 'manual',
        'status' => $rec->status ?? '',
        'price' => $rec->price ?? '',
        'startDate' => (!empty($rec->startdate) && is_numeric($rec->startdate)) ? date('Y-m-d', (int)$rec->startdate) : '',
        'endDate' => (!empty($rec->enddate) && is_numeric($rec->enddate)) ? date('Y-m-d', (int)$rec->enddate) : '',
        'billingFrequency' => $billingFrequency,
        'cohortColumn' => $cohortRecord->shortname ?? '',
        'cohortIds' => $cohortRecord->id ?? '',
        'cohort' => $cohortRecord->shortname ?? '',
        'action' => $rec->action ?? '',
        'subscriber_id' => $rec->subscriber_id ?? ''
    ];
}


$combinedData = array_merge($braintreeData, $paypalData, $patreonData, $manualData);

// $combinedData = array_merge($braintreeData, $paypalData, $patreonData);

$allColumns = [
    'name', 'email', 'method', 'status', 'price', 'startDate', 'endDate', 'billingFrequency',
    'cohortColumn', 'cohortIds', 'cohort', 'action', 'id'
];

foreach ($combinedData as $i => &$row) {
    foreach ($allColumns as $col) {
        if (!isset($row[$col])) $row[$col] = '';
    }
    if (!isset($row['id']) || empty($row['id'])) {
        $row['id'] = 'row_' . $i . '_' . uniqid();
    }
    $row['DT_RowId'] = $row['id'];
}
unset($row);

echo json_encode([
    "draw" => $draw,
    "recordsTotal" => count($combinedData),
    "recordsFiltered" => count($combinedData),
    "data" => $combinedData,
]);
exit;
?>

