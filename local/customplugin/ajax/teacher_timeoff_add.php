<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();
global $DB, $USER;

@header('Content-Type: application/json; charset=utf-8');

try {

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidrequest', 'error', '', 'JSON expected');
    }

    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);

    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error');
    }

    // ----------------------------------
    // Extract Payload
    // ----------------------------------
    $teacherid  = (int)$json['teacher']['id'];
    $title      = trim($json['title']);
    $allDay     = !empty($json['allDay']) ? 1 : 0;

    $fromIso    = $json['from']['iso'];    // e.g. "2025-12-01"
    $fromTime   = $json['from']['time'];   // "05:30 PM" or ignored if allDay

    $untilIso   = $json['until']['iso'];
    $untilTime  = $json['until']['time'];

    // ----------------------------------
    // Convert Date + Time → UNIX
    // ----------------------------------

    // Date only (midnight)
    $fromDateTS  = strtotime($fromIso);
    $untilDateTS = strtotime($untilIso);

    if (!$fromDateTS || !$untilDateTS) {
        throw new moodle_exception('invalidtime', 'error');
    }

    // Time only (convert only if NOT all-day)
    $fromTimeTS  = !$allDay ? strtotime($fromIso . ' ' . $fromTime) : null;
    $untilTimeTS = !$allDay ? strtotime($untilIso . ' ' . $untilTime) : null;

    // ----------------------------------
    // Insert DB Record
    // ----------------------------------
    $rec = new stdClass();
    $rec->teacherid    = $teacherid;
    $rec->title        = $title;

    $rec->fromdate     = $fromDateTS;
    $rec->fromtime     = $fromTimeTS;

    $rec->untildate    = $untilDateTS;
    $rec->untiltime    = $untilTimeTS;

    $rec->allday       = $allDay;

    $rec->rawjson      = $raw; // store original payload

    $rec->timecreated  = time();
    $rec->timemodified = time();
    $rec->createdby    = $USER->id;

    $id = $DB->insert_record('local_teacher_timeoff', $rec);

    echo json_encode([
        'status'  => 'success',
        'message' => 'Teacher time-off scheduled successfully.',
        'recordid' => $id
    ]);
    die();

} catch (Exception $e) {

    echo json_encode([
        'status' => 'error',
        'error'  => $e->getMessage()
    ]);
    die();
}
