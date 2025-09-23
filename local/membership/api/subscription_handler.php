<?php

/**
 * Local plugin "membership" - Subscription handler file
 *
 * @package    membership
 * @copyright  2024 Fabian (NeiValHein), Costa Rica <neivalhein@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
ob_start();  // Start output buffering
require('../../../config.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/local/membership/lib.php');

$gateway = get_braintree_gateway();

$paymentMethod = $_POST['paymentMethod'] ?? 'unknown';
$paymentMethodNonce = $_POST['paymentMethodNonce'] ?? '';
$key = $_POST['key'] ?? '';
$cycle = $_POST['cycle'] ?? '';
$code = $_POST['code'] ?? '';

if (empty($paymentMethodNonce) || empty($key) || empty($cycle)) {
    echo json_encode(['success' => false, 'errors' => 'missing_parameters']);
    exit;
}

$user = $DB->get_record('user', ['id' => $USER->id]);

if ($user) {
    if (isset($_POST['phonenumber'])) {
        $user->phone2 = $_POST['phonenumber'];
    }
    if (isset($_POST['country'])) {
        $user->country = $_POST['country'];
    }
    if (isset($_POST['city'])) {
        $user->city = $_POST['city'];
    }
    if (isset($_POST['address'])) {
        $user->address = $_POST['address'];
    }
    user_update_user($user);

    $updatedUser = $DB->get_record('user', ['id' => $USER->id]);
    foreach ((array)$updatedUser as $userKey => $value) {
        $USER->$userKey = $value;
    }
}

$planData = get_plan_data($key, $USER->id);

if ($planData->status === 1) {
    echo json_encode(['success' => false, 'errors' => 'already_subscribed']);
    exit;
}

$planName = $planData->planName;
$planIdentifier = $planData->planIdentifier;
$planCohorts = $planData->cohortsArray;
$cohortIdsFormatted = $planData->cohortIdsFormatted;


$planCycleData = $planData->$cycle;

$planPrice = $planCycleData->price;
$planOriginalPrice = $planCycleData->price;
$planInterval = $planCycleData->interval;
$billingCycles = $planCycleData->billing;
$planCurrency = $planData->currency;
$keyword = $planCycleData->keyword;
$duration = 0;

$numberOfCodes = get_config('local_membership', 'noofmembershippromotioncodes' . $key);

$found = false;
$discount = 0;

if ($numberOfCodes !== false && !empty($code)) {
    for ($fkey = 1; $fkey <= $numberOfCodes; $fkey++) {
        $promoCode = get_config('local_membership', 'membershippromotioncodestext' . $key . $fkey);
        $promoDiscount = get_config('local_membership', 'membershippromotioncodesdiscount' . $key . $fkey);

        if ($promoCode === false || $promoDiscount === false) {
            continue;
        }

        if (!is_numeric($promoDiscount)) {
            continue;
        }

        if ($code === $promoCode) {
            $found = true;
            $discount = (float)$promoDiscount;
            break;
        }
    }
}

$promotionCodeInfo = [];
if ($found) {
    $planPrice -= $discount;

    if ($planPrice <= 0) {
        echo json_encode(['success' => false, 'errors' => 'discount_price_invalid']);
        exit;
    }
    $promotionCodeInfo = [
        'code' => $code,
        'discount' => $discount,
    ];
}

$courses = get_config('local_membership', 'membershipcourses' . $key);
$coursesFormatted = str_replace(',', '_', $courses);

$planFinalId = $key . '_' . time();
$planId = get_config('local_membership', 'membershipid' . $key);

if (!empty($coursesFormatted)) {
    $planFinalId = 'courseid_' . $key . '_courses_' . $coursesFormatted;
}

if ($found) {
    $planFinalId .= '_discount_' . $discount;
}
if ($planPrice != 0) {
    $planFinalId .= '_price_' . $planPrice;

} else {
    $planFinalId .= '_free';
}

// if (!$found) {
//     set_config('membershipid' . $key, $planFinalId, 'local_membership');
// }
$plan = false;

try {
    $plan = $gateway->plan()->find($planFinalId);
} catch (Braintree\Exception\NotFound $e) {
    $plan = false;
}

$planTitle = $planName . ' (Interval each ' . $planInterval . ' month)';
if ($planPrice == 0) {
 $planTitle = $planName . ' (Free)';
}

if (!$plan) {
    $plan = $gateway->plan()->create([
        'id' => $planFinalId,
        'name' => $planTitle,
        'price' => $planPrice,
        'billingFrequency' => $planInterval,
        'currencyIsoCode' => $planCurrency
    ]);
}

$customer = null;
try {
    $customer = $gateway->customer()->search([
        Braintree\CustomerSearch::email()->is($USER->email)
    ]);
    $customer = $customer->firstItem();

} catch (Exception $e) {
    $customer = false;
}

if (!$customer) {
    $result = $gateway->customer()->create([
        'firstName' => $USER->firstname,
        'lastName' => $USER->lastname,
        'email' => $USER->email,
        'phone' => $USER->phone2,
        'paymentMethodNonce' => $paymentMethodNonce,
        'creditCard' => [
            'billingAddress' => [
                'streetAddress' => !empty($USER->address) ? $USER->address : 'Ocean Drive',
                'locality' => !empty($USER->city) ? $USER->city : 'Florida',
                'countryName' => !empty($USER->country) ? $USER->country : 'US'
            ]
        ]
    ]);
    if ($result->success) {
        $customer = $result->customer;
        $paymentMethodToken = $result->customer->paymentMethods[0]->token;
    } else {
        $errorMessages = [];
        foreach ($result->errors->deepAll() as $error) {
            array_push($errorMessages, $error->message);
        }
        echo json_encode(['success' => false, 'errors' => $errorMessages]);
        exit;
    }
} else {
    $paymentMethodToken = $customer->paymentMethods[0]->token;
}
if ($billingCycles > 0) {
    $result = $gateway->subscription()->create([
        'paymentMethodToken' => $paymentMethodToken,
        'planId' => $planFinalId,
        'trialPeriod' => false,
        'numberOfBillingCycles' => $billingCycles,
        'options' => [
            'startImmediately' => true,
            'paypal' => [
                'description' => 'Membership Subscription for the plan ' . $planName . ' in the website courses.latingles.com'
            ],
        ]
    ]);
} else {
    $result = $gateway->subscription()->create([
        'paymentMethodToken' => $paymentMethodToken,
        'planId' => $planFinalId,
        'trialPeriod' => false,
        'neverExpires' => true,
        'options' => [
            'startImmediately' => true,
            'paypal' => [
                'description' => 'Membership Subscription for the plan ' . $planName . ' in the website courses.latingles.com'
            ],
        ]
    ]);
}

if ($result->success) {
    if ($result->subscription->status !== 'Active') {
        echo json_encode([
            'success' => true,
            'status' => $result->subscription->status,
            'errors' => 'subscription_created_payment_issue'
        ]);
        exit;
    }
    $subscriptionId = $result->subscription->id;


    $data = new stdClass();
    $data->sub_id               = $planIdentifier;

    $data->sub_reference        = $subscriptionId;
    $data->sub_user             = $USER->id;
    $data->sub_email            = $USER->email;
    $data->sub_platform         = 'braintree';
    $data->sub_method           = $paymentMethod;
    $data->sub_status           = 0;
    $data->sub_modified         = time();

    $subHistory = [];

    $newSub = [
        'plan_identifier' => $planIdentifier,
        'plan_name' => $planName,
        'plan_price' => $planPrice,
        'plan_cohorts' => $cohortIdsFormatted,
        'plan_discount' => json_encode($promotionCodeInfo),
    ];

    $subHistory[] = $newSub;

    $data->sub_history = json_encode($subHistory);



    if (!empty($planCohorts)) {
        $data->sub_cohorts = $cohortIdsFormatted;
        $data->sub_status = 1;
        foreach ($planCohorts as $cohortkey => $cohortid) {
            cohort_add_member($cohortid, $USER->id);
        }
        $DB->insert_record("local_subscriptions", $data);
    } else {
        $data->sub_status = 1;
        $DB->insert_record("local_subscriptions", $data);
    }

    $intervalInvoice = 'Cada ' . $planInterval . ' ' . $keyword;
    if ($cycle == 'free') {
        $intervalInvoice = 'Sin cobro';
    }

    echo json_encode([
        'success' => true,
        'status' => 'active',
        'name' => $planName,
        'currency' => $planCurrency,
        'duration' => $duration,
        'courses' => $courses,
        'cycle' => $cycle,
        'billingCycles' => $billingCycles,
        'price' => $planPrice,
        'priceInvoice' => number_format((float)$planPrice, 0, '.', '').' '.$planCurrency,
        'originalPrice' => $planOriginalPrice,
        'originalPriceInvoice' => number_format((float)$planOriginalPrice, 0, '.', '').' '.$planCurrency,
        'interval' => $planInterval,
        'intervalInvoice' => $intervalInvoice,
        'discount' => $discount,
        'discountInvoice' => $discount . ' ' . $planCurrency,
        'promotionCodeInfo' => $promotionCodeInfo,
        'cancelurl' => $CFG->wwwroot.'/local/membership/dashboard.php'
    ]);
    exit;
} else {
    $errorMessages = [];
    foreach ($result->errors->deepAll() as $error) {
        array_push($errorMessages, $error->message);
    }
    echo json_encode(['success' => false, 'errors' => $errorMessages]);
    exit;
}
function can_send_email_to_user($user, $userfrom) {
    global $CFG, $DB;

    if (empty($user->email) || !validate_email($user->email)) {
        return false;
    }

    if (!empty($CFG->noemailever)) {
        return false;
    }

    if (isset($user->emailstop) && $user->emailstop) {
        return false;
    }
    $blocked = $DB->record_exists('message_users_blocked', ['userid' => $user->id, 'blockeduserid' => $userfrom->id]);
    if ($blocked) {
        return false;
    }
    return true;
}

?>