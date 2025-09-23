<?php
define('AJAX_SCRIPT', true);
require_once("../config.php");
require_once($CFG->dirroot . '/course/lib.php');
require_login();
header('Content-Type: application/json; charset=utf-8');

$cohortid = optional_param('cohortid', 0, PARAM_INT);
//$cohortid = 29;
if (!$cohortid) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid cohortid']);
    exit;
}

global $DB;

function find_start_for_cohort_in_availability(array $node, int $cohortid) {
    if (empty($node['c']) || !is_array($node['c'])) {
        return null;
    }

    foreach ($node['c'] as $child) {
        if (is_array($child)
            && !empty($child['c']) && is_array($child['c'])
            && isset($child['c'][0]['type'], $child['c'][0]['id'])
            && $child['c'][0]['type'] === 'cohort'
            && (int)$child['c'][0]['id'] === $cohortid
            && isset($child['c'][1]['t'])) {

            return (int)$child['c'][1]['t']; // <-- start/from time
        }
    }
    return null;
}

function find_until_for_cohort_in_availability(array $node, int $cohortid) {
    if (empty($node['c']) || !is_array($node['c'])) {
        return null;
    }

    foreach ($node['c'] as $child) {
        if (is_array($child)
            && !empty($child['c']) && is_array($child['c'])
            && isset($child['c'][0]['type'], $child['c'][0]['id'])
            && $child['c'][0]['type'] === 'cohort'
            && (int)$child['c'][0]['id'] === $cohortid
            && isset($child['c'][2]['t'])) {

            return (int)$child['c'][2]['t']; // <-- until/due time
        }
    }
    return null;
}

/**
 * Quick check: does the availability tree contain the simple cohort group you rely on?
 * (same fixed-index pattern; doesn’t introduce any different logic)
 */
function has_simple_cohort_group(array $node, int $cohortid): bool {
    if (empty($node['c']) || !is_array($node['c'])) {
        return false;
    }
    foreach ($node['c'] as $child) {
        if (is_array($child)
            && !empty($child['c']) && is_array($child['c'])
            && isset($child['c'][0]['type'], $child['c'][0]['id'])
            && $child['c'][0]['type'] === 'cohort'
            && (int)$child['c'][0]['id'] === $cohortid) {
            return true;
        }
    }
    return false;
}

/** Fallback due: assign.duedate|cutoffdate, quiz.timeclose (unchanged idea) */
function module_fallback_due(int $cmid): ?int {
    global $DB;
    $row = $DB->get_record_sql("
        SELECT cm.instance, m.name AS modname
          FROM {course_modules} cm
          JOIN {modules} m ON m.id = cm.module
         WHERE cm.id = :id
    ", ['id' => $cmid]);
    if (!$row) return null;

    if ($row->modname === 'assign') {
        $due = (int)$DB->get_field('assign', 'duedate', ['id' => $row->instance]);
        if (empty($due)) {
            $cut = (int)$DB->get_field('assign', 'cutoffdate', ['id' => $row->instance]);
            if (!empty($cut)) $due = $cut;
        }
        return $due ?: null;
    } else if ($row->modname === 'quiz') {
        $due = (int)$DB->get_field('quiz', 'timeclose', ['id' => $row->instance]);
        return $due ?: null;
    }
    return null;
}

function cm_view_url(int $cmid, string $modname): string {
    if ($modname === 'assign') return (new moodle_url('/mod/assign/view.php', ['id' => $cmid]))->out(false);
    if ($modname === 'quiz')   return (new moodle_url('/mod/quiz/view.php',   ['id' => $cmid]))->out(false);
    return (new moodle_url('/mod/view.php', ['id' => $cmid]))->out(false);
}


function format_due_relative(int $dueTs): string {
    $now  = time();
    $diff = $dueTs - $now;

    // Overdue?
    if ($diff < 0) {
        $adiff = abs($diff);
        if ($adiff >= 86400) {
            $days = (int)ceil($adiff / 86400);
            return "Task overdue by {$days} " . ($days === 1 ? "day" : "days");
        } elseif ($adiff >= 3600) {
            $hours = (int)ceil($adiff / 3600);
            return "Task overdue by {$hours} " . ($hours === 1 ? "hour" : "hours");
        } elseif ($adiff >= 60) {
            $mins = (int)ceil($adiff / 60);
            return "Task overdue by {$mins} " . ($mins === 1 ? "minute" : "minutes");
        }
        return "Task overdue by less than a minute";
    }

    // Upcoming
    if ($diff >= 86400) {
        $days = (int)ceil($diff / 86400);
        return "Task due in {$days} " . ($days === 1 ? "day" : "days");
    } elseif ($diff >= 3600) {
        $hours = (int)ceil($diff / 3600);
        return "Task due in {$hours} " . ($hours === 1 ? "hour" : "hours");
    } elseif ($diff >= 60) {
        $mins = (int)ceil($diff / 60);
        return "Task due in {$mins} " . ($mins === 1 ? "minute" : "minutes");
    }
    return "Task due in less than a minute";
}

/** 1) All courses where this cohort is enrolled (your SQL) */
$coursesql = "
    SELECT DISTINCT c.id, c.fullname, c.shortname
      FROM {enrol} e
      JOIN {course} c ON c.id = e.courseid
     WHERE e.enrol = :enrol
       AND e.customint1 = :cohortid
       AND e.status = :enabled
       AND EXISTS (
             SELECT 1 FROM {user_enrolments} ue
              WHERE ue.enrolid = e.id
                AND ue.status = :active
       )
  ORDER BY c.sortorder, c.id
";


$courseparams  = [
    'enrol'     => 'cohort',
    'cohortid'  => $cohortid,
    'enabled'   => 0, // enrol instance enabled
    'active'    => 0  // user enrolment active
];


$courses = $DB->get_records_sql($coursesql, $courseparams);
if (!$courses) {
    echo json_encode(['success' => true, 'soonest' => null, 'others' => []]);
    exit;
}

$courseids = array_map(fn($c) => (int)$c->id, array_values($courses));
list($inSql, $inParams) = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED, 'cid');

/** 2) All assign/quiz CMs for those courses */
$cmsql = "
    SELECT
        cm.id         AS cmid,
        cm.course     AS courseid,
        cm.section    AS sectionid,
        cm.instance,
        cm.availability,
        m.name        AS modname,
        a.name        AS assignname,
        q.name        AS quizname
    FROM {course_modules} cm
    JOIN {modules} m ON m.id = cm.module
    LEFT JOIN {assign} a ON a.id = cm.instance AND m.name = 'assign'
    LEFT JOIN {quiz}  q ON q.id = cm.instance AND m.name = 'quiz'
    WHERE cm.course $inSql
      AND m.name IN ('assign','quiz')
      AND cm.deletioninprogress = 0
";
$cms = $DB->get_records_sql($cmsql, $inParams);

$now = time();
$matched = [];

/** 3) Keep only items whose availability has the same cohort group pattern; get FROM/UNTIL via your logic */
foreach ($cms as $cm) {
    $fromTs = null;
    $untilTs = null;

    if (!empty($cm->availability)) {
        $tree = json_decode($cm->availability, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($tree) && has_simple_cohort_group($tree, $cohortid)) {
            // USE YOUR EXACT PATTERN functions:
            $fromTs  = find_start_for_cohort_in_availability($tree, $cohortid);
            $untilTs = find_until_for_cohort_in_availability($tree, $cohortid);
        } else {
            // Not restricted to this cohort by your simple pattern → skip
            continue;
        }
    } else {
        // No availability → not cohort-restricted → skip
        continue;
    }

    // If no UNTIL from availability, fall back to module-level due/close.
    $fallbackDue = module_fallback_due((int)$cm->cmid);
    if ($untilTs === null && $fallbackDue !== null) {
        $untilTs = $fallbackDue;
    }

    // If we still have neither FROM nor UNTIL, skip.
    if ($fromTs === null && $untilTs === null) continue;

    // Relevance window:
    // - If from in future -> it’s upcoming (sort by from)
    // - Else if until in future -> it’s open/closing soon (sort by until)
    // - Else skip (already closed)
    $sortKey = null;
    if ($fromTs !== null && $fromTs > $now) {
        $sortKey = $fromTs;
    } elseif ($untilTs !== null && $untilTs > $now) {
        $sortKey = $untilTs;
    } else {
        continue;
    }

    $name = ($cm->modname === 'assign') ? ($cm->assignname ?? 'Assignment') : ($cm->quizname ?? 'Quiz');

    $matched[] = (object)[
        'sort_key'    => (int)$sortKey,
        'cmid'        => (int)$cm->cmid,
        'courseid'    => (int)$cm->courseid,
        'sectionid'   => (int)$cm->sectionid,
        'modname'     => (string)$cm->modname,       // 'assign' | 'quiz'
        'instance'    => (int)$cm->instance,
        'name'        => (string)$name,
        'url'         => cm_view_url((int)$cm->cmid, $cm->modname),
        'from_ts'     => $fromTs !== null ? (int)$fromTs : null,
        'until_ts'    => $untilTs !== null ? (int)$untilTs : null,
        'fallback_due'=> $fallbackDue !== null ? (int)$fallbackDue : null,
        'course_full' => isset($courses[$cm->courseid]) ? (string)$courses[$cm->courseid]->fullname : '',
        'course_short'=> isset($courses[$cm->courseid]) ? (string)$courses[$cm->courseid]->shortname : '',
        'due_display' => ($untilTs !== null) ? format_due_relative((int)$untilTs) : null,
    ];
}

/** 4) Sort and keep soonest inside the same list */
usort($matched, fn($a, $b) => $a->sort_key <=> $b->sort_key);

// Remove internal sort_key from all items
foreach ($matched as $i => $o) {
    unset($matched[$i]->sort_key);
}

// soonest is the first item, but DO NOT remove it from $matched
$soonest = $matched[0] ?? null;

echo json_encode([
    'success' => true,
    'soonest' => $soonest,
    'matched' => array_values($matched) // includes soonest first, then remaining
], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
exit;
