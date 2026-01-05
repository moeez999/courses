<?php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();

global $DB, $USER;

header('Content-Type: application/json');

try {
    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidaccess', 'error', '', 'Expected application/json');
    }

    $payload = json_decode(file_get_contents('php://input'));

    if (!$payload) {
        throw new moodle_exception('invalidjson', 'error', '', 'JSON decode failed');
    }

    // Required fields
    $teacherid = (int)($payload->teacher->id ?? 0);
    if ($teacherid <= 0) {
        throw new moodle_exception('missingteacher', 'error', '', 'Teacher missing');
    }

    $fromDate = $payload->from->iso ?? null;
    $fromTime = $payload->from->time ?? null;

    $untilDate = $payload->until->iso ?? null;
    $untilTime = $payload->until->time ?? null;

    if (!$fromDate || !$fromTime || !$untilDate || !$untilTime) {
        throw new moodle_exception('missingfields', 'error', '', 'Missing times');
    }

    $start_ts = strtotime($fromDate . ' ' . $fromTime);
    $end_ts   = strtotime($untilDate . ' ' . $untilTime);

    if (!$start_ts || !$end_ts || $end_ts <= $start_ts) {
        throw new moodle_exception('invalidtime', 'error', '', 'Invalid time range');
    }

    $record = new stdClass();
    $record->teacherid     = $teacherid;
    $record->start_ts      = $start_ts;
    $record->end_ts        = $end_ts;
    $record->title         = "Extra Slot";
    $record->rawjson       = json_encode($payload);
    $record->timecreated   = time();
    $record->timemodified  = time();
    $record->createdby     = $USER->id;

    $id = $DB->insert_record('local_teacher_extra_slots', $record);

    echo json_encode([
        'ok' => true,
        'id' => $id,
        'message' => 'Extra slot added successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage()
    ]);
}
