<?php
require_once('../../config.php');
require_once('lib.php');

// Check if user is logged in and has capability
require_login();
$context = context_system::instance();
//require_capability('local/teachertimecard:manage', $context); // Only managers can process payments

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON input'
    ]);
    exit;
}

// Validate required parameters
$required_params = ['teacherid', 'amount', 'currency', 'payment_method', 'payment_details', 'period_start', 'period_end', 'sessions'];
foreach ($required_params as $param) {
    if (!isset($input[$param])) {
        echo json_encode([
            'success' => false,
            'message' => 'Missing parameter: ' . $param
        ]);
        exit;
    }
}

$teacherid = $input['teacherid'];
$amount = $input['amount'];
$currency = $input['currency'];
$payment_method = $input['payment_method'];
$payment_details = $input['payment_details'];
$period_start = $input['period_start'];
$period_end = $input['period_end'];
$sessions = $input['sessions'];

// Validate teacher exists
if (!$DB->record_exists('user', ['id' => $teacherid, 'deleted' => 0])) {
    echo json_encode([
        'success' => false,
        'message' => 'Teacher not found'
    ]);
    exit;
}

// Validate amount
if ($amount <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid payment amount'
    ]);
    exit;
}

try {
    // Get teacher rates
    $rates = get_teacher_rates($teacherid);
    
    // Calculate session details for payment
    $session_details = [];
    
    // Process main sessions
    foreach ($sessions['main_sessions'] as $session) {
        $hours = $session['duration_seconds'] / 3600;
        $session_details[] = [
            'session_id' => $session['id'], 
            'session_date' => date("Y-m-d",strtotime($session['activity_time'])),
            'session_type' => 'main',
            'duration' => $hours,
            'rate' => $rates['group_rate'],
            'amount' => $hours * $rates['group_rate']
        ];
    }
    
    // Process practice sessions
    foreach ($sessions['practice_sessions'] as $session) {
        $hours = $session['duration_seconds'] / 3600;
        $session_details[] = [
            'session_id' => $session['id'],
            'session_date' => date("Y-m-d",strtotime($session['activity_time'])),
            'session_type' => 'practice',
            'duration' => $hours,
            'rate' => $rates['single_rate'],
            'amount' => $hours * $rates['single_rate']
        ];
    }
    
    // Process payment
    $payment_id = process_teacher_payment(
        $teacherid,
        $amount,
        $currency,
        $payment_method,
        $period_start,
        $period_end,
        $session_details,
        $USER->id
    );
    
    if ($payment_id) {
        echo json_encode([
            'success' => true,
            'payment_id' => $payment_id,
            'message' => 'Payment processed successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Payment processing failed'
        ]);
    }
    
} catch (Exception $e) {
    error_log('Payment processing error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error processing payment: ' . $e->getMessage()
    ]);
}