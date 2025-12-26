<?php
// File: local/membership/api/update_manual_subscription.php

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/moodlelib.php');
require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/user/lib.php');

header('Content-Type: application/json');
require_login();

$context = context_system::instance();
if (!is_siteadmin() && !has_capability('moodle/cohort:manage', $context)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Permission denied']);
    exit;
}

global $DB;

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    echo json_encode(['success' => false, 'message' => 'Invalid payload']);
    exit;
}

$id             = $input['id'] ?? 0;
$firstname      = trim($input['firstname']      ?? '');
$lastname       = trim($input['lastname']       ?? '');
$email          = trim($input['email']          ?? '');
$contactnumber  = trim($input['contactnumber']  ?? '');
$paymentmethod  = trim($input['paymentmethod']  ?? '');
$intervalvalue  = (int)($input['intervalvalue'] ?? 1);
$intervaltype   = trim($input['intervaltype']   ?? '');
$price          = (float)($input['price']       ?? 0);
$cohortIdnumber = trim($input['cohort']         ?? '');
$subscriberid   = trim($input['subscriberid']   ?? '');
$paymentref     = trim($input['paymentref']     ?? '');
$statusIn       = trim($input['status']         ?? 'Active');

$referralcode   = trim($input['referralcode']   ?? '');
$notes          = trim($input['notes']          ?? '');

$start_date_str = trim($input['start_date'] ?? '');
$end_date_str   = trim($input['end_date']   ?? '');
$start_date     = $start_date_str ? strtotime($start_date_str) : null;
$end_date       = $end_date_str   ? strtotime($end_date_str)   : null;

if (!$id) { echo json_encode(['success' => false, 'message' => 'Missing subscription id']); exit; }
if (!$email)  { echo json_encode(['success' => false, 'message' => 'Email is required']); exit; }
if (!$paymentmethod || !$intervalvalue || !$intervaltype || !$price || !$cohortIdnumber || !$subscriberid) {
    echo json_encode(['success' => false, 'message' => 'Missing required subscription fields']); exit;
}

$statusMap = [
    'active'   => 'active',
    'inactive' => 'inactive',
    'paused'   => 'paused',
    '0'        => 'inactive',
    '1'        => 'active'
];
$normalizedStatus = $statusMap[strtolower($statusIn)] ?? 'active';

try {
    $tx = $DB->start_delegated_transaction();

    $sub  = $DB->get_record('manual_user_registrations', ['subscriber_id' => $id], '*', MUST_EXIST);
    $user = $DB->get_record('user', ['id' => $sub->userid, 'deleted' => 0], '*', MUST_EXIST);

    // Update user
    $updateUser = false;
    if ($firstname !== '' && $firstname !== $user->firstname) { $user->firstname = $firstname; $updateUser = true; }
    if ($lastname  !== '' && $lastname  !== $user->lastname)  { $user->lastname  = $lastname;  $updateUser = true; }
    if ($contactnumber !== '' && $contactnumber !== (string)($user->phone1 ?? '')) { $user->phone1 = $contactnumber; $updateUser = true; }
    if ($email !== '' && $email !== $user->email) {
        if ($DB->record_exists_select('user', 'email = :e AND id <> :uid AND deleted = 0', ['e' => $email, 'uid' => $user->id])) {
            throw new moodle_exception('emailexists', 'error', '', null, 'Email already in use by another user');
        }
        $user->email = $email;
        $user->username = $email; // keep aligned if that's your policy
        $updateUser = true;
    }
    if ($updateUser) {
        user_update_user($user, false, false);
    }

    // Cohort move (idnumber → id)
    $newcohort = $DB->get_record('cohort', ['idnumber' => $cohortIdnumber, 'visible' => 1], '*', MUST_EXIST);
    if ((int)$sub->cohortid !== (int)$newcohort->id) {
        try { cohort_remove_member((int)$sub->cohortid, $user->id); } catch (Exception $e) {}
        cohort_add_member($newcohort->id, $user->id);
        $sub->cohortid = $newcohort->id;
    }

    // Update subscription fields
    $sub->paymentmethod      = $paymentmethod;
    $sub->intervalvalue      = $intervalvalue;
    $sub->intervaltype       = $intervaltype;
    $sub->price              = $price;
    $sub->status             = $normalizedStatus;
    $sub->contactnumber      = $contactnumber;
    $sub->subscriber_id      = $subscriberid;
    $sub->payment_reference  = $paymentref;
    $sub->timemodified       = time();
    if ($start_date !== null) { $sub->start_date = $start_date; }
    if ($end_date   !== null) { $sub->end_date   = $end_date;   }

    // Optional columns if you have them (safe no-ops if not)
    if (property_exists($sub, 'referral_code')) { $sub->referral_code = $referralcode; }
    if (property_exists($sub, 'notes'))         { $sub->notes = $notes; }

    $DB->update_record('manual_user_registrations', $sub);

    $tx->allow_commit();

    echo json_encode(['success' => true, 'message' => 'Subscription updated', 'id' => $sub->id, 'userid' => $sub->userid]);
    exit;

} catch (Exception $e) {
    if (!empty($tx)) { $tx->rollback($e); }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}