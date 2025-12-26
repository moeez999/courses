<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/moodlelib.php');
require_once($CFG->dirroot . '/cohort/lib.php');

header('Content-Type: application/json');
require_login();
$context = context_system::instance();

if (!is_siteadmin()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Permission denied']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$usertype = trim($input['usertype'] ?? 'New Student');
$existingUserId = (int)($input['selecteduserid'] ?? 0);

$firstname      = trim($input['firstname'] ?? '');
$lastname       = trim($input['lastname'] ?? '');
$email          = trim($input['email'] ?? '');
$contactnumber  = trim($input['contactnumber'] ?? '');
$password       = $input['password'] ?? '';
$cohortId       = $input['cohort'] ?? '';
$paymentmethod  = trim($input['paymentmethod'] ?? '');
$intervalvalue  = (int)($input['intervalvalue'] ?? 1);
$intervaltype   = trim($input['intervaltype'] ?? '');
$price          = (float)($input['price'] ?? 0);

$subscriberid   = trim($input['subscriberid'] ?? '');
$paymentref     = trim($input['paymentref'] ?? '');
$start_date_str = trim($input['start_date'] ?? '');
$end_date_str   = trim($input['end_date'] ?? '');
$start_date     = strtotime($start_date_str);
$end_date       = strtotime($end_date_str);

$referralcode = trim($input->referralcode ?? '');

// ========= NEW STUDENT =========
if ($usertype === 'New Student') {
    if (!$firstname || !$lastname || !$email || !$password || !$cohortId) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    // Check if user already exists
    if ($DB->record_exists('user', ['email' => $email])) {
        echo json_encode(['success' => false, 'message' => 'User with this email already exists']);
        exit;
    }

    // Prepare user object
    $user = new stdClass();
    $user->username    = $email;
    $user->auth        = 'manual';
    $user->firstname   = $firstname;
    $user->lastname    = $lastname;
    $user->email       = $email;
    $user->password    = $password;
    $user->phone1      = $contactnumber;
    $user->confirmed   = 1;

    require_once($CFG->dirroot . '/user/lib.php');
    $userId = user_create_user($user, false, false);

    $cohort = $DB->get_record('cohort', ['idnumber' => $cohortId, 'visible' => 1], '*', IGNORE_MISSING);
    if (!$cohort) {
        delete_user((object)['id' => $userId]);
        echo json_encode(['success' => false, 'message' => 'Invalid cohort idnumber. User has been removed.']);
        exit;
    }

    try {
        cohort_add_member($cohort->id, $userId);
    } catch (Exception $e) {
        delete_user((object)['id' => $userId]);
        echo json_encode(['success' => false, 'message' => 'Failed to assign user to cohort. User has been removed.']);
        exit;
    }

    $record = new stdClass();
    $record->userid = $userId;
    $record->cohortid = $cohort->id;
    $record->paymentmethod = $paymentmethod;
    $record->intervalvalue = $intervalvalue;
    $record->intervaltype = $intervaltype;
    $record->price = $price;
    $record->status = 'active';
    $record->contactnumber = $contactnumber;
    $record->subscriber_id = $subscriberid;
    $record->payment_reference = $paymentref;
    $record->timecreated = time();
    $record->timemodified = time();
    $record->start_date = $start_date;
    $record->end_date = $end_date;

    $DB->insert_record('manual_user_registrations', $record);

    echo json_encode(['success' => true, 'userid' => $userId]);
    exit;
}

// ========= EXISTING STUDENT =========
else if ($usertype === 'Existing Student' && $existingUserId > 0) {
    if (!$firstname || !$lastname || !$email || !$cohortId) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
        exit;
    }

    $cohort = $DB->get_record('cohort', ['idnumber' => $cohortId, 'visible' => 1], '*', MUST_EXIST);

    try {
        cohort_add_member($cohort->id, $existingUserId);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to assign existing user to cohort']);
        exit;
    }

    $record = new stdClass();
    $record->userid = $existingUserId;
    $record->cohortid = $cohort->id;
    $record->paymentmethod = $paymentmethod;
    $record->intervalvalue = $intervalvalue;
    $record->intervaltype = $intervaltype;
    $record->price = $price;
    $record->status = 'active';
    $record->contactnumber = $contactnumber;
    $record->subscriber_id = $subscriberid;
    $record->payment_reference = $paymentref;
    $record->timecreated = time();
    $record->timemodified = time();
    $record->start_date = $start_date;
    $record->end_date = $end_date;

    $DB->insert_record('manual_user_registrations', $record);

    echo json_encode(['success' => true, 'userid' => $existingUserId]);
    exit;
}

// ========= INVALID CASE =========
echo json_encode(['success' => false, 'message' => 'Invalid user type or missing user ID']);
exit;