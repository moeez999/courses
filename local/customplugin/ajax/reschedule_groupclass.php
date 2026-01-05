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

    // -----------------------------
    // Extract values from payload
    // -----------------------------
    $eventid      = (int)$json['eventid'];
    $googlemeetid = (int)$json['googlemeetid'];

    $newTeacher = (int)$json['newTeacherId'];
    $newDate    = $json['newDate'];   // "2025-11-26"
    $newStart   = $json['newStart'];  // "0:30"
    $newEnd     = $json['newEnd'];    // "1:30"

    // -----------------------------
    // Convert new timestamps
    // -----------------------------
    $newStartTS = strtotime($newDate . ' ' . $newStart);
    $newEndTS   = strtotime($newDate . ' ' . $newEnd);

    if (!$newStartTS || !$newEndTS) {
        throw new moodle_exception('invalidtime', 'error');
    }

    // -----------------------------
    // Fetch existing status row
    // -----------------------------
    $statusrow = $DB->get_record('local_gm_event_status', [
        'eventid'      => $eventid,
        'googlemeetid' => $googlemeetid
    ], '*', MUST_EXIST);

    // -----------------------------
    // Decode OLD details JSON
    // -----------------------------
    $oldDetails = json_decode($statusrow->detailsjson, true);

    // Extract the FULL previous state (KEEP action also)
    $previousFinal = null;

    if (is_array($oldDetails)) {

        // If previous cycles exist: use the LAST “current” fully
        if (!empty($oldDetails['current'])) {
            $previousFinal = $oldDetails['current'];

        } 
        // If last action was cancel, keep that FULL block
        else if (!empty($oldDetails['cancel'])) {
            $previousFinal = $oldDetails['cancel'];

        } 
        // If previous exists from older logic
        else if (!empty($oldDetails['previous'])) {
            $previousFinal = $oldDetails['previous'];

        } 
        // Flat structure fallback
        else {
            // FIRST TIME RESCHEDULING → store old values from payload
            $previousFinal = [
                'date'    => $json['oldDate']  ?? null,
                'start'   => $json['oldStart'] ?? null,
                'end'     => $json['oldEnd']   ?? null,
                'teacher' => (int)($json['oldTeacherId'] ?? 0),
                'eventid'      => $eventid,
                'googlemeetid' => $googlemeetid,
                'time'         => time(),
                'action'       => 'reschedule_instant'
            ];
        }

    }else{

        // FIRST TIME RESCHEDULING → store old values from payload
            $previousFinal = [
                'date'    => $json['oldDate']  ?? null,
                'start'   => $json['oldStart'] ?? null,
                'end'     => $json['oldEnd']   ?? null,
                'teacher' => (int)($json['oldTeacherId'] ?? 0),
                'eventid'      => $eventid,
                'googlemeetid' => $googlemeetid,
                'time'         => time(),
                'action'       => 'reschedule_instant'
            ];

    }

    // -----------------------------
    // Build NEW details JSON
    // -----------------------------
    $details = [
        'previous' => $previousFinal,   // full previous with action preserved
        'current'  => [
            'date'    => $newDate,
            'start'   => $newStart,
            'end'     => $newEnd,
            'teacher' => $newTeacher,
            'time'    => time(),
            'action'  => 'reschedule_instant'   // <-- ADDED here for parity with others
        ],
        'action' => 'reschedule_instant'
    ];

    // -----------------------------
    // Update status row
    // -----------------------------
    $update = new stdClass();
    $update->id          = $statusrow->id;
    $update->statuscode  = 'reschedule_instant';
    $update->detailsjson = json_encode($details);
    $update->timemodified = time();
    $update->createdby    = $USER->id;

    $DB->update_record('local_gm_event_status', $update);

    // -----------------------------
    // Update googlemeet_events table
    // -----------------------------
    $event = $DB->get_record('googlemeet_events', ['id' => $eventid], '*', MUST_EXIST);

    $newDateTS = strtotime($newDate);

    $event->eventdate    = $newDateTS;
    $event->duration     = max(1, (int)(($newEndTS - $newStartTS) / 60));
    $event->timemodified = time();
    

    $DB->update_record('googlemeet_events', $event);

    // -----------------------------
    // SUCCESS
    // -----------------------------
    echo json_encode([
        'status'  => 'success',
        'message' => 'Event rescheduled successfully',
        'updated' => [
            'eventid'      => $eventid,
            'googlemeetid' => $googlemeetid
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