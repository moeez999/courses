<?php
// local/membership/server/update_subscription_payment_and_retry.php
define('AJAX_SCRIPT', true);

require('../../../config.php');
require_once($CFG->dirroot . '/local/membership/braintree/lib.php'); // your gateway + helpers

require_login();


header('Content-Type: application/json; charset=utf-8');

use Braintree\Exception\NotFound;

// Helper to send error JSON and stop.
function send_error($message, $httpcode = 400) {
    http_response_code($httpcode);
    echo json_encode(['success' => false, 'error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // ---- Inputs ----
    $subscriptionId     = optional_param('subscriptionId', '', PARAM_RAW_TRIMMED);
    $paymentMethodNonce = optional_param('paymentMethodNonce', '', PARAM_RAW_TRIMMED);

    if ($subscriptionId === '' || $paymentMethodNonce === '') {
        send_error('Missing required parameters: subscriptionId or paymentMethodNonce', 400);
    }

    // ---- Braintree gateway ----
    if (!function_exists('get_braintree_gateway')) {
        send_error('Braintree gateway helper not found. Did you include local/membership/braintree/lib.php?', 500);
    }
    $gateway = get_braintree_gateway();

    // ---- Load subscription ----
    try {
        $subscription = $gateway->subscription()->find($subscriptionId);
    } catch (NotFound $e) {
        send_error('Subscription not found: ' . $subscriptionId, 404);
    } catch (Exception $e) {
        send_error('Error loading subscription: ' . $e->getMessage(), 500);
    }

    // ---- Resolve customerId tied to the subscription ----
    $customerId = null;

    // Preferred: through current payment method token
    if (!empty($subscription->paymentMethodToken)) {
        try {
            $currentPm = $gateway->paymentMethod()->find($subscription->paymentMethodToken);
            if (!empty($currentPm->customerId)) {
                $customerId = $currentPm->customerId;
            }
        } catch (Exception $e) {
            // fall through to transaction-based fallback
        }
    }

    // Fallback: infer from a transaction on the subscription
    if (!$customerId && is_array($subscription->transactions) && count($subscription->transactions) > 0) {
        $txn = $subscription->transactions[0];
        // Braintree PHP SDK exposes customer details like this:
        if (!empty($txn->customerDetails) && !empty($txn->customerDetails->id)) {
            $customerId = $txn->customerDetails->id;
        }
    }

    if (!$customerId) {
        send_error('Unable to resolve customerId for this subscription.', 400);
    }

    // ---- Vault new payment method for this customer ----
    $pmCreate = $gateway->paymentMethod()->create([
        'customerId'         => $customerId,
        'paymentMethodNonce' => $paymentMethodNonce,
        'options' => [
            'makeDefault' => true,
            // You can enable verification if desired:
            // 'verifyCard' => true,
            // 'verificationMerchantAccountId' => 'YOUR_MERCHANT_ACCOUNT_ID',
        ],
    ]);

    if (!$pmCreate->success) {
        $errs = [];
        foreach ($pmCreate->errors->deepAll() as $e) {
            $errs[] = "{$e->attribute}: {$e->message}";
        }
        send_error('Failed to create payment method: ' . (implode('; ', $errs) ?: 'Unknown error'), 400);
    }

    $newPaymentMethodToken = $pmCreate->paymentMethod->token ?? null;
    if (!$newPaymentMethodToken) {
        send_error('Payment method token not returned by gateway.', 500);
    }

    // ---- Point the SAME subscription to the new payment method ----
    $upd = $gateway->subscription()->update($subscriptionId, [
        'paymentMethodToken' => $newPaymentMethodToken,
    ]);

    if (!$upd->success) {
        $errs = [];
        foreach ($upd->errors->deepAll() as $e) {
            $errs[] = "{$e->attribute}: {$e->message}";
        }
        send_error('Failed to update subscription: ' . (implode('; ', $errs) ?: 'Unknown error'), 400);
    }

    $finalStatus = $upd->subscription->status;

    // ---- If Past Due, retry the failed charge now ----
    $retryTxnId = null;
    if ($finalStatus === 'Past Due') {
        $chargeResult = $gateway->subscription()->retryCharge($subscriptionId);
        if (!$chargeResult->success) {
            // Provide processor decline info if present
            $txn = $chargeResult->transaction ?? null;
            if ($txn && !empty($txn->processorResponseText)) {
                $msg = $txn->processorResponseText . (!empty($txn->processorResponseCode) ? " ({$txn->processorResponseCode})" : '');
            } else {
                $msg = 'Retry charge failed.';
            }
            send_error($msg, 402); // Payment Required
        }
        $retryTxnId = $chargeResult->transaction->id ?? null;

        // Reload to reflect latest status if you want; or trust gateway state transition:
        try {
            $reloaded = $gateway->subscription()->find($subscriptionId);
            $finalStatus = $reloaded->status ?? $finalStatus;
        } catch (Exception $e) {
            // ignore; keep prior status
        }
    }{
        
    }

    // ---- Success ----
    echo json_encode([
        'success' => true,
        'subscriptionId' => $subscriptionId,
        'newPaymentMethodToken' => $newPaymentMethodToken,
        'finalStatus' => $finalStatus,          // likely "Active" if retry succeeded
        'retryTransactionId' => $retryTxnId,    // null if no retry was needed
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $t) {
    send_error('Server error: ' . $t->getMessage(), 500);
}