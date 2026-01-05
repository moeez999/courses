<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

@header('Content-Type: application/json; charset=utf-8');

try {

    global $DB, $USER;

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }

    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error');
    }

    // ============================
    // Extract values
    // ============================
    $eventid      = (int)$json['eventid'];
    $googlemeetid = (int)$json['googlemeetid'];
    $status       = $json['status']; // "cancel_reschedule_later"
    $reason       = $json['reason'] ?? '';
    $reasonText   = $json['reasonText'] ?? '';
    $notes        = $json['notes'] ?? '';

    if ($status !== 'cancel_reschedule_later') {
        throw new moodle_exception('invalidrequest', 'error', '', 'Invalid status');
    }

    // ============================
    // Fetch existing row
    // ============================
    $statusrow = $DB->get_record('local_gm_event_status', [
        'eventid'      => $eventid,
        'googlemeetid' => $googlemeetid
    ], '*', MUST_EXIST);

    $oldDetails = $statusrow->detailsjson ? json_decode($statusrow->detailsjson, true) : null;

    // ============================
    // Build previous from oldDetails
    // ============================
    if (!is_array($oldDetails)) {
        // No previous JSON → previous = null
        $previous = null;

    } else if (isset($oldDetails['current'])) {
        // Use FULL previous "current"
        $previous = $oldDetails['current'];

    } else {
        // Flat old structure → use it as previous fully
        $previous = $oldDetails;
    }

    // ============================
    // Build new current block
    // ============================
    $current = [
        'action'     => 'cancel_reschedule_later',
        'reason'     => $reason,
        'reasonText' => $reasonText,
        'notes'      => $notes,
        'time'       => time()
    ];

    // ============================
    // Build final JSON details
    // ============================
    $details = [
        'previous' => $previous,
        'current'  => $current,
        'action'   => 'cancel_reschedule_later'
    ];

    // ============================
    // Update DB row
    // ============================
    $update               = new stdClass();
    $update->id           = $statusrow->id;
    $update->statuscode   = 'cancel_reschedule_later';
    $update->detailsjson  = json_encode($details);
    $update->timemodified = time();
    $update->createdby    = $USER->id;

    $DB->update_record('local_gm_event_status', $update);

    // ============================
    // SUCCESS
    // ============================
    echo json_encode([
        'status' => 'success',
        'message' => 'Session marked as Cancel (Reschedule Later)',
        'updated' => [
            'eventid'      => $eventid,
            'googlemeetid' => $googlemeetid,
            'status'       => 'cancel_reschedule_later'
        ]
    ]);
    die();

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'error'  => $e->getMessage()
    ]);
    die();
}
