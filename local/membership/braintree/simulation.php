<?php

/**
 * Local plugin "membership" - Braintree lib file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require('../../../config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/local/membership/lib.php');
// require_once($CFG->dirroot . '/local/membership/sdk/braintree/lib/Braintree.php');

// use Braintree\Gateway;

// $gateway = new Gateway([
//     'environment' => 'sandbox',
//     'merchantId' => 'ht2c3c3zc8qt95bx',
//     'publicKey' => 'dq54gyr9j3sfmy6m',
//     'privateKey' => '9254ce25a4ad410f4bf9e4ea1122931f'
// ]);

$gateway = get_braintree_gateway();

// Generate a sample webhook payload
$sampleNotification = $gateway->webhookTesting()->sampleNotification(
    // "subscription_canceled", // Replace with the desired event type
    "subscription_expired", // Replace with the desired event type
    "5dxfcv" // Replace with a sample subscription ID
);

// Get the payload and signature
$payload = $sampleNotification['bt_payload'];
$signature = $sampleNotification['bt_signature'];

// Send the payload to your webhook URL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://dev.latingles.com/local/membership/braintree/webhook.php");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    "bt_signature" => $signature,
    "bt_payload" => $payload
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo "Webhook test response: $response";
