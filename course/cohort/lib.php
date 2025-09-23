<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Cohort related management functions, this file needs to be included manually.
 *
 * @package    core_cohort
 * @copyright  2010 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

define('COHORT_ALL', 0);
define('COHORT_COUNT_MEMBERS', 1);
define('COHORT_COUNT_ENROLLED_MEMBERS', 3);
define('COHORT_WITH_MEMBERS_ONLY', 5);
define('COHORT_WITH_ENROLLED_MEMBERS_ONLY', 17);
define('COHORT_WITH_NOTENROLLED_MEMBERS_ONLY', 23);

/**
 * Add new cohort.
 *
 * @param  stdClass $cohort
 * @return int new cohort id
 */
/**
 * Add new cohort.
 *
 * @param  stdClass $cohort
 * @return int new cohort id
 */
function cohort_add_cohort($cohort) {
    global $DB, $CFG;

    if (!isset($cohort->name)) {
        throw new coding_exception('Missing cohort name in cohort_add_cohort().');
    }
    if (!isset($cohort->idnumber)) {
        $cohort->idnumber = NULL;
    }
    if (!isset($cohort->description)) {
        $cohort->description = '';
    }
    if (!isset($cohort->descriptionformat)) {
        $cohort->descriptionformat = FORMAT_HTML;
    }
    if (!isset($cohort->visible)) {
        $cohort->visible = 1;
    }
    if (empty($cohort->component)) {
        $cohort->component = '';
    }
    if (empty($CFG->allowcohortthemes) && isset($cohort->theme)) {
        unset($cohort->theme);
    }
    if (empty($cohort->theme) || empty($CFG->allowcohortthemes)) {
        $cohort->theme = '';
    }
    if (!isset($cohort->timecreated)) {
        $cohort->timecreated = time();
    }
    if (!isset($cohort->timemodified)) {
        $cohort->timemodified = $cohort->timecreated;
    }

    $cohort->id = $DB->insert_record('cohort', $cohort);

    $handler = core_cohort\customfield\cohort_handler::create();
    $handler->instance_form_save($cohort, true);

    $event = \core\event\cohort_created::create(array(
        'context' => context::instance_by_id($cohort->contextid),
        'objectid' => $cohort->id,
    ));
    $event->add_record_snapshot('cohort', $cohort);
    $event->trigger();

    // Add your custom logic here (after cohort is created and before returning the ID).
    if ($cohort->id) {
        $courseid = 2; // Replace with your desired course ID

        // Create a new section in the course.
        $section = create_course_section($courseid, strtoupper($cohort->shortname));

        // Restrict the new section to the newly created cohort.
        if ($section) {
            
            add_cohort_restriction($courseid, $section->id, $cohort->id);
            
              // Update the course_format_options table
            if ($section->id) {
                // Update 'level' option
                $DB->execute(
                    "UPDATE {course_format_options} SET value = ? WHERE name = ? AND sectionid = ?",
                    [0, 'level', $section->id]
                );
        
                // // Update 'periodduration' option
                // $DB->execute(
                //     "UPDATE {course_format_options} SET value = ? WHERE name = ? AND sectionid = ?",
                //     ['0 day', 'periodduration', $section->id]
                // );
            }
            add_googlemeet_activities_to_section($courseid, $section->id, $cohort);
            
        }
    }

    return $cohort->id;
}

function add_cohort_restriction($courseid, $sectionid, $cohortid) {
    global $DB;

    // Build the availability restriction for the cohort.
    $availability = [
        'op' => '|', // OR condition, you can also use '&' for AND logic if needed
        'c' => [
            [
                'type' => 'cohort', // Restriction type is 'cohort'
                'id' => $cohortid,  // The ID of the cohort
            ],
        ],
        'showc' => [true], // This ensures the section is shown only to the specified cohort
    ];

    // Update the course section with the availability restriction.
    $section = $DB->get_record('course_sections', ['id' => $sectionid], '*', MUST_EXIST);

    // Apply the availability restriction to the section.
    $section->availability = json_encode($availability);

    // Update the section record in the database.
    $DB->update_record('course_sections', $section);

    // Rebuild the course cache to reflect changes.
    rebuild_course_cache($courseid);
}


function create_course_section($courseid, $cohortShortName) {
    global $DB;

    // Check if the course exists.
    $course = $DB->get_record('course', ['id' => $courseid], '*', MUST_EXIST);

    // Add a new section to the course.
    $section = new stdClass();
    $section->course = $courseid;
    $section->section = $DB->get_field_sql(
        'SELECT MAX(section) + 1 FROM {course_sections} WHERE course = ?',
        [$courseid]
    );
    $section->name = $cohortShortName; // You can customize this
    $section->summary = ''; // Customize the summary
    $section->summaryformat = FORMAT_HTML;
    $section->visible = 1; // Section is visible by default
    $section->timemodified = time(); // Set the current Unix timestamp

    // Insert the new section record.
    $section->id = $DB->insert_record('course_sections', $section);
    
    //Let Moodle handle format options properly
    if ($section->id) {
        $format = course_get_format($courseid); // Get course format
        $format->update_section_format_options($section, [
            'level' => 0,
            'periodduration' => '0 day',
            'some_other_setting' => 'default_value'
        ]);
    }

    // Rebuild the course cache to reflect the changes.
    rebuild_course_cache($courseid);

    return $section;
}


function add_googlemeet_activities_to_section($courseid, $sectionid, $cohort) {
    global $DB, $CFG, $USER;

    require_once($CFG->dirroot . '/mod/googlemeet/lib.php');

    // Ensure the Google Meet module exists.
    if (!is_module_available('googlemeet')) {
        throw new coding_exception('Google Meet module is not installed.');
    }

    // Define the time-related values (you need to get these from the cohort creation form)
    $starthour = isset($cohort->starthour) ? $cohort->starthour : 9; // Default to 9 AM
    $startminute = isset($cohort->startminute) ? $cohort->startminute : 0;
    $endhour = isset($cohort->endhour) ? $cohort->endhour : ($starthour + 1); // Default 1-hour session
    $endminute = isset($cohort->endminute) ? $cohort->endminute : 0;
    $eventdate = isset($cohort->eventdate) ? $cohort->eventdate : strtotime('tomorrow'); // Default to tomorrow

    // Define the Google Meet activities data.
    $activities = [
        ['name' => $cohort->idnumber . ' Main Classes'],
        ['name' => $cohort->idnumber . ' Practice Session'],
    ];

     foreach ($activities as $index => $activity_data) {
        // Prepare the data for the Google Meet instance.
        $googlemeet = new stdClass();
        $googlemeet->client_islogged = 1;
        $googlemeet->name = $activity_data['name'];
        $googlemeet->showdescription = "0"; // Default language (can be set dynamically if needed)
        // Pass the cohort's event time details
        $googlemeet->eventdate = $eventdate;
        if ($index === 0) { // Main Classes
            $googlemeet->starthour = isset($cohort->cohorthours) ? $cohort->cohorthours : $starthour;
            $googlemeet->startminute = isset($cohort->cohortminutes) ? $cohort->cohortminutes : $startminute;

            // Calculate end time (+1 hour, same minute)
            $googlemeet->endhour = $googlemeet->starthour + 1;
            $googlemeet->endminute = $googlemeet->startminute;
        } else { // Practice Session
            $googlemeet->starthour = isset($cohort->cohorttutorhours) ? $cohort->cohorttutorhours : $starthour;
            $googlemeet->startminute = isset($cohort->cohorttutorminutes) ? $cohort->cohorttutorminutes : $startminute;

            // Calculate end time (+1 hour, same minute)
            $googlemeet->endhour = $googlemeet->starthour + 1;
            $googlemeet->endminute = $googlemeet->startminute;
        }

        $googlemeet->addmultiply = "1"; // Default language (can be set dynamically if needed)

        // // Add a fixed days array (Monday & Tuesday)
        // $googlemeet->days = [
        //     'Mon' => "1",
        //     'Tue' => "1"
        // ];


            if ($index === 0) { // Main Classes
            $days = [];
            if (isset($cohort->cohortmonday) && $cohort->cohortmonday == "1") {
                $days['Mon'] = "1";
            }
            if (isset($cohort->cohorttuesday) && $cohort->cohorttuesday == "1") {
                $days['Tue'] = "1";
            }
            if (isset($cohort->cohortwednesday) && $cohort->cohortwednesday == "1") {
                $days['Wed'] = "1";
            }
            if (isset($cohort->cohortthursday) && $cohort->cohortthursday == "1") {
                $days['Thu'] = "1";
            }
            if (isset($cohort->cohortfriday) && $cohort->cohortfriday == "1") {
                $days['Fri'] = "1";
            }
            $googlemeet->days = $days;
        } else { // Practice Session
            $days = [];
            if (isset($cohort->cohorttutormonday) && $cohort->cohorttutormonday == "1") {
                $days['Mon'] = "1";
            }
            if (isset($cohort->cohorttutortuesday) && $cohort->cohorttutortuesday == "1") {
                $days['Tue'] = "1";
            }
            if (isset($cohort->cohorttutorwednesday) && $cohort->cohorttutorwednesday == "1") {
                $days['Wed'] = "1";
            }
            if (isset($cohort->cohorttutorthursday) && $cohort->cohorttutorthursday == "1") {
                $days['Thu'] = "1";
            }
            if (isset($cohort->cohorttutorfriday) && $cohort->cohorttutorfriday == "1") {
                $days['Fri'] = "1";
            }
            $googlemeet->days = $days;
        }

        $googlemeet->period = "1"; // Default language (can be set dynamically if needed)

        //$googlemeet->eventenddate = $eventdate;//
        $googlemeet->eventenddate = isset($cohort->enddate) ? $cohort->enddate : $eventdate;

        $googlemeet->mform_isexpanded_id_headerroomurl = 1;

        $googlemeet->url = "";

        $googlemeet->creatoremail = $USER->email; // Use the current user's email

        $googlemeet->notify = "1"; // Notify participants

        $googlemeet->minutesbefore = "5"; // Notify 5 minutes before the meeting

        $googlemeet->visibleoncoursepage = 1; // Make visible on the course page

        $googlemeet->cmidnumber = ""; // Custom course module ID (optional)

        $googlemeet->lang = ""; // Default language (can be set dynamically if needed)

        $availability = [
            'op' => '|', // OR condition
            'c' => [
                [
                    'type' => 'cohort', // Restriction type is 'cohort'
                    'id' => $cohort->id,  // Dynamic cohort ID
                ],
            ],
            'showc' => [true], // Ensure the section is shown only to the specified cohort
        ];
        
        // Convert array to JSON and assign it
        $googlemeet->availabilityconditionsjson = json_encode($availability, JSON_UNESCAPED_SLASHES);
        // $googlemeet->availabilityconditionsjson = '{"op":"&","c":[],"showc":[]}';

         // Completion settings
         $googlemeet->completionunlocked = 1;
         $googlemeet->completion = 0;
         $googlemeet->completionexpected = 0;

          // Tags (empty array by default)
        $googlemeet->tags = [];

        $googlemeet->course = $courseid;

        global $DB, $CFG;

        // // Get the Moodle database name from config.php
        // $dbname = $CFG->dbname;

        // // Get the next auto-increment value for course_modules
        // $sql = "SELECT AUTO_INCREMENT 
        //         FROM information_schema.TABLES 
        //         WHERE TABLE_SCHEMA = :dbname 
        //         AND TABLE_NAME = 'giax_course_modules'";

        // $params = ['dbname' => $dbname];

        // $next_cm_id = (int) $DB->get_field_sql($sql, $params);

        $cm = new stdClass();
        $cm->course = $courseid;
        $cm->module = 24; // Use the module ID from `mdl_modules`
        $cm->instance = 0; // Will be updated after insert
        $cm->section = $sectionid;
        $cm->added = time();
        $cm->visible = 1;

        $cm->id = $DB->insert_record('course_modules', $cm);

        $googlemeet->coursemodule = $cm->id;

        // Link the course module to the section
        $section = $DB->get_record('course_sections', ['id' => $sectionid]);
        $section->sequence = empty($section->sequence) ? $cm->id : $section->sequence . ',' . $cm->id;
        $DB->update_record('course_sections', $section);

        $googlemeet->section = $sectionid;

        $googlemeet->module = 24;

        $googlemeet->modulename = "googlemeet";

         $googlemeet->instance = "";

         $googlemeet->add = "googlemeet";

         $googlemeet->update = 0;

         $googlemeet->return = 0;

         $googlemeet->sr = 0;

         $googlemeet->beforemod = null;

         $googlemeet->showonly = "";

         $googlemeet->competencies = [];

         $googlemeet->competency_rule = "0";

         $googlemeet->override_grade = 0;

         $googlemeet->submitbutton2 = "Save and return to course";

         $googlemeet->frontend = true;
         $googlemeet->groupingid = 0;

         $googlemeet->completionview = 0;
         $googlemeet->completionpassgrade = 0;
        
        $googlemeet->intro = ''; // Customize as needed
        $googlemeet->introformat = FORMAT_HTML;
        $googlemeet->visible = 1; // Set the activity to be visible
       
        //$googlemeet->timemodified = time();

      

         
         
   
         
       
        

        // Call the Google Meet plugin function to add the instance.
        $module_instance_id = googlemeet_add_instance($googlemeet);
        
        // echo $module_instance_id;
        // echo ' ';
        // echo $cm->id;
        // die;

        if ($module_instance_id) {
            // Add the activity to the section.
            // $section = $DB->get_record('course_sections', ['id' => $sectionid]);
            // $section->sequence = empty($section->sequence) ? $module_instance_id : $section->sequence . ',' . $module_instance_id;
            // $DB->update_record('course_sections', $section);

            // Ensure the course module exists
            $cm = $DB->get_record('course_modules', ['id' => $cm->id]);
            if (!$cm) {
                throw new moodle_exception('Course module not found.');
            }

            // Update the instance ID in the course module
            $cm->instance = $module_instance_id;
            $DB->update_record('course_modules', $cm);
        }
    }

    // Rebuild the course cache to reflect the changes.
    rebuild_course_cache($courseid);
}


function is_module_available($modname) {
    global $DB;

    // Check if the module is installed and available.
    return $DB->record_exists('modules', ['name' => $modname]);
}

/**
 * Update existing cohort.
 * @param  stdClass $cohort
 * @return void
 */
function cohort_update_cohort($cohort) {
    global $DB, $CFG;
    if (property_exists($cohort, 'component') and empty($cohort->component)) {
        // prevent NULLs
        $cohort->component = '';
    }
    // Only unset the cohort theme if allowcohortthemes is enabled to prevent the value from being overwritten.
    if (empty($CFG->allowcohortthemes) && isset($cohort->theme)) {
        unset($cohort->theme);
    }
    $cohort->timemodified = time();

    // Update custom fields if there are any of them in the form.
    $handler = core_cohort\customfield\cohort_handler::create();
    $handler->instance_form_save($cohort);

    $DB->update_record('cohort', $cohort);

    $event = \core\event\cohort_updated::create(array(
        'context' => context::instance_by_id($cohort->contextid),
        'objectid' => $cohort->id,
    ));
    $event->trigger();
}


/**
 * Delete cohort.
 * @param  stdClass $cohort
 * @return void
 */
function cohort_delete_cohort($cohort) {
    global $DB;

    if ($cohort->component) {
        // TODO: add component delete callback
    }

    $handler = core_cohort\customfield\cohort_handler::create();
    $handler->delete_instance($cohort->id);

    $DB->delete_records('cohort_members', array('cohortid'=>$cohort->id));
    $DB->delete_records('cohort', array('id'=>$cohort->id));

    // Notify the competency subsystem.
    \core_competency\api::hook_cohort_deleted($cohort);

    $event = \core\event\cohort_deleted::create(array(
        'context' => context::instance_by_id($cohort->contextid),
        'objectid' => $cohort->id,
    ));
    $event->add_record_snapshot('cohort', $cohort);
    $event->trigger();
}

/**
 * Somehow deal with cohorts when deleting course category,
 * we can not just delete them because they might be used in enrol
 * plugins or referenced in external systems.
 * @param  stdClass|core_course_category $category
 * @return void
 */
function cohort_delete_category($category) {
    global $DB;
    // TODO: make sure that cohorts are really, really not used anywhere and delete, for now just move to parent or system context

    $oldcontext = context_coursecat::instance($category->id);

    if ($category->parent and $parent = $DB->get_record('course_categories', array('id'=>$category->parent))) {
        $parentcontext = context_coursecat::instance($parent->id);
        $sql = "UPDATE {cohort} SET contextid = :newcontext WHERE contextid = :oldcontext";
        $params = array('oldcontext'=>$oldcontext->id, 'newcontext'=>$parentcontext->id);
    } else {
        $syscontext = context_system::instance();
        $sql = "UPDATE {cohort} SET contextid = :newcontext WHERE contextid = :oldcontext";
        $params = array('oldcontext'=>$oldcontext->id, 'newcontext'=>$syscontext->id);
    }

    $DB->execute($sql, $params);
}

/**
 * Add cohort member
 * @param  int $cohortid
 * @param  int $userid
 * @return void
 */
function cohort_add_member($cohortid, $userid) {
    global $DB;
    if ($DB->record_exists('cohort_members', array('cohortid'=>$cohortid, 'userid'=>$userid))) {
        // No duplicates!
        return;
    }
    $record = new stdClass();
    $record->cohortid  = $cohortid;
    $record->userid    = $userid;
    $record->timeadded = time();
    $DB->insert_record('cohort_members', $record);

    // Check if the custom field 'cohort' exists.
    $field = $DB->get_record('user_info_field', ['shortname' => 'cohort'], '*', MUST_EXIST);

    if ($field) {
        // Check if there is data for this user in the custom field.
        $data = $DB->get_record('user_info_data', [
            'fieldid' => $field->id,
            'userid' => $userid
        ]);

        if ($data) {
            // Delete the existing data.
            $DB->delete_records('user_info_data', ['id' => $data->id]);
        }
        
         // Get the cohort details
        $cohort = $DB->get_record('cohort', array('id' => $cohortid), 'name', MUST_EXIST);
        $cohortName = $cohort->name;  // Get the cohort name

        // Now insert the new cohort value into the user profile field.
        $data = new stdClass();
        $data->fieldid  = $field->id;
        $data->userid   = $userid;
        $data->data     = $cohortName;  // Store cohort ID in the custom field.
        $data->timecreated = time();
        $data->timemodified = time();
        $DB->insert_record('user_info_data', $data);
    }

    $cohort = $DB->get_record('cohort', array('id' => $cohortid), '*', MUST_EXIST);

    $event = \core\event\cohort_member_added::create(array(
        'context' => context::instance_by_id($cohort->contextid),
        'objectid' => $cohortid,
        'relateduserid' => $userid,
    ));
    $event->add_record_snapshot('cohort', $cohort);
    $event->trigger();
}

/**
 * Remove cohort member
 * @param  int $cohortid
 * @param  int $userid
 * @return void
 */
function cohort_remove_member($cohortid, $userid) {
    global $DB;
    $DB->delete_records('cohort_members', array('cohortid'=>$cohortid, 'userid'=>$userid));

          // Retrieve the custom field id for 'cohort'.
          $field = $DB->get_record('user_info_field', ['shortname' => 'cohort'], '*', MUST_EXIST);

          if ($field) {
              // Check if a record already exists for this user and field.
              $data = $DB->get_record('user_info_data', [
                  'fieldid' => $field->id,
                  'userid' => $userid
              ]);
      
              if ($data) {
                  // Update the existing record.
                  $data->data = $cohortid;
                  $data->timemodified = time();
                  $DB->update_record('user_info_data', $data);
              } else {
                  // Insert a new record.
                  $record = new stdClass();
                  $record->userid = $userid;
                  $record->fieldid = $field->id;
                  $record->data = $cohortid;
                  $record->timemodified = time();
                  $DB->insert_record('user_info_data', $record);
              }
          }

    $cohort = $DB->get_record('cohort', array('id' => $cohortid), '*', MUST_EXIST);

    $event = \core\event\cohort_member_removed::create(array(
        'context' => context::instance_by_id($cohort->contextid),
        'objectid' => $cohortid,
        'relateduserid' => $userid,
    ));
    $event->add_record_snapshot('cohort', $cohort);
    $event->trigger();
}

/**
 * Is this user a cohort member?
 * @param int $cohortid
 * @param int $userid
 * @return bool
 */
function cohort_is_member($cohortid, $userid) {
    global $DB;

    return $DB->record_exists('cohort_members', array('cohortid'=>$cohortid, 'userid'=>$userid));
}

/**
 * Returns the list of cohorts visible to the current user in the given course.
 *
 * The following fields are returned in each record: id, name, contextid, idnumber, visible
 * Fields memberscnt and enrolledcnt will be also returned if requested
 *
 * @param context $currentcontext
 * @param int $withmembers one of the COHORT_XXX constants that allows to return non empty cohorts only
 *      or cohorts with enroled/not enroled users, or just return members count
 * @param int $offset
 * @param int $limit
 * @param string $search
 * @param bool $withcustomfields if set to yes, then cohort custom fields will be included in the results.
 * @return array
 */
function cohort_get_available_cohorts($currentcontext, $withmembers = 0, $offset = 0, $limit = 25,
        $search = '', $withcustomfields = false) {
    global $DB;

    $params = array();

    // Build context subquery. Find the list of parent context where user is able to see any or visible-only cohorts.
    // Since this method is normally called for the current course all parent contexts are already preloaded.
    $contextsany = array_filter($currentcontext->get_parent_context_ids(),
        function($a) {
            return has_capability("moodle/cohort:view", context::instance_by_id($a));
        });
    $contextsvisible = array_diff($currentcontext->get_parent_context_ids(), $contextsany);
    if (empty($contextsany) && empty($contextsvisible)) {
        // User does not have any permissions to view cohorts.
        return array();
    }
    $subqueries = array();
    if (!empty($contextsany)) {
        list($parentsql, $params1) = $DB->get_in_or_equal($contextsany, SQL_PARAMS_NAMED, 'ctxa');
        $subqueries[] = 'c.contextid ' . $parentsql;
        $params = array_merge($params, $params1);
    }
    if (!empty($contextsvisible)) {
        list($parentsql, $params1) = $DB->get_in_or_equal($contextsvisible, SQL_PARAMS_NAMED, 'ctxv');
        $subqueries[] = '(c.visible = 1 AND c.contextid ' . $parentsql. ')';
        $params = array_merge($params, $params1);
    }
    $wheresql = '(' . implode(' OR ', $subqueries) . ')';

    // Build the rest of the query.
    $fromsql = "";
    $fieldssql = 'c.id, c.name, c.contextid, c.idnumber, c.visible';
    $groupbysql = '';
    $havingsql = '';
    if ($withmembers) {
        $fieldssql .= ', s.memberscnt';
        $subfields = "c.id, COUNT(DISTINCT cm.userid) AS memberscnt";
        $groupbysql = " GROUP BY c.id";
        $fromsql = " LEFT JOIN {cohort_members} cm ON cm.cohortid = c.id ";
        if (in_array($withmembers,
                array(COHORT_COUNT_ENROLLED_MEMBERS, COHORT_WITH_ENROLLED_MEMBERS_ONLY, COHORT_WITH_NOTENROLLED_MEMBERS_ONLY))) {
            list($esql, $params2) = get_enrolled_sql($currentcontext);
            $fromsql .= " LEFT JOIN ($esql) u ON u.id = cm.userid ";
            $params = array_merge($params2, $params);
            $fieldssql .= ', s.enrolledcnt';
            $subfields .= ', COUNT(DISTINCT u.id) AS enrolledcnt';
        }
        if ($withmembers == COHORT_WITH_MEMBERS_ONLY) {
            $havingsql = " HAVING COUNT(DISTINCT cm.userid) > 0";
        } else if ($withmembers == COHORT_WITH_ENROLLED_MEMBERS_ONLY) {
            $havingsql = " HAVING COUNT(DISTINCT u.id) > 0";
        } else if ($withmembers == COHORT_WITH_NOTENROLLED_MEMBERS_ONLY) {
            $havingsql = " HAVING COUNT(DISTINCT cm.userid) > COUNT(DISTINCT u.id)";
        }
    }
    if ($search) {
        list($searchsql, $searchparams) = cohort_get_search_query($search);
        $wheresql .= ' AND ' . $searchsql;
        $params = array_merge($params, $searchparams);
    }

    if ($withmembers) {
        $sql = "SELECT " . str_replace('c.', 'cohort.', $fieldssql) . "
                  FROM {cohort} cohort
                  JOIN (SELECT $subfields
                          FROM {cohort} c $fromsql
                         WHERE $wheresql $groupbysql $havingsql
                        ) s ON cohort.id = s.id
              ORDER BY cohort.name, cohort.idnumber";
    } else {
        $sql = "SELECT $fieldssql
                  FROM {cohort} c $fromsql
                 WHERE $wheresql
              ORDER BY c.name, c.idnumber";
    }

    $cohorts = $DB->get_records_sql($sql, $params, $offset, $limit);
    
     foreach ($cohorts as $cohort) {
        $temp = $cohort->name; // Store name temporarily
        $cohort->name = $cohort->idnumber; // Assign idnumber to name
        $cohort->idnumber = $temp; // Assign stored name to idnumber
    }

    if ($withcustomfields) {
        $cohortids = array_keys($cohorts);
        $customfieldsdata = cohort_get_custom_fields_data($cohortids);

        foreach ($cohorts as $cohort) {
            $cohort->customfields = !empty($customfieldsdata[$cohort->id]) ? $customfieldsdata[$cohort->id] : [];
        }
    }

    return $cohorts;
}

/**
 * Check if cohort exists and user is allowed to access it from the given context.
 *
 * @param stdClass|int $cohortorid cohort object or id
 * @param context $currentcontext current context (course) where visibility is checked
 * @return boolean
 */
function cohort_can_view_cohort($cohortorid, $currentcontext) {
    global $DB;
    if (is_numeric($cohortorid)) {
        $cohort = $DB->get_record('cohort', array('id' => $cohortorid), 'id, contextid, visible');
    } else {
        $cohort = $cohortorid;
    }

    if ($cohort && in_array($cohort->contextid, $currentcontext->get_parent_context_ids())) {
        if ($cohort->visible) {
            return true;
        }
        $cohortcontext = context::instance_by_id($cohort->contextid);
        if (has_capability('moodle/cohort:view', $cohortcontext)) {
            return true;
        }
    }
    return false;
}

/**
 * Get a cohort by id. Also does a visibility check and returns false if the user cannot see this cohort.
 *
 * @param stdClass|int $cohortorid cohort object or id
 * @param context $currentcontext current context (course) where visibility is checked
 * @param bool $withcustomfields if set to yes, then cohort custom fields will be included in the results.
 * @return stdClass|boolean
 */
function cohort_get_cohort($cohortorid, $currentcontext, $withcustomfields = false) {
    global $DB;
    if (is_numeric($cohortorid)) {
        $cohort = $DB->get_record('cohort', array('id' => $cohortorid), 'id, contextid, visible');
    } else {
        $cohort = $cohortorid;
    }

    if ($cohort && in_array($cohort->contextid, $currentcontext->get_parent_context_ids())) {
        if (!$cohort->visible) {
            $cohortcontext = context::instance_by_id($cohort->contextid);
            if (!has_capability('moodle/cohort:view', $cohortcontext)) {
                return false;
            }
        }
    } else {
        return false;
    }

    if ($cohort && $withcustomfields) {
        $customfieldsdata = cohort_get_custom_fields_data([$cohort->id]);
        $cohort->customfields = !empty($customfieldsdata[$cohort->id]) ? $customfieldsdata[$cohort->id] : [];
    }

    return $cohort;
}

/**
 * Produces a part of SQL query to filter cohorts by the search string
 *
 * Called from {@link cohort_get_cohorts()}, {@link cohort_get_all_cohorts()} and {@link cohort_get_available_cohorts()}
 *
 * @access private
 *
 * @param string $search search string
 * @param string $tablealias alias of cohort table in the SQL query (highly recommended if other tables are used in query)
 * @return array of two elements - SQL condition and array of named parameters
 */
function cohort_get_search_query($search, $tablealias = '') {
    global $DB;
    $params = array();
    if (empty($search)) {
        // This function should not be called if there is no search string, just in case return dummy query.
        return array('1=1', $params);
    }
    if ($tablealias && substr($tablealias, -1) !== '.') {
        $tablealias .= '.';
    }
    $searchparam = '%' . $DB->sql_like_escape($search) . '%';
    $conditions = array();
    $fields = array('name', 'idnumber', 'description');
    $cnt = 0;
    foreach ($fields as $field) {
        $conditions[] = $DB->sql_like($tablealias . $field, ':csearch' . $cnt, false);
        $params['csearch' . $cnt] = $searchparam;
        $cnt++;
    }
    $sql = '(' . implode(' OR ', $conditions) . ')';
    return array($sql, $params);
}

/**
 * Get all the cohorts defined in given context.
 *
 * The function does not check user capability to view/manage cohorts in the given context
 * assuming that it has been already verified.
 *
 * @param int $contextid
 * @param int $page number of the current page
 * @param int $perpage items per page
 * @param string $search search string
 * @param bool $withcustomfields if set to yes, then cohort custom fields will be included in the results.
 * @return array    Array(totalcohorts => int, cohorts => array, allcohorts => int)
 */
function cohort_get_cohorts($contextid, $page = 0, $perpage = 25, $search = '', $withcustomfields = false) {
    global $DB;

    $fields = "SELECT *";
    $countfields = "SELECT COUNT(1)";
    $sql = " FROM {cohort}
             WHERE contextid = :contextid";
    $params = array('contextid' => $contextid);
    $order = " ORDER BY name ASC, idnumber ASC";

    if (!empty($search)) {
        list($searchcondition, $searchparams) = cohort_get_search_query($search);
        $sql .= ' AND ' . $searchcondition;
        $params = array_merge($params, $searchparams);
    }

    $totalcohorts = $allcohorts = $DB->count_records('cohort', array('contextid' => $contextid));
    if (!empty($search)) {
        $totalcohorts = $DB->count_records_sql($countfields . $sql, $params);
    }
    $cohorts = $DB->get_records_sql($fields . $sql . $order, $params, $page*$perpage, $perpage);

    if ($withcustomfields) {
        $cohortids = array_keys($cohorts);
        $customfieldsdata = cohort_get_custom_fields_data($cohortids);

        foreach ($cohorts as $cohort) {
            $cohort->customfields = !empty($customfieldsdata[$cohort->id]) ? $customfieldsdata[$cohort->id] : [];
        }
    }

    return array('totalcohorts' => $totalcohorts, 'cohorts' => $cohorts, 'allcohorts' => $allcohorts);
}

/**
 * Get all the cohorts defined anywhere in system.
 *
 * The function assumes that user capability to view/manage cohorts on system level
 * has already been verified. This function only checks if such capabilities have been
 * revoked in child (categories) contexts.
 *
 * @param int $page number of the current page
 * @param int $perpage items per page
 * @param string $search search string
 * @param bool $withcustomfields if set to yes, then cohort custom fields will be included in the results.
 * @return array    Array(totalcohorts => int, cohorts => array, allcohorts => int)
 */
function cohort_get_all_cohorts($page = 0, $perpage = 25, $search = '', $withcustomfields = false) {
    global $DB;

    $fields = "SELECT c.*, ".context_helper::get_preload_record_columns_sql('ctx');
    $countfields = "SELECT COUNT(*)";
    $sql = " FROM {cohort} c
             JOIN {context} ctx ON ctx.id = c.contextid ";
    $params = array();
    $wheresql = '';

    if ($excludedcontexts = cohort_get_invisible_contexts()) {
        list($excludedsql, $excludedparams) = $DB->get_in_or_equal($excludedcontexts, SQL_PARAMS_NAMED, 'excl', false);
        $wheresql = ' WHERE c.contextid '.$excludedsql;
        $params = array_merge($params, $excludedparams);
    }

    $totalcohorts = $allcohorts = $DB->count_records_sql($countfields . $sql . $wheresql, $params);

    if (!empty($search)) {
        list($searchcondition, $searchparams) = cohort_get_search_query($search, 'c');
        $wheresql .= ($wheresql ? ' AND ' : ' WHERE ') . $searchcondition;
        $params = array_merge($params, $searchparams);
        $totalcohorts = $DB->count_records_sql($countfields . $sql . $wheresql, $params);
    }

    $order = " ORDER BY c.name ASC, c.idnumber ASC";
    $cohorts = $DB->get_records_sql($fields . $sql . $wheresql . $order, $params, $page*$perpage, $perpage);

    if ($withcustomfields) {
        $cohortids = array_keys($cohorts);
        $customfieldsdata = cohort_get_custom_fields_data($cohortids);
    }

    foreach ($cohorts as $cohort) {
        // Preload used contexts, they will be used to check view/manage/assign capabilities and display categories names.
        context_helper::preload_from_record($cohort);
        if ($withcustomfields) {
            $cohort->customfields = !empty($customfieldsdata[$cohort->id]) ? $customfieldsdata[$cohort->id] : [];
        }
    }

    return array('totalcohorts' => $totalcohorts, 'cohorts' => $cohorts, 'allcohorts' => $allcohorts);
}

/**
 * Get all the cohorts where the given user is member of.
 *
 * @param int $userid
 * @param bool $withcustomfields if set to yes, then cohort custom fields will be included in the results.
 * @return array Array
 */
function cohort_get_user_cohorts($userid, $withcustomfields = false) {
    global $DB;

    $sql = 'SELECT c.*
              FROM {cohort} c
              JOIN {cohort_members} cm ON c.id = cm.cohortid
             WHERE cm.userid = ? AND c.visible = 1';
    $cohorts = $DB->get_records_sql($sql, array($userid));

    if ($withcustomfields) {
        $cohortids = array_keys($cohorts);
        $customfieldsdata = cohort_get_custom_fields_data($cohortids);

        foreach ($cohorts as $cohort) {
            $cohort->customfields = !empty($customfieldsdata[$cohort->id]) ? $customfieldsdata[$cohort->id] : [];
        }
    }

    return $cohorts;
}

/**
 * Get the user cohort theme.
 *
 * If the user is member of one cohort, will return this cohort theme (if defined).
 * If the user is member of 2 or more cohorts, will return the theme if all them have the same
 * theme (null themes are ignored).
 *
 * @param int $userid
 * @return string|null
 */
function cohort_get_user_cohort_theme($userid) {
    $cohorts = cohort_get_user_cohorts($userid);
    $theme = null;
    foreach ($cohorts as $cohort) {
        if (!empty($cohort->theme)) {
            if (null === $theme) {
                $theme = $cohort->theme;
            } else if ($theme != $cohort->theme) {
                return null;
            }
        }
    }
    return $theme;
}

/**
 * Returns list of contexts where cohorts are present but current user does not have capability to view/manage them.
 *
 * This function is called from {@link cohort_get_all_cohorts()} to ensure correct pagination in rare cases when user
 * is revoked capability in child contexts. It assumes that user's capability to view/manage cohorts on system
 * level has already been verified.
 *
 * @access private
 *
 * @return array array of context ids
 */
function cohort_get_invisible_contexts() {
    global $DB;
    if (is_siteadmin()) {
        // Shortcut, admin can do anything and can not be prohibited from any context.
        return array();
    }
    $records = $DB->get_recordset_sql("SELECT DISTINCT ctx.id, ".context_helper::get_preload_record_columns_sql('ctx')." ".
        "FROM {context} ctx JOIN {cohort} c ON ctx.id = c.contextid ");
    $excludedcontexts = array();
    foreach ($records as $ctx) {
        context_helper::preload_from_record($ctx);
        if (context::instance_by_id($ctx->id) == context_system::instance()) {
            continue; // System context cohorts should be available and permissions already checked.
        }
        if (!has_any_capability(array('moodle/cohort:manage', 'moodle/cohort:view'), context::instance_by_id($ctx->id))) {
            $excludedcontexts[] = $ctx->id;
        }
    }
    $records->close();
    return $excludedcontexts;
}

/**
 * Returns navigation controls (tabtree) to be displayed on cohort management pages
 *
 * @param context $context system or category context where cohorts controls are about to be displayed
 * @param moodle_url $currenturl
 * @return null|renderable
 */
function cohort_edit_controls(context $context, moodle_url $currenturl) {
    $tabs = array();
    $currenttab = 'view';
    $viewurl = new moodle_url('/cohort/index.php', array('contextid' => $context->id));
    if (($searchquery = $currenturl->get_param('search'))) {
        $viewurl->param('search', $searchquery);
    }
    if ($context->contextlevel == CONTEXT_SYSTEM) {
        $tabs[] = new tabobject('view', new moodle_url($viewurl, array('showall' => 0)), get_string('systemcohorts', 'cohort'));
        $tabs[] = new tabobject('viewall', new moodle_url($viewurl, array('showall' => 1)), get_string('allcohorts', 'cohort'));
        if ($currenturl->get_param('showall')) {
            $currenttab = 'viewall';
        }
    } else {
        $tabs[] = new tabobject('view', $viewurl, get_string('cohorts', 'cohort'));
    }
    if (has_capability('moodle/cohort:manage', $context)) {
        $addurl = new moodle_url('/cohort/edit.php', array('contextid' => $context->id));
        $tabs[] = new tabobject('addcohort', $addurl, get_string('addcohort', 'cohort'));
        if ($currenturl->get_path() === $addurl->get_path() && !$currenturl->param('id')) {
            $currenttab = 'addcohort';
        }

        $uploadurl = new moodle_url('/cohort/upload.php', array('contextid' => $context->id));
        $tabs[] = new tabobject('uploadcohorts', $uploadurl, get_string('uploadcohorts', 'cohort'));
        if ($currenturl->get_path() === $uploadurl->get_path()) {
            $currenttab = 'uploadcohorts';
        }
    }
    if (count($tabs) > 1) {
        return new tabtree($tabs, $currenttab);
    }
    return null;
}

/**
 * Implements callback inplace_editable() allowing to edit values in-place
 *
 * @param string $itemtype
 * @param int $itemid
 * @param mixed $newvalue
 * @return \core\output\inplace_editable
 */
function core_cohort_inplace_editable($itemtype, $itemid, $newvalue) {
    if ($itemtype === 'cohortname') {
        return \core_cohort\output\cohortname::update($itemid, $newvalue);
    } else if ($itemtype === 'cohortidnumber') {
        return \core_cohort\output\cohortidnumber::update($itemid, $newvalue);
    }
}

/**
 * Returns a list of valid themes which can be displayed in a selector.
 *
 * @return array as (string)themename => (string)get_string_theme
 */
function cohort_get_list_of_themes() {
    $themes = array();
    $allthemes = get_list_of_themes();
    foreach ($allthemes as $key => $theme) {
        if (empty($theme->hidefromselector)) {
            $themes[$key] = get_string('pluginname', 'theme_'.$theme->name);
        }
    }
    return $themes;
}

/**
 * Returns custom fields data for provided cohorts.
 *
 * @param array $cohortids a list of cohort IDs to provide data for.
 * @return \core_customfield\data_controller[]
 */
function cohort_get_custom_fields_data(array $cohortids): array {
    $result = [];

    if (!empty($cohortids)) {
        $handler = core_cohort\customfield\cohort_handler::create();
        $result = $handler->get_instances_data($cohortids, true);
    }

    return $result;
}
