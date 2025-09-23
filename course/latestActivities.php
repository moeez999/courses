<?php
// This file is part of Moodle - http://moodle.org/
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

require_once(__DIR__ . "/../config.php");
require_once($CFG->dirroot . '/course/lib.php');

$PAGE->set_url(new moodle_url('/local/yourplugin/latest_activities.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title('Latest Activities');
$PAGE->set_heading('Latest Activities');

// Optional custom CSS you already have.
$PAGE->requires->css(new moodle_url('./course.css'), true);

$user = $USER;
$urlCourse = new moodle_url($CFG->wwwroot . '/course/view.php', ['id' => 0]);

// Capture cohort id if needed later.
$cohortid = optional_param('cohortid', 0, PARAM_INT);


    $studentroleid = 5;

    // Count total number of roles assigned to the user
    $totalRoles = $DB->count_records('role_assignments', ['userid' => $user->id]);

    // Count number of student role assignments
    $studentRoles = $DB->count_records('role_assignments', ['userid' => $user->id, 'roleid' => $studentroleid]);

    // User has only student role if total == student role count and there’s at least one
    $is_student = ($studentRoles > 0 && $totalRoles == $studentRoles);



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


// Returns "final/max" or null if not graded yet.
function get_grade_display(int $courseid, string $modname, int $instanceid, int $userid): ?string {
    global $DB;
    $rec = $DB->get_record_sql("
        SELECT gi.id AS itemid, gi.grademax, gg.finalgrade
          FROM {grade_items} gi
     LEFT JOIN {grade_grades} gg ON gg.itemid = gi.id AND gg.userid = :userid
         WHERE gi.courseid = :courseid
           AND gi.itemtype = 'mod'
           AND gi.itemmodule = :modname
           AND gi.iteminstance = :instanceid
      ORDER BY gi.itemnumber ASC
         LIMIT 1
    ", [
        'userid'    => $userid,
        'courseid'  => $courseid,
        'modname'   => $modname,
        'instanceid'=> $instanceid,
    ]);

    if (!$rec || $rec->finalgrade === null) {
        return null;
    }
    // Use Moodle's formatter if available, otherwise fallback.
    if (function_exists('format_float')) {
        return format_float((float)$rec->finalgrade, 2) . ' / ' . format_float((float)$rec->grademax, 2);
    }
    return number_format((float)$rec->finalgrade, 2) . ' / ' . number_format((float)$rec->grademax, 2);
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





echo $OUTPUT->header();
?>

<h3 class="mb-3">Recent Homework & Quizzes</h3>

<div class="card" style="border:1px solid #e6e6e6;">
  <table class="generaltable latest-activities-table" style="width:100%; border-collapse:collapse; margin-bottom:0px;">
    <thead>
      <tr>
        <th class="header c0" style="text-align:left; padding:10px; width:70px;">Sr. No</th>
        <th class="header c1" style="text-align:left; padding:10px;">Name</th>
        <th class="header c2" style="text-align:left; padding:10px;">Start Date</th>
        <th class="header c3" style="text-align:left; padding:10px;">Due Date</th>
        <?php if ($is_student) { ?>
          <th class="header c4" style="text-align:left; padding:10px;">Grade</th>
        <?php } ?>
        <th class="header c5" style="text-align:left; padding:10px;">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Helper to format datetimes or show a dash.
      $fmtdt = function($ts) {
          return $ts ? userdate($ts, get_string('strftimedatetimeshort', 'langconfig')) : '—';
      };

      if (!empty($matched)) {
          $sr = 1;
          foreach ($matched as $o) {
              $name   = format_string($o->name ?? '');
              $course = format_string($o->course_full ?? '');
              $from   = $fmtdt($o->from_ts ?? null);
              $dueAbs = $fmtdt($o->until_ts ?? null);
              $dueRel = !empty($o->due_display) ? s($o->due_display) : '';

              if ($is_student) {
                  $gradeDisplay = get_grade_display((int)$o->courseid, (string)$o->modname, (int)$o->instance, (int)$user->id);
              }

              // Action URL + label varies by role.
              // Action URL + label varies by role.
if ($is_student) {
    $actionLabel = 'Attempt';
    $actionUrl   = s($o->url ?? '#'); // go to activity to attempt/continue
    $notYet      = !empty($o->from_ts) && ((int)$o->from_ts > time());
} else {
    // Teacher: open settings form for this activity
    $actionLabel = 'Update settings';
    $actionUrl   = (new moodle_url('/course/mod.php', ['update' => (int)$o->cmid, 'return' => 1]))->out(false);
    $notYet      = false;
}
              ?>
              <tr>
                <td style="padding:10px;"><?php echo $sr++; ?></td>
                <td style="padding:10px;">
                  <div><?php echo $name; ?></div>
                  <?php if (!empty($course)) { ?>
                    <div style="font-size:12px; color:#6c757d;"><?php echo $course; ?></div>
                  <?php } ?>
                </td>
                <td style="padding:10px;"><?php echo $from; ?></td>
                <td style="padding:10px;">
                  <div><?php echo $dueAbs; ?></div>
                  <?php if ($dueRel) { ?>
                    <div style="font-size:12px; color:#6c757d;"><?php echo $dueRel; ?></div>
                  <?php } ?>
                </td>
                <?php if ($is_student) { ?>
                  <td style="padding:10px;"><?php echo $gradeDisplay !== null ? s($gradeDisplay) : '—'; ?></td>
                <?php } ?>
                <td style="padding:10px;">
  <?php if ($is_student && $notYet) { ?>
    <button type="button"
            class="btn btn-primary btn-sm"
            disabled
            title="<?php echo s('Opens on ' . userdate((int)$o->from_ts, get_string('strftimedatetimeshort', 'langconfig'))); ?>">
      <?php echo $actionLabel; ?>
    </button>
  <?php } else { ?>
    <a class="btn btn-primary btn-sm" href="<?php echo $actionUrl; ?>">
      <?php echo $actionLabel; ?>
    </a>
  <?php } ?>
</td>
              </tr>
              <?php
          }
      } else {
          ?>
          <tr>
            <td colspan="<?php echo $is_student ? 6 : 5; ?>" style="padding:12px;">There are no activities to show.</td>
          </tr>
          <?php
      }
      ?>
    </tbody>
  </table>
</div>

<?php
echo $OUTPUT->footer();