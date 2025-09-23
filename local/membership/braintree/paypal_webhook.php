<?php
define('NO_MOODLE_COOKIES', true);

// Debugging logs
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/filelib.php');

global $DB;

// Read raw webhook body
$bodyReceived = file_get_contents("php://input");
file_put_contents(__DIR__ . '/paypal_webhook_raw.log', $bodyReceived . "\n\n", FILE_APPEND);

if (empty($bodyReceived)) {
    file_put_contents(__DIR__.'/paypal_webhook.log', "❌ Empty webhook body\n\n", FILE_APPEND);
    http_response_code(400);
    exit("Empty Body");
}

$webhookEvent = json_decode($bodyReceived, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    $error = json_last_error_msg();
    file_put_contents(__DIR__.'/paypal_webhook.log', "❌ JSON decode error: $error\n\n", FILE_APPEND);
    http_response_code(400);
    exit("Invalid JSON: $error");
}

$eventType = $webhookEvent['event_type'] ?? 'UNKNOWN_EVENT';
$resource = $webhookEvent['resource'] ?? [];
file_put_contents(__DIR__.'/paypal_webhook.log', "\n✅ Event received: $eventType\n", FILE_APPEND);

function get_paypal_token() {
    $clientId = get_config('local_membership', 'paypalsubscriptionclientid');
    $secret = get_config('local_membership', 'paypalsubscriptionsecret');

    if (empty($clientId) || empty($secret)) {
        file_put_contents(__DIR__.'/paypal_webhook.log', "❌ Missing PayPal client credentials\n", FILE_APPEND);
        return null;
    }

    $url = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERPWD => "$clientId:$secret",
        CURLOPT_POSTFIELDS => "grant_type=client_credentials",
        CURLOPT_HTTPHEADER => ['Accept: application/json']
    ]);
    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);
    return $result['access_token'] ?? null;
}

function get_paypal_subscription_details($subscriptionId, $accessToken) {
    $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/{$subscriptionId}";
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $accessToken",
            "Content-Type: application/json"
        ]
    ]);
    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

if (strpos($eventType, 'BILLING.SUBSCRIPTION.') === 0 && !empty($resource['id'])) {
    $subscriptionId = $resource['id'];
    $accessToken = get_paypal_token();

    if (!$accessToken) {
        http_response_code(500);
        exit("Could not get PayPal access token");
    }

    $details = get_paypal_subscription_details($subscriptionId, $accessToken);

    if ($details) {
        $email = $details['subscriber']['email_address'] ?? 'unknown@example.com';
        $name = ($details['subscriber']['name']['given_name'] ?? '') . ' ' . ($details['subscriber']['name']['surname'] ?? '');
        $status = $details['status'] ?? 'UNKNOWN';
        $price = $details['billing_info']['last_payment']['amount']['value'] ?? 0;
        $startDate = strtotime($details['start_time'] ?? 'now');
        $endDate = isset($details['billing_info']['next_billing_time']) 
            ? strtotime($details['billing_info']['next_billing_time']) 
            : 0;
        $billingFrequency = $details['billing_info']['cycle_executions'][0]['frequency']['interval_unit'] ?? 'UNKNOWN';

        $record = $DB->get_record('paypal_subscriptions', ['subscription_id' => $subscriptionId]);

        $data = (object)[
            'subscription_id'    => $subscriptionId,
            'name'               => $name,
            'email'              => $email,
            'method'             => 'paypal',
            'status'             => $status,
            'price'              => $price,
            'start_date'         => $startDate,
            'end_date'           => $endDate,
            'billing_frequency'  => $billingFrequency,
            'timeupdated'        => time()
        ];

        if ($record) {
            $data->id = $record->id;
            $DB->update_record('paypal_subscriptions', $data);
            file_put_contents(__DIR__.'/paypal_webhook.log', "🔄 Updated subscription $subscriptionId\n", FILE_APPEND);
        } else {
            $data->timecreated = time();
            $DB->insert_record('paypal_subscriptions', $data);
            file_put_contents(__DIR__.'/paypal_webhook.log', "🆕 Inserted subscription $subscriptionId\n", FILE_APPEND);
        }
    } else {
        file_put_contents(__DIR__.'/paypal_webhook.log', "⚠️ No subscription details found for $subscriptionId\n", FILE_APPEND);
    }

} elseif ($eventType === 'PAYMENT.SALE.COMPLETED') {
    $transactionId = $resource['id'] ?? '';
    $payerEmail = $resource['payer']['email_address'] ?? 'unknown@example.com';
    $amount = $resource['amount']['value'] ?? 0;
    file_put_contents(__DIR__.'/paypal_webhook.log', "💵 Payment completed: $transactionId - $payerEmail - $amount\n", FILE_APPEND);
} else {
    file_put_contents(__DIR__.'/paypal_webhook.log', "ℹ️ Unhandled event type: $eventType\n", FILE_APPEND);
}

http_response_code(200);
echo "OK";
exit;
