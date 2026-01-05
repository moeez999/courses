<?php
require_once('../../config.php');
require_once(__DIR__ . '/lib.php');
require_once($CFG->libdir . '/oauthlib.php');

global $DB;

if (isset($_POST['cohortid']) && isset($_POST['currentdate'])) {
    $cohort_id = intval($_POST['cohortid']);
    $input_date_str = trim($_POST['currentdate']); // Expecting format like "Apr-19" or "Apr 19"

    // Normalize and parse date
    $parsed_date = DateTime::createFromFormat('M-d', $input_date_str);
    if (!$parsed_date) {
        $parsed_date = DateTime::createFromFormat('d M', $input_date_str);
    }

    if (!$parsed_date) {
        echo json_encode(['error' => 'Invalid date format']);
        exit;
    }

    // Set year as current year
    $parsed_date->setDate((int)date('Y'), (int)$parsed_date->format('m'), (int)$parsed_date->format('d'));

    $cohort_days = [];

    // Fetch cohort details
    $record = $DB->get_record('cohort', ['id' => $cohort_id]);

    // // Define the cohort active days
    // $days_red = [];
    // if (!empty($record->cohortmonday))    $days_red[] = 'Mon';
    // if (!empty($record->cohorttuesday))   $days_red[] = 'Tue';
    // if (!empty($record->cohortwednesday)) $days_red[] = 'Wed';
    // if (!empty($record->cohortthursday))  $days_red[] = 'Thu';
    // if (!empty($record->cohortfriday))    $days_red[] = 'Fri';


    // $days_red = []; // ✅ Initialize properly
    // $used_days = []; // Stores days already used by main class
    
    // // Step 1: Add main class days and track used ones
    // if (!empty($record->cohortmonday))    { $days_red[] = 'Mon'; $used_days[] = 'Mon'; }
    // if (!empty($record->cohorttuesday))   { $days_red[] = 'Tue'; $used_days[] = 'Tue'; }
    // if (!empty($record->cohortwednesday)) { $days_red[] = 'Wed'; $used_days[] = 'Wed'; }
    // if (!empty($record->cohortthursday))  { $days_red[] = 'Thu'; $used_days[] = 'Thu'; }
    // if (!empty($record->cohortfriday))    { $days_red[] = 'Fri'; $used_days[] = 'Fri'; }
    
    // // Step 2: Define all tutor properties
    // $tutor_days = [
    //     'Mon' => 'cohorttutormonday',
    //     'Tue' => 'cohorttutortuesday',
    //     'Wed' => 'cohorttutorwednesday',
    //     'Thu' => 'cohorttutorthursday',
    //     'Fri' => 'cohorttutorfriday'
    // ];
    
    // // Step 3: Check only days NOT used by main class
    // foreach ($tutor_days as $day => $property) {
    //     if (!in_array($day, $used_days) && !empty($record->$property)) {
    //         $days_red[] = $day;
    //     }
    // }



    $days_red = []; // array of [day, type]
$used_days = [];

// Step 1: Add main class days and track used ones
if (!empty($record->cohortmonday))    { $days_red[] = ['Mon', 'main'];  $used_days[] = 'Mon'; }
if (!empty($record->cohorttuesday))   { $days_red[] = ['Tue', 'main'];  $used_days[] = 'Tue'; }
if (!empty($record->cohortwednesday)) { $days_red[] = ['Wed', 'main'];  $used_days[] = 'Wed'; }
if (!empty($record->cohortthursday))  { $days_red[] = ['Thu', 'main'];  $used_days[] = 'Thu'; }
if (!empty($record->cohortfriday))    { $days_red[] = ['Fri', 'main'];  $used_days[] = 'Fri'; }

// Step 2: Tutor properties
$tutor_days = [
    'Mon' => 'cohorttutormonday',
    'Tue' => 'cohorttutortuesday',
    'Wed' => 'cohorttutorwednesday',
    'Thu' => 'cohorttutorthursday',
    'Fri' => 'cohorttutorfriday'
];

// Step 3: Add tutor days only if not used in main
foreach ($tutor_days as $day => $property) {
    if (!in_array($day, $used_days) && !empty($record->$property)) {
        $days_red[] = [$day, 'tutor'];
    }
}
    

    if (empty($days_red)) {
        echo json_encode(['error' => 'No cohort days defined.']);
        exit;
    }

    // Prepare to gather past and future days
    $past_days = [];
    $future_days = [];

    $past_date = clone $parsed_date;
    $future_date = clone $parsed_date;

   // Collect past cohort days
while (count($past_days) < 7) {
    $past_date->modify('-1 day');
    $day_name = $past_date->format('D');
    foreach ($days_red as $entry) {
        if ($entry[0] === $day_name) {
            $past_days[] = $past_date->format('d M') . ', ' . $entry[1];
            break;
        }
    }
}

// Collect future cohort days
while (count($future_days) < 7) {
    $day_name = $future_date->format('D');
    foreach ($days_red as $entry) {
        if ($entry[0] === $day_name) {
            $future_days[] = $future_date->format('d M') . ', ' . $entry[1];
            break;
        }
    }
    $future_date->modify('+1 day');
}

    $arr = array_reverse($past_days);

    // Combine and sort
    $cohort_days = array_merge($arr, $future_days);

    echo json_encode(['cohortDays' => $past_days]);
    exit;
} else {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}