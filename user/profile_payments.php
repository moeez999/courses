<?php
// Initialize empty array to store all payments
$allPayments = [];

try {
    // 1. Get Braintree Payments
    if ($DB->get_manager()->table_exists('payment_braintree')) {
        $braintreePayments = $DB->get_records_sql(
            "SELECT p.id, p.amount, p.currency, p.timecreated, 
                    p.status, 'Braintree' as paymentmethod, 
                    c.fullname as coursename, c.shortname as courseshort
             FROM {payment_braintree} p
             LEFT JOIN {course} c ON c.id = p.courseid
             WHERE p.userid = :userid
             ORDER BY p.timecreated DESC",
            ['userid' => $USER->id]
        );
        $allPayments = array_merge($allPayments, array_values($braintreePayments));
    }
} catch (Exception $e) {
    debugging('Error reading Braintree payments: ' . $e->getMessage(), DEBUG_NORMAL);
}

try {
    // 2. Get PayPal Payments
    if ($DB->get_manager()->table_exists('payment_paypal')) {
        $paypalPayments = $DB->get_records_sql(
            "SELECT p.id, p.amount, p.currency, p.timecreated, 
                    p.status, 'PayPal' as paymentmethod,
                    c.fullname as coursename, c.shortname as courseshort
             FROM {payment_paypal} p
             LEFT JOIN {course} c ON c.id = p.courseid
             WHERE p.userid = :userid
             ORDER BY p.timecreated DESC",
            ['userid' => $USER->id]
        );
        $allPayments = array_merge($allPayments, array_values($paypalPayments));
    }
} catch (Exception $e) {
    debugging('Error reading PayPal payments: ' . $e->getMessage(), DEBUG_NORMAL);
}

try {
    // 3. Get Patreon Payments
    if ($DB->get_manager()->table_exists('payment_patreon')) {
        $patreonPayments = $DB->get_records_sql(
            "SELECT p.id, p.amount, 'USD' as currency, p.timecreated, 
                    p.status, 'Patreon' as paymentmethod,
                    p.membership_level as coursename, '' as courseshort
             FROM {payment_patreon} p
             WHERE p.userid = :userid
             ORDER BY p.timecreated DESC",
            ['userid' => $USER->id]
        );
        $allPayments = array_merge($allPayments, array_values($patreonPayments));
    }
} catch (Exception $e) {
    debugging('Error reading Patreon payments: ' . $e->getMessage(), DEBUG_NORMAL);
}

// Sort all payments by date (newest first)
usort($allPayments, function($a, $b) {
    return $b->timecreated <=> $a->timecreated;
});

// Limit to 5 most recent payments
$recentPayments = array_slice($allPayments, 0, 5);

echo '
<div class="col-lg-5 col-md-12">
    <section id="payment-history" class="card">
        <h2>' . get_string('paymenthistory', 'core_user') . '</h2>
        <div class="payment-list">';

if (empty($recentPayments)) {
    echo '<div class="no-payments">' . get_string('nopaymenthistory', 'core_user') . '</div>';
} else {
    foreach ($recentPayments as $payment) {
        $paymentdate = userdate($payment->timecreated, get_string('strftimedate', 'langconfig'));
        $methodclass = strtolower($payment->paymentmethod);
        $statusclass = ($payment->status == 'completed') ? 'present' : '';
        $shortname = !empty($payment->courseshort) ? $payment->courseshort : substr($payment->coursename, 0, 3);
        
        echo '
        <div class="payment-item">
            <div class="payment-info">
                <div class="payment-method-badge ' . $methodclass . '">
                    <span class="method-main">' . strtoupper(substr($payment->paymentmethod, 0, 2)) . '</span>
                    <span class="method-sub">' . format_float($payment->amount, 2) . ' ' . $payment->currency . '</span>
                </div>
                <span>' . $shortname . ' - ' . format_string($payment->coursename) . '</span>
            </div>
            <span class="payment-date ' . $statusclass . '">' . $paymentdate . '</span>
        </div>';
    }
}