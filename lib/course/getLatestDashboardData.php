<?php
// get_latest_incomplete.php
define('AJAX_SCRIPT', true);

require_once("../config.php");
require_once($CFG->dirroot . '/course/lib.php');

require_login();
header('Content-Type: application/json; charset=utf-8');

$cohortid = optional_param('cohortid', 0, PARAM_INT);
$immediateOnly = optional_param('immediateOnly', 0, PARAM_BOOL); // 1 = only direct children, 0 = all descendants
if (!$cohortid) {
    echo json_encode(['success' => false, 'error' => 'Missing or invalid cohortid']);
    exit;
}

global $DB;

$sql = "
    SELECT
        tcd.id,
        tcd.courseid,
        tcd.sectionid,
        tcd.cohortid,
        tcd.status,
        tcd.percentage,
        tcd.timecreated,
        tcd.timemodified,
        cs.name    AS rawsectionname,
        cs.section AS sectionnum,
        CASE
            WHEN tcd.timemodified IS NOT NULL AND tcd.timemodified > 0
                THEN tcd.timemodified
            ELSE tcd.timecreated
        END AS lastts
    FROM {cohorts_topics_completion_data} tcd
    LEFT JOIN {course_sections} cs ON cs.id = tcd.sectionid
    WHERE tcd.cohortid = :cohortid
      AND tcd.percentage < 100
    ORDER BY lastts DESC, tcd.id DESC
";
$params = ['cohortid' => $cohortid];

// Limit to 1 most recent record
$rows = $DB->get_records_sql($sql, $params, 0, 1);
$rec  = $rows ? reset($rows) : null;

if (!$rec) {
    // 1) First course where this cohort is enrolled via cohort enrol plugin
$now = time();

$sql = "
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

$params = [
    'enrol'     => 'cohort',
    'cohortid'  => $cohortid,
    'enabled'   => 0, // enrol instance enabled
    'active'    => 0  // user enrolment active
];

$first = $DB->get_records_sql($sql, $params, 0, 1);

$firstcourse = $first ? reset($first) : null;

    if ($firstcourse) {
        // Optional: ensure the course uses Multitopic
        $format = $DB->get_field('course', 'format', ['id' => $firstcourse->id]);
        if ($format !== 'multitopic') {
            $course_sections[$firstcourse->id] = ['course' => $firstcourse, 'sections' => []];
        }

         // Cross-DB safe cast for format option "level"
    $castlevel = $DB->sql_cast_char2int('fo.value');

        // Main topics = level 0 (skip section 0 = General)
        $sqll = "
            SELECT cs.id, cs.name, cs.section, cs.sequence, cs.visible
            FROM {course_sections} cs
            LEFT JOIN {course_format_options} fo
                   ON fo.sectionid = cs.id
                  AND fo.format    = 'multitopic'
                  AND fo.name      = 'level'
            WHERE cs.course = :courseid
              AND COALESCE($castlevel, 0) = 0
              AND cs.visible = 1
            ORDER BY cs.section
        ";

        $sections = array_values($DB->get_records_sql($sqll, ['courseid' => $firstcourse->id]));

        // Store per course
        $course_sections[$firstcourse->id] = [
            'course'   => $firstcourse,
            'sections' => $sections
        ];


        if ($sections) {
            // Compute display name (respect course format if raw name empty)
            $sectionname = trim((string)($sections[0]->name ?? ''));
            if ($sectionname === '') {
                $course      = $DB->get_record('course', ['id' => $firstcourse->id], '*', MUST_EXIST);
                $modinfo     = get_fast_modinfo($course);
                $sectioninfo = $modinfo->get_section_info($section->section); // by section number
                $sectionname = get_section_name($course, $sectioninfo);
            }

            // Return a "record" shaped like the normal payload so your JS keeps working
            $fallback = [
                'id'           => null,
                'courseid'     => (int)$firstcourse->id,
                'sectionname'  => (string)$sectionname,
                'cohortid'     => (int)$cohortid,
                'status'       => '',
                'percentage'   => 0,
                'timecreated'  => 0,
                'timemodified' => 0,
                'lastts'       => 0,
            ];


                // --------- Build cross-DB-safe casts ---------
                $castChild  = $DB->sql_cast_char2int('childfo.value');
                $castParent = $DB->sql_cast_char2int('parentfo.value');
                $castNext   = $DB->sql_cast_char2int('nextfo.value');

                // --------- Depth operator ---------
                $depthop = $immediateOnly
                    ? "= COALESCE($castParent, 0) + 1"
                    : "> COALESCE($castParent, 0)";

                // --------- Fetch subsections under the given parent section ---------
                $sqlSubsections = "
                    SELECT
                        childcs.*,
                        COALESCE($castChild, 0) AS level
                    FROM {course_sections} parentcs
                    LEFT JOIN {course_format_options} parentfo
                        ON parentfo.sectionid = parentcs.id
                        AND parentfo.format    = 'multitopic'
                        AND parentfo.name      = 'level'
                    JOIN {course_sections} childcs
                    ON childcs.course = parentcs.course
                    LEFT JOIN {course_format_options} childfo
                        ON childfo.sectionid = childcs.id
                        AND childfo.format    = 'multitopic'
                        AND childfo.name      = 'level'
                    WHERE parentcs.course = :courseid
                    AND parentcs.id     = :parentsectionid
                    -- only sections after the parent and before the next top-level (level=0) section
                    AND childcs.section > parentcs.section
                    AND childcs.section < COALESCE((
                            SELECT MIN(nextcs.section)
                            FROM {course_sections} nextcs
                            LEFT JOIN {course_format_options} nextfo
                                ON nextfo.sectionid = nextcs.id
                                AND nextfo.format    = 'multitopic'
                                AND nextfo.name      = 'level'
                            WHERE nextcs.course = parentcs.course
                            AND nextcs.section > parentcs.section
                            AND COALESCE($castNext, 0) = 0
                        ), 1000000000)
                    -- depth filter
                    AND COALESCE($castChild, 0) $depthop
                    ORDER BY childcs.section
                ";

                $params = [
                    'courseid'        => $firstcourse->id,
                    'parentsectionid' => $sections[0]->id,
                ];

                $subsections = array_values($DB->get_records_sql($sqlSubsections, $params));

                // --------- For each subsection, fetch modules ---------
                //foreach ($subsections as &$subsection) {

                    $sqlModules = "
                        SELECT cm.id,
                            CASE
                                WHEN m.name = 'page'  THEN (SELECT name FROM {page}  WHERE id = cm.instance)
                                -- Add more modules as needed:
                                -- WHEN m.name = 'page'  THEN (SELECT name FROM {page}   WHERE id = cm.instance)
                                -- WHEN m.name = 'url'   THEN (SELECT name FROM {url}    WHERE id = cm.instance)
                                ELSE 'Unknown Activity'
                            END AS module_name,
                            cm.instance
                        FROM {course_modules} cm
                        JOIN {modules} m ON cm.module = m.id
                        WHERE cm.section = :sectionid
                        AND cm.deletioninprogress = 0
                    ";
                    $modules = $DB->get_records_sql($sqlModules, ['sectionid' => $subsections[0]->id]);

                    $slides_url = null;
                    foreach ($modules as $rec) {

                            $slides_url = (new moodle_url('/mod/page/view.php', ['id' => $rec->id]))->out(false);
                            break;

                    }

                    $topic_url = (new moodle_url('/course/view.php', ['id' => $firstcourse->id]))->out(false);

                //}

        // Reindex to numeric keys, then skip the first element.
                $subs = array_values($subsections);
                $homeworks = [];

                $sql = "
                    SELECT cm.id,
                        COALESCE(a.name, q.name) AS module_name,
                        cm.instance
                    FROM {course_modules} cm
                    JOIN {modules} m ON cm.module = m.id
                    LEFT JOIN {assign} a ON a.id = cm.instance AND m.name = 'assign'
                    LEFT JOIN {quiz}  q ON q.id = cm.instance AND m.name = 'quiz'
                    WHERE cm.section = :sectionid
                    AND cm.deletioninprogress = 0
                    AND m.name IN ('assign','quiz')
                ";

                foreach (array_slice($subs, 1) as $rec) {
                    $rows = $DB->get_records_sql($sql, ['sectionid' => $rec->id]);
                    if (!$rows) { continue; }

                    foreach ($rows as $cmid => $row) { // $cmid is cm.id (keyed by first selected column)
                        $due = get_due_for_cohort_or_module((int)$row->id, $cohortid);

                        $homeworks[$cmid] = (object)[
                            'cmid'        => (int)$row->id,
                            'module_name' => $row->module_name,
                            'instance'    => (int)$row->instance,
                            'due_ts'      => $due ? (int)$due['timestamp'] : null,
                            'due_source'  => $due ? $due['source'] : null,
                             'due_display' => $due ? format_due_relative((int)$due['timestamp']) : null,
                            'sectionid'   => (int)$rec->id
                        ];
                    }
                }







            echo json_encode(['success' => true, 'record' => $fallback, 'slides' => $slides_url, 'topic' => $topic_url], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
            exit;
        }
    }

    // If no course or no sections found, still return null
    echo json_encode(['success' => true, 'record' => null]);
    exit;
}

// Compute a display name if the raw section name is empty.
$sectionname = trim((string)($rec->rawsectionname ?? ''));
if ($sectionname === '') {
    // Use Moodle’s section naming (e.g., “Topic 1”, “Week 2”, or format-specific)
    $course = $DB->get_record('course', ['id' => $rec->courseid], '*', MUST_EXIST);
    $modinfo = get_fast_modinfo($course);
    $sectioninfo = $modinfo->get_section_info_by_id($rec->sectionid); // by sectionid
    $sectionname = get_section_name($course, $sectioninfo);
}

// Build response (replace sectionid with sectionname)
$record = [
    'id'           => (int)$rec->id,
    'courseid'     => (int)$rec->courseid,
    'sectionid'     => (int)$rec->sectionid,
    'sectionname'  => (string)$sectionname,   // ← requested field
    'cohortid'     => (int)$rec->cohortid,
    'status'       => (string)$rec->status,
    'percentage'   => (int)$rec->percentage,
    'timecreated'  => (int)$rec->timecreated,
    'timemodified' => (int)$rec->timemodified,
    'lastts'       => (int)$rec->lastts,
];




                // --------- Build cross-DB-safe casts ---------
                $castChild  = $DB->sql_cast_char2int('childfo.value');
                $castParent = $DB->sql_cast_char2int('parentfo.value');
                $castNext   = $DB->sql_cast_char2int('nextfo.value');

                // --------- Depth operator ---------
                $depthop = $immediateOnly
                    ? "= COALESCE($castParent, 0) + 1"
                    : "> COALESCE($castParent, 0)";

                // --------- Fetch subsections under the given parent section ---------
                $sqlSubsections = "
                    SELECT
                        childcs.*,
                        COALESCE($castChild, 0) AS level
                    FROM {course_sections} parentcs
                    LEFT JOIN {course_format_options} parentfo
                        ON parentfo.sectionid = parentcs.id
                        AND parentfo.format    = 'multitopic'
                        AND parentfo.name      = 'level'
                    JOIN {course_sections} childcs
                    ON childcs.course = parentcs.course
                    LEFT JOIN {course_format_options} childfo
                        ON childfo.sectionid = childcs.id
                        AND childfo.format    = 'multitopic'
                        AND childfo.name      = 'level'
                    WHERE parentcs.course = :courseid
                    AND parentcs.id     = :parentsectionid
                    -- only sections after the parent and before the next top-level (level=0) section
                    AND childcs.section > parentcs.section
                    AND childcs.section < COALESCE((
                            SELECT MIN(nextcs.section)
                            FROM {course_sections} nextcs
                            LEFT JOIN {course_format_options} nextfo
                                ON nextfo.sectionid = nextcs.id
                                AND nextfo.format    = 'multitopic'
                                AND nextfo.name      = 'level'
                            WHERE nextcs.course = parentcs.course
                            AND nextcs.section > parentcs.section
                            AND COALESCE($castNext, 0) = 0
                        ), 1000000000)
                    -- depth filter
                    AND COALESCE($castChild, 0) $depthop
                    ORDER BY childcs.section
                ";

                $params = [
                    'courseid'        => $rec->courseid,
                    'parentsectionid' => $rec->sectionid,
                ];

                $subsections = array_values($DB->get_records_sql($sqlSubsections, $params));

                // --------- For each subsection, fetch modules ---------
                //foreach ($subsections as &$subsection) {

                    $sqlModules = "
                        SELECT cm.id,
                            CASE
                                WHEN m.name = 'page'  THEN (SELECT name FROM {page}  WHERE id = cm.instance)
                                -- Add more modules as needed:
                                -- WHEN m.name = 'page'  THEN (SELECT name FROM {page}   WHERE id = cm.instance)
                                -- WHEN m.name = 'url'   THEN (SELECT name FROM {url}    WHERE id = cm.instance)
                                ELSE 'Unknown Activity'
                            END AS module_name,
                            cm.instance
                        FROM {course_modules} cm
                        JOIN {modules} m ON cm.module = m.id
                        WHERE cm.section = :sectionid
                        AND cm.deletioninprogress = 0
                    ";
                    $modules = $DB->get_records_sql($sqlModules, ['sectionid' => $subsections[0]->id]);

                    $slides_url = null;
                    foreach ($modules as $rec) {

                            $slides_url = (new moodle_url('/mod/page/view.php', ['id' => $rec->id]))->out(false);
                            break;

                    }

                    $isfirst = is_first_section($record['courseid'], $record['sectionid']); // true if section number is the minimum (usually 0)

                    if($isfirst)
                    {
                     $topic_url = (new moodle_url('/course/view.php', ['id' => $record['courseid']]))->out(false);   
                    }else{
                       $topic_url = (new moodle_url('/course/view.php', [
        'id'        => $record['courseid'],   // course id
        'sectionid' => $record['sectionid'],  // course_sections.id
    ]))->out(false);
                    }

                    


echo json_encode(['success' => true, 'record' => $record, 'slides' => $slides_url, 'topic' => $topic_url], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);




/**
 * Is this the first section of a course?
 *
 * @param int  $courseid
 * @param int  $sectionid   primary key from {course_sections}
 * @param bool $includegeneral  true = section 0 counts as first; false = start at section 1
 * @param bool $onlyvisible     true = ignore hidden sections when finding the first
 * @return bool
 */
function is_first_section(int $courseid, int $sectionid, bool $includegeneral = true, bool $onlyvisible = false): bool {
    global $DB;

    // Get the target section's section number in this course.
    $target = $DB->get_record('course_sections',
        ['id' => $sectionid, 'course' => $courseid],
        'id, course, section, visible', IGNORE_MISSING);

    if (!$target) {
        return false; // not in that course or doesn't exist
    }

    $where  = 'course = ?';
    $params = [$courseid];

    if (!$includegeneral) {
        $where .= ' AND section > 0';
    }
    if ($onlyvisible) {
        $where .= ' AND visible = 1';
    }

    $minsection = $DB->get_field_sql("SELECT MIN(section) FROM {course_sections} WHERE $where", $params);

    if ($minsection === null) {
        return false; // course has no sections?
    }

    return ((int)$target->section === (int)$minsection);
}




/**
 * Get "until" timestamp for a cohort from an activity's availability.
 * Falls back to the module's own due/close date if no cohort-specific until found.
 *
 * @param int $cmid course_modules.id
 * @param int $cohortid cohort id
 * @return array|null ['source' => 'availability'|'module', 'timestamp' => int] or null if nothing
 */
function get_due_for_cohort_or_module(int $cmid, int $cohortid) {
    global $DB;

    // Fetch module basics.
    $cm = $DB->get_record_sql("
        SELECT cm.id, cm.instance, cm.availability, m.name AS modname
          FROM {course_modules} cm
          JOIN {modules} m ON m.id = cm.module
         WHERE cm.id = :cmid
    ", ['cmid' => $cmid]);

    if (!$cm) {
        return null;
    }

    // 1) Try to read "until" date from availability JSON for this cohort.
    $until = null;
    if (!empty($cm->availability)) {
        $tree = json_decode($cm->availability, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $until = find_until_for_cohort_in_availability($tree, (int)$cohortid);
        }
    }
    if (!empty($until)) {
        return ['source' => 'availability', 'timestamp' => (int)$until];
    }

    // 2) Fallback: get the module's own due/close date.
    $due = null;
    if ($cm->modname === 'assign') {
        // Prefer duedate; optionally consider cutoffdate if you want stricter closing.
        $due = (int)$DB->get_field('assign', 'duedate', ['id' => $cm->instance]);
        if (empty($due)) {
            $cutoff = (int)$DB->get_field('assign', 'cutoffdate', ['id' => $cm->instance]);
            if (!empty($cutoff)) { $due = $cutoff; }
        }
    } else if ($cm->modname === 'quiz') {
        $due = (int)$DB->get_field('quiz', 'timeclose', ['id' => $cm->instance]);
    }

    if (!empty($due)) {
        return ['source' => 'module', 'timestamp' => $due];
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

            return (int)$child['c'][2]['t']; // <-- return your until time
        }
    }

    return null;
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