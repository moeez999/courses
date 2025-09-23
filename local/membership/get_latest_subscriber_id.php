<?php
require_once('../../config.php');
require_login();

header('Content-Type: application/json');

$method = required_param('method', PARAM_TEXT);
$startdate = required_param('startdate', PARAM_TEXT); // expected format: MM/DD/YY or MM/DD/YYYY

// Validate
$allowed = ['Cash', 'zelle', 'western union', 'Other'];
if (!in_array($method, $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Invalid method']);
    exit;
}

// Format prefix: e.g. Cash_02_07_2025
$prefixBase = strtolower(str_replace(' ', '', $method)); // removes space for 'western union'
// Parse date and reformat to d_m_Y
$timestamp = strtotime($startdate);
if (!$timestamp) {
    echo json_encode(['success' => false, 'error' => 'Invalid start date']);
    exit;
}
$prefix = $prefixBase . '_' . date('d_m_Y', $timestamp);

// SQL to fetch latest subscriber_id for this prefix
$sql = "SELECT subscriber_id
        FROM {manual_user_registrations}
        WHERE subscriber_id LIKE ?
        ORDER BY id DESC
        LIMIT 1";
$params = [$prefix . '_%'];

$last = $DB->get_field_sql($sql, $params);

// Extract last number and increment
if ($last && preg_match('/_(\d+)$/', $last, $matches)) {
    $lastnum = (int)$matches[1];
    $nextnum = str_pad($lastnum + 1, 5, '0', STR_PAD_LEFT);
} else {
    $nextnum = '00001';
}

$newid = $prefix . '_' . $nextnum;

echo json_encode(['success' => true, 'subscriber_id' => $newid]);