<?php
require_once('../../config.php');
require_once('lib.php');

// Check if user is logged in and has capability
require_login();
$context = context_system::instance();
// require_capability('local/teachertimecard:view', $context);

// Get and validate parameters
$teacherid = required_param('teacherid', PARAM_INT);
$startdate = required_param('startdate', PARAM_TEXT);
$enddate = required_param('enddate', PARAM_TEXT);

// $startdate = '2025-05-16';//required_param('date', PARAM_TEXT);
// $enddate = '2025-08-16';
// $teacherid = 29;//required_param('teacherid', PARAM_INT);
// Validate teacher access
// if ($teacherid != $USER->id && !has_capability('local/teachertimecard:manage', $context)) {
//     throw new moodle_exception('nopermission', 'local_teachertimecard');
// }

// Convert dates to timestamps
$start_timestamp = strtotime($startdate . ' 00:00:00');
$end_timestamp = strtotime($enddate . ' 23:59:59');

// Validate date range
if ($start_timestamp === false || $end_timestamp === false) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid date format'
    ]);
    exit;
}

if ($start_timestamp > $end_timestamp) {
    echo json_encode([
        'success' => false,
        'message' => 'Start date cannot be after end date'
    ]);
    exit;
}

try {
    // Get unpaid sessions
    $unpaid_sessions = get_unpaid_sessions($teacherid, $start_timestamp, $end_timestamp);
   //print_r( $unpaid_sessions);
    // Get teacher rates
    $rates = get_teacher_rates($teacherid);
    
    // Calculate payment
    $payment_calculation = calculate_payment_amount($unpaid_sessions, $rates);
    
    // Prepare response
    $response = [
        'success' => true,
        'sessions' => [
            'main_sessions' => $unpaid_sessions['main_sessions'],
            'practice_sessions' => $unpaid_sessions['practice_sessions'],
            'totals' => $unpaid_sessions['totals']
        ],
        'calculation' => [
            'total_hours' => $payment_calculation['total_hours'],
            'total_amount' => $payment_calculation['total_amount'],
            'session_count' => count($payment_calculation['session_details'])
        ],
        'rates' => $rates
    ];
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log('Payment calculation error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error calculating payment: ' . $e->getMessage()
    ]);
}