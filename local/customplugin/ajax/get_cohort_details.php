<?php
// local/customplugin/ajax/get_cohort_details.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_login();
require_sesskey();

@header('Content-Type: application/json; charset=utf-8');

$PAGE->set_context(context_system::instance());

$idnumber = required_param('idnumber', PARAM_RAW_TRIMMED);

global $DB, $CFG;

$cohort = $DB->get_record('cohort', ['idnumber' => $idnumber], '*', IGNORE_MISSING);
if (!$cohort) {
    echo json_encode(['ok' => false, 'error' => 'Cohort not found'], JSON_UNESCAPED_UNICODE);
    exit;
}

// --- Helpers ---
function cc_full_name_safe(?stdClass $u): ?string {
    if (!$u) return null;
    $first = trim((string)($u->firstname ?? ''));
    $last  = trim((string)($u->lastname ?? ''));
    $name  = trim($first . ' ' . $last);
    return $name !== '' ? $name : ($u->username ?? null);
}

function cc_fmt_time(?int $h, ?int $m): ?string {
    if ($h === null || $m === null) return null;
    $ts = mktime($h, $m, 0, 1, 1, 2000);
    return strtolower(date('g:i a', $ts));
}

function cc_fmt_time_plus(?int $h, ?int $m, int $addmins = 60): ?string {
    if ($h === null || $m === null) return null;
    $ts = mktime($h, $m + $addmins, 0, 1, 1, 2000);
    return strtolower(date('g:i a', $ts));
}

function cc_user_pic_url(int $userid): string {
    global $CFG;
    return $CFG->wwwroot . '/user/pix.php/' . $userid . '/f2';
}

// --- Get Teachers ---
$teacher1 = !empty($cohort->cohortmainteacher)
    ? $DB->get_record('user', ['id' => $cohort->cohortmainteacher], 'id,firstname,lastname,username', IGNORE_MISSING)
    : null;

$teacher2 = !empty($cohort->cohortguideteacher)
    ? $DB->get_record('user', ['id' => $cohort->cohortguideteacher], 'id,firstname,lastname,username', IGNORE_MISSING)
    : null;

// --- Days ---
$daysMain = [];
if (!empty($cohort->cohortmonday))    $daysMain[] = 'Mon';
if (!empty($cohort->cohorttuesday))   $daysMain[] = 'Tue';
if (!empty($cohort->cohortwednesday)) $daysMain[] = 'Wed';
if (!empty($cohort->cohortthursday))  $daysMain[] = 'Thu';
if (!empty($cohort->cohortfriday))    $daysMain[] = 'Fri';

$daysTutor = [];
if (!empty($cohort->cohorttutormonday))    $daysTutor[] = 'Mon';
if (!empty($cohort->cohorttutortuesday))   $daysTutor[] = 'Tue';
if (!empty($cohort->cohorttutorwednesday)) $daysTutor[] = 'Wed';
if (!empty($cohort->cohorttutorthursday))  $daysTutor[] = 'Thu';
if (!empty($cohort->cohorttutorfriday))    $daysTutor[] = 'Fri';

// --- Times with proper defaults ---
// For main class
if (($cohort->cohorthours === 0 && $cohort->cohortminutes === 0) || 
    ($cohort->cohorthours === null || $cohort->cohortminutes === null)) {
    $mainStart = '9:30 am';
    $mainEnd = '10:30 am';
} else {
    $mainStart = cc_fmt_time($cohort->cohorthours, $cohort->cohortminutes);
    $mainEnd = cc_fmt_time_plus($cohort->cohorthours, $cohort->cohortminutes, 60);
}

// For tutor class
if (($cohort->cohorttutorhours === 0 && $cohort->cohorttutorminutes === 0) || 
    ($cohort->cohorttutorhours === null || $cohort->cohorttutorminutes === null)) {
    $tutorStart = '9:30 am';
    $tutorEnd = '10:30 am';
} else {
    $tutorStart = cc_fmt_time($cohort->cohorttutorhours, $cohort->cohorttutorminutes);
    $tutorEnd = cc_fmt_time_plus($cohort->cohorttutorhours, $cohort->cohorttutorminutes, 60);
}

// --- Build the exact structure the JavaScript expects ---
$out = [
    'ok' => true,
    'cohort' => [
        'id'        => (int)$cohort->id,
        'name'      => $cohort->name,
        'shortname' => $cohort->shortname,
        'idnumber'  => $cohort->idnumber,
        'enabled'   => (int)($cohort->enabled ?? 0),
        'visible'   => (int)($cohort->visible ?? 0),
        'color'     => !empty($cohort->cohortcolor) ? $cohort->cohortcolor : '#1649c7',
        'startdate' => !empty($cohort->startdate) ? (int)$cohort->startdate : null,
        'enddate'   => !empty($cohort->enddate)   ? (int)$cohort->enddate   : null,

        'main' => [
            'days'      => $daysMain,
            'start'     => $mainStart,
            'end'       => $mainEnd,
            'teacher'   => $teacher1 ? [
                'id'     => (int)$teacher1->id,
                'name'   => cc_full_name_safe($teacher1),
                'avatar' => cc_user_pic_url($teacher1->id),
            ] : null,
            'classname' => 'Main Class', // Explicitly set for JavaScript
        ],

        'tutor' => [
            'days'      => $daysTutor,
            'start'     => $tutorStart,
            'end'       => $tutorEnd,
            'teacher'   => $teacher2 ? [
                'id'     => (int)$teacher2->id,
                'name'   => cc_full_name_safe($teacher2),
                'avatar' => cc_user_pic_url($teacher2->id),
            ] : null,
            'classname' => 'Tutoring Class', // Explicitly set for JavaScript
        ],
    ],
];

// Debug output - remove this in production
error_log("Cohort data for $idnumber: " . json_encode($out));

echo json_encode($out, JSON_UNESCAPED_UNICODE);