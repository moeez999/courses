<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

@header('Content-Type: application/json; charset=utf-8');

try {

    global $DB, $USER, $PAGE;

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }

    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error');
    }

    // =======================
    // Extract values
    // =======================
    $eventid      = (int)$json['eventid'];
    $googlemeetid = (int)$json['googlemeetid'];
    $status       = $json['status'];          // "cancel_no_makeup"
    $reason       = $json['reason'] ?? '';
    $reasonText   = $json['reasonText'] ?? '';
    $notes        = $json['notes'] ?? '';

    if ($status !== 'cancel_no_makeup') {
        throw new moodle_exception('invalidrequest', 'error', '', 'Invalid status code');
    }

    // =======================
    // Fetch existing status row
    // =======================
    $statusrow = $DB->get_record('local_gm_event_status', [
        'eventid'      => $eventid,
        'googlemeetid' => $googlemeetid
    ], '*', MUST_EXIST);

    $old = json_decode($statusrow->detailsjson, true);

    // =======================
    // Fetch event row for fallback
    // =======================
    $event = $DB->get_record('googlemeet_events', ['id' => $eventid], '*', MUST_EXIST);

    // =======================
    // DETERMINE LAST PREVIOUS ENTRY
    // (MUST INCLUDE ACTION ALSO)
    // =======================
    $lastPrevious = null;

    // 1️⃣ Most recent current block (full)
    if (!empty($old['current'])) {
        $lastPrevious = $old['current'];
    }
    // 2️⃣ Previous block
    else if (!empty($old['previous'])) {
        $lastPrevious = $old['previous'];
    }
    // 3️⃣ Cancel block (previous cancel)
    else if (!empty($old['cancel'])) {
        $lastPrevious = $old['cancel'];
    }
    // 4️⃣ History array last entry
    else if (!empty($old['history']) && is_array($old['history'])) {
        $lastPrevious = end($old['history']);
    }
    // 5️⃣ Fallback to DB event data
    else {
        $lastPrevious = [
            'date'    => date("Y-m-d", $event->eventdate),
            'start'   => date("H:i", $event->eventdate),
            'end'     => date("H:i", $event->eventdate + ($event->duration * 60)),
            'teacher' => 0,   // no teacher in group event table
            'action'  => 'original'
        ];
    }

    // =======================
    // NEW JSON: previous + current(cancel)
    // =======================
    $details = [
        'previous' => $lastPrevious,
        'current' => [
            'action'     => 'cancel_no_makeup',
            'reason'     => $reason,
            'reasonText' => $reasonText,
            'notes'      => $notes,
            'time'       => time()
        ],
        'action' => 'cancel_no_makeup'
    ];

    // =======================
    // Update Status Row
    // =======================
    $update = new stdClass();
    $update->id           = $statusrow->id;
    $update->statuscode   = 'cancel_no_makeup';
    $update->detailsjson  = json_encode($details);
    $update->timemodified = time();
    $update->createdby    = $USER->id;

    $DB->update_record('local_gm_event_status', $update);

    // =======================
    // SUCCESS RESPONSE
    // =======================
    echo json_encode([
        'status'  => 'success',
        'message' => 'Event cancelled (No Make-Up) successfully',
        'updated' => [
            'eventid'      => $eventid,
            'googlemeetid' => $googlemeetid,
            'status'       => 'cancel_no_makeup'
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
