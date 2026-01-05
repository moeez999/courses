<?php

/**
 * Local plugin "membership" - Lib file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once($CFG->dirroot . '/local/membership/braintree/lib.php');
require_once($CFG->dirroot . '/local/membership/patreon/lib.php');
require_once($CFG->dirroot . '/local/membership/paypal/lib.php');
require_once($CFG->dirroot . '/cohort/lib.php');


function get_plan_data($plan_id, $user_id) {
    global $DB;

    $interval = 1;
    $keyword = 'mes';

    $status = 0;

    $statusText = 'Suscribirse';

    $planIdentifier = get_config('local_membership', 'membershipid' . $plan_id);

    $plan_status = $DB->get_record('local_subscriptions', ['sub_user' => $user_id, 'sub_id' => $planIdentifier, 'sub_status' => 1]);
    if (!empty($plan_status) && $plan_status->sub_id == $planIdentifier) {
        $status = 1;
        $statusText = 'Suscrito';
    }

    $currency = get_config('local_membership', 'paymentcurrency');

    $monthlyFee = get_config('local_membership', 'membershipmonthlyfee' . $plan_id);
    $biannuallyFee = get_config('local_membership', 'membershipbiannuallyfee' . $plan_id);
    $yearlyFee = get_config('local_membership', 'membershipyearlyfee' . $plan_id);

    $planFree = false;
    $planMonthly = false;
    $planBiannually = false;
    $planYearly = false;

    $planData = new stdClass();


    $planName = 'Default';
    if (!empty(get_config('local_membership', 'membershipname' . $plan_id))) {
      $planName = get_config('local_membership', 'membershipname' . $plan_id);
  }
  $haveDescription = false;
  $planDescription = '';


  if (!empty(get_config('local_membership', 'membershipplandescription' . $plan_id))) {
    $haveDescription = true;
    $planDescription = get_config('local_membership', 'membershipplandescription' . $plan_id);
}

$schedules = null;
$startDate = null;
$haveStartDate = false;
$haveSchedules = false;
$haveTutorSchedules = false;
$planSchedules = [];
$planTutorSchedules = [];
$cohortIds = get_config('local_membership', 'membershipcohorts' . $plan_id);
$cohortIdsFormatted = $cohortIds;
$cohortIds = explode(',', $cohortIds);
$cohortsArray = [];


foreach ($cohortIds as $cohort_id) {
    $cohort_data = get_cohort_schedule($cohort_id);
    $formatted_schedule = format_cohort_schedule($cohort_data);

    if ($formatted_schedule) {
        if (!empty($formatted_schedule->startdate)) {
            $startDate = $formatted_schedule->startdate;
            $haveStartDate = true;
        }
        if (!empty($formatted_schedule->days) && !empty($formatted_schedule->time)) {
            $cohort_schedule = new stdClass();
            $cohort_schedule->cohortName = $formatted_schedule->name;
            $cohort_schedule->days = $formatted_schedule->days;
            $cohort_schedule->time = $formatted_schedule->time;
            $planSchedules['cohort'] = $cohort_schedule;
            //$planSchedules['cohort'] = $formatted_schedule;

            $haveSchedules = true;
        }
        if (!empty($formatted_schedule->tutordays) && !empty($formatted_schedule->tutortime)) {
            $tutorcohort_schedule = new stdClass();
            $tutorcohort_schedule->tutordays = $formatted_schedule->tutordays;
            $tutorcohort_schedule->tutortime = $formatted_schedule->tutortime;
            $planSchedules['tutor'] = $tutorcohort_schedule;
            //$planSchedules['tutor'] = $formatted_schedule;

            $haveTutorSchedules = true;
        }
    }
}

$weekDaysOrder = [
    'Lunes' => 1,
    'Martes' => 2,
    'Miércoles' => 3,
    'Jueves' => 4,
    'Viernes' => 5,
];

if ($haveSchedules && $haveTutorSchedules) {
    $cohort_days = explode(', ', $planSchedules['cohort']->days);
    $tutor_days = explode(', ', $planSchedules['tutor']->tutordays);

    if ($planSchedules['cohort']->time == $planSchedules['tutor']->tutortime) {
        $all_days = array_unique(array_merge($cohort_days, $tutor_days));
        
        usort($all_days, function ($a, $b) use ($weekDaysOrder) {
            return $weekDaysOrder[$a] - $weekDaysOrder[$b];
        });

        $combined_days = implode(', ', $all_days);
        
        $schedules['days'] = $combined_days;
        $schedules['time'] = $planSchedules['cohort']->time;
    } else {
        $schedules['days'] = $planSchedules['cohort']->days;
        $schedules['time'] = $planSchedules['cohort']->time;
        $schedules['tutordays'] = $planSchedules['tutor']->tutordays;
        $schedules['tutortime'] = $planSchedules['tutor']->tutortime;
    }
} elseif ($haveSchedules) {
    $schedules['days'] = $planSchedules['cohort']->days;
    $schedules['time'] = $planSchedules['cohort']->time;
}

if ($haveTutorSchedules && !$haveSchedules) {
    $schedules['tutordays'] = $planSchedules['tutor']->tutordays;
    $schedules['tutortime'] = $planSchedules['tutor']->tutortime;
}



$planDiscounts = new stdClass();
$planDiscounts->biannually = 0;
$planDiscounts->yearly = 0;

if (empty($monthlyFee) && empty($biannuallyFee) && empty($yearlyFee)) {
    $planFree = true;
    $planData->free = (object) [
        'price' => 0,
        'interval' => 1,
        'billing' => 0,
        'keyword' => 'gratuito',
        'enabled' => true
    ];
} else {
    if ($monthlyFee > 0) {
        $planMonthly = true;
        $monthlyInterval = get_config('local_membership', 'membershipmonthlyintervalvalue' . $plan_id) ?? 1;
        $monthlyBilling = get_config('local_membership', 'noofmembershipmonthlybillingcycles' . $plan_id) ?? 0;
        $monthlyPrice = number_format((float)$monthlyFee, 0, '.', '');


        $planData->monthly = (object) [
            'price' => $monthlyPrice,
            'interval' => $monthlyInterval,
            'billing' => $monthlyBilling,
            'keyword' => ($monthlyInterval == 1) ? 'mes' : 'meses',
            'enabled' => true
        ];
    }

    if ($biannuallyFee > 0) {
        $planBiannually = true;
        $biannuallyInterval = get_config('local_membership', 'membershipbiannuallyintervalvalue' . $plan_id) ?? 6;
        $biannuallyBilling = get_config('local_membership', 'noofmembershipbiannuallybillingcycles' . $plan_id) ?? 0;
        $biannuallyPrice = number_format((float)$biannuallyFee, 0, '.', '');

        $planData->biannually = (object) [
            'price' => $biannuallyPrice,
            'interval' => $biannuallyInterval,
            'billing' => $biannuallyBilling,
            'keyword' => 'meses',
            'enabled' => true
        ];

        if (isset($planData->monthly)) {
            $monthlyNumericPrice = floatval($planData->monthly->price);
            $monthlyTotalForBiannually = $monthlyNumericPrice * ($biannuallyInterval / $monthlyInterval);
            if ($monthlyTotalForBiannually > 0) {
                $biannuallyDiscount = (($monthlyTotalForBiannually - $biannuallyFee) / $monthlyTotalForBiannually) * 100;
                $planDiscounts->biannually = number_format((float)$biannuallyDiscount, 0, '.', '');
                $planDiscounts->biannuallyPrice = number_format((float)$monthlyTotalForBiannually, 0, '.', '');
                $planDiscounts->biannuallyText = number_format((float)$biannuallyDiscount, 0, '.', '') . '%';
            }
        }
    }

    if ($yearlyFee > 0) {
        $planYearly = true;
        $yearlyInterval = get_config('local_membership', 'membershipyearlyintervalvalue' . $plan_id) ?? 12;
        $yearlyBilling = get_config('local_membership', 'noofmembershipyearlybillingcycles' . $plan_id) ?? 0;
        $yearlyPrice = number_format((float)$yearlyFee, 0, '.', '');

        $planData->yearly = (object) [
            'price' => $yearlyPrice,
            'interval' => $yearlyInterval,
            'billing' => $yearlyBilling,
            'keyword' => 'meses',
            'enabled' => true
        ];

        if (isset($planData->monthly)) {
            $monthlyNumericPrice = floatval($planData->monthly->price);
            $monthlyTotalForYearly = $monthlyNumericPrice * ($yearlyInterval / $monthlyInterval);
            if ($monthlyTotalForYearly > 0) {
                $yearlyDiscount = (($monthlyTotalForYearly - $yearlyFee) / $monthlyTotalForYearly) * 100;
                $planDiscounts->yearly = number_format((float)$yearlyDiscount, 0, '.', '');
                $planDiscounts->yearlyPrice = number_format((float)$monthlyTotalForYearly, 0, '.', '');
                $planDiscounts->yearlyText = number_format((float)$yearlyDiscount, 0, '.', '') . '%';
            }
        }
    }
}



$planCohorts = [];
foreach ($cohortIds as $cohortid) {
    if ($cohortid != 0) {
        $planCohorts[] = get_cohort_name_by_id($cohortid);
        $cohortsArray[] = $cohortid;
    }
}

$noofmembershipfeatures = get_config('local_membership', 'noofmembershipfeatures' . $plan_id);

$planFeatures = [];

if (!empty($noofmembershipfeatures)) {
    for ($fkey = 1; $fkey <= $noofmembershipfeatures; $fkey++) {
        $featureName = get_config('local_membership', 'membershipfeaturestext' . $plan_id . $fkey);
        if (!empty($featureName)) {
            $planFeatures[] = $featureName;
        }
    }
}
$planData->planIdentifier = $planIdentifier;
$planData->isFree = $planFree;
$planData->isMonthly = $planMonthly;
$planData->isBiannually = $planBiannually;
$planData->isYearly = $planYearly;

$planData->status = $status;
$planData->statusText = $statusText;
$planData->planName = $planName;
$planData->currency = $currency;
$planData->haveStartDate = $haveStartDate;
$planData->startDate = $startDate;
$planData->planDiscounts = $planDiscounts;
$planData->haveDescription = $haveDescription;
$planData->planDescription = $planDescription;
$planData->schedules = $schedules;
$planData->haveSchedules = $haveSchedules;
$planData->planSchedules = $planSchedules;
$planData->haveTutorSchedules = $haveTutorSchedules;
$planData->planTutorSchedules = $planTutorSchedules;
$planData->planCohorts = $planCohorts;
$planData->cohortIds = $cohortIds;
$planData->cohortIdsFormatted = $cohortIdsFormatted;
$planData->cohortsArray = $cohortsArray;


$planData->planFeatures = $planFeatures;



return $planData;
}



function getCohorts() {
    global $DB;

    $cohorts = $DB->get_records('cohort', array('enabled' => 1), 'shortname ASC', 'id, shortname');
    $cohort_data = [];

    foreach ($cohorts as $cohort) {
        $cohort_data[] = ['id' => $cohort->id, 'name' => $cohort->shortname];
    }
    return $cohort_data;
}

function updateCohorts_old($userId, $subCohorts, $subReference, $subPlatform, $subEmail) {
    global $DB, $USER;

    $success = false;

    error_log("updateCohorts - userId: $userId, subCohorts: $subCohorts, subReference: $subReference, subPlatform: $subPlatform, subEmail: $subEmail");

    $subscription = $DB->get_record('local_subscriptions', ['sub_reference' => $subReference]);

    if ($subscription) {
        $subscription->sub_cohorts = $subCohorts;
        $subscription->sub_cron = null;
        $subscription->sub_new_cohorts = null;
        $subscription->sub_modified = time();

        $success = $DB->update_record('local_subscriptions', $subscription);
        error_log('update success: ' . $success);

        if ($success) {
            $updatedSubscription = $DB->get_record('local_subscriptions', ['id' => $subscription->id]);
        }

    } else {
        $new_subscription = new stdClass();
        $new_subscription->sub_reference = $subReference;
        $new_subscription->sub_email = $subEmail;
        $new_subscription->sub_platform = $subPlatform;
        $new_subscription->sub_cohorts = $subCohorts;
        $new_subscription->sub_cron = null;
        $new_subscription->sub_new_cohorts = null;
        $new_subscription->sub_modified = time();

        $success = $DB->insert_record('local_subscriptions', $new_subscription);
        error_log('create success: ' . $success);

        if ($success) {
            $insertedSubscription = $DB->get_record('local_subscriptions', ['sub_reference' => $subReference]);
        }
    }
    return $success;
}


function updateCohortsTask($userId, $subCohorts, $subReference, $subPlatform, $subEmail, $subCron) { 
    global $DB, $USER;

    $success = false;

    // Platform-specific logic
    if ($subPlatform == 'braintree') {

        error_log("updateCohortsTask - userId: $userId, subCohorts: $subCohorts, subReference: $subReference, subPlatform: $subPlatform, subEmail: $subEmail, subCron: $subCron");

        // Check if the subscription exists
        $subscription = $DB->get_record('local_subscriptions', ['sub_reference' => $subReference]);

        if ($subscription) {
            $subscription->sub_new_cohorts = $subCohorts;
            $subscription->sub_modified = time();
            $subscription->sub_cron = $subCron;

            // Update the subscription with the new cohorts
            $success = $DB->update_record('local_subscriptions', $subscription);
            error_log('update success: ' . $success);

            if ($success) {
                $updatedSubscription = $DB->get_record('local_subscriptions', ['id' => $subscription->id]);

                // Manage user cohorts
                $targetUserId = $updatedSubscription->sub_user ?? $userId;

                // Remove user from current cohorts
                $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $targetUserId]);
                foreach ($currentCohortMembers as $membership) {
                    cohort_remove_member($membership->cohortid, $targetUserId);
                }

                // Add user to new cohorts
                $cohortIds = explode(',', $subCohorts);
                foreach ($cohortIds as $cohortId) {
                    $cohortId = trim($cohortId);
                    if ($cohortId !== '' && is_numeric($cohortId)) {
                        cohort_add_member((int)$cohortId, $targetUserId);
                    }
                }
            }

        } else {
            // If subscription doesn't exist, create a new one
            $new_subscription = new stdClass();
            $new_subscription->sub_reference = $subReference;
            $new_subscription->sub_email = $subEmail;
            $new_subscription->sub_platform = $subPlatform;
            $new_subscription->sub_new_cohorts = $subCohorts;
            $new_subscription->sub_cron = $subCron;
            $new_subscription->sub_modified = time();

            $success = $DB->insert_record('local_subscriptions', $new_subscription);
            error_log('create success: ' . $success);

            if ($success) {
                $insertedSubscription = $DB->get_record('local_subscriptions', ['sub_reference' => $subReference]);
            }
        }

    } elseif ($subPlatform == 'PayPal') {

        // If the platform is PayPal, handle the user by email
        $user = $DB->get_record('user', ['email' => $subEmail]);

        if ($user) {
            // User found, now remove them from current cohorts
            $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
            foreach ($currentCohortMembers as $membership) {
                cohort_remove_member($membership->cohortid, $user->id);
            }

            // Add user to new cohort(s)
            $cohortIds = explode(',', $subCohorts);
            foreach ($cohortIds as $cohortId) {
                $cohortId = trim($cohortId);
                if ($cohortId !== '' && is_numeric($cohortId)) {
                    cohort_add_member((int)$cohortId, $user->id);
                }
            }

            $success = true;
        } else {
            // User not found by email, try to find user by custom profile field 'SubID'
            $sql = "SELECT u.*
                    FROM {user} u
                    JOIN {user_info_data} uif ON u.id = uif.userid
                    JOIN {user_info_field} uifield ON uifield.id = uif.fieldid
                    WHERE uifield.shortname = :subid_field AND uif.data = :subid_value";

            $params = [
                'subid_field' => 'SubID',  // The shortname of your custom profile field
                'subid_value' => $subReference
            ];

            $user = $DB->get_record_sql($sql, $params);

            if ($user) {
                // User found, now remove them from current cohorts
                $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
                foreach ($currentCohortMembers as $membership) {
                    cohort_remove_member($membership->cohortid, $user->id);
                }

                // Add user to new cohort(s)
                $cohortIds = explode(',', $subCohorts);
                foreach ($cohortIds as $cohortId) {
                    $cohortId = trim($cohortId);
                    if ($cohortId !== '' && is_numeric($cohortId)) {
                        cohort_add_member((int)$cohortId, $user->id);
                    }
                }

                $success = true;
            } else {
                // User not found by either email or custom profile field
                $success = false;
            }
        }

    } else {
        // Handle cases where platform is not PayPal or Braintree, same logic applies
        $user = $DB->get_record('user', ['email' => $subEmail]);

        if ($user) {
            // User found, now remove them from current cohorts
            $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
            foreach ($currentCohortMembers as $membership) {
                cohort_remove_member($membership->cohortid, $user->id);
            }

            // Add user to new cohort(s)
            $cohortIds = explode(',', $subCohorts);
            foreach ($cohortIds as $cohortId) {
                $cohortId = trim($cohortId);
                if ($cohortId !== '' && is_numeric($cohortId)) {
                    cohort_add_member((int)$cohortId, $user->id);
                }
            }

            $success = true;
        } else {
            // User not found, try to find user by custom profile field 'SubID'
            $sql = "SELECT u.*
                    FROM {user} u
                    JOIN {user_info_data} uif ON u.id = uif.userid
                    JOIN {user_info_field} uifield ON uifield.id = uif.fieldid
                    WHERE uifield.shortname = :subid_field AND uif.data = :subid_value";

            $params = [
                'subid_field' => 'SubID',
                'subid_value' => $subReference
            ];

            $user = $DB->get_record_sql($sql, $params);

            if ($user) {
                // User found by SubID, now remove from cohorts and add to new ones
                $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
                foreach ($currentCohortMembers as $membership) {
                    cohort_remove_member($membership->cohortid, $user->id);
                }

                // Add user to new cohort(s)
                $cohortIds = explode(',', $subCohorts);
                foreach ($cohortIds as $cohortId) {
                    $cohortId = trim($cohortId);
                    if ($cohortId !== '' && is_numeric($cohortId)) {
                        cohort_add_member((int)$cohortId, $user->id);
                    }
                }

                $success = true;
            } else {
                // User not found, set success to false
                $success = false;
            }
        }
    }

    return $success;
}


function updateCohorts($userId, $subCohorts, $subReference, $subPlatform, $subEmail) {
    global $DB, $USER;

    $success = false;


    if($subPlatform == 'braintree')
    {
    

    error_log("updateCohorts - userId: $userId, subCohorts: $subCohorts, subReference: $subReference, subPlatform: $subPlatform, subEmail: $subEmail");

    $subscription = $DB->get_record('local_subscriptions', ['sub_reference' => $subReference]);

    if ($subscription) {
        $subscription->sub_cohorts = $subCohorts;
        $subscription->sub_cron = null;
        $subscription->sub_new_cohorts = null;
        $subscription->sub_modified = time();

        $success = $DB->update_record('local_subscriptions', $subscription);
        error_log('update success: ' . $success);

        if ($success) {
            $updatedSubscription = $DB->get_record('local_subscriptions', ['id' => $subscription->id]);


            //07/072025/Rahul-start

            $targetUserId = $updatedSubscription->sub_user ?? $userId;

            // Remove user from all current cohorts
            $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $targetUserId]);
            foreach ($currentCohortMembers as $membership) {
                cohort_remove_member($membership->cohortid, $targetUserId);
            }

            // Add user to new cohort(s)
            $cohortIds = explode(',', $subCohorts);
            foreach ($cohortIds as $cohortId) {
                $cohortId = trim($cohortId);
                if ($cohortId !== '' && is_numeric($cohortId)) {
                    cohort_add_member((int)$cohortId, $targetUserId);
                }
            }

            //07/072025/Rahul-end
        }

    } else {
        $new_subscription = new stdClass();
        $new_subscription->sub_reference = $subReference;
        $new_subscription->sub_email = $subEmail;
        $new_subscription->sub_platform = $subPlatform;
        $new_subscription->sub_cohorts = $subCohorts;
        $new_subscription->sub_cron = null;
        $new_subscription->sub_new_cohorts = null;
        $new_subscription->sub_modified = time();

        $success = $DB->insert_record('local_subscriptions', $new_subscription);
        error_log('create success: ' . $success);

        if ($success) {
            $insertedSubscription = $DB->get_record('local_subscriptions', ['sub_reference' => $subReference]);
        }
    }

    }elseif($subPlatform == 'PayPal')
    {
        $user = $DB->get_record('user', ['email' => $subEmail]);

        if ($user) {
            // User found, you can now access user details
            echo 'User Name: ' . $user->firstname . ' ' . $user->lastname;

            // Remove user from all current cohorts
            $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
            foreach ($currentCohortMembers as $membership) {
                cohort_remove_member($membership->cohortid, $user->id);
            }

            // Add user to new cohort(s)
            $cohortIds = explode(',', $subCohorts);
            foreach ($cohortIds as $cohortId) {
                $cohortId = trim($cohortId);
                if ($cohortId !== '' && is_numeric($cohortId)) {
                    cohort_add_member((int)$cohortId, $user->id);
                }
            }
            // Set success to true if all actions are completed
    $success = true;
        } else {
            // User not found
            echo 'User not found';

            // Fetch the user by the custom profile field 'SubID'
            $sql = "SELECT u.*
                    FROM {user} u
                    JOIN {user_info_data} uif ON u.id = uif.userid
                    JOIN {user_info_field} uifield ON uifield.id = uif.fieldid
                    WHERE uifield.shortname = :subid_field AND uif.data = :subid_value";

            $params = [
                'subid_field' => 'SubID',  // The shortname of your custom profile field
                'subid_value' => $subReference
            ];

            $user = $DB->get_record_sql($sql, $params);

            if ($user) {
                // User found, you can now access user details
                echo 'User Name: ' . $user->firstname . ' ' . $user->lastname;
                // Remove user from all current cohorts
            $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
            foreach ($currentCohortMembers as $membership) {
                cohort_remove_member($membership->cohortid, $user->id);
            }

            // Add user to new cohort(s)
            $cohortIds = explode(',', $subCohorts);
            foreach ($cohortIds as $cohortId) {
                $cohortId = trim($cohortId);
                if ($cohortId !== '' && is_numeric($cohortId)) {
                    cohort_add_member((int)$cohortId, $user->id);
                }
            }
            // Set success to true if all actions are completed
           $success = true;
            } else {
                // User not found
                echo 'User not found';
                $success = false;
            }
        }
    }else{


         $user = $DB->get_record('user', ['email' => $subEmail]);

        if ($user) {
            // User found, you can now access user details
            echo 'User Name: ' . $user->firstname . ' ' . $user->lastname;

            // Remove user from all current cohorts
            $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
            foreach ($currentCohortMembers as $membership) {
                cohort_remove_member($membership->cohortid, $user->id);
            }

            // Add user to new cohort(s)
            $cohortIds = explode(',', $subCohorts);
            foreach ($cohortIds as $cohortId) {
                $cohortId = trim($cohortId);
                if ($cohortId !== '' && is_numeric($cohortId)) {
                    cohort_add_member((int)$cohortId, $user->id);
                }
            }
            // Set success to true if all actions are completed
    $success = true;
        } else {
            // User not found
            echo 'User not found';

            // Fetch the user by the custom profile field 'SubID'
            $sql = "SELECT u.*
                    FROM {user} u
                    JOIN {user_info_data} uif ON u.id = uif.userid
                    JOIN {user_info_field} uifield ON uifield.id = uif.fieldid
                    WHERE uifield.shortname = :subid_field AND uif.data = :subid_value";

            $params = [
                'subid_field' => 'SubID',  // The shortname of your custom profile field
                'subid_value' => $subReference
            ];

            $user = $DB->get_record_sql($sql, $params);

            if ($user) {
                // User found, you can now access user details
                echo 'User Name: ' . $user->firstname . ' ' . $user->lastname;
                // Remove user from all current cohorts
            $currentCohortMembers = $DB->get_records('cohort_members', ['userid' => $user->id]);
            foreach ($currentCohortMembers as $membership) {
                cohort_remove_member($membership->cohortid, $user->id);
            }

            // Add user to new cohort(s)
            $cohortIds = explode(',', $subCohorts);
            foreach ($cohortIds as $cohortId) {
                $cohortId = trim($cohortId);
                if ($cohortId !== '' && is_numeric($cohortId)) {
                    cohort_add_member((int)$cohortId, $user->id);
                }
            }
            // Set success to true if all actions are completed
           $success = true;
            } else {
                // User not found
                echo 'User not found';
                $success = false;
            }
        }

    }
    return $success;
}


function updateCohortsTask_old($userId, $subCohorts, $subReference, $subPlatform, $subEmail, $subCron) {
    global $DB, $USER;

    $success = false;

    error_log("updateCohortsTask - userId: $userId, subCohorts: $subCohorts, subReference: $subReference, subPlatform: $subPlatform, subEmail: $subEmail, subCron: $subCron");

    $subscription = $DB->get_record('local_subscriptions', ['sub_reference' => $subReference]);

    if ($subscription) {
        $subscription->sub_new_cohorts = $subCohorts;
        $subscription->sub_modified = time();
        $subscription->sub_cron = $subCron;
        $success = $DB->update_record('local_subscriptions', $subscription);
    } else {
        $new_subscription = new stdClass();
        $new_subscription->sub_reference = $subReference;
        $new_subscription->sub_email = $subEmail;
        $new_subscription->sub_platform = $subPlatform;
        $new_subscription->sub_new_cohorts = $subCohorts;
        $subscription->sub_cron = $subCron;
        $new_subscription->sub_modified = time();

        $success = $DB->insert_record('local_subscriptions', $new_subscription);
    }
    return $success;
}



function get_all_cohorts() {
    global $DB;
    
    $cohorts = $DB->get_records('cohort', null, '', 'id, shortname');
    $cohort_array = array();
    foreach ($cohorts as $cohort) {
        $cohort_array[$cohort->id] = $cohort->shortname;
    }

    return $cohort_array;
}

function get_cohort_names_by_ids($cohortIds) {
   $cohorts = get_all_cohorts();

   $sub_cohorts_ids = $cohortIds ? explode(',', $cohortIds) : [];
   $valid_cohort_ids = array();

   foreach ($sub_cohorts_ids as $id) {
    $id = trim($id);
    if (array_key_exists($id, $cohorts)) {
        $shortname = $cohorts[$id];
        $valid_cohort_ids[] = $shortname;
    }
}

$subCohorts = implode(', ', $valid_cohort_ids);
return $subCohorts;
}

function get_cohort_name_by_id($id) {
    global $DB;
    $cohort = $DB->get_record('cohort', ['id' => $id], 'name');

    if ($cohort) {
        return $cohort->name;
    } else {
        return false;
    }
}
function get_cohort_schedule($cohort_id) {
    global $DB;

    $cohort_data = $DB->get_record('cohort', ['id' => $cohort_id]);
    if (!empty($cohort_data)) {
        $cohort_data->class_start_date = (object) [
            'startdate' => $cohort_data->startdate,
        ];
        $cohort_data->class_schedule = (object) [
            'cohortname' => $cohort_data->name,
            'cohortmonday' => $cohort_data->cohortmonday,
            'cohorttuesday' => $cohort_data->cohorttuesday,
            'cohortwednesday' => $cohort_data->cohortwednesday,
            'cohortthursday' => $cohort_data->cohortthursday,
            'cohortfriday' => $cohort_data->cohortfriday,
            'cohorthours' => $cohort_data->cohorthours,
            'cohortminutes' => $cohort_data->cohortminutes
        ];
        $cohort_data->tutorclass_schedule = (object) [
            'cohorttutormonday' => $cohort_data->cohorttutormonday,
            'cohorttutortuesday' => $cohort_data->cohorttutortuesday,
            'cohorttutorwednesday' => $cohort_data->cohorttutorwednesday,
            'cohorttutorthursday' => $cohort_data->cohorttutorthursday,
            'cohorttutorfriday' => $cohort_data->cohorttutorfriday,
            'cohorttutorhours' => $cohort_data->cohorttutorhours,
            'cohorttutorminutes' => $cohort_data->cohorttutorminutes
        ];
    }
    return $cohort_data;
}
function format_cohort_schedule($cohort_data) {
    if (empty($cohort_data)) {
        return null;
    }

    $result = new stdClass();

    $days = [];
    $tutordays = [];
    $class_schedule = $cohort_data->class_schedule ?? null;
    $tutorclass_schedule = $cohort_data->tutorclass_schedule ?? null;
    $startdate = $cohort_data->class_start_date->startdate ?? null;

    if ($startdate) {
        $monthsTranslations = [
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ];

        $day = date('d', $startdate);
        $monthKey = date('F', $startdate);
        $monthTranslation = $monthsTranslations[$monthKey];
        $result->startdate = "$day de $monthTranslation";
    }
    if ($class_schedule) {
        if ($class_schedule->cohortmonday) $days[] = 'Lunes';
        if ($class_schedule->cohorttuesday) $days[] = 'Martes';
        if ($class_schedule->cohortwednesday) $days[] = 'Miércoles';
        if ($class_schedule->cohortthursday) $days[] = 'Jueves';
        if ($class_schedule->cohortfriday) $days[] = 'Viernes';

        $formatted_days = implode(', ', $days);

        $hours = $class_schedule->cohorthours ?? 0;
        $minutes = str_pad($class_schedule->cohortminutes ?? 0, 2, '0', STR_PAD_LEFT);
        $period = $hours >= 12 ? 'PM' : 'AM';
        $formatted_hours = $hours % 12 == 0 ? 12 : $hours % 12;

        $formatted_time = "$formatted_hours:$minutes $period";

        $result->name = $class_schedule->cohortname;
        $result->days = $formatted_days;
        $result->time = $formatted_time . ' EST';
    }
    if ($tutorclass_schedule) {
        if ($tutorclass_schedule->cohorttutormonday) $tutordays[] = 'Lunes';
        if ($tutorclass_schedule->cohorttutortuesday) $tutordays[] = 'Martes';
        if ($tutorclass_schedule->cohorttutorwednesday) $tutordays[] = 'Miércoles';
        if ($tutorclass_schedule->cohorttutorthursday) $tutordays[] = 'Jueves';
        if ($tutorclass_schedule->cohorttutorfriday) $tutordays[] = 'Viernes';

        $formatted_days = implode(', ', $tutordays);

        $hours = $tutorclass_schedule->cohorttutorhours ?? 0;
        $minutes = str_pad($tutorclass_schedule->cohorttutorminutes ?? 0, 2, '0', STR_PAD_LEFT);
        $period = $hours >= 12 ? 'PM' : 'AM';
        $formatted_hours = $hours % 12 == 0 ? 12 : $hours % 12;

        $formatted_time = "$formatted_hours:$minutes $period";

        $result->tutordays = $formatted_days;
        $result->tutortime = $formatted_time . ' EST';
    }
    if (!empty((array)$result)) {
        return $result;
    }
    return null;
}


function local_membership_get_stats($startdate, $enddate) {
    global $DB;
    
    $stats = [];
    
    // Convert timestamps to database format
    $startdb = date('Y-m-d H:i:s', $startdate);
    $enddb = date('Y-m-d H:i:s', $enddate);
    
    // Get active students count (status = 1 for active in Patreon)
    $stats['activestudents'] = $DB->count_records_sql("
        SELECT COUNT(DISTINCT id) 
        FROM {membership_patreon_subscriptions} 
        WHERE status = 1 
        AND startdate <= ? AND (enddate >= ? OR enddate IS NULL)",
        [$enddb, $startdb]);
    
    // Get new students count (started in date range)
    $stats['newstudents'] = $DB->count_records_sql("
        SELECT COUNT(DISTINCT id) 
        FROM {membership_patreon_subscriptions} 
        WHERE startdate BETWEEN ? AND ?",
        [$startdb, $enddb]);
    
    // Get paused students count (status = 0 for inactive in Patreon)
    $stats['pausedstudents'] = $DB->count_records_sql("
        SELECT COUNT(DISTINCT id) 
        FROM {membership_patreon_subscriptions} 
        WHERE status = 0 
        AND startdate <= ? AND (enddate >= ? OR enddate IS NULL)",
        [$enddb, $startdb]);
    
    // Get declined students count (status = 2 for declined, adjust if needed)
    $stats['declinedstudents'] = $DB->count_records_sql("
        SELECT COUNT(DISTINCT id) 
        FROM {membership_patreon_subscriptions} 
        WHERE status = 2 
        AND startdate <= ? AND (enddate >= ? OR enddate IS NULL)",
        [$enddb, $startdb]);
    
    // Get dropout students count (ended in date range)
    $stats['dropoutstudent'] = $DB->count_records_sql("
        SELECT COUNT(DISTINCT id) 
        FROM {membership_patreon_subscriptions} 
        WHERE status != 1 
        AND enddate BETWEEN ? AND ?",
        [$startdb, $enddb]);
    
    // Calculate retention rate (customize based on your needs)
    $totalactive = $stats['activestudents'];
    $totalnew = $stats['newstudents'];
    $stats['retention'] = $totalnew > 0 ? round(($totalactive / $totalnew) * 100) . '%' : '0%';
    
    // Calculate total revenue for the period
    $stats['totalrevenue'] = $DB->get_field_sql("
        SELECT SUM(price - discount) 
        FROM {membership_patreon_subscriptions} 
        WHERE startdate BETWEEN ? AND ?",
        [$startdb, $enddb]);
    
    return $stats;
}

function local_membership_calculate_trend($stattype, $currentvalue, $startdate = null, $enddate = null) {
    global $DB;
    
    // If dates aren't provided, use current month as default
    if ($startdate === null) {
        $startdate = strtotime('first day of this month');
    }
    if ($enddate === null) {
        $enddate = strtotime('last day of this month');
    }
    if (!is_numeric($currentvalue)) {
        if (is_string($currentvalue)) {
            $currentvalue = (float)preg_replace('/[^0-9.]/', '', $currentvalue);
        } else {
            $currentvalue = 0;
        }
    }
    // Get previous period value (e.g., previous month)
    $previousstart = strtotime('-1 month', $startdate);
    $previousend = strtotime('-1 month', $enddate);
    
    $previousstats = local_membership_get_stats($previousstart, $previousend);
    $previousvalue = $previousstats[$stattype] ?? 0;
    
    // Handle percentage values
    if (is_string($previousvalue)) {
        if (strpos($previousvalue, '%') !== false) {
            $previousvalue = (float)str_replace('%', '', $previousvalue);
        } elseif (strpos($previousvalue, '$') !== false) {
            $previousvalue = (float)str_replace(['$', ','], '', $previousvalue);
        }
    }
    
    // Handle current value if it's a string (for percentages or currency)
    if (is_string($currentvalue)) {
        if (strpos($currentvalue, '%') !== false) {
            $currentvalue = (float)str_replace('%', '', $currentvalue);
        } elseif (strpos($currentvalue, '$') !== false) {
            $currentvalue = (float)str_replace(['$', ','], '', $currentvalue);
        }
    }
    
    if ($previousvalue == 0) {
        return 'neutral';
    }
    
    $change = (($currentvalue - $previousvalue) / $previousvalue) * 100;
    
    // Define thresholds for positive/negative trends
    if ($change > 5) {
        return 'positive';
    } elseif ($change < -5) {
        return 'negative';
    } else {
        return 'neutral';
    }
}
