<?php
// local/customplugin/ajax/create_conference.php
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');

require_login();
@header('Content-Type: application/json; charset=utf-8');

try {
    global $DB, $CFG, $USER;

    if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
        throw new moodle_exception('invalidaccess', 'error', '', 'Expected application/json');
    }

    $raw = file_get_contents('php://input') ?: '';
    $json = json_decode($raw, true);

    if (!is_array($json)) {
        throw new moodle_exception('invaliddata', 'error', '', 'Invalid JSON.');
    }

    $data = $json ?? null;
    if (!is_array($data)) {
        throw new moodle_exception('missingparam', 'error', '', 'Payload missing.');
    }

    // -----------------------
    // COURSE = 25 (Conference)
    // -----------------------
    $courseid = 25;
$course = $DB->get_record('course', ['id' => $courseid], '*', IGNORE_MISSING);

if (!$course) {

    // -------------------------------
    // CREATE NEW COURSE (Multi Topic)
    // -------------------------------
    require_capability('moodle/course:create', context_system::instance());

    // Default category = 1 (Site Home / Misc)
    $categoryid = 1;

    $courseconfig = [
        'fullname'  => 'Conference Classes',
        'shortname' => 'conference-25',
        'category'  => $categoryid,
        'format'    => 'multitopic',      // <--- Multi Topic Format
        'visible'   => 1
    ];

    // Use core API to create course
    $course = create_course((object)$courseconfig);

    if (!$course || empty($course->id)) {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to auto-create Course ID 25.'
        ]);
        exit;
    }

    // Make sure section 1 exists
    course_create_sections_if_missing($course->id, [1]);
}

    if (!$course) {
        echo json_encode([
            'success' => false,
            'message' => 'Course with ID 25 does not exist.',
        ]);
        exit;
    }

    $context = context_course::instance($courseid);
    require_capability('moodle/course:manageactivities', $context);
    require_capability('mod/googlemeet:addinstance', $context);

    // -----------------------
    // Extract fields
    // -----------------------
    $title        = trim((string)$data['title'] ?? '');
    $startDateLbl = trim((string)$data['startDate'] ?? '');
    $timezoneLbl  = trim((string)$data['timezone'] ?? '');
    $schedule     = $data['scheduleArray'] ?? [];
    $cohorts      = $data['cohorts'] ?? [];
    $teachers     = $data['teachers'] ?? [];
    $students     = $data['students'] ?? []; // optional

    if ($title === '' || !$schedule) {
        throw new moodle_exception('missingparam', 'error', '', 'Missing title or schedule.');
    }

    // ---------------------------
    // Convert start date
    // ---------------------------
    $ts = strtotime($startDateLbl);
    if (!$ts) {
        throw new moodle_exception('invaliddata', 'error', '', 'Bad start date');
    }

    $eventdate = strtotime(date('Y-m-d 00:00:00', $ts));

    // ---------------------------
    // DAY + TIME PARSING
    // ---------------------------
    $dayname_to_key = [
        "Sun"=>"Sun","Mon"=>"Mon","Tue"=>"Tue","Wed"=>"Wed",
        "Thu"=>"Thu","Fri"=>"Fri","Sat"=>"Sat"
    ];

    $parse_ampm = function($label) {
        if (!preg_match('/^(\d{1,2}):(\d{2})\s*(am|pm)$/i', $label, $m)) {
            throw new moodle_exception('invaliddata', 'error', '', 'Bad time: ' . $label);
        }
        $h=(int)$m[1]; $i=(int)$m[2]; $ap=strtolower($m[3]);
        if ($ap==='pm' && $h<12) $h+=12;
        if ($ap==='am' && $h===12) $h=0;
        return [$h,$i];
    };

    // ---------------------------
    // Collect all rows into time groups
    // ---------------------------
    $timeBuckets = [];

    foreach ($schedule as $row) {
        $day = $row['day'] ?? '';
        if (!isset($dayname_to_key[$day])) continue;

        [$sH,$sI] = $parse_ampm($row['startTime']);
        [$eH,$eI] = $parse_ampm($row['endTime']);

        // group key
        $key = sprintf('%02d:%02d-%02d:%02d', $sH, $sI, $eH, $eI);

        if (!isset($timeBuckets[$key])) {
            $timeBuckets[$key] = [
                'starth' => $sH,
                'starti' => $sI,
                'endh'   => $eH,
                'endi'   => $eI,
                'days'   => []
            ];
        }
        $timeBuckets[$key]['days'][$day] = "1";
    }

    if (!$timeBuckets) {
        throw new moodle_exception('invaliddata', 'error', '', 'No valid schedule entries.');
    }

    // ---------------------------
    // BUILD AVAILABILITY JSON
    // ---------------------------
    $availability = [
        "op" => "&",
        "c"  => [],
        "showc" => []
    ];

    // Cohorts
    foreach ($cohorts as $c) {
        if (!empty($c['id'])) {
            $availability["c"][] = [
                "type" => "cohort",
                "id"   => (int)$c['id']
            ];
            $availability["showc"][] = true;
        }
    }

    // Teachers (profile email)
    foreach ($teachers as $t) {
        if (!empty($t['id'])) {
            $u = $DB->get_record('user', ['id'=>$t['id']], 'email', IGNORE_MISSING);
            if ($u && $u->email) {
                $availability["c"][] = [
                    "type" => "profile",
                    "sf"   => "email",
                    "op"   => "isequalto",
                    "v"    => strtolower($u->email)
                ];
                $availability["showc"][] = true;
            }
        }
    }

    // Students (profile email)
    foreach ($students as $s) {
        if (!empty($s['id'])) {
            $u = $DB->get_record('user', ['id'=>$s['id']], 'email', IGNORE_MISSING);
            if ($u && $u->email) {
                $availability["c"][] = [
                    "type" => "profile",
                    "sf"   => "email",
                    "op"   => "isequalto",
                    "v"    => strtolower($u->email)
                ];
                $availability["showc"][] = true;
            }
        }
    }

    $availabilityjson = json_encode($availability, JSON_UNESCAPED_SLASHES);

    // ---------------------------
    // CREATE GOOGLE MEETS — PER TIME GROUP
    // ---------------------------
    $created = [];

    foreach ($timeBuckets as $bucket) {

        $moduleinfo = (object)[
            'course'          => $courseid,
            'section'         => 1,         // always section 1
            'modulename'      => 'googlemeet',
            'visible'         => 1,
            'showdescription' => 0,
            'name'            => $title,
            'availability'    => $availabilityjson,
            'introeditor'     => ['text'=>'','format'=>FORMAT_HTML,'itemid'=>0],
            'completion'      => COMPLETION_TRACKING_NONE,

            // Meet time
            'client_islogged'    => 1,
            'eventdate'          => $eventdate,
            'starthour'          => $bucket['starth'],
            'startminute'        => $bucket['starti'],
            'endhour'            => $bucket['endh'],
            'endminute'          => $bucket['endi'],

            // Recurrence weekly
            'addmultiply'        => "1",
            'days'               => $bucket['days'],
            'period'             => "1",
            'eventenddate'       => $eventdate,

            'url'                => "",
            'creatoremail'       => $USER->email ?? "",
            'notify'             => "1",
            'minutesbefore'      => "5",
            'visibleoncoursepage'=> 1,
            'cmidnumber'         => "",
            'lang'               => "",
        ];

        $cm = create_module($moduleinfo);

        $created[] = [
            'cmid'     => (int)$cm->id,
            'instance' => (int)$cm->instance,
            'days'     => array_keys($bucket['days']),
            'time'     => sprintf('%02d:%02d-%02d:%02d', $bucket['starth'], $bucket['starti'], $bucket['endh'], $bucket['endi'])
        ];
    }

    echo json_encode([
        'success' => true,
        'count'   => count($created),
        'items'   => $created,
        'message' => 'Conference created successfully.'
    ]);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ]);
    exit;
}
