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

global $CFG, $DB;

$gateway = get_braintree_gateway();

// Get the payload and signature from Braintree
$payload = $_POST['bt_payload'] ?? '';
$signature = $_POST['bt_signature'] ?? '';


try {
    $webhookNotification = $gateway->webhookNotification()->parse(
        $signature,
        $payload
    );

    // Handle the webhook event
    switch ($webhookNotification->kind) {
        case 'subscription_charged_successfully':
            // Handle successful subscription charge
            $subscriptionId = $webhookNotification->subscription->id;
            // Update your Moodle database as needed

            // Log the verified webhook payload
            // $filePath = __DIR__ . '/webhook_log.txt'; // Save log in the same folder
            // $file = fopen($filePath, 'a');
            // fwrite($file, date('Y-m-d H:i:s') . " - Webhook Received:\n");
            // fwrite($file, print_r($webhookNotification, true));
            // fclose($file);

            break;

        case 'subscription_charged_unsuccessfully':
            // Handle failed subscription charge
            $subscriptionId = $webhookNotification->subscription->id;
            // Notify the user or take necessary actions
            break;

        case 'subscription_canceled':
            // Handle subscription cancellation
            $subscriptionId = $webhookNotification->subscription->id;
            hanlde_subscription_canceled($subscriptionId, $DB);

            break;

        case 'subscription_expired':
            // Handle subscription expiration
            $subscriptionId = $webhookNotification->subscription->id;
            hanlde_subscription_canceled($subscriptionId, $DB);

            break;

        // Add other webhook types as needed
        default:
            // Log unhandled webhook events
            error_log('Unhandled webhook: ' . $webhookNotification->kind);
    }

    // Send a 200 response to acknowledge receipt
    http_response_code(200);
    echo "Webhook received";
} catch (\Exception $e) {

    // Log the error for debugging
    error_log('Webhook verification failed: ' . $e->getMessage());
    http_response_code(500);
    echo "Webhook verification failed";
}


function hanlde_subscription_canceled($subscriptionId, $DB)
{
    $gateway = get_braintree_gateway();

    $cancelSub = $gateway->subscription()->cancel($subscriptionId);

    if ($cancelSub->success) {
        $subscription = $DB->get_record('local_subscriptions', array('sub_reference' => $subscriptionId));
        if (empty($subscription)) {
            return false;
        }

        $oldmembershipcohorts = array();
        $oldmembershipcohorts = explode(',', $subscription->sub_cohorts);

        foreach ($oldmembershipcohorts as $cohortid) {
            $cohort = $DB->get_record('cohort', array('id' => $cohortid), '*', MUST_EXIST);

            if (!empty($cohort)) {
                $cohort_members = $DB->get_records('cohort_members', array('cohortid' => $cohortid, 'userid' => $subscription->sub_user));

                if (!empty($cohort_members)) {
                    foreach ($cohort_members as $cohort_member) {
                        $DB->delete_records('cohort_members', array('id' => $cohort_member->id));
                    }
                }
            }
        }

        $DB->execute("UPDATE {local_subscriptions} SET sub_status = 0 WHERE id = '{$subscription->id}' AND sub_id = '{$subscription->sub_id}'");

        return true;
    }

    return false;
}