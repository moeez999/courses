<?php
// local/membership/braintree/retry_bootstrap.php
define('AJAX_SCRIPT', true);
// Prevent Moodle debug HTML in JSON responses:
define('NO_DEBUG_DISPLAY', true);

require_once(__DIR__ . '/../../../config.php');  // <-- FIXED (3 levels up)
require_once($CFG->dirroot . '/local/membership/braintree/lib.php');

require_login(); // make sure user is logged in (else Moodle would return an HTML login page)
header('Content-Type: application/json; charset=utf-8');

global $DB, $USER;

try {
    $subscriptionid = optional_param('subscriptionid', '', PARAM_RAW_TRIMMED);

    if ($subscriptionid === '') {
        $rec = $DB->get_record_sql("
            SELECT *
              FROM {local_subscriptions}
             WHERE sub_platform = 'braintree'
               AND sub_user = :uid
          ORDER BY id DESC
             LIMIT 1
        ", ['uid' => $USER->id]);
        if ($rec && !empty($rec->sub_reference)) {
            $subscriptionid = $rec->sub_reference;
        }
    }

    if ($subscriptionid === '') {
        echo json_encode(['success' => false, 'error' => 'No Braintree subscription found for this user.']);
        exit;
    }

    $gateway = get_braintree_gateway();
    $sub = $gateway->subscription()->find($subscriptionid);

    $price = $sub->price ?? null;
    $displayPrice = !empty($price) ? '$' . htmlspecialchars($price) : '$20';

    $clientToken = $gateway->clientToken()->generate();

    echo json_encode([
        'success' => true,
        'subscriptionId' => $subscriptionid,
        'clientToken' => $clientToken,
        'displayPrice' => $displayPrice
    ]);
} catch (Throwable $t) {
    // Log server-side; return JSON-safe error
    error_log('retry_bootstrap error: ' . $t->getMessage());
    echo json_encode(['success' => false, 'error' => $t->getMessage()]);
}