<?php
require_once('../../config.php');
require_login();

header('Content-Type: application/json');

global $DB;

// Params
$method    = required_param('method', PARAM_TEXT);
$startdate = required_param('startdate', PARAM_TEXT); // MM/DD/YY or MM/DD/YYYY

// Validate method (case-insensitive)
$methodlower = strtolower(trim($method));
$allowedlower = ['cash', 'zelle', 'western union', 'other', 'paypal', 'exclusive', 'paypal invoice'];
if (!in_array($methodlower, $allowedlower, true)) {
    echo json_encode(['success' => false, 'error' => 'Invalid method']);
    exit;
}

// Build prefix: e.g., cash_01_10_2025 (spaces removed for 'western union')
$prefixBase = str_replace(' ', '', $methodlower);

$timestamp = strtotime($startdate);
if (!$timestamp) {
    echo json_encode(['success' => false, 'error' => 'Invalid start date']);
    exit;
}
$prefix = $prefixBase . '_' . date('d_m_Y', $timestamp);

// Get next counter for this payment method (rolling, not per date)
$sql = "
    SELECT LPAD(
             IFNULL(MAX(CAST(REGEXP_SUBSTR(subscriber_id, '[0-9]+$') AS UNSIGNED)), 0) + 1,
             5, '0'
           ) AS next_counter
      FROM {manual_user_registrations}
     WHERE LOWER(paymentmethod) = :pm
";
$params = ['pm' => $methodlower];

// Note: even with no matching rows, MySQL returns one row; but Moodle may still yield false.
// Handle both cases robustly.
$record = $DB->get_record_sql($sql, $params);

$nextCounter = '00001';
if ($record && isset($record->next_counter) && $record->next_counter !== null && $record->next_counter !== '') {
    // Ensure it's zero-padded to 5 just in case
    $nextCounter = str_pad((int)$record->next_counter, 5, '0', STR_PAD_LEFT);
}

$newid = $prefix . '_' . $nextCounter;

echo json_encode(['success' => true, 'subscriber_id' => $newid]);
