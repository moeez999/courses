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
 * Lists the course categories
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package course
 */

require_once("../config.php");
require_once($CFG->dirroot. '/course/lib.php');
require_once($CFG->dirroot. '/mod/googlemeet/lib.php');
$PAGE->requires->css(new moodle_url('./course.css'), true);
$user = $USER;
$urlCourse = new moodle_url($CFG->wwwroot .'/course/view.php?id=');

// Capture the googleMeetId from the query string
$cohortid = optional_param('cohortid', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT); // Default to 0 if not passed

$categoryid = optional_param('categoryid', 0, PARAM_INT); // Category id
$site = get_site();

if ($CFG->forcelogin) {
    require_login();
}

$heading = $site->fullname;
if ($categoryid) {
    $category = core_course_category::get($categoryid); // This will validate access.
    $PAGE->set_category_by_id($categoryid);
    $PAGE->set_url(new moodle_url('/course/index.php', array('categoryid' => $categoryid)));
    $PAGE->set_pagetype('course-index-category');
    $heading = $category->get_formatted_name();
} else if ($category = core_course_category::user_top()) {
    // Check if there is only one top-level category, if so use that.
    $categoryid = $category->id;
    $PAGE->set_url('/course/index.php');
    if ($category->is_uservisible() && $categoryid) {
        $PAGE->set_category_by_id($categoryid);
        $PAGE->set_context($category->get_context());
        if (!core_course_category::is_simple_site()) {
            $PAGE->set_url(new moodle_url('/course/index.php', array('categoryid' => $categoryid)));
            $heading = $category->get_formatted_name();
        }
    } else {
        $PAGE->set_context(context_system::instance());
    }
    $PAGE->set_pagetype('course-index-category');
} else {
    throw new moodle_exception('cannotviewcategory');
}



$PAGE->set_heading("Session Recordings");


echo $OUTPUT->header();


?>

<script>
// Function to reload the page with the selected session type
function reloadPageWithSessionType() {
    var sessionType = document.getElementById('sessionType').value;
    var url = new URL(window.location.href);
    url.searchParams.set('sessionType', sessionType); // Set sessionType in URL
    window.location.href = url.toString(); // Reload the page with the new URL
}
</script>

<?php


    global $DB;
    // Fetch all sections in the course
    $sections = $DB->get_records('course_sections', ['course' => $courseid], 'section ASC');

    // Loop through sections to find those restricted to the cohort
    $allowed_sections = [];
    foreach ($sections as $section) {
        if (!empty($section->availability)) {
            // Decode the availability JSON
            $availability = json_decode($section->availability, true);
    
            // Check if there is a cohort restriction
            if (isset($availability['c']) && is_array($availability['c'])) {
                foreach ($availability['c'] as $condition) {
                    if ($condition['type'] === 'cohort' && $condition['id'] == $cohortid) {
                        $allowed_sections[] = $section;
                        break;
                    }
                }
            }
        }
    }
    
    $googleMeetActivities = []; // Array to store Google Meet activities with their upcoming schedules
    
    if (!empty($allowed_sections)) {
        //echo "Topics allowed for cohort ID $cohortid:<br>";
    
        foreach ($allowed_sections as $section) {
            //echo "Section: " . $section->section . " - " . $section->name . "<br>";
    
            // Fetch all modules in this section
            $modules = $DB->get_records('course_modules', ['section' => $section->id]);
    
            if (!empty($modules)) {
                //echo "Activities in this section:<br>";
    
                foreach ($modules as $module) {
                    // Get module information from modinfo
                    $modinfo = $DB->get_record('modules', ['id' => $module->module]);
    
                    if ($modinfo && $modinfo->name === 'googlemeet') { // Check if it's a Google Meet module
                        // Fetch Google Meet activity details
                        $googleMeetActivity = $DB->get_record('googlemeet', ['id' => $module->instance]);
                        if ($googleMeetActivity) {
                            // Fetch the upcoming schedule for this Google Meet activity
                            $sql = "SELECT * 
                                    FROM {googlemeet_events}
                                    WHERE googlemeetid = :googlemeetid 
                                      AND eventdate > :currenttime
                                    ORDER BY eventdate ASC
                                    LIMIT 1";
                            $params = [
                                'googlemeetid' => $googleMeetActivity->id,
                                'currenttime' => time()
                            ];
                            $upcomingSchedule = $DB->get_record_sql($sql, $params);
    
                            // Store activity details and the upcoming schedule
                            $googleMeetActivities[] = (object) [
                                'name' => $googleMeetActivity->name,
                                'section' => $section->section,
                                'module_id' => $module->id,
                                'upcoming_schedule' => $upcomingSchedule
                            ];
    
                            //echo "- Google Meet: " . $googleMeetActivity->name . "<br>";
                            if ($upcomingSchedule) {
                                //echo "-- Upcoming Event Date: " . date('Y-m-d H:i:s', $upcomingSchedule->eventdate) . "<br>";
                               // echo "-- Duration: " . $upcomingSchedule->duration . " minutes<br>";
                            } else {
                                //echo "-- No upcoming schedule found.<br>";
                            }
                        }
                    }
                }
            } else {
                //echo "No activities found in this section.<br>";
            }
        }
    
    } else {
        //echo "No topics are restricted to cohort ID $cohortid in this course.";
    }

// Retrieve the sessionType parameter
$sessionType = optional_param('sessionType', '', PARAM_TEXT);

// Check if sessionType is empty and use defaults if necessary
if (empty($sessionType)) {
    if (!empty($googleMeetActivities)) {
        // Set defaults to the first element of the $googleMeetActivities array
        $module_id = (int)$googleMeetActivities[0]->module_id;
        $googlemeetid = (int)$googleMeetActivities[0]->upcoming_schedule->googlemeetid;
    } else {
        // Fallback default values if $googleMeetActivities is empty
        $module_id = 1;
        $googlemeetid = 1;
    }
} else {
    // Split the sessionType into module_id and googlemeetid
    list($module_id, $googlemeetid) = explode('_', $sessionType);

    // Cast to integers for safety
    $module_id = (int)$module_id;
    $googlemeetid = (int)$googlemeetid;
}

// Add CSS styles for the dropdown
echo '<style>
    .dropdown-container {
        margin: 10px 0;
    }
    .dropdown-container label {
        font-size: 14px;
        font-weight: bold;
        margin-right: 10px;
    }
    #sessionType {
        font-size: 14px;
        padding: 5px;
        background-color: #f9f9f9; /* Light background */
        border: none; /* Remove border */
        border-radius: 4px; /* Optional: Add some rounding to the edges */
        outline: none; /* Remove focus outline */
        cursor: pointer;
    }
    #sessionType:focus {
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.2); /* Optional: Add focus effect */
    }
</style>';



// Create the dropdown dynamically based on $googleMeetActivities
echo '<div class="dropdown-container">
    <label for="sessionType">Select Session:</label>
    <select id="sessionType" name="sessionType" onchange="reloadPageWithSessionType()">';

// Loop through $googleMeetActivities to populate the options
foreach ($googleMeetActivities as $activity) {
    // Combine module_id and googlemeetid with an underscore
    $value = $activity->module_id . '_' . $activity->upcoming_schedule->googlemeetid;

    // Check if this option should be selected
    $selected = ($sessionType === $value) ? ' selected' : '';

    // Render the option
    echo '<option value="' . $value . '"' . $selected . '>' . htmlspecialchars($activity->name) . '</option>';
}

echo '</select>
</div>';


$params = ['googlemeetid' => $googlemeetid];
$recordings = googlemeet_list_recordings($params);

    foreach ($recordings as &$recording) {
        $recording->isEnterClassTopic = ($recording->name === "Enter class topic");
    }


    if (is_siteadmin($user->id)) {
        $editable = 1;
        $visible = 1;
    } else {
        $editable = 0;
        $visible = 0;
    }


echo $OUTPUT->render_from_template('mod_googlemeet/recordingstable', [
    'recordings' => $recordings,
    'coursemoduleid' => $module_id,
    'hascapability' => 1,
    'editable' => $editable,
    'visiblee' => $visible
]);

echo $OUTPUT->footer();
