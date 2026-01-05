<?php
define('AJAX_SCRIPT', true); // ✅ Tells Moodle this is an AJAX response (no HTML)

require_once(__DIR__.'/../../config.php');
require_login();
global $DB, $USER;

$action = required_param('action', PARAM_ALPHA);

header('Content-Type: application/json'); // ✅ Ensures proper response type

if ($action === 'generate') {
     $subscriptionid = required_param('subscriptionid', PARAM_ALPHANUMEXT); // 🔁 changed

    $code = random_int(100000, 999999);
    $now = time();
    $expires = $now + 600; // 10 minutes

    $record = new stdClass();
    $record->subscriptionid = $subscriptionid;
    $record->code = $code;
    $record->created_at = $now;
    $record->expires_at = $expires;
    $record->userid = $USER->id; // Optional: track who triggered it
    // Delete existing record with same userid and subscriptionid
    $exists = $DB->record_exists('membership_unsub_codes', [
        'subscriptionid' => $subscriptionid,
        'userid' => $USER->id
    ]);

    if ($exists) {
        $DB->delete_records('membership_unsub_codes', [
            'subscriptionid' => $subscriptionid,
            'userid' => $USER->id
        ]);
    }
    $DB->insert_record('membership_unsub_codes', $record);

    // Send mail to admin
    $admin = get_admin();
    $subject = "Unsubscription Code for Subscription #$subscriptionid";
    $message = "Verification Code: <strong>$code</strong><br>This code expires in 10 minutes.";
    email_to_user($admin, $admin, $subject, strip_tags($message), $message);

    echo json_encode(['status' => 'ok']);
    exit;
} else if ($action === 'verify') {
    $subscriptionid = required_param('subscriptionid', PARAM_TEXT);
    $code = required_param('code', PARAM_TEXT);
    $userid = $USER->id;

    $record = $DB->get_record('membership_unsub_codes', [
        'subscriptionid' => $subscriptionid,
        'userid' => $userid,
        'code' => $code
    ]);

    if ($record && $record->expires_at >= time()) {
        echo json_encode(['status' => 'ok']);
    } else {
        echo json_encode(['status' => 'fail']);
    }
    exit;
}