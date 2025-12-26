<?php
/**
 * Local plugin "membership" - Payment History Handler
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/local/membership/lib.php');
require_login();

global $DB, $USER;

// Initialize parameters
$start = optional_param('start', 0, PARAM_INT);
$length = optional_param('length', 10, PARAM_INT);
$draw = optional_param('draw', 1, PARAM_INT);

// 1. Get Braintree Payments
$braintreePayments = [];
if (function_exists('get_braintree_payments')) {
    $braintreePayments = $DB->get_records_sql(
        "SELECT p.id, p.userid, p.amount, p.currency, 
                p.paymentgateway, p.timecreated, p.timemodified, 
                p.status, p.transactionid, 'braintree' as source,
                c.shortname as courseshortname, c.fullname as coursefullname
         FROM {payment_braintree} p
         LEFT JOIN {course} c ON c.id = p.courseid
         WHERE p.userid = :userid
         ORDER BY p.timecreated DESC",
        ['userid' => $USER->id]
    );
}

// 2. Get PayPal Payments
$paypalPayments = [];
if (function_exists('get_paypal_payments')) {
    $paypalPayments = $DB->get_records_sql(
        "SELECT p.id, p.userid, p.amount, p.currency, 
                'paypal' as paymentgateway, p.timecreated, p.timemodified, 
                p.status, p.txn_id as transactionid, 'paypal' as source,
                c.shortname as courseshortname, c.fullname as coursefullname
         FROM {payment_paypal} p
         LEFT JOIN {course} c ON c.id = p.courseid
         WHERE p.userid = :userid
         ORDER BY p.timecreated DESC",
        ['userid' => $USER->id]
    );
}

// 3. Get Patreon Payments
$patreonPayments = [];
if (function_exists('get_patreon_payments')) {
    $patreonPayments = $DB->get_records_sql(
        "SELECT p.id, p.userid, p.amount, 'USD' as currency, 
                'patreon' as paymentgateway, p.timecreated, p.timemodified, 
                p.status, p.patreon_id as transactionid, 'patreon' as source,
                NULL as courseshortname, p.membership_level as coursefullname
         FROM {payment_patreon} p
         WHERE p.userid = :userid
         ORDER BY p.timecreated DESC",
        ['userid' => $USER->id]
    );
}

// 4. Get Moodle Enrolment Payments (if using enrol_plugin)
$enrolPayments = [];
if (function_exists('enrol_get_my_payments')) {
    $enrolPayments = $DB->get_records_sql(
        "SELECT e.id, e.userid, p.cost as amount, p.currency, 
                e.enrol as paymentgateway, e.timecreated, e.timemodified, 
                'completed' as status, e.id as transactionid, 'enrol' as source,
                c.shortname as courseshortname, c.fullname as coursefullname
         FROM {user_enrolments} e
         JOIN {enrol} p ON p.id = e.enrolid
         JOIN {course} c ON c.id = p.courseid
         WHERE e.userid = :userid AND p.cost > 0
         ORDER BY e.timecreated DESC",
        ['userid' => $USER->id]
    );
}

// Combine all payment sources
$allPayments = array_merge(
    array_values($braintreePayments),
    array_values($paypalPayments),
    array_values($patreonPayments),
    array_values($enrolPayments)
);

// Sort by timecreated descending
usort($allPayments, function($a, $b) {
    return $b->timecreated <=> $a->timecreated;
});

// Paginate results
$totalRecords = count($allPayments);
$filteredPayments = array_slice($allPayments, $start, $length);

// Prepare DataTables response
$response = [
    "draw" => $draw,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords,
    "data" => []
];

foreach ($filteredPayments as $payment) {
    $paymentDate = userdate($payment->timecreated, get_string('strftimedatetimeshort', 'langconfig'));
    $statusClass = strtolower($payment->status);
    
    $response['data'][] = [
        'id' => $payment->id,
        'date' => $paymentDate,
        'amount' => format_float($payment->amount, 2) . ' ' . $payment->currency,
        'course' => !empty($payment->coursefullname) ? 
            format_string($payment->coursefullname) . ' (' . $payment->courseshortname . ')' : 
            get_string('notapplicable', 'local_membership'),
        'method' => ucfirst($payment->source),
        'gateway' => ucfirst($payment->paymentgateway),
        'transaction_id' => $payment->transactionid,
        'status' => '<span class="payment-status badge badge-' . $statusClass . '">' . 
                    ucfirst($payment->status) . '</span>',
        'receipt' => '<button class="btn btn-sm btn-outline-primary receipt-btn" data-paymentid="' . 
                    $payment->id . '" data-source="' . $payment->source . '">' .
                    get_string('viewreceipt', 'local_membership') . '</button>'
    ];
}

// Send JSON response
@header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
exit;