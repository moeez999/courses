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

require_once($CFG->dirroot . '/local/membership/sdk/braintree/lib/Braintree.php');

use Braintree\Gateway;

$gateway = new Gateway([
    'environment' => 'production',
	'merchantId' => '8p7h9vxrqn7tg3y2',
	'publicKey' => 'jxbsqpmck8k8bh68',
	'privateKey' => 'fff157d00e1bd11f8f3c2f1cded28945'
// 	'environment' => 'sandbox',
// 	'merchantId' => 'ht2c3c3zc8qt95bx',
// 	'publicKey' => '25vf3jwv9bmsqrmv',
// 	'privateKey' => 'a26422cbe4ad068838c1d3af263578e0'
// 	'publicKey' => 'dq54gyr9j3sfmy6m',
// 	'privateKey' => '9254ce25a4ad410f4bf9e4ea1122931f'
	// 'merchantId' => 'f2vwyjctcs857tyr',
	// 'publicKey' => 'rpmw7cz7xs8tnq8v',
	// 'privateKey' => '47a02ca4e166e235720b0a8d989feff7'
]);

function get_braintree_gateway()
{
	global $gateway;
	return $gateway;
}

function get_braintree_subscriptions_data($isAdmin, $userId)
{
	global $DB, $USER;
	$isAdmin = true;
	$braintreeSubscriptionsData = [];
	if ($isAdmin) {
		$braintreeSubscriptions = $DB->get_records_sql("SELECT * FROM {local_subscriptions} WHERE sub_platform = 'braintree' ORDER BY id DESC");
	} else {
		$braintreeSubscriptions = $DB->get_records_sql("SELECT * FROM {local_subscriptions} WHERE sub_user = {$USER->id} AND sub_platform = 'braintree' ORDER BY id DESC");
	}

	foreach ($braintreeSubscriptions as $record) {
		$braintreeSubscriptionsData[] = get_braintree_subscription_details($record);
	}
	return array_filter($braintreeSubscriptionsData, function ($item) {
		return is_array($item);
	});

	// return $braintreeSubscriptionsData;
}


function get_braintree_subscription_details($record)
{
	global $DB;

	$gateway = get_braintree_gateway();
	try {
		$subscription = $gateway->subscription()->find($record->sub_reference);
		
		// --- NEW: compare & update status for THIS record only ---
        $newstatusint = _bt_status_to_int($subscription->status);
        // Cast both to string to avoid null/int strictness issues

            $update = (object)[
                'id'           => $record->id,
                'sub_status'   => $newstatusint,
                'sub_modified' => time(),
            ];

            $DB->update_record('local_subscriptions', $update);

            // Also update the in-memory $record so returned data reflects current status
            $record->sub_status = $newstatusint;
        
        // --- end NEW --

		$startDate = $subscription->billingPeriodStartDate;
		$endDate = $subscription->billingPeriodEndDate;

		$interval = $startDate->diff($endDate);
		$billingFrequency = $interval->m + ($interval->y * 12);

		if ($startDate->format('d') != $endDate->format('d')) {
			$billingFrequency += 1;
		}

		$user = $DB->get_record('user', ['id' => $record->sub_user]);

		$discountData = [];
		$subHistory = json_decode($record->sub_history, true);

		if (is_array($subHistory) && !empty($subHistory)) {
			$lastEntry = end($subHistory);
			$planDiscount = isset($lastEntry['plan_discount']) ? json_decode($lastEntry['plan_discount'], true) : null;
			if ($planDiscount !== null) {
				$discountData = $planDiscount;
			}
		}

		$subCohorts = get_cohort_names_by_ids($record->sub_cohorts);
		$cohortColumnInfo = $subCohorts;

		if (!empty($record->sub_cron) && !empty($record->sub_new_cohorts)) {
			$currentDate = new DateTime();
			$scheduleDate = new DateTime();
			$scheduleDate->setTimestamp($record->sub_cron);

			$timeDiff = $scheduleDate->getTimestamp() - $currentDate->getTimestamp();
			$daysRemaining = ceil($timeDiff / (60 * 60 * 24));

			if ($daysRemaining > 0) {
				$daysRemainingText = "{$daysRemaining} days";
			} else {
				$daysRemainingText = 'today';
			}

			$newCohortNames = get_cohort_names_by_ids($record->sub_new_cohorts);
			$cohortColumnInfo = "{$subCohorts}, scheduled to: {$newCohortNames} in {$daysRemainingText}";
		}

		return [
			'id' => $subscription->id,
			'name' => $user->firstname . ' ' . $user->lastname,
			'email' => $user->email,
			'method' => 'braintree',
			'planId' => $subscription->planId,
			'planKey' => $record->sub_id,
			'status' => strtolower($subscription->status),
			'price' => $subscription->price,
			'discount' => json_encode($discountData),
			'startDate' => $startDate->format('Y-m-d'),
			'endDate' => $endDate->format('Y-m-d'),
			'billingFrequency' => $billingFrequency,
			'cohortColumn' => $cohortColumnInfo,
			'cohortIds' => $record->sub_cohorts,
			'cohort' => $subCohorts,
			'action' => null
		];
	} catch (\Braintree\Exception\NotFound $e) {
		return null;
	} catch (\Exception $e) {
		error_log($e->getMessage());
		return null;
	}
}



function cancel_braintree_subscription($subscriptionId)
{
	$gateway = get_braintree_gateway();
	$cancelSub = $gateway->subscription()->cancel($subscriptionId);
	if ($cancelSub->success) {
		return true;
	}
	return false;
}

// Map Braintree status string -> your bigint code.
function _bt_status_to_int(?string $status): int {
    static $map = [
        'Active'   => 1,
        'Canceled' => 2,
        'Expired'  => 3,
        'Past Due' => 4,
        'Pending'  => 5,
    ];
    return $map[$status ?? ''] ?? 0;
}

?>