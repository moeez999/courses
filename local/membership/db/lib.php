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

function updateCohorts($userId, $subCohorts, $subReference, $subPlatform, $subEmail) {
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

   $sub_cohorts_ids = explode(',', $cohortIds);
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