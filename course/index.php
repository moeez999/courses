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
//include($CFG->dirroot. '/local/adminboard/test/index.php');
include($CFG->dirroot. '/local/adminboard/test/index_new.php');


$PAGE->requires->css(new moodle_url('./style.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('./group-subscription.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('./calendar.css?v=' . time()), true);
?>

<style>
.tertiary-navigation {
    display: none !important;
    visibility: hidden !important;
}

#action_bar {
    display: none !important;
    visibility: hidden !important;
}
</style>
<?php
$PAGE->requires->css(new moodle_url('./MessageBox.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('./course.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js '), true);
$user = $USER;
$urlCourse = new moodle_url($CFG->wwwroot .'/course/view.php?id');

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
    // throw new moodle_exception('cannotviewcategory');
}

$PAGE->set_pagelayout('coursecategory');
$PAGE->set_primary_active_tab('home');
$PAGE->add_body_class('limitedwidth');
$courserenderer = $PAGE->get_renderer('core', 'course');

$PAGE->set_heading($heading);
$content = $courserenderer->course_category($categoryid);

$PAGE->set_secondary_active_tab('categorymain');

echo $OUTPUT->header();

// Ejecutamos la consulta
$cursos = $DB->get_records('course', null, 'fullname ASC');

$cursosArray = [];
// Mostrar los cursos
function ordering($fullname) {
    // Usamos una expresión regular para obtener el número al final del fullname
    preg_match('/(\d+)$/', $fullname, $coincidencias);
    return isset($coincidencias[1]) ? (int)$coincidencias[1] : 0;
}

// Mostrar los cursos
foreach ($cursos as $curso) {
    // Creamos un objeto para almacenar la información del curso
    $cursoObj = new stdClass();
    $cursoObj->id = $curso->id;
    $cursoObj->fullname = $curso->fullname;
    $cursoObj->category = $curso->category;
    $cursoObj->summary = $curso->summary;

    // Verificar si el usuario está inscrito en el curso
    if (is_enrolled(context_course::instance($curso->id), $user)) {
        $cursoObj->inscrito = true; // El usuario está inscrito
    } else {
        $cursoObj->inscrito = false; // El usuario NO está inscrito
    }

    // Añadir el objeto curso al array
    $cursosArray[] = $cursoObj;
}


if (!empty($cursosArray)) {

// Ordenar el array de cursos según el número al final del fullname
usort($cursosArray, function($a, $b) {
    return ordering($a->fullname) - ordering($b->fullname);
});
}
if (is_siteadmin($user->id)) {
    // echo $content; // Aquí va el contenido que quieres mostrar
} else {
    echo "";
}
function verificarInscripcion($cursos, $id) {
    $bol = false;  // Inicializamos bol como false para el caso en que no se encuentre el id

    // Recorremos todos los cursos
    foreach ($cursos as $curso) {
        // Verificamos si el fullname del curso coincide con el nombre
        if ($curso->id == $id) {
            // Si el curso está inscrito, retornamos true, si no, false
            if ($curso->inscrito === true) {
                $bol = true;  // El usuario está inscrito
            }
            return $bol;  // Salimos de la función inmediatamente
        }
    } 
    return $bol;  // Si no encuentra el nombre en los cursos, devuelve false
}

function getLink($cursos, $id, $url) {
    foreach ($cursos as $curso) {
        if ($curso->id == $id && !empty($curso->inscrito)) {
            return $url . "=" . $id; // Si está inscrito, devuelve la URL
        }
    }
    return "#"; // Si no está inscrito o no se encontró el curso, devuelve "#"
}

if (is_siteadmin($user->id)) {
    echo $content; // Aquí va el contenido que quieres mostrar
} else {
    echo "";
}
echo $OUTPUT->skip_link_target(); ?>

<script>
function joinClass(url) {
    //window.location.href = url;  // Redirect to the sample URL
    window.open(url, '_blank'); // Open the URL in a new window or tab
}

// window._join_debug = true;
// function dbg(m){ console.log("[JOIN DEBUG]", m); try{ if(window._join_debug) alert(m);}catch(e){} }

// function joinClass(url){
//   const stripped = url.replace(/^https?:\/\//,'');
//   dbg("start → UA: " + (navigator.userAgent||""));

//   // consider it a “Meet link” so we always try to escape
//   const isMeet = /(^|\.)meet\.google\.com$/i.test((() => { try{return new URL(url).hostname;}catch(e){return ""} })());

//   // track if we likely left the app
//   let left = false;
//   const leave = () => { left = true; dbg("visibility/pagehide → likely left app"); };
//   window.addEventListener("visibilitychange", leave, { once:true });
//   window.addEventListener("pagehide", leave, { once:true });

//   const steps = [
//     // 1) Try Google Meet app
//     { label: "Meet App intent",
//       href: `intent://${stripped}#Intent;scheme=https;package=com.google.android.apps.meetings;S.browser_fallback_url=${encodeURIComponent(url)};end` },
//     // 2) Default browser (VIEW intent)
//     { label: "Default browser VIEW intent",
//       href: `intent://${stripped}#Intent;scheme=https;action=android.intent.action.VIEW;category=android.intent.category.BROWSABLE;S.browser_fallback_url=${encodeURIComponent(url)};end` },
//     // 3) Explicit Chrome scheme
//     { label: "Chrome scheme", href: `googlechrome://navigate?url=${encodeURIComponent(url)}` },
//     // 4) Normal open (works on desktop)
//     { label: "_blank window.open", fn: () => window.open(url, '_blank') },
//     // 5) Last resort
//     { label: "location.href direct", fn: () => { location.href = url; } }
//   ];

//   const a = document.createElement("a");
//   document.body.appendChild(a);

//   let i = 0;
//   function next(){
//     if (left || i >= steps.length) {
//       dbg(left ? "stopped (left app)" : "stopped (no more steps)");
//       return;
//     }
//     const s = steps[i++];
//     dbg("trying → " + s.label);
//     try {
//       if (s.href) { a.href = s.href; a.click(); }
//       else { s.fn(); }
//     } catch (e) { dbg("error at " + s.label + ": " + e); }
//     setTimeout(next, 800); // give each a moment
//   }

//   // If it's a Meet link, always try to escape (don’t rely on Android detection)
//   if (isMeet) next();
//   else { dbg("not a Meet link → window.open"); window.open(url, "_blank", "noopener,noreferrer"); }
// }
function redirectToRecordings(cohortId, courseid) {
    if (courseid && cohortId) {
        window.location.href = 'sessionRecordings.php?cohortid=' + cohortId + '&courseid=' + courseid;
    }
    // Ensure both googleMeetId and id (cmid) are included in the URL query string
}

function redirectToActivities(cohortId, userid) {
    if (userid && cohortId) {
        window.location.href = 'latestActivities.php?cohortid=' + cohortId + '&userid=' + userid;
    }
    // Ensure both googleMeetId and id (cmid) are included in the URL query string
}
</script>
<div class="noSelect">
    <div class="wrapper">

        <header>
            <ul>
                <li><a href="" class="active">Home</a></li>
                <li><a href="">Messages</a></li>
                <li><a href="">My lessons</a></li>
                <li><a href="">Learn</a></li>
                <li><a href="">Settings</a></li>
            </ul>

            <div class="findTutors_and_findGroups">
                <a href="">Find Tutors</a>
                <a href="">Find Groups</a>
            </div>
        </header>

        <section class="page_top custom-top-margin">
            <div class="center_content">
                <?php


           function is_cohort_teacher($userid) {
                global $DB;

                $sql = "SELECT 1
                        FROM {cohort}
                        WHERE cohortmainteacher = :uid1 OR cohortguideteacher = :uid2";

                return $DB->record_exists_sql($sql, [
                    'uid1' => (int)$userid,
                    'uid2' => (int)$userid
                ]);
            }
                        
            
            if (isloggedin()) {
                if (!is_siteadmin($user->id)) {

                    global $DB;


                     $isteacher = is_cohort_teacher($user->id);

                    if ($isteacher) {
                        // User is a teacher in at least one course
                        //echo 'Yes';

                    }
                
                    // Fetch the course details using the idnumber.
                    $course = $DB->get_record('course', ['idnumber' => 'CR001'], '*');

                    if (!defined('CONTEXT_COHORT')) {
                        define('CONTEXT_COHORT', 10); // 10 is the constant value for cohort context level
                    }

                    $cohortData = [];

                    $ff = 0;


                    if(!$isteacher){
                    // SQL query to fetch the cohort names the user belongs to
                    $sql = "SELECT c.id, c.name, c.description
                            FROM {cohort} c
                            JOIN {cohort_members} cm ON cm.cohortid = c.id
                            WHERE cm.userid = :userid AND c.visible = 1";
                
                    // Execute the query and fetch the results
                    $cohorts = $DB->get_records_sql($sql, ['userid' => $user->id]);

                    if(count($cohorts) == 0)
                    {
                        $ff = 1;
                        
                    }else{
                   
                    foreach ($cohorts as $cohort) {
                        $cohortid = $cohort->id;
                         // Get the context for the cohort
                       
                    // Get the system context or category context if needed
                    $context = context_system::instance();

                    // Rewrite the cohort description to get pluginfile URL
                    $rewrittenDescription = file_rewrite_pluginfile_urls(
                        $cohort->description,
                        'pluginfile.php',
                        $context->id,
                        'cohort',
                        'description',
                        $cohort->id
                    );

                    // Extract the actual image URL from the rewritten HTML
                    preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $rewrittenDescription, $matches);
                    $imageUrl = isset($matches[1]) ? $matches[1] : ''; // fallback if not found

                     // ✅ ADD THIS
                    $cohortData[] = [
                        'id' => $cohortid,
                        'name' => $cohort->name,
                        'image' => $imageUrl,
                        'description' => $rewrittenDescription
                    ];}
                    }
                    }else{
                         // User is a cohort main teacher or guide teacher
                        $sql = "SELECT c.id, c.name, c.description, c.cohortmainteacher, c.visible, c.cohortguideteacher
                                FROM {cohort} c
                                WHERE c.cohortmainteacher = :userid1 OR c.cohortguideteacher = :userid2 AND c.visible = 1";

                        $cohorts = $DB->get_records_sql($sql, [
                            'userid1' => $user->id,
                            'userid2' => $user->id
                        ]);

                        

                        foreach ($cohorts as $cohort) {
                            $cohortid = $cohort->id;

                             // If 'visible' is already in your record, use it.
    if (isset($cohort->visible) && (int)$cohort->visible === 0) {
        continue; // skip hidden cohort
    }

                            // Get the context for the cohort description files
                            $context = context_system::instance(); // or use context_cohort::instance($cohortid) if available in your version

                            // Rewrite the cohort description with embedded file URLs
                            $rewrittenDescription = file_rewrite_pluginfile_urls(
                                $cohort->description,
                                'pluginfile.php',
                                $context->id,
                                'cohort',
                                'description',
                                $cohortid
                            );

                            // Extract image URL if present
                            preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $rewrittenDescription, $matches);
                            $imageUrl = isset($matches[1]) ? $matches[1] : '';

                            // Store everything in the array
                            $cohortData[] = [
                                'id' => $cohortid,
                                'name' => $cohort->name,
                                'image' => $imageUrl,
                                'description' => $rewrittenDescription
                            ];
                        }
                    }


                    if($ff == 1){ 
                       $googleMeetURL=""; 
                    }else{ 
                
                    
                    
                
                    // Fetch all sections in the course
                $sections = $DB->get_records('course_sections', ['course' => $course->id], 'section ASC');


                $context = context_course::instance($course->id);

                // Get the role ID for editingteacher (or use 'teacher' if needed)
                $teacherrole = $DB->get_record('role', ['shortname' => 'editingteacher']);

                $teachers = get_role_users($teacherrole->id, $context);
                $teacherName = '';

                foreach ($teachers as $teacher) {
                    $teacherName = $teacher->firstname;
                }
                
                // Loop through sections to find those restricted to the cohort
                $allowed_sections = [];
                foreach ($sections as $section) {
                    if (!empty($section->availability)) {
                        // Decode the availability JSON
                        $availability = json_decode($section->availability, true);
                
                        // Check if there is a cohort restriction
                        if (isset($availability['c']) && is_array($availability['c'])) {
                            foreach ($availability['c'] as $condition) {

                                
                                    $cohortids = array_column($cohortData, 'id');
                                    if ($condition['type'] === 'cohort' && in_array($condition['id'], $cohortids)) {


                                           if($isteacher){
                                        // Determine the user's role in the matched cohort
                                            $cohortRole = 'practice'; // default
                                            foreach ($cohorts as $cohort) {
                                                if ($cohort->id == $condition['id']) {
                                                    if ($cohort->cohortmainteacher == $user->id && $cohort->cohortguideteacher == $user->id ) {
                                                        $cohortRole = 'main_practice';
                                                    }

                                                    if ($cohort->cohortmainteacher == $user->id && $cohort->cohortguideteacher != $user->id ) {
                                                        $cohortRole = 'main';
                                                    }

                                                    if ($cohort->cohortmainteacher != $user->id && $cohort->cohortguideteacher == $user->id ) {
                                                        $cohortRole = 'practice';
                                                    }

                                                    break;
                                                }
                                            }
                                        }
                                                
                                                // Convert section to array, add role, then back to object
                                                $sectionWithRole = (array) $section;
                                                $sectionWithRole['role'] = $cohortRole;
                                                $allowed_sections[] = (object) $sectionWithRole;
                                                break;
                                            }
                                
                                
                            }
                        }
                    }
                }
                
                
                $googleMeetActivities = []; // Array to store Google Meet activities with their upcoming schedules
                
                if (!empty($allowed_sections)) {

                    $googleMeetActivities = []; // For all activities
                    $schedules = []; // Only from the first section
                    $i = 0;
                    // Get cohort ID from section availability
                   $ccid = null;
                                    
                    foreach ($allowed_sections as $section) {
                   
                      

                    // Fetch all modules in this section
                    $modules = $DB->get_records('course_modules', ['section' => $section->id]);
                    
                       

                    if (empty($modules)) {
                        continue;
                    }
                    
                    
                 
                   

                    foreach ($modules as $module) {
                        
                        
                        $modinfo = $DB->get_record('modules', ['id' => $module->module]);
                        if (!$modinfo || $modinfo->name !== 'googlemeet') {
                            continue;
                        }
                        
                        

                        $googleMeetActivity = $DB->get_record('googlemeet', ['id' => $module->instance]);
                        
                        if (!$googleMeetActivity) {
                            continue;
                        }

                         if ($googleMeetActivity) {
                            $role = strtolower($section->role); // Convert role to lowercase
                            $name = strtolower($googleMeetActivity->name); // Convert name to lowercase

                            // if (strpos($name, $role) !== false) {
                            //     // Role matches activity name
                            //     // Proceed with your logic here
                            // } else {
                            //     // Role doesn't match the name, skip
                            //     continue;
                            // }


                          

if (strpos($role, '_') !== false) {
    // Case: main_practice → ["main", "practice"]
    $roles = explode('_', $role);
    $found = false;

    foreach ($roles as $r) {
        if (strpos($name, $r) !== false) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        continue; // none matched, skip
    }

} else {
    // Case: main OR practice
    if (strpos($name, $role) === false) {
        continue;
    }
}

                        }


                        
                     
                        

                        // For first iteration only: add to $schedules
                        if ($i === 0) {
                            $schedules[] = [
                                'starthour' => $googleMeetActivity->starthour,
                                'startminute' => $googleMeetActivity->startminute,
                                'days' => $googleMeetActivity->days,
                            ];

                                            if (!empty($section->availability)) {
                            $availability = json_decode($section->availability, true);
                            if (isset($availability['c']) && is_array($availability['c'])) {
                                foreach ($availability['c'] as $condition) {
                                    if (isset($condition['type']) && $condition['type'] === 'cohort' && isset($condition['id'])) {
                                        $ccid = $condition['id'];
                                        break;
                                    }
                                }
                            }
                        }
                        }

                        // Always fetch upcoming schedule
                        $sql = "SELECT *
                                FROM {googlemeet_events}
                                WHERE googlemeetid = :googlemeetid 
                                AND eventdate > :currenttime 
                                ORDER BY eventdate ASC
                                LIMIT 1";

                                // $sql = "SELECT *
                                // FROM {googlemeet_events}
                                // WHERE googlemeetid = :googlemeetid 
                                // AND ( eventdate >= :currenttime OR (:currenttime1 >= eventdate AND :currenttime2 <= (eventdate + 3600)) )
                                // ORDER BY eventdate ASC
                                // LIMIT 1";

                            

                        $params = [
                            'googlemeetid' => $googleMeetActivity->id,
                            'currenttime' => time() 
                        ];






                        

                        $upcomingSchedule = $DB->get_record_sql($sql, $params);
                        

                        // Store activity info for all
                        $googleMeetActivities[] = (object)[
                            'name' => $googleMeetActivity->name,
                            'section' => $section->section,
                            'module_id' => $module->id,
                            'upcoming_schedule' => $upcomingSchedule
                        ];
                    }
                  
                    // Only the first section should populate $schedules
                    $i++;
                    //if ($i > 11) break; // No need to loop more if only first section is needed for schedules
                }
                
                

                    $classes = []; // Initialize the array for storing remaining Google Meet activities
                    $today = new DateTime();
                
                
                    // Final Output
                    if (!empty($googleMeetActivities)) {
                        $mostUpcomingSchedule = null;
                        //echo "<br>Final Google Meet Activities with Upcoming Schedules:<br>";
                        foreach ($googleMeetActivities as $activity) {
                            //echo "- " . $activity->name . " (Section: " . $activity->section . ")<br>";
                    
                            if ($activity->upcoming_schedule) {
                                
                
                            // Directly compare eventdate for each activity to find the most upcoming one
                            if (!$mostUpcomingSchedule || $activity->upcoming_schedule->eventdate < $mostUpcomingSchedule->eventdate) {
                                $d = $activity->upcoming_schedule->eventdate;
                                $s = $mostUpcomingSchedule?->eventdate ?? null;
                                $mostUpcomingSchedule = $activity->upcoming_schedule;
                            }
                            } else {
                                //echo "-- No upcoming schedule found.<br>";
                            }
                        }

                        $allMeetFutureDates = []; // Step 1: Store future dates per Google Meet (with name)

                    

                         // Step 2: Loop over other meets and extract classes
                      foreach ($googleMeetActivities as $index => $activity) {

                                if($activity->upcoming_schedule == false)
                                {
                                    continue;
                                }
                            
                                $googleMeet = $DB->get_record('googlemeet', ['id' => $activity->upcoming_schedule->googlemeetid], '*', MUST_EXIST);

                                $daysJson = $googleMeet->days ?? '{}';
                                $recurringDays = json_decode($daysJson, true);
                            
                                $dayMap = [
                                    'Sun' => 0, 'Mon' => 1, 'Tue' => 2, 'Wed' => 3,
                                    'Thu' => 4, 'Fri' => 5, 'Sat' => 6
                                ];
                            
                                $fullDayMap = [
                                    'Sun' => 'Sunday', 'Mon' => 'Monday', 'Tue' => 'Tuesday',
                                    'Wed' => 'Wednesday', 'Thu' => 'Thursday',
                                    'Fri' => 'Friday', 'Sat' => 'Saturday'
                                ];
                            
                                $activeDays = [];
                                foreach ($recurringDays as $day => $isActive) {
                                    if ($isActive === "1") {
                                        $activeDays[] = $day;
                                    }
                                }

                                if (!empty($activeDays)) {
                            
                                usort($activeDays, function($a, $b) use ($dayMap) {
                                    return $dayMap[$a] - $dayMap[$b];
                                });
                            }
                            
                                // Collect formatted classes
                                $today = new DateTime();
                                $classCount = 0;
                                $maxClasses = 500;
                                $weekOffset = 1;
                            
                                //while ($classCount < $maxClasses) {
                                    foreach ($activeDays as $dayKey) {
                                        if ($classCount >= $maxClasses) break;
                            
                                        $nextDate = new DateTime("next " . $fullDayMap[$dayKey]);
                                        $nextDate->modify("+".($weekOffset - 1)." week");
                            
                                        $fullDayName = $nextDate->format('l'); // e.g., Thursday
                                        $formattedTime = date('g:i A', strtotime(sprintf('%02d:%02d', $googleMeet->starthour, $googleMeet->startminute)));
                            

                                        $namePrefix = explode('-', $googleMeet->name)[0] ?? '';
                                        $badgeText = strtoupper(substr($namePrefix, 0, 4)); // E.g., FL1
                                        $parts = preg_split('/\s+/',$googleMeet->originalname);
                                        if (!empty($parts)) {
                                        $fullname = implode(' ', array_slice($parts, 0, 2));
                                        }

                                        //$coh = $DB->get_record('cohort', ['shortname' => $namePrefix], '*', MUST_EXIST);
                                        
                                        $coh = $DB->get_record('cohort', ['shortname' => $namePrefix], '*', IGNORE_MISSING);

                                        if (!$coh) {
                                            // Skip if cohort doesn't exist
                                            continue;
                                        }
                                                                               
                                        $cohortcolor = $coh->cohortcolor ?? 'Green'; // fallback color


                                        $classType = 'Group Class';
                                        if (strpos($googleMeet->name, 'Main') !== false) {
                                            $classType = 'Main Class';
                                        } elseif (strpos($googleMeet->name, 'Practice') !== false) {
                                            $classType = 'Practice Class';
                                        }
                            

                                        $allMeetFutureDates[] = [
                                            'date' => $nextDate->format('Y-m-d'),
                                            'class_display' => [
                                                'date' => $nextDate->format('F j'),
                                                'day_time' => $fullDayName . ' at ' . $formattedTime,
                                                'short_text' => [
                                                    'title' => $classType,
                                                    'badge' => $badgeText,
                                                    'label' => $coh->name,
                                                    'color' => $cohortcolor
                                                ],
                                                'type' => 'group',
                                                'image' => '',
                                                'user' => ''
                                            ]
                                        ];
                            
                                        $classCount++;
                                    }
                                    $weekOffset++;
                                //}
                                
                                
                            
                            

                                $daysJson = $googleMeet->days ?? '{}';
                                $recurringDays = json_decode($daysJson, true);

                                // Time format
                                $startTime = sprintf('%02d:%02d', $googleMeet->starthour, $googleMeet->startminute);
                                $endTime   = sprintf('%02d:%02d', $googleMeet->endhour, $googleMeet->endminute);
                                $formattedTime = date('g:i A', strtotime($startTime)) . ' - ' . date('g:i A', strtotime($endTime));
                                $formattedTimee = date('g:i A', strtotime($startTime));

                                // Map weekday short names to PHP constants
                                $dayMap = [
                                    'Sun' => 0,
                                    'Mon' => 1,
                                    'Tue' => 2,
                                    'Wed' => 3,
                                    'Thu' => 4,
                                    'Fri' => 5,
                                    'Sat' => 6
                                ];

                                $fullDayMap = [
                                    'Sun' => 'Sunday',
                                    'Mon' => 'Monday',
                                    'Tue' => 'Tuesday',
                                    'Wed' => 'Wednesday',
                                    'Thu' => 'Thursday',
                                    'Fri' => 'Friday',
                                    'Sat' => 'Saturday'
                                ];
                                
                                
                                

//                                 foreach ($recurringDays as $dayName => $isActive) {
//                                     if ($isActive !== "1") continue;

//                                      $fullDayName = $fullDayMap[$dayName];
//     $targetWeekday = $dayMap[$dayName];
//     $nextDate = clone $today;

    
//     $currentWeekday = (int)$today->format('w'); // 0 (Sun) to 6 (Sat)

//     // Time comparison values
//     $currentTime = (int)date('Hi'); // e.g., 1345 for 1:45 PM
//     $startTimeStr = sprintf('%02d%02d', $googleMeet->starthour, $googleMeet->startminute); // e.g., 1400

// // Build end by adding 1 hour to the start time
// $endTimeStr    = (int)date(
//     'Hi',
//     strtotime(sprintf('%02d:%02d', $googleMeet->starthour, $googleMeet->startminute) . ' +1 hour')
// );

//     if ($currentWeekday === $targetWeekday) {
//         if ($currentTime >= (int)$startTimeStr && !($currentTime >= $startTimeStr && $currentTime <= $endTimeStr)) {
//             // Today is the target day, but time has passed — move to next week's same day
//             $nextDate->modify('+7 days');
//         }  else {
//         // Today is the target day and the meeting time is still upcoming — keep today
//         $daysToAdd = 0;
//         $nextDate->modify("+$daysToAdd days"); // Optional but clear
//     }
//         // else: Today is the day and time has not yet come → no modification needed
//     } elseif ($currentWeekday > $targetWeekday) {
//         // Target day already passed this week → go to next week's day
//         $daysToAdd = 7 - ($currentWeekday - $targetWeekday);
//         $nextDate->modify("+$daysToAdd days");
//     } else {
//         // Target day is upcoming this week
//         $daysToAdd = $targetWeekday - $currentWeekday;
//         $nextDate->modify("+$daysToAdd days");
//     }
                                    

//                                     //$nextDate->modify("+$daysToAdd days");

//                                     // Determine class type based on name
//                                     $classType = 'Group Class'; // default fallback

//                                     if (strpos($googleMeet->name, 'Main') !== false) {
//                                         $classType = 'Main Class';
//                                     } elseif (strpos($googleMeet->name, 'Practice') !== false) {
//                                         $classType = 'Practice Class';
//                                     }
                                    

//                                     // Build entry
//                                     $classes[] = [
//                                         'date' => $nextDate->format('F j'), // Ex: April 4
//                                         'day_time' => $fullDayName . ' at ' . $formattedTimee,
//                                         'short_text' => $classType,
//                                         'type' => 'group',
//                                         'image' => '',
//                                         'user' => '' // You can add teacher's name here later
//                                     ];

//                                     $dateLabel = ($nextDate->format('Y-m-d') === date('Y-m-d')) 
//     ? 'Today' 
//     : $nextDate->format('F j');


//                                      $allMeetFutureDatess[] = [
//                                             'date' => $nextDate->format('Y-m-d'),
//                                             'class_display' => [
//                                                 'date' => $dateLabel,
//                                                 'day_time' => $fullDayName . ' at ' . $formattedTime,
//                                                 'short_text' => [
//                                                     'title' => $classType,
//                                                     'badge' => $badgeText,
//                                                     'label' => $coh->name,
//                                                     'color' => $cohortcolor
//                                                 ],
//                                                 'url' => $googleMeet->url,
//                                                 'type' => 'group',
//                                                 'image' => '',
//                                                 'user' => ''
//                                             ]
//                                         ];
//                                 }




                                // ==== Build next 10 future classes for this Google Meet ====

                            $today          = new DateTime();                // now (server TZ or set user TZ if needed)
                            $todayYmd       = $today->format('Y-m-d');
                            //$currentHM      = (int)$today->format('Hi');     // e.g. 1345
                            $currentHM  = (clone $today)->modify('-1 hour')->format('Hi'); // "0755"
                            $startHM        = (int)sprintf('%02d%02d', (int)$googleMeet->starthour, (int)$googleMeet->startminute);
                            $starthour      = (int)$googleMeet->starthour;
                            $startminute    = (int)$googleMeet->startminute;
                            $endhour        = isset($googleMeet->endhour) ? (int)$googleMeet->endhour : $starthour;
                            $endminute      = isset($googleMeet->endminute) ? (int)$googleMeet->endminute : $startminute;
                            $durationSecs   = max(60, (($endhour * 60 + $endminute) - ($starthour * 60 + $startminute)) * 60);
                            if ($durationSecs <= 0) { $durationSecs = 3600; } // fallback 1h

                            // Map weekdays
                            $dayMap = ['Sun'=>0,'Mon'=>1,'Tue'=>2,'Wed'=>3,'Thu'=>4,'Fri'=>5,'Sat'=>6];
                            $fullDayMap = ['Sun'=>'Sunday','Mon'=>'Monday','Tue'=>'Tuesday','Wed'=>'Wednesday','Thu'=>'Thursday','Fri'=>'Friday','Sat'=>'Saturday'];

                            // Collect active days as numeric 0..6 and sort
                            $activeDows = [];
                            foreach (($recurringDays ?? []) as $d => $isActive) {
                                if ($isActive === "1" && isset($dayMap[$d])) {
                                    $activeDows[] = $dayMap[$d];
                                }
                            }
                            sort($activeDows);
                            if (!$activeDows) {
                                // no active days → nothing to add
                                continue;
                            }

                            $baseDow = (int)$today->format('w'); // 0..6
                            $needed  = 10;
                            $made    = 0;
                            $weekOffset = 0;

                            while ($made < $needed) {
                                foreach ($activeDows as $targetDow) {
                                    // Days ahead from *this* week
                                    $daysAhead0 = ($targetDow - $baseDow + 7) % 7;

                                    // For week 0, if today is the target day but start time already passed, push to next week
                                    $daysAhead = $daysAhead0 + 7 * $weekOffset;
                                    if ($weekOffset === 0 && $daysAhead0 === 0 && $currentHM >= $startHM) {
                                        $daysAhead += 7;
                                    }

                                    // Build start/end DateTimes
                                    $startDT = (clone $today)->setTime($starthour, $startminute, 0)->modify("+{$daysAhead} days");
                                    $endDT   = (clone $startDT)->modify("+{$durationSecs} seconds");

                                    // Human labels
                                    $fullDayName   = $startDT->format('l'); // Monday, ...
                                    $dateLabel     = ($startDT->format('Y-m-d') === $todayYmd) ? 'Today' : $startDT->format('F j');
                                    $formattedTime = $startDT->format('g:i A') . ' - ' . $endDT->format('g:i A');

                                    // Class type (as you had)
                                    $classType = 'Group Class';
                                    if (strpos($googleMeet->name, 'Main') !== false)     { $classType = 'Main Class'; }
                                    elseif (strpos($googleMeet->name, 'Practice') !== false) { $classType = 'Practice Class'; }

                                    // Push into your target array
                                    $allMeetFutureDatess[] = [
                                        'date' => $startDT->format('Y-m-d'),
                                        'class_display' => [
                                            'date'       => $dateLabel,
                                            'day_time'   => $fullDayName . ' at ' . $formattedTime,
                                            'short_text' => [
                                                'title' => $classType,
                                                'badge' => $badgeText,         // from your earlier code
                                                'label' => $coh->name,         // from your earlier code
                                                'color' => $cohortcolor        // from your earlier code
                                            ],
                                            'url'   => $googleMeet->url,        // <-- use the activity URL you built earlier
                                            'type'  => 'group',
                                            'image' => '',
                                            'user'  => ''
                                        ]
                                    ];

                                    $made++;
                                    if ($made >= $needed) { break 2; }
                                }
                                $weekOffset++; // move to the next week and loop the days again
                            }
                                                            
                               
                                
                             
                            
                        }
                    } 
                } else {
                    //echo "No topics are restricted to cohort ID $cohortid in this course.";
                }

                if (!empty($allMeetFutureDatess)) {

                        usort($allMeetFutureDatess, function($a, $b) {
            // Convert 'date' field to timestamp
            $dateA = strtotime($a['date']);
            $dateB = strtotime($b['date']);

            // If dates are different, sort by date
            if ($dateA !== $dateB) {
                return $dateA - $dateB;
            }

            // Extract time from 'day_time' (e.g., "Tuesday at 5:00 AM - 6:00 AM")
            preg_match('/at ([\d:]+ [APMapm]+) -/', $a['class_display']['day_time'], $matchA);
            preg_match('/at ([\d:]+ [APMapm]+) -/', $b['class_display']['day_time'], $matchB);

            $timeA = isset($matchA[1]) ? strtotime($matchA[1]) : 0;
            $timeB = isset($matchB[1]) ? strtotime($matchB[1]) : 0;

            return $timeA - $timeB;
        });
                }

                if (!empty($allMeetFutureDatess)) {
// Take first 12 sorted entries
$upcoming12 = array_slice($allMeetFutureDatess, 0, 40);
                }

// Extract only 'class_display'
// $finalUpcoming12 = array_map(function($entry) {
//     return $entry['class_display'];
// }, $upcoming12);

$finalUpcoming12 = [];

if (is_array($upcoming12)) {
    $finalUpcoming12 = array_map(function($entry) {
        return $entry['class_display'];
    }, $upcoming12);
}




$cohortIds = [];

if (is_array($cohortData)) {
    $cohortIds = array_map(function($c) {
        return (int)$c['id'];
    }, $cohortData);
}



                
                
                
                // Fetch the Google Meet activity record
                if($mostUpcomingSchedule){
                    $googleMeet = $DB->get_record('googlemeet', ['id' => $mostUpcomingSchedule->googlemeetid], '*', MUST_EXIST);
                
                }
               
                // Extract the URL from the record
                //$googleMeetURL = $googleMeet->url;
                $dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
                // Master array to store sorted data across schedules
                $allDaysWithHours = [];

                // Collect available days and their timings
                foreach ($schedules as $schedule) {
                    // Convert starthour and startminute to a 12-hour format with AM/PM
                    $hour24 = $schedule['starthour'];
                    $minute = str_pad($schedule['startminute'], 2, "0", STR_PAD_LEFT); // Ensure 2 digits for minutes
                    $formattedHour = date("g:i A", strtotime("$hour24:$minute"));

                    // Decode the JSON data in 'days'
                    $days = json_decode($schedule['days'], true); // Decoded as associative array

                    // Sort and add available days to the master array
                    foreach ($dayOrder as $day) {
                        if (isset($days[$day]) && $days[$day] === "1") {
                            $allDaysWithHours[$day][] = $formattedHour; // Group timings by day
                        }
                    }
                }

                // Ensure all days are present and in sorted order
                foreach ($dayOrder as $day) {
                    if (!isset($allDaysWithHours[$day])) {
                        $allDaysWithHours[$day] = []; // Add empty entry for non-available days
                    }
                }





                    //Videocalling section merging schedules

                    $cohortids = [];

                    foreach ($cohorts as $cohort) {
                        $cohortids[] = $cohort->id;
                    }

                    $idplanificactions = [];

                    if (!empty($cohortids)) {
                        list($in, $params) = $DB->get_in_or_equal($cohortids, SQL_PARAMS_NAMED);

                        // Replace 'your_table_name' with the actual name, like 'local_sometable'
                        $sql = "SELECT DISTINCT idplanificaction 
                                FROM {assignamentcohortforclass}
                                WHERE idcohort $in AND idplanificaction IS NOT NULL";

                        $idplanificactions = $DB->get_fieldset_sql($sql, $params);
                    }


// Step 1: Fetch all idplanificaction records for the current user
$user_idplanificactions = $DB->get_records('assignamentteachearforclass', ['iduserteacher' => $user->id], '', 'idplanificaction');

// Step 2: Compare and merge the user's idplanificaction with the $idplanificactions array
if (!empty($user_idplanificactions)) {
    // Extract the idplanificaction values from the user's records
    $user_idplanificactions = array_map(function($record) {
        return $record->idplanificaction;
    }, $user_idplanificactions);

    // Step 3: Compare and merge the values (add missing ones to $idplanificactions)
    foreach ($user_idplanificactions as $id) {
        // Only add if it's not already in the $idplanificactions array
        if (!in_array($id, $idplanificactions)) {
            $idplanificactions[] = $id;
        }
    }
}


                    // Step 3: Get full records from planification_meta table using those IDs
                    $planificationrecords = [];

                    if (!empty($idplanificactions)) {
                        list($in2, $params2) = $DB->get_in_or_equal($idplanificactions, SQL_PARAMS_NAMED);
                        
                        $sql2 = "SELECT *
                                FROM {planificationclass}
                                WHERE id $in2";

                        $planificationrecords = $DB->get_records_sql($sql2, $params2);
                    }

$allMeetFuturevideocalling = [];

foreach ($planificationrecords as $record) {
    $recurrence = $DB->get_record('optionsrepeat', ['idplanificaction' => $record->id]);
    //if (!$recurrence) continue;


    if($recurrence)
    {

        if($recurrence->type == 'week')
        {
            $repeatevery = (int)($recurrence->repeatevery ?? 1);
                $repeatUntil = (int)($recurrence->repeaton ?? PHP_INT_MAX);
                $currentTime = time();

                $weekdayMap = [
                    'sunday' => 0, 'monday' => 1, 'tuesday' => 2,
                    'wednesday' => 3, 'thursday' => 4,
                    'friday' => 5, 'saturday' => 6
                ];

                $recurrenceDays = [];
                foreach ($weekdayMap as $day => $num) {
                    if (!empty($recurrence->$day)) {
                        $recurrenceDays[$num] = $day;
                    }
                }

                // ✅ Loop for each weekday recurrence in this record
                foreach ($recurrenceDays as $weekday => $dayname) {
                    $nextDate = new DateTime(); // start from now
                    $currentWeekday = (int)$nextDate->format('w');

                    // Calculate how many days ahead this weekday is
                    $daysToAdd = ($weekday - $currentWeekday + 7) % 7;
                    if ($daysToAdd === 0) {
                // Today's session: check if it's still ongoing
                $startTime = (int)date('Hi', strtotime(date('H:i', $record->startdate)));
                
                // Add 1 hour to the start time
                $startPlusOneHour = (int)date('Hi', strtotime(date('H:i', $record->startdate) . ' +1 hour'));

                $nowTime = (int)date('Hi');

                if ($nowTime > $startPlusOneHour) {
                    // Session has fully passed, move to next week
                    $daysToAdd = 7;
                }
                // else: current time is within session or just before it → keep today
            }

                    $nextDate->modify("+$daysToAdd days");

                    $dateStr = $nextDate->format('Y-m-d');
                    $sessionStart = strtotime($dateStr . ' ' . date('H:i', $record->startdate));
                    $sessionEnd = strtotime($dateStr . ' ' . date('H:i', $record->finishdate));

                    if ($sessionEnd >= $currentTime && $sessionStart <= $repeatUntil) {
                        $fullDayName = date('l', $sessionStart);
                        $formattedTime = date('g:i A', $sessionStart) . ' - ' . date('g:i A', $sessionEnd);

                        $dt = new DateTime();
                        $dt->setTimestamp($sessionStart);

                        $dateLabel = ($dt->format('Y-m-d') === date('Y-m-d')) 
    ? 'Today' 
    : $dt->format('F j');

                        $allMeetFuturevideocalling[] = [
                            'timestamp' => $sessionStart,
                            'class_display' => [
                                'date' => $dateLabel,
                                'day_time' => $fullDayName . ' at ' . $formattedTime,
                                'short_text' => [
                                    'title' => 'Quick Talk',
                                    'badge' => 'VI',
                                    'label' => 'Peers',
                                    'color' => 'Blue'
                                ],
                                'url' => 'https://courses.latingles.com/local/videocalling',
                                'type' => 'group',
                                'image' => '',
                                'user' => ''
                            ]
                        ];
                    }
                }
        }

         if ($recurrence->type == 'day') {
    $repeatevery = (int)($recurrence->repeatevery ?? 1);
    $repeatUntil = $recurrence->repeaton ? (int)$recurrence->repeaton : PHP_INT_MAX; // unlimited
    $currentTime = time();

    $loopDate = max($record->startdate, $currentTime);

    // Round loopDate to start-of-day (optional, for cleaner matching)
    $loopDate = strtotime(date('Y-m-d 00:00:00', $loopDate));

    // Find the first next session from start date that is in future
    for ($i = 0; $i < 100; $i++) { // limit to avoid infinite loop
        $sessionStart = strtotime("+".($i * $repeatevery)." days", $record->startdate);
        $sessionEnd = strtotime(date('Y-m-d', $sessionStart) . ' ' . date('H:i', $record->finishdate));

        if ($sessionStart >= $currentTime || ($currentTime >= $sessionStart && $currentTime <= strtotime('+1 hour', $sessionStart))) {
            if ($sessionStart <= $repeatUntil) {
                $dt = new DateTime();
                $dt->setTimestamp($sessionStart);

                $fullDayName = date('l', $sessionStart);
                $formattedTime = date('g:i A', $sessionStart) . ' - ' . date('g:i A', $sessionEnd);

                $dt = new DateTime();
                        $dt->setTimestamp($sessionStart);

                        $dateLabel = ($dt->format('Y-m-d') === date('Y-m-d')) 
    ? 'Today' 
    : $dt->format('F j');

                $allMeetFuturevideocalling[] = [
                    'timestamp' => $sessionStart,
                    'class_display' => [
                        'date' => $dateLabel,
                        'day_time' => $fullDayName . ' at ' . $formattedTime,
                        'short_text' => [
                            'title' => 'Quick Talk',
                            'badge' => 'VI',
                            'label' => 'Peers',
                            'color' => 'Blue'
                        ],
                        'url' => 'https://courses.latingles.com/local/videocalling',
                        'type' => 'group',
                        'image' => '',
                        'user' => ''
                    ]
                ];
            }
            //break; // only add one upcoming instance
        }
    }
}
    



    }else{
         // Handle one-time session
    $currentTime = time();
    $startTime = strtotime(date('Y-m-d', $record->startdate) . ' ' . date('H:i', $record->startdate));
    $endTime = strtotime(date('Y-m-d', $record->finishdate) . ' ' . date('H:i', $record->finishdate));

    // If session is upcoming or currently ongoing (within 1 hour window)
    if ($startTime >= $currentTime || ($currentTime >= $startTime && $currentTime <= strtotime('+1 hour', $startTime))) {
        $dt = new DateTime();
        $dt->setTimestamp($startTime);

        $fullDayName = date('l', $startTime);
        $formattedTime = date('g:i A', $startTime) . ' - ' . date('g:i A', $endTime);

         $dt = new DateTime();
                        $dt->setTimestamp($startTime);

                        $dateLabel = ($dt->format('Y-m-d') === date('Y-m-d')) 
    ? 'Today' 
    : $dt->format('F j');

        $allMeetFuturevideocalling[] = [
            'timestamp' => $startTime,
            'class_display' => [
                'date' => $dateLabel,
                'day_time' => $fullDayName . ' at ' . $formattedTime,
                'short_text' => [
                    'title' => 'Quick Talk',
                    'badge' => 'VI',
                    'label' => 'Peers',
                    'color' => 'Blue'
                ],
                'url' => 'https://courses.latingles.com/local/videocalling',
                'type' => 'group',
                'image' => '',
                'user' => ''
            ]
        ];
    }
    }
    
}

// ✅ Sort all next sessions by timestamp (across all plans)
usort($allMeetFuturevideocalling, function ($a, $b) {
    return $a['timestamp'] <=> $b['timestamp'];
});

// ✅ Keep only first 10 earliest
$allMeetFuturevideocalling = array_slice($allMeetFuturevideocalling, 0, 40);

// ✅ Extract only class_display
$finalClassDisplays = array_map(function ($entry) {
    return $entry['class_display'];
}, $allMeetFuturevideocalling);



//One on One

function user_in_cohort(int $userid, int $cohortid): bool {
    return cohort_is_member($cohortid, $userid); // true/false
}

// Example:
if (user_in_cohort($user->id, 163) && !$isteacher) {
    // user is a member
    //echo 'found';

    // --- begin added code ---
    $googleMeetActivities = []; // For all activities
    $schedules = [];            // Only from the first section (kept from your code)
    $i = 0;
    $ccid = null;

    // Get module id for googlemeet once
    $googlemeetmodid = (int)$DB->get_field('modules', 'id', ['name' => 'googlemeet'], IGNORE_MISSING);
    if (!$googlemeetmodid) {
        echo ' (googlemeet module not installed)';
    } else {
        // Fetch all sections in the course
        $sections_one_on_one = $DB->get_records('course_sections', ['course' => 24], 'section ASC');

        foreach ($sections_one_on_one as $section) {
            // Fetch only googlemeet modules in this section
            $modules = $DB->get_records('course_modules',
                ['section' => $section->id, 'module' => $googlemeetmodid],
                'id ASC',
                'id,instance,availability'
            );

            if (empty($modules)) {
                continue;
            }

            foreach ($modules as $module) {
                if (empty($module->availability)) {
                    continue; // no restrictions set
                }

                $tree = json_decode($module->availability, true);
                if (!is_array($tree)) {
                    continue; // invalid availability JSON
                }

                // Look for a profile rule where field=email and value == user's email
                $match = false;
                $targetEmail = mb_strtolower(trim($user->email));
                $stack = [$tree];

                while (!$match && ($node = array_pop($stack))) {
                    if (isset($node['type']) && $node['type'] === 'profile') {
                        $isEmailField = (isset($node['sf']) && $node['sf'] === 'email'); // standard field
                        if ($isEmailField) {
                            $val = isset($node['v']) ? mb_strtolower(trim($node['v'])) : null;
                            if ($val !== null && $val === $targetEmail) {
                                $match = true;
                                break;
                            }
                        }
                    }
                    if (!empty($node['c']) && is_array($node['c'])) {
                        foreach ($node['c'] as $child) {
                            if (is_array($child)) {
                                $stack[] = $child;
                            }
                        }
                    }
                }

                if (!$match) {
                    continue; // this googlemeet does not target this user by email
                }

                // Collect basic info
                $gm = $DB->get_record('googlemeet', ['id' => $module->instance], 'id,name,url', IGNORE_MISSING);
                $name = ($gm && !empty($gm->name)) ? $gm->name : 'Google Meet';
                $url  = (new moodle_url('/mod/googlemeet/view.php', ['id' => $module->id]))->out(false);

                $isStudent = (
    is_only_student($user->id)
);

            if ($isStudent) {
                // e.g. "1:1 Sandra Ayala with Teacher Jessica Smith" -> "Jessica Smith"
                if (preg_match('/\bTeacher\b[[:space:]:\-–—]*(.+)\z/ui', $name, $m)) {
                    $name = trim($m[1]);                 // "Jessica Smith"
                    // Optional: normalize inner whitespace
                    $name = preg_replace('/\s+/', ' ', $name);

                    // $name currently holds either first name OR last name (single token).
                        global $DB;

                        $name = trim(preg_replace('/\s+/', ' ', $name)); // normalize spaces

                        if ($name !== '' && strpos($name, ' ') === false) { // only try if it's a single token
                            $lc = core_text::strtolower($name);

                            $sql = "SELECT id, firstname, lastname
                                    FROM {user}
                                    WHERE deleted = 0 AND suspended = 0
                                    AND (LOWER(firstname) = ? OR LOWER(lastname) = ?)";
                            $matches = $DB->get_records_sql($sql, [$lc, $lc]);

                            if (count($matches) === 1) {
                                $u = reset($matches);
                                $name = fullname($u); // e.g., "Jessica Smith"
                            }
                            // If 0 or >1 matches, keep original $name unchanged.
                        }
                    
                }
            }else {
    // Extract text after "1:1" and before "with"
    if (preg_match('/\b1\s*:\s*1\b\s*(.*?)\s+with\b/ui', $name, $m)) {
        $name = preg_replace('/\s+/', ' ', trim($m[1])); // "Sandra Ayala"

        // $name currently holds either first name OR last name (single token).
                        global $DB;

                        $name = trim(preg_replace('/\s+/', ' ', $name)); // normalize spaces

                        if ($name !== '' && strpos($name, ' ') === false) { // only try if it's a single token
                            $lc = core_text::strtolower($name);

                            $sql = "SELECT id, firstname, lastname
                                    FROM {user}
                                    WHERE deleted = 0 AND suspended = 0
                                    AND (LOWER(firstname) = ? OR LOWER(lastname) = ?)";
                            $matches = $DB->get_records_sql($sql, [$lc, $lc]);

                            if (count($matches) === 1) {
                                $u = reset($matches);
                                $name = fullname($u); // e.g., "Jessica Smith"
                            }
                            // If 0 or >1 matches, keep original $name unchanged.
                        }
    }
}


// Build profile image URL from $name by matching firstname OR lastname
require_once($CFG->libdir . '/filelib.php'); // for moodle_url & file serving
$profile_url = '';

$target = trim($name);
if ($target !== '') {
    // Split the display name into tokens ("Jessica Smith" -> ["Jessica","Smith"])
    $parts = preg_split('/\s+/', $target, -1, PREG_SPLIT_NO_EMPTY);

    if (!empty($parts)) {
        // Prepare IN (...) placeholders for a case-insensitive match on firstname/lastname
        $params = ['deleted' => 0, 'suspended' => 0];
        $fnph = [];
        $lnph = [];
        $i = 0;
        foreach ($parts as $p) {
            $p = mb_strtolower($p);
            $fnph[] = ":fn{$i}";
            $lnph[] = ":ln{$i}";
            $params["fn{$i}"] = $p;
            $params["ln{$i}"] = $p;
            $i++;
        }

        $sql = "
            SELECT id, firstname, lastname, picture, imagealt
              FROM {user}
             WHERE deleted = :deleted
               AND suspended = :suspended
               AND (
                     LOWER(firstname) IN (" . implode(',', $fnph) . ")
                  OR LOWER(lastname)  IN (" . implode(',', $lnph) . ")
               )
             ORDER BY lastaccess DESC, id DESC
        ";

        // Get the best candidate (most recently active)
        $candidates = $DB->get_records_sql($sql, $params, 0, 1);
        if ($candidates) {
            $u = reset($candidates);
            $userpic = new user_picture($u);
            $userpic->size = 100; // pick your size (0, 35, 100)
            $profile_url = $userpic->get_url($PAGE)->out(false);
        }
    }
}
                $googleMeetActivities[] = (object)[
                    'sectionid' => $section->id,
                    'cmid'      => $module->id,
                    'name'      => $name,
                    'url'       => $gm->url,
                    'profile_url'  => $profile_url, // <-- added
                ];
            }
        }
    
    }
    // --- end added code ---


    // Build "future videocalling" cards from Google Meet activities
$allMeetFuturevideocallingg = [];

foreach ($googleMeetActivities as $act) {
    // Get the activity instance id from cmid (needed to locate its calendar events)
    $instanceid = (int)$DB->get_field('course_modules', 'instance', ['id' => $act->cmid], IGNORE_MISSING);
    if (!$instanceid) {
        continue;
    }

    // Fetch FUTURE calendar events for this activity
    // Most modules (incl. googlemeet) create calendar events with modulename='googlemeet'
    $now = time();

$events = $DB->get_records_select(
    'event',
    "modulename = :mod
     AND instance = :instance
     AND visible = 1
     AND (
           timestart >= :now1
        OR (:now2 >= timestart AND :now3 <= (timestart + 3600))
     )",
    [
        'mod' => 'googlemeet',
        'instance' => $instanceid,
        'now1' => $now,
        'now2' => $now,
        'now3' => $now
    ],
    'timestart ASC',
    'id,name,timestart,timeduration'
);


// $now = time();
//     $events = $DB->get_records_select(
//         'event',
//         "modulename = :mod AND instance = :instance AND visible = 1 AND timestart >= :now",
//         ['mod' => 'googlemeet', 'instance' => $instanceid, 'now' => $now],
//         'timestart ASC',
//         'id,name,timestart,timeduration'
//     );

    if (empty($events)) {
        continue; // no upcoming sessions found for this meet
    }

    foreach ($events as $ev) {
        $sessionStart = (int)$ev->timestart;
        $sessionEnd   = $sessionStart + (int)($ev->timeduration ?? 0);
        if ($sessionEnd <= $sessionStart) {
            // Fallback: assume 60 minutes if duration is 0/empty
            $sessionEnd = $sessionStart + 3600;
        }

        // User-timezone friendly formatting
        $fullDayName    = userdate($sessionStart, '%A');                  // e.g. Monday
        $displayDate    = userdate($sessionStart, '%B %e');               // e.g. August 23
        $formattedStart = userdate($sessionStart, '%l:%M %p');            // e.g. 3:15 PM
        $formattedEnd   = userdate($sessionEnd,   '%l:%M %p');            // e.g. 4:15 PM
        $formattedTime  = trim($formattedStart) . ' - ' . trim($formattedEnd);


        $dt = new DateTime();
                        $dt->setTimestamp($sessionStart);

                        $dateLabel = ($dt->format('Y-m-d') === date('Y-m-d')) 
    ? 'Today' 
    : $dt->format('F j');

        // Push in your required shape
        $allMeetFuturevideocallingg[] = [
            'timestamp' => $sessionStart,
            'class_display' => [
                'date'       => $dateLabel,                                 // "F j"
                'day_time'   => $fullDayName . ' at ' . $formattedTime,       // "Monday at 3:15 PM - 4:15 PM"
                'short_text' => [
                    'title' => '1 on 1',
                    'badge' => $act->profile_url,
                    'label' => $act->name,
                    'color' => 'Blue',
                ],
                'url'   => $act->url,         // e.g. /mod/googlemeet/view.php?id=CMID
                'type'  => 'group',
                'image' => '',
                'user'  => '',
            ],
        ];

        // If you only want the *next* upcoming session per activity, uncomment:
        // break;
    }
}

// Optional: sort all cards by soonest first
usort($allMeetFuturevideocallingg, function($a, $b) {
    return $a['timestamp'] <=> $b['timestamp'];
});

// Keep only the first 12
$allMeetFuturevideocallingg = array_slice($allMeetFuturevideocallingg, 0, 40);

$allMeetFuturevideocallingg = array_values(
    array_column($allMeetFuturevideocallingg, 'class_display')
);

} else {
    // not a member

    // Get module id for googlemeet once
    $googlemeetmodid = (int)$DB->get_field('modules', 'id', ['name' => 'googlemeet'], IGNORE_MISSING);
    if (!$googlemeetmodid) {
        echo ' (googlemeet module not installed)';
    } else {
        $allMeetFuturevideocallingg = [];
        // Fetch all sections in the course
        $sections_one_on_one = $DB->get_records('course_sections', ['course' => 24], 'section ASC');

         $fname = $user->firstname;
            $lname = $user->lastname;

        // Iterate sections that belong to this teacher.
foreach ($sections_one_on_one as $section) {
    if (!section_is_for_teacher($section->name ?? '', $fname, $lname)) {
        continue;
    }

    // Only googlemeet activities in this section
    $modules = $DB->get_records('course_modules',
        ['section' => $section->id, 'module' => $googlemeetmodid],
        'id ASC',
        'id,instance,availability'
    );

    if (!$modules) {
        continue;
    }

    foreach ($modules as $cm) {
        $student = availability_extract_user($cm->availability ?? '');
        if (!$student) {
            // must be restricted to a student email; skip otherwise
            continue;
        }

       $userpic = new user_picture($student);
$userpic->size = 100; // 0, 35, or 100 are common sizes
$profile_img_url = $userpic->get_url($PAGE)->out(false);



        // Instance info (meet name)
        $gm = $DB->get_record('googlemeet', ['id' => $cm->instance], 'id,name,url', IGNORE_MISSING);
        $meetname = $gm && !empty($gm->name) ? $gm->name : fullname($student);

        // Future events tied to this activity
        // $now = time();
        // $events = $DB->get_records_select(
        //     'event',
        //     "modulename = :mod AND instance = :instance AND visible = 1 AND timestart >= :now",
        //     ['mod' => 'googlemeet', 'instance' => (int)$cm->instance, 'now' => $now],
        //     'timestart ASC',
        //     'id,name,timestart,timeduration'
        // );

$now = time();

$events = $DB->get_records_select(
    'event',
    "modulename = :mod
     AND instance = :instance
     AND visible = 1
     AND (
           timestart >= :now1
        OR (:now2 >= timestart AND :now3 <= (timestart + 3600))
     )",
    [
        'mod' => 'googlemeet',
        'instance' => (int)$cm->instance,
        'now1' => $now,
        'now2' => $now,
        'now3' => $now
    ],
    'timestart ASC',
    'id,name,timestart,timeduration'
);

        
        if (empty($events)) {
            continue;
        }


        foreach ($events as $ev) {
            $sessionStart = (int)$ev->timestart;
            $sessionEnd   = $sessionStart + (int)($ev->timeduration ?? 0);
            [$displayDate, $dayTime] = format_session_times($sessionStart, $sessionEnd);

            $dt = new DateTime();
                        $dt->setTimestamp($sessionStart);

                        $dateLabel = ($dt->format('Y-m-d') === date('Y-m-d')) 
    ? 'Today' 
    : $dt->format('F j');

            // Push in your required shape
            $allMeetFuturevideocallingg[] = [
                'timestamp'     => $sessionStart,
                'class_display' => [
                    'date'       => $dateLabel,            // "F j"
                    'day_time'   => $dayTime,                // "Monday at 3:15 PM - 4:15 PM"
                    'short_text' => [
                        'title' => '1 on 1',
                        // use the student's profile (or just email if you prefer)
                        'badge' => $profile_img_url,              // or $student->email
                        'label' => fullname($student),        // student name
                        'color' => 'Blue',
                    ],
                    'url'   => $gm->url,                     // /mod/googlemeet/view.php?id=CMID
                    'type'  => 'group',
                    'image' => '',
                    'user'  => $student->id,                 // the student for this 1:1
                ],
                // Optional extras if you want:
                // 'teacher' => fullname($user),
                // 'student_email' => $student->email,
                // 'cmid' => $cm->id,
            ];
        }
    }
}

// Sort by start time (ascending)
usort($allMeetFuturevideocallingg, static function($a, $b) {
    return $a['timestamp'] <=> $b['timestamp'];
});

// Keep only the first 12
$allMeetFuturevideocallingg = array_slice($allMeetFuturevideocallingg, 0, 40);

$allMeetFuturevideocallingg = array_values(
    array_column($allMeetFuturevideocallingg, 'class_display')
);




        }
}

// Combine the two arrays
// $finalCombined = array_merge($finalUpcoming12, $finalClassDisplays, $allMeetFuturevideocallingg);
// //$finalCombined = array_merge($finalUpcoming12, $finalClassDisplays);

// // Sort by full datetime: date + start time
// usort($finalCombined, function($a, $b) {
//     // Extract time portion from 'day_time' (e.g., "Monday at 9:00 AM - 10:00 AM")
//     preg_match('/at\s+([\d:]+\s[AP]M)/i', $a['day_time'] ?? $a['class_display']['day_time'], $matchA);
//     preg_match('/at\s+([\d:]+\s[AP]M)/i', $b['day_time'] ?? $b['class_display']['day_time'], $matchB);

//     $timeA = $matchA[1] ?? '12:00 AM';
//     $timeB = $matchB[1] ?? '12:00 AM';

//     $datetimeA = strtotime($a['date'] . ' ' . $timeA);
//     $datetimeB = strtotime($b['date'] . ' ' . $timeB);

//     return $datetimeA <=> $datetimeB;
// });



// Combine the two arrays
$finalCombined = array_merge($finalUpcoming12, $finalClassDisplays, $allMeetFuturevideocallingg);

// Sort by full datetime: date + start time, with year rollover if missing.
// usort($finalCombined, function ($a, $b) {
//     $now = time();

//     // Pull date from either root or class_display
//     $dateA = $a['date'] ?? ($a['class_display']['date'] ?? '');
//     $dateB = $b['date'] ?? ($b['class_display']['date'] ?? '');

//     // Pull the "start" time from day_time-like fields (e.g., "Monday at 9:00 AM - 10:00 AM")
//     $dayTimeA = $a['day_time'] ?? ($a['class_display']['day_time'] ?? '');
//     $dayTimeB = $b['day_time'] ?? ($b['class_display']['day_time'] ?? '');

//     // More forgiving time matcher: "9 AM" or "9:00 AM"
//     $timeA = (preg_match('/\b(\d{1,2}(?::\d{2})?\s*[AP]M)\b/i', $dayTimeA, $mA)) ? strtoupper($mA[1]) : '12:00 AM';
//     $timeB = (preg_match('/\b(\d{1,2}(?::\d{2})?\s*[AP]M)\b/i', $dayTimeB, $mB)) ? strtoupper($mB[1]) : '12:00 AM';

//     // Build timestamps
//     $tsA = strtotime(trim("$dateA $timeA"));
//     $tsB = strtotime(trim("$dateB $timeB"));

//     // If date string has NO 4-digit year and is in the past, push it to next year
//     $hasYearA = is_string($dateA) && preg_match('/\b\d{4}\b/', $dateA);
//     $hasYearB = is_string($dateB) && preg_match('/\b\d{4}\b/', $dateB);

//     if ($tsA !== false && !$hasYearA && $tsA < $now) {
//         $tsA = strtotime('+1 year', $tsA);
//     }
//     if ($tsB !== false && !$hasYearB && $tsB < $now) {
//         $tsB = strtotime('+1 year', $tsB);
//     }

//     // Push unparseable items to the end
//     if ($tsA === false) $tsA = PHP_INT_MAX;
//     if ($tsB === false) $tsB = PHP_INT_MAX;

//     return $tsA <=> $tsB;
// });


// Sort by full datetime: date + start time, with year rollover if missing.
// Also treat events as "ongoing" if they started within the last 60 minutes.
usort($finalCombined, function ($a, $b) {
    $now = time();

    // Pull date from either root or class_display
    $dateA = $a['date'] ?? ($a['class_display']['date'] ?? '');
    $dateB = $b['date'] ?? ($b['class_display']['date'] ?? '');

    // Pull "start" time text (e.g., "Monday at 9:00 AM - 10:00 AM")
    $dayTimeA = $a['day_time'] ?? ($a['class_display']['day_time'] ?? '');
    $dayTimeB = $b['day_time'] ?? ($b['class_display']['day_time'] ?? '');

    // More forgiving time matcher: "9 AM" or "9:00 AM"
    $timeA = (preg_match('/\b(\d{1,2}(?::\d{2})?\s*[AP]M)\b/i', $dayTimeA, $mA)) ? strtoupper($mA[1]) : '12:00 AM';
    $timeB = (preg_match('/\b(\d{1,2}(?::\d{2})?\s*[AP]M)\b/i', $dayTimeB, $mB)) ? strtoupper($mB[1]) : '12:00 AM';

    // Build timestamps
    $tsA = strtotime(trim("$dateA $timeA"));
    $tsB = strtotime(trim("$dateB $timeB"));

    // Duration (fallback to 3600s = 1h)
    $durA = (int)($a['timeduration'] ?? ($a['duration'] ?? ($a['class_display']['timeduration'] ?? 3600)));
    $durB = (int)($b['timeduration'] ?? ($b['duration'] ?? ($b['class_display']['timeduration'] ?? 3600)));
    if ($durA <= 0) $durA = 3600;
    if ($durB <= 0) $durB = 3600;

    // Ongoing if now is between start and start+duration (default 1h)
    $ongoingA = ($tsA !== false && $now >= $tsA && $now <= $tsA + $durA);
    $ongoingB = ($tsB !== false && $now >= $tsB && $now <= $tsB + $durB);

    // If date has NO 4-digit year and is in the past, push to next year (but not if ongoing)
    $hasYearA = is_string($dateA) && preg_match('/\b\d{4}\b/', $dateA);
    $hasYearB = is_string($dateB) && preg_match('/\b\d{4}\b/', $dateB);

    if ($tsA !== false && !$hasYearA && !$ongoingA && $tsA < $now) {
        $tsA = strtotime('+1 year', $tsA);
    }
    if ($tsB !== false && !$hasYearB && !$ongoingB && $tsB < $now) {
        $tsB = strtotime('+1 year', $tsB);
    }

    // Push unparseable items to the end
    if ($tsA === false) $tsA = PHP_INT_MAX;
    if ($tsB === false) $tsB = PHP_INT_MAX;

    // Effective sort key: treat ongoing as "now" so they appear near the top
    $keyA = $ongoingA ? $now : $tsA;
    $keyB = $ongoingB ? $now : $tsB;

    $cmp = $keyA <=> $keyB;
    if ($cmp !== 0) return $cmp;

    // Tie-breaker: older start first
    return $tsA <=> $tsB;
});

// Keep only first 15 upcoming
$finalUpcoming12 = array_slice($finalCombined, 0, 41);

// Reset array indexes
$finalUpcoming12 = array_values($finalUpcoming12);






                //  if($savedDate === 'today')
                // {
                   $todayDate = date('Y-m-d'); // e.g., '2025-07-29'
                   $unixTimeToday = strtotime("$todayDate $startTimeFormatted"); 
                    $unixTimeTodayPlus1Hour = $unixTimeToday + 3600;

                    if ($unixTimeTodayPlus1Hour < time()) {

// ──────────────────────────────────────────────────────────────────────────────
// PRIORITIZE: 1:1 & Group over Videocalling (Quick Talk) for overlapping/same-time
// Keeps lower-priority sessions (e.g., Videocalling) in the list so they can
// appear again AFTER the higher-priority session finishes.
// Priority: 1) 1:1  2) Main Class  3) Practice Class  4) Other non-VC  5) Videocalling
// ──────────────────────────────────────────────────────────────────────────────
// if (!empty($finalUpcoming12) && is_array($finalUpcoming12)) {

//     $now = time();

//     $parseWindow = static function(array $entry) {
//         // Normalize date (e.g., "Today" -> "F j")
//         $dateStr = trim($entry['date'] ?? '');
//         if (strcasecmp($dateStr, 'Today') === 0) {
//             $dateStr = date('F j');
//         }
//         $year = date('Y');

//         $dayTime = $entry['day_time'] ?? '';
//         $start = $end = false;

//         // Try "at 9:00 AM - 10:00 AM"
//         if (preg_match('/at\s+(\d{1,2}(?::\d{2})?\s*[AP]M)\s*-\s*(\d{1,2}(?::\d{2})?\s*[AP]M)/i', $dayTime, $m)) {
//             $start = strtotime("$dateStr $year " . strtoupper(trim($m[1])));
//             $end   = strtotime("$dateStr $year " . strtoupper(trim($m[2])));
//         } elseif (preg_match('/\b(\d{1,2}(?::\d{2})?\s*[AP]M)\b/i', $dayTime, $m1)) {
//             // Fallback: one time only → assume 1h duration
//             $start = strtotime("$dateStr $year " . strtoupper(trim($m1[1])));
//             $end   = ($start !== false) ? $start + 3600 : false;
//         }

//         if ($start !== false && ($end === false || $end <= $start)) {
//             $end = $start + 3600; // default 1h
//         }

//         // Priority detection
//         $title = strtolower($entry['short_text']['title'] ?? '');
//         $url   = strtolower($entry['url'] ?? '');

//         // Highest: 1:1
//         if (strpos($title, '1 on 1') !== false || strpos($title, '1:1') !== false) {
//             $prio = 1;
//         }
//         // Group classes
//         elseif (strpos($title, 'main') !== false) {
//             $prio = 2;
//         } elseif (strpos($title, 'practice') !== false) {
//             $prio = 3;
//         }
//         // Videocalling (Quick Talk) = lowest
//         elseif (strpos($title, 'quick talk') !== false || strpos($url, '/local/videocalling') !== false) {
//             $prio = 5;
//         }
//         // Any other non-VC thing goes above VC by default
//         else {
//             $prio = 4;
//         }

//         return [$start, $end, $prio];
//     };

//     // Build windows
//     $windows = [];
//     foreach ($finalUpcoming12 as $i => $entry) {
//         [$s, $e, $p] = $parseWindow($entry);
//         $windows[] = ['i' => $i, 'start' => $s, 'end' => $e, 'prio' => $p];
//     }

//     // 1) If anything is active *now*, pick the highest priority among those
//     $active = array_values(array_filter($windows, function($w) use ($now) {
//         return ($w['start'] !== false && $w['end'] !== false && $now >= $w['start'] && $now <= $w['end']);
//     }));

//     if (!empty($active)) {
//         usort($active, function($a, $b) {
//             // lower prio number wins; then earlier start; then stable by index
//             return ($a['prio'] <=> $b['prio']) ?: ($a['start'] <=> $b['start']) ?: ($a['i'] <=> $b['i']);
//         });
//         $keepIndex = $active[0]['i'];
//     } else {
//         // 2) Otherwise pick the earliest upcoming; if multiple start at the same time,
//         //    choose higher priority (non-VC wins over VC).
//         $upcoming = array_values(array_filter($windows, fn($w) => $w['start'] !== false));
//         if (!empty($upcoming)) {
//             usort($upcoming, function($a, $b) {
//                 return ($a['start'] <=> $b['start']) ?: ($a['prio'] <=> $b['prio']) ?: ($a['i'] <=> $b['i']);
//             });
//             $keepIndex = $upcoming[0]['i'];
//         } else {
//             $keepIndex = 0; // fallback
//         }
//     }

//     // Move the chosen one to the FRONT, do not delete others (so VC can appear later).
//     if (isset($finalUpcoming12[$keepIndex]) && $keepIndex !== 0) {
//         $chosen = $finalUpcoming12[$keepIndex];
//         array_splice($finalUpcoming12, $keepIndex, 1);
//         array_unshift($finalUpcoming12, $chosen);
//     }
// }




if (!empty($finalUpcoming12) && is_array($finalUpcoming12)) {

    $now = time();

    $parseWindow = static function(array $entry) use ($now) {
        // Normalize date (e.g., "Today" -> "F j")
        $rawDate = trim($entry['date'] ?? '');
        $dateStr = $rawDate;
        if (strcasecmp($dateStr, 'Today') === 0) {
            $dateStr = date('F j', $now);
        }
        $year = date('Y', $now);

        $dayTime = $entry['day_time'] ?? '';
        $start = $end = false;

        // Try "at 9:00 AM - 10:00 AM"
        if (preg_match('/at\s+(\d{1,2}(?::\d{2})?\s*[AP]M)\s*-\s*(\d{1,2}(?::\d{2})?\s*[AP]M)/i', $dayTime, $m)) {
            $start = strtotime("$dateStr $year " . strtoupper(trim($m[1])));
            $end   = strtotime("$dateStr $year " . strtoupper(trim($m[2])));
        } elseif (preg_match('/\b(\d{1,2}(?::\d{2})?\s*[AP]M)\b/i', $dayTime, $m1)) {
            // Fallback: one time only → assume 1h duration
            $start = strtotime("$dateStr $year " . strtoupper(trim($m1[1])));
            $end   = ($start !== false) ? $start + 3600 : false;
        }

        if ($start !== false && ($end === false || $end <= $start)) {
            $end = $start + 3600; // default 1h
        }

        // ── Year roll-over: if no explicit year and it's already past, push to next year ──
        $hasExplicitYear = (bool) preg_match('/\b\d{4}\b/', $rawDate);
        $isTodayWord     = (strcasecmp($rawDate, 'Today') === 0);
        if (!$hasExplicitYear && !$isTodayWord && $end !== false && $end < $now) {
            $start = strtotime('+1 year', $start);
            $end   = strtotime('+1 year', $end);
        }

        // Priority detection
        $title = strtolower($entry['short_text']['title'] ?? '');
        $url   = strtolower($entry['url'] ?? '');
        if (strpos($title, '1 on 1') !== false || strpos($title, '1:1') !== false) {
            $prio = 1;
        } elseif (strpos($title, 'main') !== false) {
            $prio = 2;
        } elseif (strpos($title, 'practice') !== false) {
            $prio = 3;
        } elseif (strpos($title, 'quick talk') !== false || strpos($url, '/local/videocalling') !== false) {
            $prio = 5;
        } else {
            $prio = 4;
        }

        return [$start, $end, $prio];
    };

    // Build windows
    $windows = [];
    foreach ($finalUpcoming12 as $i => $entry) {
        [$s, $e, $p] = $parseWindow($entry);
        $windows[] = ['i' => $i, 'start' => $s, 'end' => $e, 'prio' => $p];
    }

    // 1) If anything is active now, pick the highest priority among those
    $active = array_values(array_filter($windows, function($w) use ($now) {
        return ($w['start'] !== false && $w['end'] !== false && $now >= $w['start'] && $now <= $w['end']);
    }));

    if (!empty($active)) {
        usort($active, function($a, $b) {
            return ($a['prio'] <=> $b['prio']) ?: ($a['start'] <=> $b['start']) ?: ($a['i'] <=> $b['i']);
        });
        $keepIndex = $active[0]['i'];
    } else {
        // 2) Otherwise pick the earliest UPCOMING (future only); tie-break by priority.
        $upcoming = array_values(array_filter($windows, fn($w) => $w['start'] !== false && $w['start'] >= $now));
        if (!empty($upcoming)) {
            usort($upcoming, function($a, $b) {
                return ($a['start'] <=> $b['start']) ?: ($a['prio'] <=> $b['prio']) ?: ($a['i'] <=> $b['i']);
            });
            $keepIndex = $upcoming[0]['i'];
        } else {
            $keepIndex = 0; // fallback
        }
    }

    // Move chosen one to FRONT; keep others (so VC can appear later)
    if (isset($finalUpcoming12[$keepIndex]) && $keepIndex !== 0) {
        $chosen = $finalUpcoming12[$keepIndex];
        array_splice($finalUpcoming12, $keepIndex, 1);
        array_unshift($finalUpcoming12, $chosen);
    }
}
// ──────────────────────────────────────────────────────────────────────────────


                         $googleMeetURL = $finalUpcoming12[0]['url'];

                         // It's a past time
                            $savedDate = $finalUpcoming12[0]['date'];
                            $meetingSchedule = $finalUpcoming12[0]['day_time'];
                            if(str_contains($finalUpcoming12[0]['short_text']['title'], '1 on 1'))
                            {
                                $customTitle = 'Weekly English with '.$finalUpcoming12[0]['short_text']['label'];

                            }else{
                             $customTitle = $finalUpcoming12[0]['short_text']['title'].' with '.$finalUpcoming12[0]['short_text']['label'];
                            }
                            

                            $sessionMessage = 'Your '.$finalUpcoming12[0]['short_text']['title']. ' Starts Soon';

                            
                            if(empty($finalUpcoming12[0]['short_text']['color']))
                            {
                              $cohortcolorx = 'Green';
                            }else{
                              $cohortcolorx = $finalUpcoming12[0]['short_text']['color'];
                            }
                            $badgeTextx = $finalUpcoming12[0]['short_text']['badge'];

                            // Extract the time part and ensure it only includes the first time (e.g., "8:00 PM")
                            $meetingScheduleParts = explode(' at ', $meetingSchedule);
                            if (isset($meetingScheduleParts[1])) {
                                // Split the second time using the dash and take only the first part
                                $timePart = explode(' - ', $meetingScheduleParts[1])[0]; 
                                $meetingSchedule = $meetingScheduleParts[0] . ' at ' . $timePart;
                           }
                             // Remove the used first element and shift the array (reindex)
                        array_shift($finalUpcoming12);


                        // Get today's date
                    $todayDate = date('Y-m-d'); // e.g., '2025-07-31'
                    // Append current year
$currentYear = date('Y');
$dateString = $savedDate . ' ' . $currentYear; // "August 1 2025"

// Convert to Y-m-d format
$formattedDate = date('Y-m-d', strtotime($dateString));

                    // Convert start time into Unix timestamp for today
                    $unixStart = strtotime("$formattedDate  $timePart");

                    // Add 1 hour
                    $unixStartPlus1Hour = $unixStart + 3600;

                    // Get current time
                    $now = time();
                    } else {
                        // It's a future time
                        // echo "The time (plus 1 hour) is still upcoming.";
                    }
                // }

                $currently_running = 0;

                if ($now >= $unixStart && $now <= $unixStartPlus1Hour) {
                        $currently_running = 1;
                    }






                
                ?>
                <div class="rightSide">
                    <div class="row01">

                        <div class="row01_01">
                            <h1 class="selectGroup_titleChange" style="margin-right:8px;"><?php echo $sessionMessage?>
                            </h1>
                            <h2 class="centered-heading">
                                <span class="circle-custom">
                                </span>
                                Upcoming classes
                            </h2>
                        </div>
                        <!-- small dot -->
                        <div href="" class="whichTutor_open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40"
                                fill="none">
                                <path
                                    d="M14.8295 9.5C14.64 9.5 14.4582 9.5753 14.3241 9.70935C14.1901 9.84339 14.1148 10.0252 14.1148 10.2148V11.3277H11.8475C11.2792 11.3293 10.7347 11.5557 10.3328 11.9575C9.93088 12.3592 9.7043 12.9037 9.70251 13.472V15.602H29.7178V13.472C29.7162 12.9037 29.4898 12.3592 29.088 11.9573C28.6863 11.5554 28.1418 11.3288 27.5735 11.327H25.3063V10.2155C25.3063 10.1216 25.2878 10.0287 25.2519 9.94198C25.2159 9.85526 25.1633 9.77647 25.0969 9.7101C25.0305 9.64372 24.9518 9.59108 24.865 9.55516C24.7783 9.51924 24.6854 9.50075 24.5915 9.50075C24.4977 9.50075 24.4047 9.51924 24.318 9.55516C24.2313 9.59108 24.1525 9.64372 24.0861 9.7101C24.0197 9.77647 23.9671 9.85526 23.9312 9.94198C23.8953 10.0287 23.8768 10.1216 23.8768 10.2155V11.3285H15.5443V10.2148C15.5443 10.1209 15.5258 10.0279 15.4899 9.94123C15.4539 9.85451 15.4013 9.77572 15.3349 9.70935C15.2685 9.64297 15.1898 9.59033 15.103 9.55441C15.0163 9.51849 14.9234 9.5 14.8295 9.5ZM25.5005 19.4705C27.1228 19.4705 28.6025 20.0997 29.7178 21.1145V17.033H9.70326V26.483C9.70505 27.0513 9.93163 27.5957 10.3335 27.9975C10.7354 28.3993 11.28 28.6257 11.8483 28.6273H20.0038C19.5181 27.7268 19.265 26.7193 19.2673 25.6962C19.2673 22.265 22.0625 19.4705 25.5005 19.4705Z"
                                    fill="black" />
                                <path
                                    d="M25.5005 30.5C28.145 30.5 30.2968 28.3482 30.2968 25.6962C30.2954 24.4246 29.7896 23.2055 28.8905 22.3063C27.9913 21.4071 26.7721 20.9014 25.5005 20.9C22.8485 20.9 20.6968 23.0517 20.6968 25.6962C20.697 26.9702 21.2031 28.192 22.104 29.0928C23.0048 29.9936 24.2266 30.4998 25.5005 30.5ZM24.071 24.9815H24.7858V24.2667C24.7855 24.1728 24.8038 24.0797 24.8396 23.9929C24.8754 23.906 24.928 23.8271 24.9945 23.7607C25.0609 23.6942 25.1398 23.6416 25.2267 23.6058C25.3135 23.57 25.4066 23.5517 25.5005 23.552C25.8935 23.552 26.2153 23.8737 26.2153 24.2667V24.9815H26.93C27.323 24.9815 27.6448 25.3032 27.6448 25.6962C27.6451 25.7902 27.6268 25.8833 27.591 25.9701C27.5552 26.057 27.5025 26.1359 27.4361 26.2023C27.3697 26.2687 27.2908 26.3214 27.2039 26.3572C27.117 26.393 27.024 26.4113 26.93 26.411H26.2153V27.1257C26.2156 27.2197 26.1973 27.3128 26.1615 27.3996C26.1257 27.4865 26.073 27.5654 26.0066 27.6318C25.9402 27.6982 25.8613 27.7509 25.7744 27.7867C25.6875 27.8225 25.5945 27.8408 25.5005 27.8405C25.4064 27.8414 25.3131 27.8235 25.2259 27.7879C25.1388 27.7523 25.0597 27.6997 24.9931 27.6332C24.9266 27.5666 24.8739 27.4875 24.8383 27.4003C24.8027 27.3132 24.7849 27.2199 24.7858 27.1257V26.411H24.071C23.9769 26.4119 23.8836 26.394 23.7964 26.3584C23.7093 26.3228 23.6302 26.2702 23.5636 26.2037C23.4971 26.1371 23.4444 26.058 23.4088 25.9708C23.3732 25.8837 23.3554 25.7904 23.3563 25.6962C23.356 25.6023 23.3743 25.5092 23.4101 25.4224C23.4459 25.3355 23.4985 25.2566 23.565 25.1902C23.6314 25.1237 23.7103 25.0711 23.7972 25.0353C23.884 24.9995 23.9771 24.9812 24.071 24.9815Z"
                                    fill="black" />
                            </svg>
                        </div>
                    </div>

                    <div class="row02">
                        <div class="row02_leftSide">
                            <div class="row02_leftSide_01">
                                <div class="imageContainer">
                                    <?php if (trim($customTitle) === 'Quick Talk with Peers'): ?>
                                    <!-- ✅ Show image from same folder -->
                                    <img src="quicktalk.jpeg" alt="Quick Talk" style="
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                            border-radius: 4px;
                                        ">
                                    <?php elseif(trim(str_contains($customTitle, 'Weekly English with'))):?>
                                    <img src="<?php echo $badgeTextx ?>" alt="Quick Talk" style="
                                            width: 100%;
                                            height: 100%;
                                            object-fit: cover;
                                            border-radius: 4px;
                                        ">
                                    <?php else: ?>
                                    <!-- ✅ Default colored box with badge -->
                                    <div class="selectGroup_changeImage" style="
                                            width: 100%;
                                            height: 100%;
                                            background-color: <?php echo htmlspecialchars($cohortcolorx ?? '#888'); ?>;
                                            border-radius: 4px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        ">
                                        <span style="
                                                display: flex;
                                                width: 100%;
                                                height: 100%;
                                                color: #fff;
                                                font-weight: bold;
                                                font-size: 130%;
                                                line-height: 1;
                                                text-transform: uppercase;
                                                text-align: center;
                                                align-items: center;
                                                justify-content: center;
                                            ">
                                            <?php echo htmlspecialchars($badgeTextx); ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col02 selectGroup_changeContent">
                                    <h5><?php echo $savedDate?></h5>
                                    <h1><?php echo $meetingSchedule?></h1>
                                    <p><?php echo $customTitle; ?></p>
                                </div>
                            </div>
                            <div class="row02_leftSide_02">
                                <div class="threeDots userOptionOpen">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M3 10H7V14H3V10ZM10 10H14V14H10V10ZM21 10H17V14H21V10Z" fill="#121117" />
                                    </svg>
                                </div>
                                <div class="row02_rightSide mobile-row02_rightSide">
                                    <?php if ($currently_running === 1): ?>
                                    <button class="joinLesson" style="white-space: nowrap;"
                                        onclick='joinClass(<?php echo json_encode($googleMeetURL, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT); ?>)'>
                                        Join Lesson
                                    </button>
                                    <?php else: ?>
                                    <?php if ($now < $unixStart): ?>
                                    <?php
                                            $diff = max(0, $unixStart - $now); // seconds until start
                                
                                            if ($diff >= 3600) {
                                                $h = ceil($diff / 3600);
                                                $timeLeft = $h . ' hour' . ($h === 1 ? '' : 's');
                                            } else {
                                                $m = ceil($diff / 60);
                                                $timeLeft = $m . ' minute' . ($m === 1 ? '' : 's');
                                            }
                                            //$googleMeetURL = 'https://meet.google.com/mnm-txoc-wcd';
                                        ?>
                                    <button class="joinLesson" style="background:#ccc; 
                                                   color:#666; 
                                                   cursor:not-allowed; 
                                                   border:1px solid #555; 
                                                   border-radius:6px;
                                                    white-space: nowrap;" disabled>
                                        Join in <?php echo htmlspecialchars($timeLeft, ENT_QUOTES, 'UTF-8'); ?>
                                    </button>
                                    <?php else: ?>
                                    <button class="joinLesson" style="background:#ccc; 
                                                   color:#666; 
                                                   cursor:not-allowed; 
                                                   border:1px solid #555; 
                                                   border-radius:6px;
                                                   white-space: nowrap;" disabled>
                                        Meeting ended
                                    </button>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row02_rightSide desktop">



                            <?php if ($currently_running === 1): ?>
                            <button class="joinLesson" style="white-space: nowrap;"
                                onclick='joinClass(<?php echo json_encode($googleMeetURL, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT); ?>)'>
                                Join Lesson
                            </button>
                            <?php else: ?>
                            <?php if ($now < $unixStart): ?>
                            <?php
            $diff = max(0, $unixStart - $now); // seconds until start

            if ($diff >= 3600) {
                $h = ceil($diff / 3600);
                $timeLeft = $h . ' hour' . ($h === 1 ? '' : 's');
            } else {
                $m = ceil($diff / 60);
                $timeLeft = $m . ' minute' . ($m === 1 ? '' : 's');
            }
            //$googleMeetURL = 'https://meet.google.com/mnm-txoc-wcd';
        ?>
                            <button class="joinLesson" style="background:#ccc; 
                   color:#666; 
                   cursor:not-allowed; 
                   border:1px solid #555; 
                   border-radius:6px;
                    white-space: nowrap;" disabled>
                                Join in <?php echo htmlspecialchars($timeLeft, ENT_QUOTES, 'UTF-8'); ?>
                            </button>
                            <?php else: ?>
                            <button class="joinLesson" style="background:#ccc; 
                   color:#666; 
                   cursor:not-allowed; 
                   border:1px solid #555; 
                   border-radius:6px;
                   white-space: nowrap;" disabled>
                                Meeting ended
                            </button>
                            <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="row03">
                        <div class="top">
                            <h5>Up Next</h5>

                            <?php if (!empty($finalUpcoming12) && is_array($finalUpcoming12)) : ?>
                            <a href="">See all (<?php echo count($finalUpcoming12); ?>)</a>
                            <?php endif; ?>
                        </div>

                        <div class="bottom">
                            <?php
                       $d = (!empty($finalUpcoming12) && is_array($finalUpcoming12)) ? count($finalUpcoming12) : 0;
                        if ($d > 1) { // Ensure there are at least 2 elements to run the loop safely
                        for ($i = 0; $i < $d; $i++) { ?>
                            <div class="card">
                                <div class="content">
                                    <div class="card_leftSide selectGroupBTN">

                                        <h1><?php echo $finalUpcoming12[$i]['date']; ?>
                                            <?php echo $finalUpcoming12[$i]['day_time']; ?></h1>
                                        <p style="font-size: 1rem; color: #555; margin: 0;">


                                        <p style="
    font-size: 0.85rem;
    color: #666;
    margin: 0;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    flex-wrap: wrap;
">
                                            <span style="display: inline-flex; align-items: center;">
                                                <?php echo htmlspecialchars($finalUpcoming12[$i]['short_text']['title']); ?>
                                                with
                                            </span>

                                            <span style="
        display: inline-flex;
        align-items: center;
        background-color: #f5f5f5;
        border-radius: 4px;
        padding: 4px 6px;
        height: 28px;
    ">
                                                <?php if (trim($finalUpcoming12[$i]['short_text']['title']) === 'Quick Talk'): ?>
                                                <!-- ✅ Image instead of badge -->
                                                <img src="quicktalk.jpeg" alt="Quick Talk" style="
                width: auto;
                height: 28px;
                border-radius: 4px;
                margin-right: 6px;
                display: inline-block;
                object-fit: cover;
            ">

                                                <?php elseif (
    !empty($finalUpcoming12[$i]['short_text']['title']) &&
    str_contains($finalUpcoming12[$i]['short_text']['title'], '1 on 1')
): ?>
                                                <!-- ✅ Image instead of badge -->
                                                <img src="<?php echo $finalUpcoming12[$i]['short_text']['badge']; ?>"
                                                    alt="1 on 1" style="
                width: auto;
                height: 25px;
                border-radius: 4px;
                margin-right: 6px;
                display: inline-block;
                object-fit: cover;
            ">
                                                <?php else: ?>
                                                <!-- ✅ Badge -->
                                                <span style="
                display: inline-block;
                background-color: <?php echo htmlspecialchars($finalUpcoming12[$i]['short_text']['color'] ?? '#888'); ?>;
                color: #fff;
                font-weight: 600;
                border-radius: 4px;
                padding: 2px 6px;
                font-size: 0.7rem;
                margin-right: 6px;
                line-height: 1;
            ">
                                                    <?php echo htmlspecialchars($finalUpcoming12[$i]['short_text']['badge']); ?>
                                                </span>
                                                <?php endif; ?>

                                                <span style="font-size: 0.8rem; color: #333;">
                                                    <?php echo htmlspecialchars($finalUpcoming12[$i]['short_text']['label']); ?>
                                                </span>
                                            </span>
                                        </p>
                                    </div>

                                    <div class="threeDots userOptionOpen">
                                        <svg width="18" height="4" viewBox="0 0 18 4" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0 0H4V4H0V0ZM7 0H11V4H7V0ZM18 0H14V4H18V0Z" fill="#121117" />
                                        </svg>
                                    </div>
                                </div>
                                <?php if ($i +1 < $d - 1) { // Only add underline if not the last iteration ?>
                                <div class="underline"></div>
                                <?php } ?>
                            </div>
                            <?php }} ?>
                        </div>
                    </div>
                </div>

                <?php
                // Left COntent
                ?>
                <div class="leftSide">
                    <div class="leftside-content">
                        <div class="leftside-content_01">
                            <h1 class="heading" style="margin: 0;">My group Classes</h1>
                            <h2 class="centered-heading">
                                <span class="circle-custom">
                                </span>
                                Group Florida 1 Information
                            </h2>
                        </div>
                        <div href="" class="note_open group-classes-options-modal-open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M17.7757 15.6396L16.3738 17.0641C16.3335 17.1112 16.2814 17.1468 16.2229 17.1674L12.6966 18.3364H14.8664C14.9853 18.3364 15.0995 18.3837 15.1836 18.4678C15.2677 18.552 15.315 18.6661 15.315 18.785C15.315 18.904 15.2677 19.0181 15.1836 19.1023C15.0995 19.1864 14.9853 19.2336 14.8664 19.2336H2.92206C2.80308 19.2336 2.68898 19.1864 2.60485 19.1023C2.52072 19.0181 2.47346 18.904 2.47346 18.785C2.47346 18.6661 2.52072 18.552 2.60485 18.4678C2.68898 18.3837 2.80308 18.3364 2.92206 18.3364H12.2519C12.2138 18.3364 12.1784 18.2951 12.1468 18.2635C12.088 18.2056 12.0466 18.1323 12.0275 18.052C12.0083 17.9717 12.0122 17.8877 12.0386 17.8095L12.3089 16.9907H2.92206C2.80308 16.9907 2.68898 16.9434 2.60485 16.8593C2.52072 16.7751 2.47346 16.661 2.47346 16.5421C2.47346 16.4231 2.52072 16.309 2.60485 16.2248C2.68898 16.1407 2.80308 16.0935 2.92206 16.0935H12.6087L13.2414 14.1926C13.2571 14.1307 13.2883 14.0737 13.3321 14.0272L17.7757 9.56888V4.54206H13.7333C13.4855 4.54206 13.2897 4.3666 13.2897 4.11869V0H0V24H17.7757V15.6396ZM2.92206 13.8505H9.2589C9.37787 13.8505 9.49197 13.8977 9.5761 13.9819C9.66023 14.066 9.70749 14.1801 9.70749 14.2991C9.70749 14.418 9.66023 14.5321 9.5761 14.6163C9.49197 14.7004 9.37787 14.7477 9.2589 14.7477H2.92206C2.80308 14.7477 2.68898 14.7004 2.60485 14.6163C2.52072 14.5321 2.47346 14.418 2.47346 14.2991C2.47346 14.1801 2.52072 14.066 2.60485 13.9819C2.68898 13.8977 2.80308 13.8505 2.92206 13.8505ZM14.8664 21.4766H2.92206C2.80308 21.4766 2.68898 21.4294 2.60485 21.3452C2.52072 21.2611 2.47346 21.147 2.47346 21.028C2.47346 20.9091 2.52072 20.795 2.60485 20.7108C2.68898 20.6267 2.80308 20.5794 2.92206 20.5794H14.8664C14.9854 20.5794 15.0995 20.6267 15.1836 20.7108C15.2678 20.795 15.315 20.9091 15.315 21.028C15.315 21.147 15.2678 21.2611 15.1836 21.3452C15.0995 21.4294 14.9854 21.4766 14.8664 21.4766H14.8664Z"
                                    fill="black" />
                                <path
                                    d="M14.1869 0.662109V3.64478H17.19L14.1869 0.662109ZM13.1745 17.2508L15.2508 16.5567L13.8686 15.1745L13.1745 17.2508ZM16.0803 16.1173L21.7601 10.425L20.0003 8.66521L14.3081 14.345L16.0803 16.1173ZM23.7527 8.42779L21.9973 6.67265L20.6353 8.03151L22.3938 9.78979L23.7527 8.42779Z"
                                    fill="black" />
                            </svg>

                            <section id="popup-menu-section">
                                <div class="popup-menu-container">
                                    <ul class="popup-menu-list">
                                        <li class="popup-menu-item">
                                            <a href="#" class="popup-menu-link">
                                                <!--merged image-->
                                                <div class="">
                                                    <img src="../img/subs/report.svg" alt="Feedback icon"
                                                        class="icon-image">

                                                </div>
                                                <span class="popup-menu-text">Give feedback to Group</span>
                                            </a>
                                        </li>
                                        <li class="popup-menu-item">
                                            <a href="#" class="popup-menu-link">
                                                <!--merged image-->
                                                <div class="">
                                                    <img src="../img/subs/teacher-feedback.svg" alt="Feedback icon"
                                                        class="icon-image">
                                                </div>
                                                <span class="popup-menu-text">Give feedback to teacher</span>
                                            </a>
                                        </li>
                                        <li class="popup-menu-item">
                                            <a href="#" class="popup-menu-link">
                                                <!--merged image-->
                                                <div class="">
                                                    <img src="../img/subs/group-feedback.svg" alt="Feedback icon"
                                                        class="icon-image">
                                                </div>
                                                <span class="popup-menu-text">Report a issue</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                        <?php 
                // Determine selected cohort: from GET or default to first in list
                $selectedcohortid = null;

                if (!empty($_GET['cohortid'])) {
                    $selectedcohortid = (int)$_GET['cohortid'];
                } elseif (!empty($cohorts)) {
                    $firstCohort = reset($cohorts);
                    $selectedcohortid = $firstCohort->id;
                }

                if ($isteacher): ?>
                        <select id="cohortDropdown" style="
                        padding: 0.5rem 2rem 0.5rem 0.5rem;
                        font-size: 1rem;
                        border: none;
                        outline: none;
                        background-color: transparent;
                        appearance: none;
                        -webkit-appearance: none;
                        -moz-appearance: none;
                        cursor: pointer;
                        background-image: url('data:image/svg+xml;utf8,<svg fill=\'gray\' height=\'16\' viewBox=\'0 0 24 24\' width=\'16\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7 10l5 5 5-5z\'/></svg>');
                        background-repeat: no-repeat;
                        background-position: right 0.5rem center;
                        background-size: 26px;
                    ">
                            <?php 
                       
                        foreach ($cohorts as $cohort): ?>
                            <option value="<?php echo $cohort->id; ?>"
                                <?php if ($ccid == $cohort->id) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($cohort->name); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                        <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const dd = document.getElementById('cohortDropdown');
                            debugger
                            if (!dd) return;

                            dd.addEventListener('change', async function() {
                                const cohortId = this.value;

                                try {
                                    // 1) Schedule
                                    const res1 = await fetch('getSchedule.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: 'cohortid=' + encodeURIComponent(cohortId)
                                    });
                                    const data1 = await res1.json();

                                    const {
                                        dayOrder,
                                        allDaysWithHours,
                                        cohortId: respCohortId,
                                        courseId
                                    } = data1; // <- rename to avoid shadowing

                                    const defaultSchedule = document.getElementById(
                                        'default-schedule');
                                    if (defaultSchedule) defaultSchedule.remove();

                                    const scheduleContainer = document.getElementById(
                                        'schedule-container');
                                    scheduleContainer.innerHTML = '';
                                    scheduleContainer.style.display = 'flex';
                                    scheduleContainer.style.flexWrap = 'wrap';
                                    scheduleContainer.style.gap = '16px';

                                    dayOrder.forEach(day => {
                                        const hours = allDaysWithHours[day] || [];
                                        if (hours.length) {
                                            hours.forEach(hour => {
                                                const div = document.createElement(
                                                    'div');
                                                div.className = 'date';
                                                div.innerHTML = `
              <div class='day'><h1>${day}</h1></div>
              <p>${hour}</p>
            `;
                                                scheduleContainer.appendChild(div);
                                            });
                                        } else {
                                            const div = document.createElement('div');
                                            div.className = 'date';
                                            div.innerHTML =
                                                `<div class='day'><h1>${day}</h1></div>`;
                                            scheduleContainer.appendChild(div);
                                        }
                                    });

                                    const recordingCard = document.getElementById('recording-card');
                                    if (recordingCard) {
                                        recordingCard.onclick = () => redirectToRecordings(
                                            respCohortId, courseId);
                                    }

                                    const activitiesCard = document.getElementById(
                                        'activities-card');
                                    if (activitiesCard) {
                                        activitiesCard.onclick = () => redirectToActivities(
                                            respCohortId, courseId);
                                    }


                                    debugger

                                    // 2) Dashboard data -> build cards HTML
                                    const res2 = await fetch(
                                        'getLatestDashboardData.php', { // <- make sure URL matches your file
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded'
                                            },
                                            body: 'cohortid=' + encodeURIComponent(cohortId)
                                        });

                                    if (!res2.ok) throw new Error('Bad response: ' + res2.status);
                                    const data2 = await res2
                                        .json(); // { success: true, record: {...} }
                                    const rec = data2 && data2
                                        .record; // may be null if no row (e.g., all 100%)

                                    const topic = rec ? (rec.sectionname || '—') : '—';

                                    const slides = rec?.slides_url || data2?.slides || '';
                                    const topic_url = rec?.topic_url || data2?.topic || '';


                                    // 3) Latest Due Activity data -> build cards HTML
                                    const res3 = await fetch('getLatestDueActivities.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: 'cohortid=' + encodeURIComponent(cohortId)
                                    });
                                    if (!res3.ok) throw new Error('Bad response: ' + res3.status);

                                    const data3 = await res3.json();
                                    const soonest = (data3 && data3.success) ? data3.soonest : null;

                                    debugger

                                    const dueText = soonest && soonest.due_display ?
                                        soonest.due_display :
                                        'No upcoming tasks';
                                    const actName = soonest && soonest.name ? soonest.name : '—';
                                    const actUrl = soonest && soonest.url ? soonest.url : '#';

                                    const cardsHtml = `
  <a href="${topic_url}" class="card">
    <p><span class="desktop">Current</span> Topic</p>
    <h2>
      <span class="desktop">${escapeHTML(topic)}</span>
      <span class="mobile">${escapeHTML(topic)}</span>
    </h2>
  </a>

  <div id="activities-card" style="cursor:pointer"
       onclick="redirectToActivities(${respCohortId}, ${courseId})"
       class="card">
                        <p>
                        <span class="">${escapeHTML(dueText)}</span>
                        <span class="">${escapeHTML(dueText)}</span>
                        </p>
                        <h2>
                        <span
                            ><span class="">${escapeHTML(actName)}</span>
                            <span class="">${escapeHTML(actName)}</span></span
                        >
                        </h2>
                    </div>

  <a href="${slides}" class="card">
                        <p><span class="desktop">See</span> Slides</p>
                        <svg
                        width="34"
                        height="33"
                        viewBox="0 0 34 33"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                        >
                        <g clip-path="url(#clip0_2444_52879)">
                            <path
                            d="M28.661 9.19295V30.5716C28.661 31.72 27.7271 32.6539 26.5787 32.6539H7.33917C6.19073 32.6539 5.25684 31.72 5.25684 30.5716V2.42852C5.25684 1.28009 6.19073 0.346191 7.33917 0.346191H19.8079L28.661 9.19295Z"
                            fill="#001CB1"
                            />
                            <path
                            d="M21.2656 15.0803H12.7785C11.9897 15.0803 11.3524 15.7176 11.3524 16.5064V24.9935C11.3524 25.7822 11.9897 26.4195 12.7785 26.4195H21.2656C22.0543 26.4195 22.6917 25.7822 22.6917 24.9935V16.5001C22.6917 15.7176 22.0543 15.0803 21.2656 15.0803ZM21.2214 23.8829H12.829V18.1722H21.2214V23.8829Z"
                            fill="white"
                            />
                            <path
                            d="M21.0132 8.82699L28.6547 15.0172V9.19928L24.3197 6.68787L21.0132 8.82699Z"
                            fill="black"
                            fill-opacity="0.0980392"
                            />
                            <path
                            d="M28.6989 9.19298H21.9345C20.7861 9.19298 19.8522 8.25908 19.8522 7.11064V0.346222L28.6989 9.19298Z"
                            fill="#9E87FA"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_2444_52879">
                            <rect
                                width="32.3077"
                                height="32.3077"
                                fill="white"
                                transform="translate(0.846191 0.346161)"
                            />
                            </clipPath>
                        </defs>
                        </svg>
                    </a>

  <div id="recording-card" style="cursor:pointer"
       onclick="redirectToRecordings(${respCohortId}, ${courseId})"
       class="card">
    <p><span class="desktop">Previous</span> Recording</p>
    <svg width="32" height="19" viewBox="0 0 32 19" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M18.1007 0.0995483H3.50109C1.57549 0.0995483 0 1.67504 0 3.60064V15.3993C0 17.3249 1.57549 18.9004 3.50109 18.9004H18.1007C20.0263 18.9004 21.6017 17.3249 21.6017 15.3993V3.60064C21.6017 1.64003 20.0263 0.0995483 18.1007 0.0995483ZM29.4092 2.02515C29.1991 2.06016 28.9891 2.16519 28.814 2.27023L23.3523 5.42121V13.5437L28.849 16.6947C29.8643 17.2899 31.1247 16.9398 31.7199 15.9245C31.895 15.6094 32 15.2593 32 14.8742V4.05578C32 2.76038 30.7746 1.71005 29.4092 2.02515Z"
        fill="#001CB1"/>
    </svg>
  </div>
  
`;

                                    document.getElementById('cards').innerHTML = cardsHtml;

                                } catch (err) {
                                    console.error('Error:', err);
                                }
                            });

                            // fire once for default selected
                            if (dd.selectedIndex < 0 && dd.options.length) dd.selectedIndex = 0;
                            dd.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                        });

                        // small helper to avoid HTML injection when inserting strings
                        function escapeHTML(s) {
                            return String(s ?? '')
                                .replace(/&/g, '&amp;').replace(/</g, '&lt;')
                                .replace(/>/g, '&gt;').replace(/"/g, '&quot;')
                                .replace(/'/g, '&#39;');
                        }
                        </script>

                        <?php endif; ?>
                    </div>

                    <?php if ($isteacher) { ?>
                    <div class="cards" id="cards">
                    </div>
                    <?php } ?>

                    <?php if (!$isteacher) { 
                
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
                    $params = ['cohortid' => (int)$cohortid];

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

                    $topic_url = (new moodle_url('/course/view.php', ['id' => (int)$firstcourse->id]))->out(false);

                //}
            
        }
    }

}else{
    
    $idd = $rec->courseid;
    
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
}










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
    // echo json_encode(['success' => true, 'soonest' => null, 'others' => []]);
    // exit;


    $excludeids = [2, 24];

// Build a NOT IN clause safely
list($notinSql, $notinParams) = $DB->get_in_or_equal($excludeids, SQL_PARAMS_NAMED, 'ex', false);

$sql = "
    SELECT DISTINCT c.id, c.fullname, c.shortname
      FROM {user_enrolments} ue
      JOIN {enrol} e ON e.id = ue.enrolid
      JOIN {course} c ON c.id = e.courseid
     WHERE ue.userid = :userid
       AND ue.status = :ueactive      -- active user enrolment
       AND e.status  = :eenabled      -- enabled enrol instance
       AND c.id $notinSql             -- exclude specific courses
  ORDER BY c.sortorder, c.id
";

$params = [
    'userid'   => $user->id,
    'ueactive' => 0,
    'eenabled' => 0,
] + $notinParams;

$courses = $DB->get_records_sql($sql, $params);

}


if(count($courses) == 0)
{

}else{
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

             }
                
                ?>


                    <div class="cards" id="cards">

                        <?php
                if(count($courses) != 0)
                {
                ?>
                        <a href="<?php echo $topic_url;?>" class="card">
                            <p><span class="">Current</span> Topic</p>
                            <h2>
                                <span class=""><?php echo $sectionname;?></span>
                                <span class="">Adverb</span>
                            </h2>
                        </a>
                        <div id="activities-card" style="cursor:pointer"
                            onclick="redirectToActivities(<?php echo $cohortid; ?>, 10)" class="card">
                            <p>
                                <span class="">
                                    <?php echo !empty($soonest->due_display) ? $soonest->due_display : 'No upcoming tasks'; ?>
                                </span>
                                <span class="">
                                    <?php echo !empty($soonest->due_display) ? $soonest->due_display : 'No upcoming tasks'; ?>
                                </span>
                            </p>

                            <h2>
                                <span>
                                    <span class="">
                                        <?php echo !empty($soonest->name) ? $soonest->name : '—'; ?>
                                    </span>
                                    <span class="">
                                        <?php echo !empty($soonest->name) ? $soonest->name : '—'; ?>
                                    </span>
                                </span>

                                <!-- <svg
                            width="25"
                            height="25"
                            viewBox="0 0 25 25"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <rect
                            x="0.706897"
                            y="0.706897"
                            width="23.5862"
                            height="23.5862"
                            rx="11.7931"
                            stroke="#001CB1"
                            stroke-width="0.413793"
                            />
                            <path
                            d="M6.75178 11.8873C6.46612 11.8881 6.18653 11.9698 5.94534 12.1228C5.70416 12.2759 5.51124 12.4942 5.38891 12.7523C5.26657 13.0104 5.21983 13.2979 5.25408 13.5815C5.28833 13.8651 5.40217 14.1333 5.58244 14.3549L9.4253 19.0624C9.56232 19.2325 9.73795 19.3675 9.93761 19.4561C10.1373 19.5447 10.3552 19.5844 10.5733 19.5719C11.0397 19.5469 11.4608 19.2974 11.7293 18.8871L19.7119 6.03112C19.7133 6.02897 19.7146 6.02685 19.716 6.02475C19.7909 5.90975 19.7666 5.68185 19.612 5.53867C19.5696 5.49936 19.5195 5.46915 19.4649 5.44992C19.4103 5.43068 19.3524 5.42282 19.2946 5.42683C19.2369 5.43083 19.1806 5.44661 19.1292 5.4732C19.0778 5.49979 19.0324 5.53662 18.9957 5.58142C18.9929 5.58495 18.9899 5.58842 18.9869 5.59183L10.9363 14.6878C10.9057 14.7224 10.8685 14.7506 10.8269 14.7707C10.7852 14.7908 10.74 14.8024 10.6939 14.8049C10.6477 14.8074 10.6015 14.8007 10.558 14.7852C10.5145 14.7697 10.4744 14.7457 10.4402 14.7146L7.76841 12.2832C7.49092 12.0288 7.12823 11.8876 6.75178 11.8873Z"
                            fill="#001CB1"
                            />
                        </svg> -->
                            </h2>
                        </div>
                        <a href="" class="card">
                            <p>Quizzes</p>
                            <h2><span>Quizzes 1</span></h2>
                        </a>
                        <a href="<?php echo $slides_url;?>" class="card">
                            <p><span class="desktop">See</span> Slides</p>
                            <svg width="34" height="33" viewBox="0 0 34 33" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2444_52879)">
                                    <path
                                        d="M28.661 9.19295V30.5716C28.661 31.72 27.7271 32.6539 26.5787 32.6539H7.33917C6.19073 32.6539 5.25684 31.72 5.25684 30.5716V2.42852C5.25684 1.28009 6.19073 0.346191 7.33917 0.346191H19.8079L28.661 9.19295Z"
                                        fill="#001CB1" />
                                    <path
                                        d="M21.2656 15.0803H12.7785C11.9897 15.0803 11.3524 15.7176 11.3524 16.5064V24.9935C11.3524 25.7822 11.9897 26.4195 12.7785 26.4195H21.2656C22.0543 26.4195 22.6917 25.7822 22.6917 24.9935V16.5001C22.6917 15.7176 22.0543 15.0803 21.2656 15.0803ZM21.2214 23.8829H12.829V18.1722H21.2214V23.8829Z"
                                        fill="white" />
                                    <path d="M21.0132 8.82699L28.6547 15.0172V9.19928L24.3197 6.68787L21.0132 8.82699Z"
                                        fill="black" fill-opacity="0.0980392" />
                                    <path
                                        d="M28.6989 9.19298H21.9345C20.7861 9.19298 19.8522 8.25908 19.8522 7.11064V0.346222L28.6989 9.19298Z"
                                        fill="#9E87FA" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_2444_52879">
                                        <rect width="32.3077" height="32.3077" fill="white"
                                            transform="translate(0.846191 0.346161)" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>

                        <div id="recording-card" style="cursor:pointer"
                            onclick="redirectToRecordings(<?php echo $cohortid; ?>, <?php echo $course->id; ?>)"
                            class="card">
                            <p><span class="desktop">Previous</span> Recording</p>

                            <svg width="32" height="19" viewBox="0 0 32 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.1007 0.0995483H3.50109C1.57549 0.0995483 0 1.67504 0 3.60064V15.3993C0 17.3249 1.57549 18.9004 3.50109 18.9004H18.1007C20.0263 18.9004 21.6017 17.3249 21.6017 15.3993V3.60064C21.6017 1.64003 20.0263 0.0995483 18.1007 0.0995483ZM29.4092 2.02515C29.1991 2.06016 28.9891 2.16519 28.814 2.27023L23.3523 5.42121V13.5437L28.849 16.6947C29.8643 17.2899 31.1247 16.9398 31.7199 15.9245C31.895 15.6094 32 15.2593 32 14.8742V4.05578C32 2.76038 30.7746 1.71005 29.4092 2.02515Z"
                                    fill="#001CB1" />
                            </svg>
                        </div>
                        <a href="" class="card">
                            <p>Group Level</p>
                            <h2><span>A1-Level 1</span></h2>
                        </a>
                        <?php
             }else{
?>
                        <div class="card">
                            <p>You have not been enrolled in any levels yet</p>
                        </div>
                        <?php
             }
                ?>
                    </div>
                    <?php } ?>


                    <div class="schedule">
                        <h4>Schedule</h4>
                        <div class="row" id="schedule-container">
                            <div id="default-schedule" style="display: flex; flex-wrap: wrap;">
                                <?php
                            foreach ($dayOrder as $day) {
                                if (!empty($allDaysWithHours[$day])) {
                                    foreach ($allDaysWithHours[$day] as $hour) {
                                        echo "
                                        <div class='date'>
                                            <div class='day'><h1>" . htmlspecialchars($day) . "</h1></div>
                                            <p>" . htmlspecialchars($hour) . "</p>
                                        </div>
                                        ";
                                    }
                                } else {
                                    echo "
                                    <div class='date'>
                                        <div class='day gray'><h1>" . htmlspecialchars($day) . "</h1></div>
                                    </div>
                                    ";
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                
                }}else{
                    $googleMeetURL="";
                }
            }
            ?>
            </div>
        </section>

        <section class="page_bottom">
            <div class="center_content">
                <h1 class="heading">Take a Look at Your Level and Access It</h1>

                <div class="levels">
                    <div class="card subLevelOpen1">
                        <div class="top">
                            <p>A1</p>
                            <h2>Begginer</h2>
                        </div>
                        <div class="bottom">
                            <div class="stag">
                                <div class="content">
                                    <h3>100%</h3>
                                    <p>completed</p>
                                </div>
                                <a href="<?php echo getLink($cursosArray, 21, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 21) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 21)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='margin-bottom: -30px;position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>1</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                            <div class="stag">
                                <div class="content">
                                    <h3>100%</h3>
                                    <p>completed</p>
                                </div>

                                <a href="<?php echo getLink($cursosArray, 10, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 10) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 10)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='margin-bottom: -30px;position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>2</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card subLevelOpen2">
                        <div class="top">
                            <p>A2</p>
                            <h2>Elementary</h2>
                        </div>
                        <div class="bottom">
                            <div class="stag">
                                <div class="content">
                                    <h3>100%</h3>
                                    <p>completed</p>
                                </div>

                                <a href="<?php echo getLink($cursosArray, 22, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 22) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 22)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>3</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                            <div class="stag">
                                <div class="content">
                                    <h3>100%</h3>
                                    <p>completed</p>
                                </div>

                                <a href="<?php echo getLink($cursosArray, 12, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 12) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 12)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>4</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card subLevelOpen3">
                        <div class="top">
                            <p>B1</p>
                            <h2>Intermediate</h2>
                        </div>
                        <div class="bottom">
                            <div class="stag">
                                <div class="content">
                                    <h3>100%</h3>
                                    <p>completed</p>
                                </div>

                                <a href="<?php echo getLink($cursosArray, 13, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 13) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 13)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>5</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                            <div class="stag">
                                <a href="<?php echo getLink($cursosArray, 14, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 14) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 14)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>6</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card subLevelOpen4">
                        <div class="top">
                            <p>B2</p>
                            <h2>
                                Upper <br />
                                Intermediate
                            </h2>
                        </div>
                        <div class="bottom">
                            <div class="stag">
                                <a href="<?php echo getLink($cursosArray, 15, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 15) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 15)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>7</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                            <div class="stag">
                                <a href="<?php echo getLink($cursosArray, 16, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 16) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 16)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>8</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card subLevelOpen5">
                        <div class="top">
                            <p>C1</p>
                            <h2>Advanced</h2>
                        </div>
                        <div class="bottom">
                            <div class="stag">

                                <a href="<?php echo getLink($cursosArray, 17, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 17) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 17)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>9</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                            <div class="stag">

                                <a href="<?php echo getLink($cursosArray, 18, $urlCourse); ?>"
                                    class="stagBox <?php echo verificarInscripcion($cursosArray, 18) ? '' : 'lock'; ?>">
                                    <?php
                        if(!verificarInscripcion($cursosArray, 18)){
                            echo "
                            <div style='position:absolute;width: 100%;height: 100%;background: #00000063;' ;></div>
                                <svg 
                            style='position:relative;'
                            width='18'
                            height='24'
                            viewBox='0 0 18 24'
                            fill='none'
                            xmlns='http://www.w3.org/2000/svg'
                            >
                            <path
                                d='M17.5 9H16V6.99998C16 3.14016 12.8599 0 9 0C5.14012 0 2.00002 3.14016 2.00002 6.99998V9H0.500016C0.434341 8.99996 0.369301 9.01286 0.308617 9.03797C0.247933 9.06309 0.192794 9.09992 0.146355 9.14635C0.0999157 9.19279 0.0630866 9.24793 0.0379738 9.30862C0.0128609 9.3693 -4.30326e-05 9.43434 1.07813e-07 9.50002V22C1.07813e-07 23.103 0.896953 24 2.00002 24H16C17.103 24 18 23.103 18 22V9.50002C18 9.43434 17.9871 9.3693 17.962 9.30862C17.9369 9.24793 17.9001 9.19279 17.8536 9.14635C17.8072 9.09992 17.7521 9.06309 17.6914 9.03797C17.6307 9.01286 17.5657 8.99996 17.5 9ZM10.4971 19.4448C10.5048 19.5147 10.4977 19.5855 10.4763 19.6524C10.4548 19.7194 10.4195 19.7811 10.3726 19.8335C10.3257 19.8859 10.2683 19.9278 10.2041 19.9565C10.1399 19.9852 10.0704 20 10 20H8.00002C7.9297 20 7.86017 19.9852 7.79597 19.9565C7.73177 19.9278 7.67435 19.8859 7.62744 19.8335C7.58054 19.7811 7.5452 19.7194 7.52375 19.6524C7.5023 19.5855 7.49522 19.5147 7.50295 19.4448L7.81838 16.6084C7.30617 16.2359 7.00003 15.6465 7.00003 15C7.00003 13.897 7.89698 13 9.00005 13C10.1031 13 11.0001 13.8969 11.0001 15C11.0001 15.6465 10.6939 16.2359 10.1817 16.6084L10.4971 19.4448ZM13 9H5.00002V6.99998C5.00002 4.79442 6.79444 3 9 3C11.2056 3 13 4.79442 13 6.99998V9Z'
                                fill='white'
                            />
                            </svg>
                            ";
                        }
                    ?>
                                    <h1>10</h1>
                                    <p>Level</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="level1" class="sub_level">
            <div class="center_content">
                <h1 class="heading">Levels Of Begginer-A1</h1>

                <div class="cards">
                    <div class="card">
                        <img src="../img/cour/card-01.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 1</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 21, $urlCourse); ?>" class="btn">View Level 1</a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="../img/cour/card-02.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 2</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 10, $urlCourse); ?>" class="btn">View Level 2</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="level2" class="sub_level">
            <div class="center_content">
                <h1 class="heading">Levels Of Elementary-A2</h1>

                <div class="cards">
                    <div class="card">
                        <img src="../img/cour/card-01.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 3</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 22, $urlCourse); ?>" class="btn">View Level 3</a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="../img/cour/card-02.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 4</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 12, $urlCourse); ?>" class="btn">View Level 4</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="level3" class="sub_level">
            <div class="center_content">
                <h1 class="heading">Levels Of Intermediate-B1</h1>

                <div class="cards">
                    <div class="card">
                        <img src="../img/cour/Figure2.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 5</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 13, $urlCourse); ?>" class="btn">View Level 5</a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="../img/cour/Figure.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 6</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 14, $urlCourse); ?>" class="btn">View Level 6</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="level4" class="sub_level">
            <div class="center_content">
                <h1 class="heading">Levels Of Upper Intermediate-B2</h1>

                <div class="cards">
                    <div class="card">
                        <img src="../img/cour/Figure2.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 7</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 15, $urlCourse); ?>" class="btn">View Level 7</a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="../img/cour/Figure.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 8</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 16, $urlCourse); ?>" class="btn">View Level 8</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="level5" class="sub_level">
            <div class="center_content">
                <h1 class="heading">Levels Of Advanced-C1</h1>

                <div class="cards">
                    <div class="card">
                        <img src="../img/cour/FigureF1.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 9</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 17, $urlCourse); ?>" class="btn">View Level 9</a>
                        </div>
                    </div>
                    <div class="card">
                        <img src="../img/cour/FigureF2.png" alt="" class="bg" />

                        <div class="top">
                            <h1>Level 10</h1>
                            <p>
                                Rem tempore est ea velit. Possimus consequatur totam iusto
                                dolorum facere aut aut eius nesciunt. Ratione ut in
                                repellendus neque autem ea enim.
                            </p>
                        </div>
                        <div class="bottom">
                            <div class="progress">
                                <!-- <svg class="progress-ring" width="44" height="44">
                    <circle
                    class="progress-ring__circle"
                    cx="22"
                    cy="22"
                    r="20"
                    stroke-width="4"
                    />
                </svg> -->
                                <!-- <div class="progress-text">100%</div> -->
                            </div>
                            <a href="<?php echo getLink($cursosArray, 18, $urlCourse); ?>" class="btn">View Level 10</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="subscriptions">
            <div class="topPart">
                <h1>Subscriptions</h1>
                <a href="">Manage</a>
            </div>
            <div class="bottomPart">
                <div class="card">
                    <div class="card_top">
                        <div class="row_01">
                            <div class="imageContainer">
                                <img src="../img/cour/2.png" alt="" />
                            </div>
                            <p class="status notStarted">Not Started</p>
                        </div>
                        <div class="row_02">
                            <h1>English with Wade Warren</h1>
                            <!-- <div class="balance">
                <img src="../img/cour/icons/wallet_lg.png" alt="" />
                <p>Balance : 0 Lessons</p>
                </div>
                <div class="balance revision">
                <img src="../img/cour/icons/revision.png" alt="">
                <p>Subscription to 1 lesson renews 
                    automatically on February 18</p>
                </div> -->
                            <p class="text">
                                Start a Monthly Subscription and set up the schedule
                            </p>
                        </div>
                    </div>
                    <div class="row_03">
                        <a href="" class="btn subscribe subscribe-modal-open">Subscribe</a>
                        <!-- <div class="options">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="4"
                viewBox="0 0 18 4"
                fill="none"
                >
                <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M0 0.00012207H4V4.00012H0V0.00012207ZM7 0.00012207H11V4.00012H7V0.00012207ZM18 0.00012207H14V4.00012H18V0.00012207Z"
                    fill="#121117"
                />
                </svg>
            </div> -->
                    </div>
                </div>

                <div class="card">
                    <div class="card_top">
                        <div class="row_01">
                            <div class="imageContainer">
                                <img src="../img/cour/1.png" alt="" />
                            </div>
                            <p class="status active">Active</p>
                        </div>
                        <div class="row_02">
                            <h1>English with Dainiela</h1>
                            <div class="balance">
                                <img src="../img/cour/icons/wallet_lg.png" alt="" />
                                <p>Balance : 0 Lessons</p>
                            </div>
                            <div class="balance revision">
                                <img src="../img/cour/icons/revision.png" alt="" />
                                <p>
                                    Subscription to 1 lesson renews automatically on February 18
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row_03">
                        <button href="" class="btn addExtraLessonsModalOpen">
                            Add Lessons
                        </button>
                        <div class="options subscription_dropdown_options_open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0 0.00012207H4V4.00012H0V0.00012207ZM7 0.00012207H11V4.00012H7V0.00012207ZM18 0.00012207H14V4.00012H18V0.00012207Z"
                                    fill="#121117" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card_top">
                        <div class="row_01">
                            <div class="imageContainer">
                                <img src="../img/cour/3.png" alt="" />
                            </div>
                            <p class="status active">Active</p>
                        </div>
                        <div class="row_02">
                            <h1>English with David</h1>
                            <div class="balance">
                                <img src="../img/cour/icons/wallet_lg.png" alt="" />
                                <p>Balance : 1 Lessons</p>
                            </div>
                            <div class="balance revision">
                                <img src="../img/cour/icons/revision.png" alt="" />
                                <p>
                                    Subscription to 20 lesson renews automatically on February
                                    18
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row_03">
                        <a href="" class="btn">Scheule Lessons</a>
                        <div class="options subscription_dropdown_options_open">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="4" viewBox="0 0 18 4"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0 0.00012207H4V4.00012H0V0.00012207ZM7 0.00012207H11V4.00012H7V0.00012207ZM18 0.00012207H14V4.00012H18V0.00012207Z"
                                    fill="#121117" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="anotherOptions">
                    <a href="" class="anotherOptions_card">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10.9174 29.0573C11.0155 29.1355 11.1336 29.1846 11.2582 29.1987C11.3829 29.2129 11.509 29.1916 11.6221 29.1373C11.7351 29.0829 11.8306 28.9978 11.8975 28.8917C11.9644 28.7856 11.9999 28.6627 12.0001 28.5373V20.6439C11.9999 20.5185 11.9644 20.3956 11.8975 20.2895C11.8306 20.1834 11.7351 20.0982 11.6221 20.0439C11.509 19.9896 11.3829 19.9683 11.2582 19.9825C11.1336 19.9966 11.0155 20.0456 10.9174 20.1239L5.9841 24.0706C5.90624 24.1331 5.8434 24.2122 5.80022 24.3022C5.75704 24.3922 5.73462 24.4908 5.73462 24.5906C5.73462 24.6904 5.75704 24.789 5.80022 24.879C5.8434 24.969 5.90624 25.0481 5.9841 25.1106L10.9174 29.0573ZM21.0828 4.12393C20.9847 4.04565 20.8666 3.99662 20.742 3.98247C20.6173 3.96831 20.4912 3.98962 20.3781 4.04393C20.2651 4.09824 20.1696 4.18336 20.1027 4.28949C20.0358 4.39563 20.0003 4.51848 20.0001 4.64393V12.5373C20.0003 12.6627 20.0358 12.7856 20.1027 12.8917C20.1696 12.9978 20.2651 13.0829 20.3781 13.1373C20.4912 13.1916 20.6173 13.2129 20.742 13.1987C20.8666 13.1846 20.9847 13.1355 21.0828 13.0573L26.0161 9.1106C26.094 9.04813 26.1568 8.96897 26.2 8.87897C26.2432 8.78897 26.2656 8.69042 26.2656 8.5906C26.2656 8.49077 26.2432 8.39222 26.2 8.30222C26.1568 8.21222 26.094 8.13306 26.0161 8.0706L21.0828 4.12393Z"
                                fill="black" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M24 8.5906C24 8.23697 23.8596 7.89784 23.6095 7.64779C23.3595 7.39774 23.0203 7.25726 22.6667 7.25726H10.6667C9.33168 7.25696 8.01779 7.59078 6.8448 8.22828C5.6718 8.86578 4.677 9.7867 3.95104 10.9071C3.22509 12.0275 2.79107 13.3118 2.68855 14.6429C2.58602 15.974 2.81824 17.3096 3.36405 18.5279C3.51047 18.8478 3.77738 19.0968 4.10661 19.2208C4.43585 19.3447 4.80072 19.3336 5.12174 19.1897C5.44276 19.0458 5.69391 18.7809 5.82046 18.4526C5.94702 18.1244 5.93872 17.7594 5.79738 17.4373C5.43358 16.625 5.27884 15.7345 5.34729 14.8471C5.41573 13.9597 5.70517 13.1036 6.18923 12.3567C6.67329 11.6098 7.33658 10.9959 8.11864 10.571C8.9007 10.1461 9.77667 9.92362 10.6667 9.92393H22.6667C23.0203 9.92393 23.3595 9.78345 23.6095 9.53341C23.8596 9.28336 24 8.94422 24 8.5906ZM8.00005 24.5906C8.00005 24.9442 8.14052 25.2834 8.39057 25.5334C8.64062 25.7835 8.97976 25.9239 9.33338 25.9239H21.3334C22.6684 25.9242 23.9823 25.5904 25.1553 24.9529C26.3283 24.3154 27.3231 23.3945 28.0491 22.2741C28.775 21.1537 29.209 19.8694 29.3115 18.5383C29.4141 17.2072 29.1819 15.8716 28.636 14.6533C28.4896 14.3334 28.2227 14.0844 27.8935 13.9604C27.5642 13.8365 27.1994 13.8476 26.8784 13.9915C26.5573 14.1354 26.3062 14.4003 26.1796 14.7286C26.0531 15.0568 26.0614 15.4218 26.2027 15.7439C26.5665 16.5562 26.7213 17.4467 26.6528 18.3341C26.5844 19.2215 26.2949 20.0776 25.8109 20.8245C25.3268 21.5714 24.6635 22.1853 23.8815 22.6102C23.0994 23.0351 22.2234 23.2576 21.3334 23.2573H9.33338C8.97976 23.2573 8.64062 23.3977 8.39057 23.6478C8.14052 23.8978 8.00005 24.237 8.00005 24.5906Z"
                                fill="black" />
                        </svg>

                        <p>Transfer Lesson or Subscription</p>
                    </a>
                    <a href="" class="anotherOptions_card">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                            <path
                                d="M28.8701 27.2282L23.7441 22.1022C25.3072 20.0644 26.153 17.5671 26.1498 14.9989C26.1498 11.8613 24.928 8.91266 22.7096 6.69425C21.6216 5.60018 20.3274 4.73278 18.9019 4.14226C17.4764 3.55174 15.9479 3.24983 14.405 3.25401C11.2682 3.25401 8.31955 4.47584 6.10035 6.69425C1.52205 11.2733 1.52205 18.7244 6.10035 23.3035C7.18832 24.3976 8.48253 25.265 9.90803 25.8556C11.3335 26.4461 12.862 26.748 14.405 26.7437C17.0083 26.7437 19.4748 25.891 21.5091 24.3372L26.6351 29.464C26.9433 29.7722 27.348 29.9271 27.7526 29.9271C28.1572 29.9271 28.5619 29.7722 28.8701 29.464C29.017 29.3172 29.1334 29.143 29.2129 28.9511C29.2924 28.7593 29.3333 28.5537 29.3333 28.3461C29.3333 28.1385 29.2924 27.9329 29.2129 27.7411C29.1334 27.5493 29.017 27.375 28.8701 27.2282ZM8.33615 21.0685C4.98916 17.7215 4.98995 12.2762 8.33615 8.92926C9.13149 8.12992 10.0774 7.49623 11.1193 7.06484C12.1611 6.63346 13.2782 6.41295 14.4058 6.41606C15.5333 6.41296 16.6502 6.63349 17.6919 7.06487C18.7336 7.49626 19.6794 8.12995 20.4746 8.92926C21.2741 9.72449 21.908 10.6704 22.3396 11.7123C22.7711 12.7541 22.9917 13.8712 22.9886 14.9989C22.9886 17.2916 22.0955 19.4468 20.4746 21.0685C18.8537 22.6902 16.6985 23.5817 14.405 23.5817C12.1131 23.5817 9.95708 22.6886 8.33536 21.0685H8.33615Z"
                                fill="black" />
                        </svg>

                        <p>Find Another Tutor</p>
                    </a>
                </div>
            </div>
        </section>
        <section class="subscriptions groupSubscription">
            <div class="topPart">
                <h1>Group Subscription</h1>
                <a href="">Manage</a>
            </div>
            <div class="bottomPart">
                <div class="card">
                    <div class="card-top">
                        <div class="tag">
                            <img src="../img/group-section/1.png" alt="" />
                        </div>
                        <div class="level-and-status">
                            <div class="level-status">
                                <div class="level green">A1-Level 1</div>
                                <div class="status">Active</div>
                            </div>

                            <div class="teacher-info">
                                <div class="teacher01">
                                    <span>Main Teacher</span>
                                    <h4>Daniela Canelon</h4>
                                </div>
                                <div class="verticalLine"></div>
                                <div class="teacher02">
                                    <span>Practice Teacher</span>
                                    <h4>Karen V.</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="title-desc">
                        <h1>English Group Classes (Florida 1)</h1>
                        <p>
                            Conversational English for Beginners" refers to learning and
                            practicing the essential skills needed to engage in basic
                            English conversations.
                        </p>
                    </div>

                    <div class="schedule">
                        <div class="day active">
                            <label>Mon</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                        <div class="day">
                            <label>Tue</label>
                            <div class="horizontalLine"></div>
                        </div>
                        <div class="day active">
                            <label>Wed</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                        <div class="day">
                            <label>Thu</label>
                            <div class="horizontalLine"></div>
                        </div>
                        <div class="day active">
                            <label>Fri</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                    </div>

                    <button class="btn manage_options">Manage</button>
                </div>

                <div class="card">
                    <div class="card-top">
                        <div class="tag">
                            <img src="../img/group-section/2.png" alt="" />
                        </div>
                        <div class="level-and-status">
                            <div class="level-status">
                                <div class="level purple">B1-Level 5</div>
                                <div class="status">Not Started</div>
                            </div>

                            <div class="teacher-info">
                                <div class="teacher01">
                                    <span>Main Teacher</span>
                                    <h4>Wade Warren</h4>
                                </div>
                                <div class="verticalLine"></div>
                                <div class="teacher02">
                                    <span>Practice Teacher</span>
                                    <h4>David</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="title-desc">
                        <h1>English Group Classes (NewYork)</h1>
                        <p>
                            Conversational English for Intermediate" refers to learning and
                            practicing the essential skills needed to engage in Higher
                            English conversations.
                        </p>
                    </div>

                    <div class="schedule">
                        <div class="day active">
                            <label>Mon</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                        <div class="day">
                            <label>Tue</label>
                            <div class="horizontalLine"></div>
                        </div>
                        <div class="day">
                            <label>Wed</label>
                            <div class="horizontalLine"></div>
                        </div>
                        <div class="day active">
                            <label>Thu</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                        <div class="day active">
                            <label>Fri</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                    </div>

                    <button class="btn btn subscribe subscribe-modal-open">Change to this group</button>
                </div>

                <div class="card">
                    <div class="card-top">
                        <div class="tag">
                            <img src="../img/group-section/3.png" alt="" />
                        </div>
                        <div class="level-and-status">
                            <div class="level-status">
                                <div class="level purple">B1-Level 5</div>
                                <div class="status">Not Started</div>
                            </div>

                            <div class="teacher-info">
                                <div class="teacher01">
                                    <span>Main Teacher</span>
                                    <h4>Wade Warren</h4>
                                </div>
                                <div class="verticalLine"></div>
                                <div class="teacher02">
                                    <span>Practice Teacher</span>
                                    <h4>David</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="title-desc">
                        <h1>English Group Classes (Texas)</h1>
                        <p>
                            Conversational English for Intermediate" refers to learning and
                            practicing the essential skills needed to engage in Higher
                            English conversations.
                        </p>
                    </div>

                    <div class="schedule">
                        <div class="day active">
                            <label>Mon</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                        <div class="day">
                            <label>Tue</label>
                            <div class="horizontalLine"></div>
                        </div>
                        <div class="day">
                            <label>Wed</label>
                            <div class="horizontalLine"></div>
                        </div>
                        <div class="day active">
                            <label>Thu</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                        <div class="day active">
                            <label>Fri</label>
                            <div class="horizontalLine"></div>
                            <div class="time">5:40 am</div>
                        </div>
                    </div>

                    <button class="btn subscribe subscribe-modal-open">Subscribe</button>
                </div>

                <div class="anotherOptions">
                    <a href="" class="anotherOptions_card">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="33" viewBox="0 0 32 33" fill="none">
                            <path
                                d="M28.8701 27.2282L23.7441 22.1022C25.3072 20.0644 26.153 17.5671 26.1498 14.9989C26.1498 11.8613 24.928 8.91266 22.7096 6.69425C21.6216 5.60018 20.3274 4.73278 18.9019 4.14226C17.4764 3.55174 15.9479 3.24983 14.405 3.25401C11.2682 3.25401 8.31955 4.47584 6.10035 6.69425C1.52205 11.2733 1.52205 18.7244 6.10035 23.3035C7.18832 24.3976 8.48253 25.265 9.90803 25.8556C11.3335 26.4461 12.862 26.748 14.405 26.7437C17.0083 26.7437 19.4748 25.891 21.5091 24.3372L26.6351 29.464C26.9433 29.7722 27.348 29.9271 27.7526 29.9271C28.1572 29.9271 28.5619 29.7722 28.8701 29.464C29.017 29.3172 29.1334 29.143 29.2129 28.9511C29.2924 28.7593 29.3333 28.5537 29.3333 28.3461C29.3333 28.1385 29.2924 27.9329 29.2129 27.7411C29.1334 27.5493 29.017 27.375 28.8701 27.2282ZM8.33615 21.0685C4.98916 17.7215 4.98995 12.2762 8.33615 8.92926C9.13149 8.12992 10.0774 7.49623 11.1193 7.06484C12.1611 6.63346 13.2782 6.41295 14.4058 6.41606C15.5333 6.41296 16.6502 6.63349 17.6919 7.06487C18.7336 7.49626 19.6794 8.12995 20.4746 8.92926C21.2741 9.72449 21.908 10.6704 22.3396 11.7123C22.7711 12.7541 22.9917 13.8712 22.9886 14.9989C22.9886 17.2916 22.0955 19.4468 20.4746 21.0685C18.8537 22.6902 16.6985 23.5817 14.405 23.5817C12.1131 23.5817 9.95708 22.6886 8.33536 21.0685H8.33615Z"
                                fill="black" />
                        </svg>

                        <p>Find Another Group</p>
                    </a>
                </div>
            </div>
        </section>
    </div>



    <!-- Share Tutor -->
    <!-- =========== -->
    <section class="shareTutor">
        <div class="shareTutor_close_icon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <h1 class="heading">Share this tutor</h1>

        <div class="row01">
            <div class="col01">
                <img src="../img/cour/1.png" alt="" />
            </div>

            <div class="col02">
                <div class="r">
                    <h1>Dinella</h1>

                    <div class="rating">
                        <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9 0L11.221 5.942L17.559 6.219L12.594 10.169L14.29 16.281L9 12.78L3.71 16.281L5.405 10.168L0.440002 6.218L6.778 5.942L9 0Z"
                                fill="#121117" />
                        </svg>
                        <h1>5</h1>
                    </div>

                    <p>(28 reviews)</p>
                </div>

                <div class="r_1">
                    <div class="verified">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.56 8.73908L18.2 7.15908C17.94 6.85908 17.73 6.29908 17.73 5.89908V4.19908C17.73 3.13908 16.86 2.26908 15.8 2.26908H14.1C13.71 2.26908 13.14 2.05908 12.84 1.79908L11.26 0.439082C10.57 -0.150918 9.44001 -0.150918 8.74001 0.439082L7.17001 1.80908C6.87001 2.05908 6.30001 2.26908 5.91001 2.26908H4.18001C3.12001 2.26908 2.25001 3.13908 2.25001 4.19908V5.90908C2.25001 6.29908 2.04 6.85908 1.79 7.15908L0.440005 8.74908C-0.139995 9.43908 -0.139995 10.5591 0.440005 11.2491L1.79 12.8391C2.04 13.1391 2.25001 13.6991 2.25001 14.0891V15.7991C2.25001 16.8591 3.12001 17.7291 4.18001 17.7291H5.91001C6.30001 17.7291 6.87001 17.9391 7.17001 18.1991L8.75001 19.5591C9.44001 20.1491 10.57 20.1491 11.27 19.5591L12.85 18.1991C13.15 17.9391 13.71 17.7291 14.11 17.7291H15.81C16.87 17.7291 17.74 16.8591 17.74 15.7991V14.0991C17.74 13.7091 17.95 13.1391 18.21 12.8391L19.57 11.2591C20.15 10.5691 20.15 9.42908 19.56 8.73908ZM14.16 8.10908L9.33001 12.9391C9.18938 13.0795 8.99876 13.1584 8.80001 13.1584C8.60126 13.1584 8.41063 13.0795 8.27001 12.9391L5.85001 10.5191C5.56001 10.2291 5.56001 9.74908 5.85001 9.45908C6.14001 9.16908 6.62001 9.16908 6.91001 9.45908L8.80001 11.3491L13.1 7.04908C13.39 6.75908 13.87 6.75908 14.16 7.04908C14.45 7.33908 14.45 7.81908 14.16 8.10908Z"
                                fill="black" />
                        </svg>
                        <p>Verified</p>
                    </div>

                    <div class="professional">
                        <svg width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M23.4003 6.30357C23.4023 6.72553 23.2819 7.13902 23.0537 7.49396C22.8255 7.84891 22.4993 8.1301 22.1147 8.30349L19.5575 9.46077L18.129 10.1035L14.0718 11.9465C13.4253 12.2476 12.7207 12.4036 12.0075 12.4036C11.2943 12.4036 10.5898 12.2476 9.94329 11.9465L5.87193 10.1035L4.44345 9.46077L3.01497 8.80365V14.9748C3.11638 15.0384 3.1998 15.127 3.25731 15.232C3.31482 15.3371 3.34451 15.455 3.34353 15.5748V17.0462C3.34446 17.1403 3.32663 17.2336 3.29106 17.3206C3.2555 17.4077 3.20292 17.4868 3.13641 17.5533C3.0699 17.6198 2.99079 17.6724 2.90372 17.708C2.81664 17.7435 2.72335 17.7614 2.62929 17.7605H1.97217C1.8781 17.7614 1.78478 17.7436 1.69768 17.7081C1.61057 17.6725 1.53144 17.6199 1.4649 17.5534C1.39837 17.4869 1.34577 17.4078 1.31019 17.3207C1.27461 17.2336 1.25676 17.1403 1.25769 17.0462V15.575C1.25677 15.4553 1.2865 15.3373 1.34405 15.2322C1.4016 15.1272 1.48506 15.0387 1.58649 14.975V8.40333C1.5855 8.32042 1.59999 8.23805 1.62921 8.16045C1.29233 7.94979 1.01913 7.65143 0.838872 7.29734C0.658618 6.94326 0.578111 6.5468 0.605979 6.15045C0.633847 5.75411 0.769041 5.37281 0.99707 5.04743C1.2251 4.72206 1.53737 4.46486 1.90041 4.30341L9.94353 0.660693C11.2544 0.0606934 12.7611 0.0606934 14.072 0.660693L22.1149 4.30365C22.4996 4.47707 22.8257 4.75827 23.0539 5.11321C23.2821 5.46815 23.4023 5.88162 23.4003 6.30357ZM14.6576 13.2463C13.8275 13.6321 12.9231 13.832 12.0077 13.832C11.0922 13.832 10.1878 13.6321 9.35769 13.2463L4.44345 11.0321V12.8606C4.44501 13.4098 4.57193 13.9513 4.81454 14.444C5.05715 14.9366 5.40903 15.3674 5.84337 15.7034C9.48249 18.4843 14.5328 18.4843 18.1719 15.7034C18.6044 15.3666 18.9541 14.9354 19.1942 14.4426C19.4344 13.9499 19.5586 13.4088 19.5575 12.8606V11.0179L18.7146 11.4036L14.6576 13.2463Z"
                                fill="black" />
                        </svg>
                        <p>Professional</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row02">
            <div class="link">
                <p id="copyLinkText">https://latingles.com/Dinela26121264</p>
                <img src="../img/cour/icons/copy.png" alt="" class="copyLinkBTN" />
            </div>

            <button class="copyLinkBTN">Copy link</button>
        </div>

        <div class="socialLinks">
            <a href="">
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.333 2H2.667L9 6.75L15.333 2ZM2 4V12H16V4L9.6 8.8L9 9.25L8.4 8.8L2 4ZM0 0H18V14H0V0Z"
                        fill="#121117" />
                </svg>
                <span>Email</span>
            </a>

            <a href="">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.303 2.61603C14.4768 1.78426 13.4937 1.12473 12.4107 0.675678C11.3277 0.226625 10.1664 -0.00302758 8.994 3.01367e-05C4.078 3.01367e-05 0.0769999 4.00003 0.0739999 8.91903C0.0720007 10.4842 0.482814 12.0223 1.265 13.378L0 18L4.728 16.76C6.03594 17.4724 7.50164 17.8455 8.991 17.845H8.994C13.91 17.845 17.912 13.844 17.914 8.92603C17.9178 7.75393 17.689 6.59272 17.241 5.50961C16.793 4.42651 16.1346 3.443 15.304 2.61603H15.303ZM8.994 16.339H8.991C7.66347 16.3392 6.36032 15.9824 5.218 15.306L4.948 15.145L2.141 15.881L2.891 13.145L2.714 12.865C1.97142 11.683 1.57861 10.3149 1.581 8.91903C1.582 4.83203 4.908 1.50603 8.998 1.50603C10.978 1.50703 12.838 2.27903 14.238 3.68103C14.9284 4.36827 15.4757 5.18559 15.8482 6.08572C16.2206 6.98584 16.4109 7.95089 16.408 8.92503C16.406 13.013 13.08 16.338 8.994 16.338V16.339ZM13.061 10.787C12.838 10.675 11.742 10.137 11.538 10.062C11.333 9.98803 11.185 9.95003 11.037 10.174C10.888 10.397 10.461 10.899 10.331 11.047C10.201 11.197 10.071 11.214 9.848 11.103C9.625 10.991 8.908 10.756 8.056 9.99703C7.393 9.40603 6.946 8.67703 6.816 8.45303C6.686 8.23003 6.802 8.10903 6.913 7.99803C7.013 7.89803 7.136 7.73803 7.248 7.60803C7.36 7.47803 7.396 7.38503 7.471 7.23603C7.545 7.08703 7.508 6.95703 7.452 6.84603C7.397 6.73403 6.951 5.63703 6.765 5.19103C6.584 4.75703 6.4 4.81603 6.264 4.80803C6.12141 4.8023 5.9787 4.79997 5.836 4.80103C5.72309 4.80401 5.61203 4.83033 5.50979 4.87835C5.40756 4.92637 5.31638 4.99504 5.242 5.08003C5.038 5.30303 4.462 5.84203 4.462 6.93903C4.462 8.03503 5.26 9.09503 5.372 9.24403C5.484 9.39403 6.944 11.644 9.179 12.61C9.711 12.84 10.126 12.977 10.449 13.08C10.984 13.249 11.469 13.225 11.853 13.168C12.282 13.104 13.172 12.628 13.358 12.108C13.543 11.588 13.543 11.141 13.488 11.048C13.432 10.955 13.283 10.899 13.06 10.788V10.787H13.061Z"
                        fill="#121117" />
                </svg>

                <span>WhatsApp</span>
            </a>

            <a href="">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M14.546 0H1.455C0.65 0 0 0.65 0 1.455V14.545C0 15.35 0.65 16 1.455 16H14.545C15.35 16 16 15.35 16 14.546V1.455C16 0.65 15.35 0 14.546 0ZM5.057 13.09H2.912V6.188H5.057V13.09ZM3.963 5.2C3.63135 5.2 3.31328 5.06825 3.07876 4.83374C2.84425 4.59922 2.7125 4.28115 2.7125 3.9495C2.7125 3.61785 2.84425 3.29978 3.07876 3.06526C3.31328 2.83075 3.63135 2.699 3.963 2.699C4.29479 2.699 4.61298 2.8308 4.84759 3.06541C5.0822 3.30002 5.214 3.61821 5.214 3.95C5.214 4.28179 5.0822 4.59998 4.84759 4.83459C4.61298 5.0692 4.29479 5.201 3.963 5.201M13.093 13.091H10.95V9.735C10.95 8.935 10.935 7.905 9.835 7.905C8.718 7.905 8.547 8.776 8.547 9.677V13.092H6.403V6.189H8.461V7.132H8.491C8.777 6.589 9.476 6.017 10.52 6.017C12.692 6.017 13.094 7.447 13.094 9.306L13.093 13.091Z"
                        fill="#121117" />
                </svg>

                <span>LinkedIn</span>
            </a>

            <a href="">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.482 7.622L17.04 0H15.486L9.793 6.618L5.245 0H0L6.876 10.007L0 18H1.554L7.566 11.011L12.368 18H17.613L10.482 7.622ZM8.354 10.096L7.657 9.099L2.114 1.169H4.5L8.974 7.569L9.671 8.565L15.486 16.884H13.099L8.354 10.096Z"
                        fill="#121117" />
                </svg>

                <span>X (Twitter)</span>
            </a>
        </div>
    </section>

    <!-- Reshedule Lesson -->
    <!-- ================ -->
    <section class="resheduleLesson resheduleLesson_popup">
        <div class="goBack">
            <img src="../img/cour/icons/Goback.png" alt="" />
        </div>

        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <h1 class="heading">Reshedule lesson</h1>

        <div class="row01">
            <p>Current Lesson</p>
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/1.png" alt="" />
                    </div>
                    <div class="container">
                        <h5>Today</h5>
                        <h1>Monday, Dec 9, 09:30 - 10:20</h1>
                        <p>Weekly English with Dinella</p>
                    </div>
                </div>

                <div class="totalLesson">
                    <img src="../img/cour/icons/wallet.png" alt="" />
                    <p>0 lessons</p>
                </div>
            </div>
        </div>

        <div class="newDateAndTime">
            <p>New date and time</p>

            <div class="dropdown time_dropdown">
                <div class="dropdown-button">
                    <p>25 minutes</p>
                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.7004 1.32082C13.5918 1.1849 13.4575 1.07171 13.3051 0.987713C13.1527 0.903714 12.9853 0.850552 12.8124 0.831262C12.6395 0.811973 12.4645 0.826934 12.2973 0.875291C12.1302 0.923648 11.9742 1.00445 11.8383 1.11309L7.36694 4.68998L2.89451 1.11309C2.75941 0.998034 2.60257 0.911288 2.43331 0.858005C2.26404 0.804722 2.0858 0.785989 1.90915 0.802917C1.73251 0.819845 1.56106 0.872088 1.405 0.956548C1.24893 1.04101 1.11143 1.15596 1.00064 1.29459C0.889854 1.43321 0.808048 1.59268 0.760078 1.76353C0.712107 1.93437 0.69895 2.11312 0.721386 2.28915C0.743823 2.46518 0.801396 2.6349 0.890689 2.78826C0.979981 2.94161 1.09917 3.07546 1.24119 3.18186L6.54028 7.42113C6.77503 7.60859 7.06653 7.7107 7.36694 7.7107C7.66735 7.7107 7.95885 7.60859 8.1936 7.42113L13.4927 3.18186C13.6286 3.07324 13.7418 2.93891 13.8258 2.78654C13.9098 2.63417 13.963 2.46675 13.9822 2.29383C14.0015 2.12092 13.9866 1.9459 13.9382 1.77876C13.8899 1.61163 13.8091 1.45566 13.7004 1.31976V1.32082Z"
                            fill="#121117" />
                    </svg>
                </div>
                <div class="dropdown-menu">
                    <div class="dropdown-item">25 minutes</div>
                    <div class="dropdown-item">20 Minutes</div>
                    <div class="dropdown-item">50 Minutes</div>
                    <div class="dropdown-item">1 Hour</div>
                    <div class="dropdown-item">1.5 Hour</div>
                    <div class="dropdown-item">2 Hours</div>
                </div>
            </div>

            <div class="row02">
                <div class="date calendarOpen">
                    <p id="selectedData">Monday, Dec 9</p>
                    <svg width="8" height="4" viewBox="0 0 8 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.08934 3.89511C3.89586 4.04591 3.62463 4.04591 3.43115 3.89511L0.352673 1.49567C-0.0491378 1.18249 0.172324 0.538106 0.68177 0.538106L6.83872 0.538107C7.34817 0.538107 7.56963 1.18249 7.16782 1.49567L4.08934 3.89511Z"
                            fill="black" />
                    </svg>
                </div>

                <div class="dropdown limitedTime">
                    <div class="dropdown-button">
                        <p>10:30</p>
                        <svg width="8" height="4" viewBox="0 0 8 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.08934 3.89511C3.89586 4.04591 3.62463 4.04591 3.43115 3.89511L0.352673 1.49567C-0.0491378 1.18249 0.172324 0.538106 0.68177 0.538106L6.83872 0.538107C7.34817 0.538107 7.56963 1.18249 7.16782 1.49567L4.08934 3.89511Z"
                                fill="black" />
                        </svg>
                    </div>
                    <div class="dropdown-menu">
                        <div class="dropdown-item">05:00</div>
                        <div class="dropdown-item">05:30</div>
                        <div class="dropdown-item">06:00</div>
                        <div class="dropdown-item">06:30</div>
                        <div class="dropdown-item">07:00</div>
                    </div>
                </div>
            </div>
        </div>

        <button class="secondLayerBackdropClose">Continue</button>
    </section>

    <!-- Change your plan with Ranim A. -->
    <!-- ============================== -->
    <section class="change_your_plane change_your_plane_popup">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="row01">
            <div class="imageContainer">
                <img src="../img/cour/1.png" alt="" />
            </div>

            <h1>Change your plan with Ranim A.</h1>
        </div>
        <div class="row02">
            <div class="currentPlane">
                <p>Current plan</p>
            </div>

            <h4>4 lessons per week</h4>
            <p>16 lessons · $86 every 4 weeks</p>
        </div>
        <div class="row03 changePlaneBox">
            <div class="leftSide">
                <h4>5 lessons per week</h4>
                <p>20 lessons · $108 every 4 weeks</p>
            </div>
            <div class="rightSide">
                <div class="center_box"></div>
            </div>
        </div>
        <div class="row04">
            <p>Prices are for our standard lesson time of 50 min</p>
            <button class="btnToContinueChangePlane">Continue</button>
        </div>
    </section>

    <!-- Upgrade now? -->
    <!-- ============ -->
    <section class="upgradeNow upgradeNow_popup">
        <div class="backArrow">
            <img src="../img/cour/icons/Goback.png" alt="" />
        </div>

        <div class="closeIcon secondLayerBackdropCloses">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="top">
            <h1>Upgrade now?</h1>
            <p>
                You can activate your new plan immediately or wait until your billing
                cycle renews on December 10
            </p>
        </div>

        <div class="bottom">
            <div class="card review_your_changes_popupOpen">
                <div class="left">
                    <img src="../img/cour/icons/process.png" alt="" />

                    <div class="content">
                        <div class="tag">
                            <p>Recommended</p>
                        </div>

                        <h1>Proceed with the upgrade now</h1>
                        <p>Start your new plan today with a payment.</p>
                    </div>
                </div>

                <img src="../img/cour/icons/leftArrow.png" alt="" />
            </div>
            <div class="divider"></div>
            <div class="card great_popup_open">
                <div class="left">
                    <img src="../img/cour/icons/calander_red.png" alt="" />

                    <div class="content">
                        <h1>Wait to upgrade on December 10</h1>
                        <p>
                            Your new plan will begin, and payment will be processed on
                            December 10.
                        </p>
                    </div>
                </div>

                <img src="../img/cour/icons/leftArrow.png" alt="" />
            </div>
        </div>
    </section>

    <!-- Review your changes -->
    <!-- =================== -->
    <section class="review_your_changes review_your_changes_popup">
        <div class="backArrow">
            <img src="../img/cour/icons/Goback.png" alt="" />
        </div>

        <div class="closeIcon secondLayerBackdropCloses">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="review_your_changes_row01">
            <div class="imageContainer">
                <img src="../img/cour/1.png" alt="" />
            </div>
            <h1>Review your changes</h1>
        </div>

        <div class="review_your_changes_row02">
            <div class="row01">
                <h4>4 lessons per week</h4>
                <p>16 lessons · $86 every 4 weeks</p>
            </div>

            <img src="../img/cour/icons/bottomArrow.png" alt="" />

            <div class="row01">
                <h4>5 lessons per week</h4>
                <p>20 lessons · $108 every 4 weeks</p>
            </div>
        </div>

        <div class="review_your_changes_row03">
            <img src="../img/cour/icons/wallet.png" alt="" />
            <p>
                You’ll keep all remaining lessons from your current plan. Schedule
                them before <span>Dec 10</span>.
            </p>
        </div>

        <a href="" class="continueBtn">Continue to checkout</a>
    </section>

    <!-- Great! We’ve confirmed your upgrade. -->
    <!-- ==================================== -->
    <section class="great_popup">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="top">
            <div class="highlighted">
                <h1>5</h1>
            </div>
            <h1>Great! We’ve confirmed your upgrade.</h1>
        </div>

        <div class="bottom">
            <p>
                Starting Dec 10, your plan with Ranim A. will change to 5 lessons per
                week. Keep up the good work!
            </p>

            <button class="secondLayerBackdropClose">Okay, thanks!</button>
        </div>
    </section>

    <!-- Cancel lesson -->
    <!-- ============= -->
    <section class="cancel_lesson_popup">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="top">
            <div class="imageContainer">
                <img src="../img/cour/1.png" alt="" />
            </div>

            <div class="row01">
                <h1>Cancel lesson</h1>
                <p>Wednesday, November 20, 15:00-15:50</p>
            </div>

            <div class="policy">
                <img src="../img/cour/icons/policy.png" alt="" />

                <div class="policy_col01">
                    <p>Cancellation policy</p>
                    <p>
                        When you cancel with less than 12 hours notice, the lesson will be
                        deducted from your balance
                    </p>
                </div>
            </div>
        </div>

        <form action="">
            <div class="row">
                <p>Please choose a reason for canceling</p>

                <div class="dropdown reasonOption">
                    <div class="dropdown-button">
                        <p>Select a reason</p>
                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.7004 1.32082C13.5918 1.1849 13.4575 1.07171 13.3051 0.987713C13.1527 0.903714 12.9853 0.850552 12.8124 0.831262C12.6395 0.811973 12.4645 0.826934 12.2973 0.875291C12.1302 0.923648 11.9742 1.00445 11.8383 1.11309L7.36694 4.68998L2.89451 1.11309C2.75941 0.998034 2.60257 0.911288 2.43331 0.858005C2.26404 0.804722 2.0858 0.785989 1.90915 0.802917C1.73251 0.819845 1.56106 0.872088 1.405 0.956548C1.24893 1.04101 1.11143 1.15596 1.00064 1.29459C0.889854 1.43321 0.808048 1.59268 0.760078 1.76353C0.712107 1.93437 0.69895 2.11312 0.721386 2.28915C0.743823 2.46518 0.801396 2.6349 0.890689 2.78826C0.979981 2.94161 1.09917 3.07546 1.24119 3.18186L6.54028 7.42113C6.77503 7.60859 7.06653 7.7107 7.36694 7.7107C7.66735 7.7107 7.95885 7.60859 8.1936 7.42113L13.4927 3.18186C13.6286 3.07324 13.7418 2.93891 13.8258 2.78654C13.9098 2.63417 13.963 2.46675 13.9822 2.29383C14.0015 2.12092 13.9866 1.9459 13.9382 1.77876C13.8899 1.61163 13.8091 1.45566 13.7004 1.31976V1.32082Z"
                                fill="#121117" />
                        </svg>
                    </div>
                    <div class="dropdown-menu">
                        <div class="dropdown-item">Select a reason 1</div>
                        <div class="dropdown-item">Select a reason 2</div>
                        <div class="dropdown-item">Select a reason 3</div>
                        <div class="dropdown-item">Select a reason 4</div>
                        <div class="dropdown-item">Select a reason 5</div>
                        <div class="dropdown-item">Select a reason 6</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <label for="reason">Message for Dinela • Optional</label>
                <textarea name="reason" id="reason" placeholder="I need to cancel because..."></textarea>
            </div>
            <div class="buttons">
                <button type="submit">Reschedule Instead</button>
                <button type="submit">Confirm cancellation</button>
            </div>

        </form>
    </section>

    <!-- Message Toaster -->
    <div class="toaster notActive">
        <div class="correct"></div>
        <p>Successfully toasted!</p>
    </div>

    <!-- Calander -->
    <!-- ========= -->
    <div class="calendar-modal" id="calendarModal">
        <div class="calendar-container">
            <div class="calendar-header">
                <h2>Select Date</h2>
                <button class="close-btn" id="closeBtn">✖</button>
            </div>
            <input type="text" id="datePicker" name="datePicker" placeholder="Select a date" />
            <button class="confirm-btn">Confirm</button>
        </div>
    </div>

    <!-- Which tutor? -->
    <!-- ============ -->
    <div class="whichTutor">
        <div class="whichTutor_close_icon firstLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <h1>Which tutor?</h1>

        <div class="tutors">
            <a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/1.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Dinela</h1>
                            <p>6 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a>
            <a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/2.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Wade Warren</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a>
            <a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/3.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Albert Flores</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a>
            <a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/4.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Daniel A.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a>
            <a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/5.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Javier G.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/6.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>David H.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a>
            <a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/7.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Marbe B.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/8.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Andrew S.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/7.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Marbe B.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/8.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Andrew S.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/1.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Dinela</h1>
                            <p>6 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/2.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Wade Warren</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/3.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Albert Flores</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/4.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Daniel A.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/5.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Javier G.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/6.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>David H.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/7.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Marbe B.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/8.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Andrew S.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/7.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Marbe B.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a><a href="/courses/local/customplugin/my_lessons_details_reshedule.php">
                <div class="tutor_card">
                    <div class="tutor_card_leftSide">
                        <div class="imageContainer">
                            <img src="../img/cour/8.png" alt="" />
                        </div>
                        <div class="content">
                            <h1>Andrew S.</h1>
                            <p>0 lessons to schedule</p>
                        </div>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="12" viewBox="0 0 7 12" fill="none"
                        class="tutor_card_rightArrow">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.195225 0.195191C0.0702444 0.320209 3.40715e-05 0.489748 3.40715e-05 0.666524C3.40715e-05 0.8433 0.0702444 1.01284 0.195225 1.13786L5.05723 5.99986L0.195225 10.8619C0.131552 10.9234 0.0807631 10.9969 0.0458238 11.0783C0.0108845 11.1596 -0.0075064 11.2471 -0.00827561 11.3356C-0.00904482 11.4241 0.00782347 11.5119 0.0413441 11.5938C0.0748647 11.6758 0.124367 11.7502 0.186962 11.8128C0.249557 11.8754 0.323991 11.9249 0.405922 11.9584C0.487853 11.9919 0.575639 12.0088 0.664159 12.008C0.752678 12.0073 0.840159 11.9889 0.921495 11.9539C1.00283 11.919 1.07639 11.8682 1.13789 11.8045L6.47123 6.47119C6.59621 6.34617 6.66642 6.17663 6.66642 5.99986C6.66642 5.82308 6.59621 5.65354 6.47123 5.52852L1.13789 0.195191C1.01287 0.0702102 0.843334 0 0.666558 0C0.489782 0 0.320244 0.0702102 0.195225 0.195191Z"
                            fill="#6A697C" />
                    </svg>
                </div>
            </a>
        </div>
    </div>



    <!-- User Options -->
    <!-- ============ -->
    <div class="options userOptions">
        <a href="" class="option">
            <img src="../img/cour/icons/message.png" alt="" />
            <p>Message Tutor</p>
        </a>
        <div class="option shareTutorOpen">
            <img src="../img/cour/icons/share.png" alt="" />
            <p>Share Tutor</p>
        </div>
        <a href="" class="option">
            <img src="../img/cour/icons/User.png" alt="" />
            <p>See Tutor Profile</p>
        </a>
        <a href="/courses/local/customplugin/my_lessons_details_reshedule.php" class="option">
            <img src="../img/cour/icons/calander.png" alt="" />
            <p>Reshedule</p>
        </a>
        <div href="" class="option cancel_popup_open">
            <img src="../img/cour/icons/cancel.png" alt="" />
            <p>Cancel</p>
        </div>
    </div>

    <!-- Subcribtion options -->
    <!-- =================== -->
    <div class="options userOptions subscription_dropdown_options">
        <a href="/courses/local/customplugin/my_lessons_details_reshedule.php" class="option">
            <img src="../img/cour/icons/calander.png" alt="" />
            <p>Schedule lessons</p>
        </a>
        <div class="option">
            <img src="../img/cour/icons/revision.png" alt="" />
            <p>Change nenewal date</p>
        </div>
        <div href="" class="option c_y_p">
            <img src="../img/cour/icons/dollar.png" alt="" />
            <p>Change your plan</p>
        </div>
        <div href="" class="option">
            <img src="../img/cour/icons/wallet.png" alt="" />
            <p>Add extra lessons</p>
        </div>
        <div class="option transfer-balance-or-subscription">
            <img src="../img/cour/icons/revision.png" alt="" />
            <p>Transfer lessons or subscription</p>
        </div>
        <div href="" class="option">
            <img src="../img/cour/icons/cancel.png" alt="" />
            <p>Cancel Subscription</p>
        </div>
    </div>

    <div class="options manage_userOptions subscription_dropdown_options" style="top: 1300px; left: 926.095px;">
        <a href="" class="option">
            <img src="../img/cour/icons/revision.png" alt="">
            <p>Change to a new group</p>
        </a>
        <a href="" class="option">
            <img src="../img/cour/icons/dollar.png" alt="" />
            <p>Change your plan</p>
        </a>
        <a href="" class="option">
            <img src="../img/cour/icons/revision.png" alt="">
            <p>Pause subscription</p>
        </a>


        <div href="" class="option">
            <img src="../img/cour/icons/cancel.png" alt="">
            <p>Cancel Group Subscription</p>
        </div>
    </div>




    <div class="subscribe-modal-backdrop" data-subscribe-modal>
        <div class="subscribe-modal-main">
            <button class="subscribe-modal__close" data-subscribe-close aria-label="Close">
                &times;
            </button>
            <main class="checkout-page">
                <div class="checkout-container">
                    <section class="plan-selection-panel">
                        <div class="panel-content">
                            <div class="selection-header">
                                <!--merged image-->
                                <div class="header-icon-wrapper">
                                    <img src="../img/subs/Progress-steps.png" alt="" />
                                </div>
                                <div class="selection-header-text">
                                    <h2>Time to help you succeed at work!</h2>
                                    <p>Consistency is key to progress, so we recommend a weekly schedule. Each
                                        <b>50-min</b>
                                        lesson costs <b>$9.00</b>.
                                    </p>
                                </div>
                            </div>
                            <div class="plan-options">
                                <div class="plan-option">
                                    <input type="radio" name="plan" id="plan-1" class="visually-hidden">
                                    <label for="plan-1" class="plan-label">
                                        <span class="plan-name">1 Month</span>
                                        <span class="plan-price"><b>$36.00</b> per Month</span>
                                    </label>
                                </div>
                                <div class="plan-option">
                                    <input type="radio" name="plan" id="plan-4" class="visually-hidden">
                                    <label for="plan-4" class="plan-label">
                                        <span class="plan-name">4 Months</span>
                                        <span class="plan-price"><b>$72.00</b> per 4 Month</span>
                                    </label>
                                </div>
                                <div class="plan-option">
                                    <input type="radio" name="plan" id="plan-6" class="visually-hidden" checked>
                                    <label for="plan-6" class="plan-label">
                                        <span class="plan-name">6 Months</span>
                                        <span class="plan-price"><b>$108.00</b> per 6 Month</span>

                                    </label>
                                </div>
                                <div class="plan-option">
                                    <input type="radio" name="plan" id="plan-9" class="visually-hidden">
                                    <label for="plan-9" class="plan-label">
                                        <span class="plan-name">9 Months</span>
                                        <span class="plan-price"><b>$144.00</b> per 9 Month</span>
                                    </label>
                                </div>
                                <div class="plan-option">
                                    <input type="radio" name="plan" id="plan-12" class="visually-hidden">
                                    <label for="plan-12" class="plan-label">
                                        <div class="plan-name-wrapper">
                                            <span class="plan-name">12 Months</span>
                                            <span class="popular-badge">Popular</span>
                                        </div>
                                        <span class="plan-price"><b>$180.00</b> per 12 Month</span>
                                    </label>
                                </div>
                                <div class="plan-option">
                                    <input type="radio" name="plan" id="plan-custom" class="visually-hidden">
                                    <label for="plan-custom" class="plan-label">
                                        <div class="custom-plan-text">
                                            <span class="plan-name">Custom plan</span>
                                            <p>Choose the number of <b>months</b> if that suits you better.</p>
                                        </div>
                                        <img src="../img/subs/calendar.png" alt="" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <footer class="selection-footer">
                            <button class="checkout-button">Continue to checkout</button>
                        </footer>
                    </section>

                    <div class="confirm-section">
                        <section id="intro">
                            <div class="intro-container">
                                <!--merged image-->
                                <div class="intro-icon-wrapper">
                                    <img src="../img/subs/good-choice.png" alt="icon element" />
                                </div>
                                <div class="intro-text">
                                    <h1 class="intro-heading">Good choice. Last step!</h1>
                                    <p class="intro-subheading">Enter your details to confirm your monthly subscription.
                                    </p>
                                </div>
                            </div>
                        </section>
                        <section id="order">
                            <div class="order-container">
                                <h2 class="order-title">Your order</h2>
                                <hr>
                                <div class="order-items-list">
                                    <div class="order-item">
                                        <span class="item-name">6 Months Plan</span>
                                        <span class="item-price">$108.00</span>
                                    </div>
                                    <div class="order-item">
                                        <div class="item-name-with-icon">
                                            <span class="item-name">Taxes & fees</span>
                                            <img src="../img/subs/question-mark.svg" alt="info icon" class="info-icon">
                                        </div>
                                        <span class="item-price">$12.00</span>
                                    </div>
                                    <div class="order-item">
                                        <div class="item-name-with-icon">
                                            <span class="item-name">Your latingles credit</span>
                                            <img src="../img/subs/question-mark.svg" alt="info icon" class="info-icon">
                                        </div>
                                        <span class="item-price">$20.00</span>
                                    </div>
                                </div>
                                <div class="order-total">
                                    <div class="total-row">
                                        <h3 class="total-label">Total</h3>
                                        <span class="total-amount">$120.00</span>
                                    </div>
                                    <span class="total-period">per 6 Month</span>
                                </div>
                                <!-- Promo code row (hidden until "Have a promo code?" is clicked) -->
                                <div class="promo-row" hidden>
                                    <label class="sr-only" for="promo-input">Promo code</label>
                                    <input id="promo-input" class="promo-input" type="text" inputmode="text"
                                        autocomplete="off" placeholder="Enter promo code" />
                                    <button class="promo-apply" type="button">Apply</button>
                                </div>

                                <a href="#" class="promo-link">Have a promo code?</a>
                            </div>
                        </section>
                        <section id="payment">
                            <div class="payment-container">
                                <hr>
                                <div class="payment-details">
                                    <h2 class="payment-title">Payment method</h2>
                                    <div class="payment-selector-container">
                                        <button class="payment-selector">
                                            <div class="card-details">
                                                <img src="../img/subs/visa.png" alt="Visa" alt="Visa" class="card-logo">
                                                <span class="card-number">visa****7583</span>
                                            </div>
                                            <img src="../img/subs/arrow-down.svg" alt="dropdown arrow"
                                                alt="dropdown arrow" class="dropdown-arrow">
                                        </button>
                                        <!-- Payment dropdown menu -->
                                        <ul class="payment-menu" role="listbox" aria-label="Payment methods" hidden>
                                            <li class="payment-option" role="option" tabindex="-1" data-method="visa"
                                                data-label="visa ****7583">
                                                <span>visa ****7583</span>
                                            </li>
                                            <li class="payment-option" role="option" tabindex="-1"
                                                data-method="new-card" data-label="New Payment Card">
                                                <span>New Payment Card</span>
                                            </li>
                                            <li class="payment-option" role="option" tabindex="-1"
                                                data-method="apple-pay" data-label="Apple Pay">
                                                <span>Apple Pay</span>
                                            </li>
                                            <li class="payment-option" role="option" tabindex="-1"
                                                data-method="google-pay" data-label="Google Pay">
                                                <span>Google Pay</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- New Card form (hidden until 'New Payment Card' selected) -->
                                    <div class="new-card-form" hidden>
                                        <label>Card Number</label>
                                        <input type="text" placeholder="5218 - 9811 - 4323 - 5216" />

                                        <div class="new-card-row">
                                            <div>
                                                <label>Expire Date</label>
                                                <input type="text" placeholder="MM / YYYY" />
                                            </div>
                                            <div>
                                                <label>Security Code</label>
                                                <input type="text" placeholder="CVC / CVV" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Apple Pay button (hidden until Apple Pay selected) -->
                                    <button class="apple-pay-button" hidden><img src="../img/subs/apple-pay.svg"
                                            alt="Apple Pay" alt="Apple Pay" class="apple-pay-logo"></button>

                                    <!-- Google Pay button (hidden until Google Pay selected) -->
                                    <button class="google-pay-button" hidden><img src="../img/subs/google-pay.svg"
                                            alt="Google Pay" alt="Google Pay" class="google-pay-logo"></button>

                                    <button class="confirm-button">Confirm monthly subscription</button>
                                    <p class="policy-text">
                                        By pressing the "Confirm monthly subscription" button, you agree to <a href="#"
                                            class="policy-link">LAtingles’s Refund and Payment Policy</a>.
                                    </p>
                                    <div class="info-box-cancellation">
                                        <img src="../img/subs/check-mark.svg" alt="checkmark" class="info-icon">
                                        <p>You can change your tutor for free or cancel your subscriptioat any time</p>
                                    </div>
                                    <div class="info-box-renewal">
                                        <h3 class="renewal-title">Renews automatically every 6 Months</h3>
                                        <p class="renewal-text">We will charge <strong>$120.00</strong> to your saved
                                            payment method to add <strong>6 Months</strong> plan unless you cancel your
                                            subscription</p>
                                    </div>
                                    <p class="security-text">It’s safe to pay on Latingles. All transactions are
                                        protected
                                        by SSL encryption.</p>
                                </div>
                            </div>
                        </section>
                    </div>

                    <section class="plan-summary-panel">
                        <button class="close-button" data-subscribe-close aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                                    fill="#121117"></path>
                            </svg>
                        </button>
                        <div class="summary-card">

                            <div class="summary-header">
                                <h3>Your learning plan</h3>
                                <a href="#" class="link open-faq-modal">See how our plans work</a>
                            </div>
                            <hr class="separator">
                            <div class="summary-body">
                                <div class="plan-title-section">
                                    <h4>6 Months Plan</h4>
                                    <p>That’s <b>6 Months Plan at $108.00.</b></p>
                                    <span class="flexible-badge"><img src="${ASSET_PATH}/8160_24684.svg" alt="">Flexible
                                        plan</span>
                                </div>

                                <section id="plan-selector">
                                    <div class="plan-container">
                                        <div class="plan-header-group">
                                            <h2 class="plan-title">How many Months would you like to<br>Select?</h2>
                                            <div class="plan-dropdown" role="button" tabindex="0">
                                                <span class="plan-dropdown-value">12</span>
                                                <img src="../img/subs/arrow-down.svg" alt="Dropdown arrow"
                                                    class="plan-dropdown-arrow">
                                                <section id="pricing-options">
                                                    <div class="pricing-list-container">
                                                        <ul class="pricing-list">
                                                            <li class="pricing-item">
                                                                <span class="item-label">4 Months</span>
                                                                <span class="item-price">$72.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">5 Months</span>
                                                                <span class="item-price">$90.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">6 Months</span>
                                                                <span class="item-price">$108.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">7 Months</span>
                                                                <span class="item-price">$120.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">8 Months</span>
                                                                <span class="item-price">$135.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">9 Months</span>
                                                                <span class="item-price">$144.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">10 Months</span>
                                                                <span class="item-price">$156.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">11 Months</span>
                                                                <span class="item-price">$170.00</span>
                                                            </li>
                                                            <li class="pricing-item">
                                                                <span class="item-label">12 Months</span>
                                                                <span class="item-price">$180.00</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </section>

                                            </div>

                                        </div>

                                        <hr class="plan-separator">

                                        <div class="plan-details">
                                            <div class="plan-duration">
                                                <p class="duration-number">12</p>
                                                <p class="duration-label">Months</p>
                                            </div>
                                            <div class="plan-pricing">
                                                <div class="plan-pricing-sub">
                                                    <p class="price-amount">$180.00</p>
                                                    <div class="plan-badge">save 20%</div>
                                                </div>

                                                <p class="price-description">charged per 12 Month</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <ul class="features-list">
                                    <li class="feature-item">
                                        <div class="feature-icon-wrapper"><img src="../img/subs/calender-1.png" alt="">
                                        </div>
                                        <p>your <b>lessons will be scheduled for 6 Months</b></p>
                                    </li>
                                    <li class="feature-item">
                                        <div class="feature-icon-wrapper"><img src="../img/subs/cap.png" alt=""></div>
                                        <p>Change your tutor <b>for free at any time.</b></p>
                                    </li>
                                    <li class="feature-item">
                                        <div class="feature-icon-wrapper"><img src="../img/subs/stop.png" alt=""></div>
                                        <p>Cancel your plan <b>at any time.</b></p>
                                    </li>
                                    <li class="feature-item">
                                        <div class="feature-icon-wrapper"><img src="../img/subs/clock.png" alt=""></div>
                                        <p>Change the duration of your classes <b>at any time.</b></p>
                                    </li>
                                </ul>
                            </div>
                            <hr class="separator">
                            <div class="group-details">
                                <img src="../img/subs/group-section/1.png" alt="Florida 1" class="group-logo">
                                <div class="group-info">
                                    <div class="group-header">
                                        <h5 class="group-name">English Group (NewYork)</h5>
                                        <div class="group-rating">
                                            <img src="../img/subs/star.png" alt="star icon">
                                            <span class="rating-score">5</span>
                                            <a href="#" class="link">(3 reviews)</a>
                                        </div>
                                    </div>
                                    <div class="group-schedule">
                                        <!--merged image-->
                                        <div class="tutor-avatars">
                                            <img src="../img/subs/1.png" alt="Tutor avatar">
                                            <img src="../img/subs/2.png" alt="Tutor avatar">
                                        </div>
                                        <div class="time-tags">
                                            <span class="time-tag">Mon - 5: 40 am</span>
                                            <span class="time-tag">Tue - 5: 40 am</span>
                                            <span class="time-tag">Fri - 5: 40 am</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>




                </div>
            </main>

            <!-- Modal + overlay -->
            <div class="modal-overlay" data-faq-overlay hidden>
                <div class="modal modal-faq" data-faq>
                    <button class="modal-close" type="button" aria-label="Close" data-faq-close>&times;</button>

                    <h2 id="faq-modal-title" class="modal-title">See how plans works</h2>

                    <div class="faq" data-faq>
                        <!-- Item -->
                        <section class="faq-item">
                            <h3>
                                <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p1" id="faq-h1">
                                    How to schedule your lessons
                                    <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                            alt=""></span>
                                </button>
                            </h3>
                            <div id="faq-p1" class="faq-panel" role="region" aria-labelledby="faq-h1" hidden>
                                <div class="faq-panel-inner">
                                    Dummy content: Go to “My Lessons”, pick a time slot, and confirm. You’ll receive a
                                    calendar invite and in-app reminder.
                                </div>
                            </div>
                        </section>

                        <!-- Item -->
                        <section class="faq-item">
                            <h3>
                                <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p2" id="faq-h2">
                                    How to change your tutor
                                    <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                            alt=""></span>
                                </button>
                            </h3>
                            <div id="faq-p2" class="faq-panel" role="region" aria-labelledby="faq-h2" hidden>
                                <div class="faq-panel-inner">
                                    Dummy content: From your dashboard, choose “Change tutor”, review suggestions, and
                                    confirm. Your plan and credits carry over.
                                </div>
                            </div>
                        </section>

                        <!-- Item -->
                        <section class="faq-item">
                            <h3>
                                <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p3" id="faq-h3">
                                    How to cancel your plan
                                    <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                            alt=""></span>
                                </button>
                            </h3>
                            <div id="faq-p3" class="faq-panel" role="region" aria-labelledby="faq-h3" hidden>
                                <div class="faq-panel-inner">
                                    Dummy content: Open “Billing & Plan”, click “Cancel plan”, follow the steps, and
                                    you’ll see your end date immediately.
                                </div>
                            </div>
                        </section>

                        <!-- Item -->
                        <section class="faq-item">
                            <h3>
                                <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p4" id="faq-h4">
                                    How to change your renewal date
                                    <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                            alt=""></span>
                                </button>
                            </h3>
                            <div id="faq-p4" class="faq-panel" role="region" aria-labelledby="faq-h4" hidden>
                                <div class="faq-panel-inner">
                                    Dummy content: In “Billing & Plan”, choose “Change renewal”, select a new date, and
                                    confirm the proration preview.
                                </div>
                            </div>
                        </section>

                        <!-- Item -->
                        <section class="faq-item">
                            <h3>
                                <button class="faq-trigger" aria-expanded="false" aria-controls="faq-p5" id="faq-h5">
                                    How automatic payments work
                                    <span class="chev" aria-hidden="true"><img src="../img/subs/arrow-down.svg"
                                            alt=""></span>
                                </button>
                            </h3>
                            <div id="faq-p5" class="faq-panel" role="region" aria-labelledby="faq-h5" hidden>
                                <div class="faq-panel-inner">
                                    Dummy content: We charge your saved method on the renewal date. You’ll get a receipt
                                    and can update payment any time.
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section class="plan-selection-panel-sub">
        <div class="panel-content">
            <div class="selection-header">
                <!--merged image-->
                <div class="header-icon-wrapper">
                    <img src="../img/subs/Progress-steps.png" alt="" />
                </div>
                <div class="selection-header-text">
                    <h2>Time to help you succeed at work!</h2>
                    <p>Consistency is key to progress, so we recommend a weekly schedule. Each
                        <b>50-min</b>
                        lesson costs <b>$9.00</b>.
                    </p>
                </div>
            </div>
            <div class="plan-options">
                <div class="plan-option">
                    <input type="radio" name="plan" id="plan-1" class="visually-hidden">
                    <label for="plan-1" class="plan-label">
                        <span class="plan-name">1 Month</span>
                        <span class="plan-price"><b>$36.00</b> per Month</span>
                    </label>
                </div>
                <div class="plan-option">
                    <input type="radio" name="plan" id="plan-4" class="visually-hidden">
                    <label for="plan-4" class="plan-label">
                        <span class="plan-name">4 Months</span>
                        <span class="plan-price"><b>$72.00</b> per 4 Month</span>
                    </label>
                </div>
                <div class="plan-option">
                    <input type="radio" name="plan" id="plan-6" class="visually-hidden" checked>
                    <label for="plan-6" class="plan-label">
                        <span class="plan-name">6 Months</span>
                        <span class="plan-price"><b>$108.00</b> per 6 Month</span>

                    </label>
                </div>
                <div class="plan-option">
                    <input type="radio" name="plan" id="plan-9" class="visually-hidden">
                    <label for="plan-9" class="plan-label">
                        <span class="plan-name">9 Months</span>
                        <span class="plan-price"><b>$144.00</b> per 9 Month</span>
                    </label>
                </div>
                <div class="plan-option">
                    <input type="radio" name="plan" id="plan-12" class="visually-hidden">
                    <label for="plan-12" class="plan-label">
                        <div class="plan-name-wrapper">
                            <span class="plan-name">12 Months</span>
                            <span class="popular-badge">Popular</span>
                        </div>
                        <span class="plan-price"><b>$180.00</b> per 12 Month</span>
                    </label>
                </div>
                <div class="plan-option">
                    <input type="radio" name="plan" id="plan-custom" class="visually-hidden">
                    <label for="plan-custom" class="plan-label">
                        <div class="custom-plan-text">
                            <span class="plan-name">Custom plan</span>
                            <p>Choose the number of <b>months</b> if that suits you better.</p>
                        </div>
                        <img src="../img/subs/calendar.png" alt="" />
                    </label>
                </div>
                <button class="checkout-button">Continue to checkout</button>

            </div>
        </div>

    </section>


    <div class="subscribe-modal-backdrop" data-subscribe-modal>

        <div class="subscribe-modal-main">
            <button class="subscribe-modal__close" data-subscribe-close aria-label="Close">
                &times;
            </button>
            <aside class="plans">
                <div class="plans__title">
                    <img src="../img/subs/Progress-steps.png" alt="" />
                    <div>
                        <h2>Time to help you succeed at work!</h2>
                        <p>Consistency is key to progress, so we recommend a weekly schedule. Each 50-min lesson
                            costs <strong>$9.00</strong>.</p>
                    </div>
                </div>

                <button class="plan-card" data-plan="1" data-price="36">
                    <span>1 Month</span><span class="price">$36.00 <small>per Month</small></span>
                </button>

                <button class="plan-card" data-plan="4" data-price="72">
                    <span>4 Months</span><span class="price">$72.00 <small>per 4 Month</small></span>
                </button>

                <button class="plan-card" data-plan="6" data-price="108">
                    <span>6 Months</span><span class="price">$108.00 <small>per 6 Month</small></span>
                </button>

                <button class="plan-card" data-plan="9" data-price="144">
                    <span>9 Months</span><span class="price">$144.00 <small>per 9 Month</small></span>
                </button>

                <button class="plan-card " data-plan="12" data-price="180">
                    <span>12 Months</span>
                    <span class="tag">Popular</span>
                    <span class="price">$180.00 <small>per 12 Month</small></span>
                </button>

                <div class="plan-card custom-plan">
                    <div class="plan-custom__row">
                        <strong>Custom plan</strong> <small>per month</small>
                    </div>
                    <p>Choose the number of months if that suits you better.</p>


                </div>

                <div class="plans__cta">
                    <button class="btn-primary" data-continue>Continue to checkout</button>
                </div>
            </aside>
        </div>
    </div>


    <!-- extra lessons -->
    <!-- ============= -->
    <div class="extraLesson">
        <div class="closeIcon firstLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="row01">
            <div class="imageContainer">
                <img src="../img/cour/1.png" alt="" />
            </div>
            <h1>Add extra lessons with Dinela</h1>
            <p>
                Buy more lessons without changing your plan. Schedule these lessons
                before Jan 07.
            </p>
        </div>

        <div class="row02">
            <div class="top">
                <div class="increment">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="2" viewBox="0 0 16 2" fill="none">
                        <path d="M0 0H16V2H0V0Z" fill="#121117" />
                    </svg>
                </div>
                <div class="value">
                    <h1>1</h1>
                    <p>extra lessons</p>
                </div>
                <div class="decrement">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13 4H11V11H4V13H11V20H13V13H20V11H13V4Z"
                            fill="#121117" />
                    </svg>
                </div>
            </div>
            <div class="horizontalLine"></div>
            <div class="bottom">
                <h1>
                    Total: $<span class="after_increment_and_decrement_value">5</span>
                </h1>
            </div>
        </div>

        <button class="confirm_payment_modal_open">Continue</button>
    </div>

    <!-- Confirm Payment -->
    <!-- =============== -->
    <div class="confirm_payment">
        <div class="goBack">
            <img src="../img/cour/icons/Goback.png" alt="" />
        </div>
        <div class="closeIcon firstLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <h1 class="heading">Confirm payment</h1>

        <div class="row01">
            <div class="top">
                <div class="row01_top_row1">
                    <div class="row01_top_row1_left">
                        <p><span class="extraLesson_count">2</span> extra lessons</p>
                        <p class="tag">Expire Jan 7</p>
                    </div>
                    <p class="price totalLessonAmount">$10.80</p>
                </div>
                <div class="row01_top_row1">
                    <div class="row01_top_row1_left">
                        <p>Processing fee</p>
                    </div>
                    <p class="price">$0.54</p>
                </div>
            </div>
            <div class="bottom">
                <p>Total</p>
                <p class="totalLesson_amountWithProcessingFee">$11.34</p>
            </div>
        </div>
        <div class="horizontalLine"></div>
        <h2>Payment with</h2>
        <div class="paymentLabel">
            <div class="left">
                <img src="../img/cour/icons/visa.png" alt="" />
                <p>Visa **** 1345</p>
            </div>

            <a href="" class="editBTN">Edit</a>
        </div>
        <p class="instruction">
            By pressing the "Confirm payment" button, you agree to
            <a href="">Preply’s Refund</a> <a href="">and Payment Policy</a>
        </p>

        <button class="firstLayerBackdropClose">
            Confirm payment · $<span class="totalAmountShowInBtn">11.34</span>
        </button>
    </div>

    <!-- Transfer lessons or subscription -->
    <!-- =============================== -->
    <div class="transferLessons_subscription">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <h1 class="heading">Transfer lessons or subscription</h1>

        <div class="cards">
            <div class="card">
                <div class="left">
                    <h1>Transfer balance for a trial lesson</h1>
                    <p>
                        If you need to learn more with another tutor for some time If your
                        lessons are expiring soon and you want to use them with another
                        tutor
                    </p>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <div class="card">
                <div class="left">
                    <h1>Transfer lessons</h1>
                    <p>
                        If you need to learn more with another tutor for some time If your
                        lessons are expiring soon and you want to use them with another
                        tutor
                    </p>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <div class="card">
                <div class="left">
                    <h1>Transfer subscription</h1>
                    <p>Completely switch your monthly plan to a new tutor</p>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
        </div>

        <button class="transferLessons_subscription_btn_ModalOpen">
            Continue
        </button>
    </div>

    <!-- Transfer Balance -->
    <!-- ================ -->
    <div class="transferBalance">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="backButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <h1 class="heading">Transfer balance</h1>

        <div class="row01">
            <div class="from">
                <h1>From</h1>
                <p>Select teacher</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.5859 6.99313H0.585938V8.99313H12.5859L7.29294 14.2861L8.70694 15.7001L16.4139 7.99313L8.70694 0.286133L7.29294 1.70013L12.5859 6.99313Z"
                    fill="#121117" />
            </svg>
        </div>

        <p class="peragraph">
            Select the tutor you want to transfer balance from
        </p>

        <div class="cards cardsfrom">
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/13.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Albert</h1>
                        <p>English · 8-week plan · $7.60/lesson</p>
                        <h2>5 lessons · $25.65 left</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/14.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Karen V.</h1>
                        <p>English · 6-week plan · $7.60/lesson</p>
                        <h2>1 lessons · $25.65 left</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
        </div>

        <button class="transferBalanceFrom_ModalOpen">Continue</button>
    </div>

    <!-- Transfer Balance -->
    <!-- ================ -->
    <div class="transferBalance transferBalanceTo">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="backButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <h1 class="heading">Transfer balance</h1>

        <div class="row01">
            <div class="from">
                <h1>Albert</h1>
                <p>lessons . $</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.5859 6.99313H0.585938V8.99313H12.5859L7.29294 14.2861L8.70694 15.7001L16.4139 7.99313L8.70694 0.286133L7.29294 1.70013L12.5859 6.99313Z"
                    fill="#121117" />
            </svg>

            <div class="from to">
                <h1>To</h1>
                <p>Select teacher</p>
            </div>
        </div>

        <p class="peragraph">
            Select the tutor you want to transfer balance from
        </p>

        <div class="cards cardsTo">
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/15.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Lucia B.</h1>
                        <p>English · 4-week plan · $7.60/lesson</p>
                        <h2 class="blueColor">Book a trial lesson!</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/16.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Triny A.</h1>
                        <p>English · 6-week plan · $7.60/lesson</p>
                        <h2 class="blueColor">Book a trial lesson!</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/16.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Triny A.</h1>
                        <p>English · 6-week plan · $7.60/lesson</p>
                        <h2 class="blueColor">Book a trial lesson!</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/16.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Triny A.</h1>
                        <p>English · 6-week plan · $7.60/lesson</p>
                        <h2 class="blueColor">Book a trial lesson!</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/16.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Triny A.</h1>
                        <p>English · 6-week plan · $7.60/lesson</p>
                        <h2 class="blueColor">Book a trial lesson!</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
            <div class="card">
                <div class="left">
                    <div class="imageContainer">
                        <img src="../img/cour/16.png" alt="" />
                    </div>

                    <div class="content">
                        <h1>Triny A.</h1>
                        <p>English · 6-week plan · $7.60/lesson</p>
                        <h2 class="blueColor">Book a trial lesson!</h2>
                    </div>
                </div>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>
        </div>

        <a href="">Find Tutors</a>
        <button class="transferLessonsOpen">Continue</button>
    </div>

    <!-- Transfer lessons -->
    <!-- ================ -->
    <div class="transferBalance transferLessonsTo transferLessons">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="backButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <h1 class="heading">Transfer lessons</h1>

        <div class="row01">
            <div class="from">
                <h1>Albert</h1>
                <p class="fromLessonAndAmount">lessons . $</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.5859 6.99313H0.585938V8.99313H12.5859L7.29294 14.2861L8.70694 15.7001L16.4139 7.99313L8.70694 0.286133L7.29294 1.70013L12.5859 6.99313Z"
                    fill="#121117" />
            </svg>

            <div class="from to">
                <h1>Lucia B.</h1>
                <p class="toLessonAndAmount">lessons . $</p>
            </div>
        </div>

        <div class="horizontalLine"></div>

        <p class="peragraph">Select the amount of lessons to transfer</p>

        <div class="lesson_and_dragger">
            <h1 id="lessonCount">1 lesson</h1>

            <div class="drag_lesson">
                <div class="blackArea slider-track"></div>
                <div class="grayArea"></div>
                <div class="dragger slider-thumb"></div>
            </div>
        </div>

        <div class="box lessonDetailBox">
            <p class="topPera accortingLessonTexts">
                Your tutors have different lesson prices, so when you transfer
                <span>1 lesson from Albert ($5.18/lesson)</span>, you will need to
                cover a price difference of
                <span>$2.50 to get 1 lesson with Lucia B. ($7.68/lesson)</span>
            </p>

            <div class="bottomContent">
                <div class="left">
                    <div class="user">
                        <div class="imageContainer">
                            <img src="../img/cour/13.png" alt="" />
                        </div>

                        <h1>Albert</h1>
                    </div>

                    <div class="lesson lessonFromBox">
                        <div></div>
                    </div>

                    <h1 class="shortDetail_fromUser">1 lesson</h1>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M16.0859 10.9931H4.08594V12.9931H16.0859L10.7929 18.2861L12.2069 19.7001L19.9139 11.9931L12.2069 4.28613L10.7929 5.70013L16.0859 10.9931Z"
                        fill="#121117" />
                </svg>

                <div class="left">
                    <div class="user">
                        <div class="imageContainer">
                            <img src="../img/cour/15.png" alt="" />
                        </div>
                        <h1>Lucia B.</h1>
                    </div>

                    <div class="lesson lessonToBox">
                        <div></div>
                    </div>

                    <h1 class="shortDetail_toUser">
                        <span>$2.50 to pay</span> for a full lesson
                    </h1>
                </div>
            </div>

            <p class="extraContent_ofTransferLessons"></p>
        </div>

        <button class="active tellUsWhyOpen">Continue</button>
    </div>

    <!-- Tell Us Why -->
    <!-- =========== -->
    <div class="transferBalance tellUsWhy">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="backButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <h1 class="heading">Tell us why</h1>

        <div class="row01">
            <div class="from">
                <h1>Albert</h1>
                <p>lessons . $</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.5859 6.99313H0.585938V8.99313H12.5859L7.29294 14.2861L8.70694 15.7001L16.4139 7.99313L8.70694 0.286133L7.29294 1.70013L12.5859 6.99313Z"
                    fill="#121117" />
            </svg>

            <div class="from to">
                <h1>Lucia B.</h1>
                <p>lessons . $</p>
            </div>
        </div>

        <div class="horizontalLine"></div>

        <p class="peragraph">
            Tell us why you decided to transfer. We won't share this with your
            tutors.
        </p>

        <div class="options">
            <div class="option">
                <p>I want to focus on another subject</p>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <div class="option">
                <p>Too many lessons left</p>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <div class="option">
                <p>Problems with availability</p>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <div class="option">
                <p>Unhappy with my tutor</p>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <div class="otherAsyncTextarea">
                <p>Other</p>
                <div class="circle">
                    <div class="innerCircle"></div>
                </div>
            </div>

            <textarea name="defineWhatOther" id="defineWhatOther" placeholder="Define here..."
                class="otherAsync"></textarea>
        </div>

        <button class="transferCompleteOpen">Continue</button>
    </div>

    <!-- Transfer complete! -->
    <!-- ================= -->
    <div class="TransferComplete">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="topPart">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="41" viewBox="0 0 40 41" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M26.582 4.61L20 0.5L13.418 4.61L5.858 6.358L4.11 13.918L0 20.5L4.11 27.082L5.858 34.642L13.418 36.39L20 40.5L26.582 36.39L34.142 34.642L35.89 27.082L40 20.5L35.89 13.918L34.142 6.358L26.582 4.61ZM15.586 27.914L17 29.328L18.414 27.914L30.414 15.914L27.586 13.086L17 23.672L12.414 19.086L9.586 21.914L15.586 27.914Z"
                    fill="#FF2500" />
            </svg>
            <h1>Transfer complete!</h1>
        </div>

        <div class="content">
            <p>
                You have <span>1 Trial lessons</span> available to schedule with Lucia
                B. and <span>$2.66 credit</span> for your future payments.
            </p>

            <p>
                Remember to schedule your balance by <span>Mar 18, 2025</span> so it
                doesn't expire when your subscription renews.
            </p>
        </div>

        <a href="">Schedule lessons</a>
    </div>

    <!-- Review Your Transfer -->
    <!-- ==================== -->
    <div class="transferBalance transferLessonsTo reviewYourTransfer">
        <div class="closeIcon secondLayerBackdropClose">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117"></path>
            </svg>
        </div>

        <div class="backButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <h1 class="heading">Review your transfer</h1>

        <div class="row01">
            <div class="from">
                <h1>Dinela</h1>
                <p>16 lessons / 4 weeks</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12.5859 6.99313H0.585938V8.99313H12.5859L7.29294 14.2861L8.70694 15.7001L16.4139 7.99313L8.70694 0.286133L7.29294 1.70013L12.5859 6.99313Z"
                    fill="#121117" />
            </svg>

            <div class="from to">
                <h1>David</h1>
                <p class="toLessonAndAmount">16 lessons / 4 weeks</p>
            </div>
        </div>

        <div class="content">
            <h1>What happens next</h1>

            <ul>
                <li>
                    Your subscription with Ranim will stop and you won’t be charged
                    again
                </li>
                <li>
                    Your first subscription refill and payment with Patricia willhappen
                    on Dec 10, 2024 (16 lessons · $176.00 every 4 weeks)
                </li>
            </ul>
        </div>

        <button class="active secondLayerBackdropClose">Continue</button>
    </div>




    <div class="modal-wrapper">
        <div class="modal-container">
            <button class="modal-close-button" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                        fill="#121117"></path>
                </svg>
            </button>
            <h2 class="modal-title">What would you like to do?</h2>
            <div class="modal-options-list">
                <a href="#" class="modal-option">
                    <img class="modal-option-icon" src="../img/cour/icons/revision.png" alt="">
                    <span class="modal-option-text">Upgrade Plan</span>
                </a>
                <a href="#" class="modal-option">
                    <img class="modal-option-icon" src="../img/cour/icons/revision.png" alt="">
                    <span class="modal-option-text">Downgrade Plan</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Group Classes options -->
    <main class="group-classes-options-modal">
        <button class="option prefer-to-share-feedback-modal-open">
            <img src="../img/subs/icons/feedback-to-group.png" alt="feedback to group" />
            <p>Give feedback to Group</p>
        </button>

        <button class="option give-feedback-to-teacher-modal-open">
            <img src="../img/subs/icons/feedback-to-teacher.png" alt="feedback to teacher" />
            <p>Give feedback to teacher</p>
        </button>

        <button class="option tell-us-what-happened-modal-open">
            <img src="../img/subs/icons/report-a-issue.png" alt="report a issue" />
            <p>Report a issue</p>
        </button>
    </main>

    <!-- prefer to share your feedback for Florida -->
    <main class="modal-basic-style prefer-to-share-feedback-modal">
        <div class="closeIcon backdrop-level-2-close desktop">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="heading-options">
            <div class="mobile back-custom-icon">
                <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px"
                    viewBox="0 0 66.91 122.88" style="enable-background: new 0 0 66.91 122.88" xml:space="preserve">
                    <g>
                        <path
                            d="M64.96,111.2c2.65,2.73,2.59,7.08-0.13,9.73c-2.73,2.65-7.08,2.59-9.73-0.14L1.97,66.01l4.93-4.8l-4.95,4.8 c-2.65-2.74-2.59-7.1,0.15-9.76c0.08-0.08,0.16-0.15,0.24-0.22L55.1,2.09c2.65-2.73,7-2.79,9.73-0.14 c2.73,2.65,2.78,7.01,0.13,9.73L16.5,61.23L64.96,111.2L64.96,111.2L64.96,111.2z" />
                    </g>
                </svg>
            </div>
            <div class="image-and-heading">
                <h1>
                    How Would You Prefer to Share Your Feedback for Florida 1 Group?
                </h1>
            </div>

            <div class="bullet-select-options">
                <button>
                    <div class="icon-and-text">
                        <img src="../img/subs/icons/feedback-to-group.png" alt="" />
                        <p class="public-review-for-group">Public Review</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>

                <button>
                    <div class="icon-and-text">
                        <img src="../img/subs/icons/anonymous.png" alt="" />
                        <p>Anonymous feedback</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>
            </div>
        </div>

        <button class="red-button disabled-button">Continue</button>
    </main>

    <!-- Publish your Review for Florida 1 -->
    <main class="modal-basic-style publish-your-review-for-florida-1-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <section class="top-part">
            <h1 class="heading">Publish your Review for Florida 1</h1>

            <div class="review">
                <div class="review-short-detail">
                    <h1>5</h1>
                    <div class="stars">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                            <path
                                d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                fill="#121118" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                            <path
                                d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                fill="#121118" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                            <path
                                d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                fill="#121118" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                            <path
                                d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                fill="#121118" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                            <path
                                d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                fill="#121118" />
                        </svg>
                    </div>
                    <p>3 reviews</p>
                </div>

                <div class="review-bar">
                    <div class="rating-bar active-text-color">
                        <p class="rating-stage">5</p>
                        <div class="review-progress" style="--progress-width: 100%"></div>
                        <p class="rating-count">(3)</p>
                    </div>
                    <div class="rating-bar">
                        <p class="rating-stage">4</p>
                        <div class="review-progress"></div>
                        <p class="rating-count">(0)</p>
                    </div>
                    <div class="rating-bar">
                        <p class="rating-stage">3</p>
                        <div class="review-progress"></div>
                        <p class="rating-count">(0)</p>
                    </div>
                    <div class="rating-bar">
                        <p class="rating-stage">2</p>
                        <div class="review-progress"></div>
                        <p class="rating-count">(0)</p>
                    </div>
                    <div class="rating-bar">
                        <p class="rating-stage">1</p>
                        <div class="review-progress"></div>
                        <p class="rating-count">(0)</p>
                    </div>
                </div>
            </div>

            <form action="" class="review-form">
                <div class="selectable-stars outline-and-fill-star-container-one">
                    <div class="outline-and-fill-star">
                        <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                            <path
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                            class="outline-star">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                                fill="#4D4C5C" />
                        </svg>
                    </div>
                    <div class="outline-and-fill-star">
                        <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                            <path
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                            class="outline-star">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                                fill="#4D4C5C" />
                        </svg>
                    </div>
                    <div class="outline-and-fill-star">
                        <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                            <path
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                            class="outline-star">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                                fill="#4D4C5C" />
                        </svg>
                    </div>
                    <div class="outline-and-fill-star">
                        <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                            <path
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                            class="outline-star">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                                fill="#4D4C5C" />
                        </svg>
                    </div>
                    <div class="outline-and-fill-star">
                        <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                            <path
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                            class="outline-star">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                                fill="#4D4C5C" />
                        </svg>
                    </div>
                </div>

                <textarea name="review-text-area" id="review-text-area"
                    placeholder="How was your learning experience? Write your review here..." required
                    autocomplete="off"></textarea>

                <div class="btnGroup">
                    <button type="button" class="outline-button">Cancel</button>
                    <button type="button" class="red-button success-modal-for-providing-feedback-modal-open">
                        Post review
                    </button>
                </div>
            </form>
        </section>

        <section class="student-reviews">
            <h1 class="heading">What my students say for Florida 1</h1>

            <div class="review-cards">
                <div class="review-card">
                    <div class="top">
                        <div class="image">
                            <img src="../img/subs/20.png" alt="student" />
                        </div>

                        <div class="name-and-date">
                            <h1>Marcos</h1>
                            <p>March 27, 2025</p>
                        </div>
                    </div>
                    <div class="content">
                        <div class="stars">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                        </div>

                        <p>
                            I took several lessons with Carolina. She is proficient in
                            English. In every lesson I learned new words and phrasal verbs,
                            but most important, I felt confident learning with her. So, I
                            recommend her since she has all the skills and knowledge to
                            boost your English.
                        </p>
                    </div>
                </div>
                <div class="review-card">
                    <div class="top">
                        <div class="image">
                            <img src="../img/subs/21.png" alt="student" />
                        </div>

                        <div class="name-and-date">
                            <h1>Alejandro</h1>
                            <p>February 28, 2025</p>
                        </div>
                    </div>
                    <div class="content">
                        <div class="stars">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                        </div>

                        <p>
                            * The best teacher on earth. She's very professional and
                            patient. * Carolina was the only teacher that really understand
                            what i needed to improve my pronunciation and my language
                            structure. And as a bonus! you will learn a lot of cultural
                            things and expressions. So you wont end up using "regular and
                            boring" ones. I definitely recommend her as a tutor/teacher. See
                            you soon, Carolina! Best of luck to you! 🤞
                        </p>
                    </div>
                </div>
                <div class="review-card">
                    <div class="top">
                        <div class="image">
                            <img src="../img/subs/22.png" alt="student" />
                        </div>

                        <div class="name-and-date">
                            <h1>Blas</h1>
                            <p>December 21, 2024</p>
                        </div>
                    </div>
                    <div class="content">
                        <div class="stars">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17"
                                fill="none">
                                <path
                                    d="M11.2219 5.942L8.99993 0L6.77793 5.942L0.44043 6.219L5.40493 10.168L3.70993 16.281L8.99993 12.78L14.2899 16.281L12.5949 10.168L17.5594 6.219L11.2219 5.942ZM10.2349 7.301L8.99993 4L7.76593 7.301L4.24493 7.455L7.00293 9.649L6.06143 13.045L9.00043 11.1L11.9394 13.045L10.9974 9.649L13.7554 7.455L10.2349 7.301Z"
                                    fill="#121118" />
                            </svg>
                        </div>

                        <p>
                            Great teacher. Very patient and committed to helping the student
                            feel confident with speaking and continue learning English
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Great! Thankyou For proving your feedback -->
    <main class="modal-basic-style success-modal-for-providing-feedback-modal">
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="content">
            <div class="user-image-with-latingles">
                <div class="image">
                    <img src="../img/subs/23.jpg" alt="" />
                </div>

                <div class="image">
                    <img src="../img/subs/1.png" alt="" />
                </div>
            </div>

            <h1 class="heading">
                Great! Thankyou For proving <br />
                your feedback
            </h1>
        </div>

        <button class="red-button backdrop-level-2-close">Done</button>
    </main>

    <!-- Rate your lesson with Florida 1 in 4 simple questions -->
    <main class="modal-basic-style rate-your-teacher-4-questions-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="content">
            <div class="heading-and-pera">
                <h1 class="heading">
                    Rate your lesson with Florida 1 in 4 simple questions
                </h1>
                <p>This rating is anonymous</p>
            </div>
        </div>

        <button class="red-button question-one-modal-open">
            Share your rating
        </button>
    </main>

    <!-- How well did the lesson improve your learning goals? -->
    <main class="modal-basic-style rate-your-teacher-4-questions-modal question-one-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="question-progress-bar" style="--question-answer-progress: 0%"></div>

        <div class="content">
            <div class="icon-and-skip-button">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none">
                        <path
                            d="M15.5012 0.500065C11.5236 0.502068 7.70943 2.08293 4.89664 4.89537C2.08385 7.70781 0.502504 11.5218 0.5 15.4994C0.502003 19.4774 2.08313 23.2918 4.89597 26.1047C7.70882 28.9175 11.5233 30.4987 15.5012 30.5007C18.0309 30.498 20.5188 29.856 22.7339 28.6343C24.949 27.4126 26.8193 25.6509 28.1712 23.5128C29.5231 21.3747 30.3126 18.9295 30.4665 16.4046C30.6203 13.8796 30.1334 11.3567 29.0511 9.07031L27.5638 10.5576C27.4245 10.698 27.2587 10.8095 27.0762 10.8858C26.8936 10.962 26.6977 11.0014 26.4999 11.0017H26.0841C26.6756 12.3831 27.0026 13.9044 27.0026 15.4994C27.0006 18.5491 25.7882 21.4734 23.6317 23.6299C21.4752 25.7864 18.551 26.9987 15.5012 27.0007C9.15529 27.0007 3.99991 21.8454 3.99991 15.4994C4.00208 13.5998 4.47441 11.7303 5.37477 10.0576C6.27513 8.38498 7.57551 6.96119 9.15991 5.91328C10.7443 4.86537 12.5635 4.22593 14.4551 4.05201C16.3467 3.87809 18.2519 4.1751 20.0009 4.91653V4.50077C20.0009 4.10203 20.1596 3.7184 20.4431 3.43682L21.9322 1.94765C19.9231 0.992637 17.7258 0.496811 15.5012 0.500065ZM24.988 0.500065C24.86 0.503876 24.7382 0.556629 24.6479 0.64747L21.148 4.14549C21.1012 4.19207 21.0641 4.24744 21.0388 4.30842C21.0135 4.36939 21.0005 4.43476 21.0006 4.50077V7.7947L14.3976 14.3977C14.1068 14.6914 13.9436 15.088 13.9436 15.5013C13.9436 15.9146 14.1068 16.3112 14.3976 16.6049C15.0023 17.2097 15.9983 17.2078 16.603 16.6012L23.2041 10.0001H26.4999C26.5659 10.0002 26.6313 9.98716 26.6922 9.96186C26.7532 9.93657 26.8086 9.89946 26.8552 9.85269L30.3532 6.35278C30.4217 6.28256 30.468 6.19379 30.4865 6.09747C30.505 6.00115 30.4947 5.90153 30.4571 5.81096C30.4195 5.7204 30.3561 5.64288 30.2748 5.58802C30.1935 5.53316 30.0979 5.50338 29.9998 5.50237H27.7037L28.1024 5.10173C28.3931 4.80893 28.5565 4.41331 28.5572 4.00075C28.5579 3.5882 28.3958 3.19202 28.1062 2.89822C27.8038 2.59585 27.4013 2.44467 27.0007 2.44467C26.6 2.44467 26.1994 2.59585 25.897 2.89822L25.5002 3.29508V0.997083C25.4999 0.930511 25.4864 0.864655 25.4605 0.803364C25.4345 0.742073 25.3965 0.686578 25.3488 0.640124C25.3012 0.593671 25.2447 0.557191 25.1827 0.532818C25.1208 0.508445 25.0546 0.498557 24.988 0.500065ZM15.5012 7.498C11.0886 7.498 7.49793 11.0886 7.49793 15.4994C7.49793 19.9102 11.0886 23.4989 15.5012 23.4989C17.6221 23.4969 19.6554 22.6534 21.1549 21.1536C22.6544 19.6538 23.4974 17.6202 23.4989 15.4994C23.4989 14.2276 23.1927 13.0257 22.6636 11.956L19.9234 14.6963C20.0399 15.344 20.013 16.0095 19.8448 16.6457C19.6765 17.282 19.3708 17.8737 18.9493 18.3792C18.5278 18.8847 18.0006 19.2916 17.4049 19.5715C16.8092 19.8513 16.1594 19.9973 15.5012 19.999C14.3087 19.9975 13.1653 19.5232 12.3219 18.6801C11.4784 17.837 11.0036 16.6939 11.0016 15.5013C11.0031 14.3087 11.4774 13.1654 12.3205 12.3219C13.1636 11.4785 14.3068 11.0037 15.4994 11.0017C15.7753 11.0017 16.0436 11.03 16.3044 11.0773L19.0446 8.33707C17.9445 7.78656 16.7314 7.49931 15.5012 7.498Z"
                            fill="black" />
                    </svg>
                </div>

                <button type="button" class="anonymous-feedback-last-modal-open">
                    Skip
                </button>
            </div>

            <div class="heading-and-pera">
                <h1 class="heading">
                    How well did the lesson improve your learning goals?
                </h1>
                <p>This rating is anonymous</p>
            </div>

            <div class="rating-1-to-10-options">
                <ul class="options disabled-btn-remove-1">
                    <li><button>1</button></li>
                    <li><button>2</button></li>
                    <li><button>3</button></li>
                    <li><button>4</button></li>
                    <li><button>5</button></li>
                    <li><button>6</button></li>
                    <li><button>7</button></li>
                    <li><button>8</button></li>
                    <li><button>9</button></li>
                    <li><button>10</button></li>
                </ul>

                <div class="rating-description">
                    <p>Not at all</p>
                    <p>Fully</p>
                </div>
            </div>
        </div>

        <button class="red-button question-two-modal-open disabled-button">
            Next
        </button>
    </main>

    <!-- How clear was the lesson with Florida 1? -->
    <main class="modal-basic-style rate-your-teacher-4-questions-modal question-two-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="question-progress-bar" style="--question-answer-progress: 25%"></div>

        <div class="content">
            <div class="icon-and-skip-button">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" viewBox="0 0 32 30" fill="none">
                        <path
                            d="M29.1875 8.44107H27.2237C25.5534 4.4752 21.8756 1.59313 17.6416 1.0427C13.4457 0.483321 9.32306 2.09832 6.62594 5.34932C5.83306 6.30513 5.20413 7.34426 4.74363 8.44107H2.8125C1.26163 8.44107 0 9.7027 0 11.2536V15.0036C0 16.5544 1.26163 17.8161 2.8125 17.8161H6.66256L6.25975 16.5865C5.08694 13.0049 5.74706 9.34557 8.06975 6.54682C10.3522 3.79563 13.8376 2.43426 17.3981 2.9012C21.1635 3.3917 24.4319 6.05463 25.7269 9.68707L25.7348 9.70813C25.9431 10.2611 26.0905 10.8352 26.1742 11.4202C26.4553 13.1734 26.2951 14.9504 25.7119 16.5591L25.7078 16.5703C24.2603 20.6802 20.3669 23.4411 16.0183 23.4411C14.4573 23.4411 13.1875 24.7027 13.1875 26.2536C13.1875 27.8044 14.4491 29.0661 16 29.0661C17.5509 29.0661 18.8125 27.8044 18.8125 26.2536V24.9892C22.5559 24.0994 25.7001 21.4459 27.2114 17.816H29.1875C30.7384 17.816 32 16.5544 32 15.0035V11.2535C32 9.70263 30.7384 8.44107 29.1875 8.44107Z"
                            fill="black" />
                        <path
                            d="M7.5625 19.6914V21.5664H16C20.6527 21.5664 24.4375 17.7816 24.4375 13.1289C24.4375 8.47622 20.6527 4.69141 16 4.69141C11.3473 4.69141 7.5625 8.47622 7.5625 13.1289C7.56195 15.0191 8.19648 16.8547 9.36425 18.341C9.13813 19.1311 8.41669 19.6914 7.5625 19.6914ZM18.8125 12.1914H20.6875V14.0664H18.8125V12.1914ZM15.0625 12.1914H16.9375V14.0664H15.0625V12.1914ZM11.3125 12.1914H13.1875V14.0664H11.3125V12.1914Z"
                            fill="black" />
                    </svg>
                </div>

                <button type="button" class="anonymous-feedback-last-modal-open">
                    Skip
                </button>
            </div>

            <div class="heading-and-pera">
                <h1 class="heading">How clear was the lesson with Florida 1?</h1>
                <p>This rating is anonymous</p>
            </div>

            <div class="rating-1-to-10-options">
                <ul class="options disabled-btn-remove-2">
                    <li><button>1</button></li>
                    <li><button>2</button></li>
                    <li><button>3</button></li>
                    <li><button>4</button></li>
                    <li><button>5</button></li>
                    <li><button>6</button></li>
                    <li><button>7</button></li>
                    <li><button>8</button></li>
                    <li><button>9</button></li>
                    <li><button>10</button></li>
                </ul>

                <div class="rating-description">
                    <p>Not at all</p>
                    <p>Fully</p>
                </div>
            </div>
        </div>

        <button class="red-button question-three-modal-open disabled-button">
            Next
        </button>
    </main>

    <!-- How well prepared was the lesson? -->
    <main class="modal-basic-style rate-your-teacher-4-questions-modal question-three-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="question-progress-bar" style="--question-answer-progress: 50%"></div>

        <div class="content">
            <div class="icon-and-skip-button">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="22" viewBox="0 0 30 22" fill="none">
                        <path
                            d="M29.4499 7.62977C29.4523 8.15722 29.3018 8.67408 29.0166 9.11776C28.7314 9.56144 28.3236 9.91293 27.8428 10.1297L24.6463 11.5763L22.8607 12.3797L17.7892 14.6834C16.9811 15.0598 16.1004 15.2548 15.2089 15.2548C14.3174 15.2548 13.4367 15.0598 12.6286 14.6834L7.53938 12.3797L5.75378 11.5763L3.96818 10.7549V18.4688C4.09494 18.5484 4.19922 18.6591 4.2711 18.7903C4.34299 18.9216 4.38009 19.0691 4.37888 19.2188V21.0581C4.38004 21.1756 4.35774 21.2923 4.31329 21.4011C4.26883 21.5099 4.20311 21.6088 4.11998 21.692C4.03684 21.7751 3.93796 21.8408 3.82911 21.8853C3.72027 21.9297 3.60365 21.952 3.48608 21.9509H2.66468C2.54709 21.9521 2.43044 21.9298 2.32156 21.8854C2.21268 21.8409 2.11376 21.7752 2.03059 21.6921C1.94742 21.6089 1.88167 21.51 1.8372 21.4012C1.79273 21.2923 1.77042 21.1757 1.77158 21.0581V19.2191C1.77043 19.0694 1.80759 18.9219 1.87953 18.7906C1.95147 18.6593 2.05579 18.5487 2.18258 18.4691V10.2545C2.18134 10.1508 2.19945 10.0479 2.23598 9.95087C1.81488 9.68754 1.47337 9.31459 1.24805 8.87198C1.02274 8.42938 0.922101 7.9338 0.956937 7.43837C0.991772 6.94294 1.16076 6.46632 1.4458 6.0596C1.73084 5.65288 2.12118 5.33138 2.57498 5.12957L12.6289 0.576172C14.2675 -0.173828 16.1509 -0.173828 17.7895 0.576172L27.8431 5.12987C28.3239 5.34664 28.7316 5.69814 29.0169 6.14182C29.3021 6.58549 29.4523 7.10233 29.4499 7.62977ZM18.5215 16.3082C17.4838 16.7905 16.3533 17.0403 15.209 17.0403C14.0647 17.0403 12.9343 16.7905 11.8966 16.3082L5.75378 13.5404V15.8261C5.75573 16.5125 5.91438 17.1894 6.21764 17.8053C6.5209 18.4211 6.96075 18.9595 7.50368 19.3796C12.0526 22.8557 18.3655 22.8557 22.9144 19.3796C23.455 18.9586 23.8921 18.4195 24.1922 17.8036C24.4924 17.1877 24.6477 16.5112 24.6463 15.8261V13.5227L23.5927 14.0048L18.5215 16.3082Z"
                            fill="black" />
                    </svg>
                </div>

                <button type="button" class="anonymous-feedback-last-modal-open">
                    Skip
                </button>
            </div>

            <div class="heading-and-pera">
                <h1 class="heading">How well prepared was the lesson?</h1>
                <p>This rating is anonymous</p>
            </div>

            <div class="rating-1-to-10-options">
                <ul class="options disabled-btn-remove-3">
                    <li><button>1</button></li>
                    <li><button>2</button></li>
                    <li><button>3</button></li>
                    <li><button>4</button></li>
                    <li><button>5</button></li>
                    <li><button>6</button></li>
                    <li><button>7</button></li>
                    <li><button>8</button></li>
                    <li><button>9</button></li>
                    <li><button>10</button></li>
                </ul>

                <div class="rating-description">
                    <p>Not at all</p>
                    <p>Fully</p>
                </div>
            </div>
        </div>

        <button class="red-button question-four-modal-open disabled-button">
            Next
        </button>
    </main>

    <!-- How well did Florida 1 needs your support? -->
    <main class="modal-basic-style rate-your-teacher-4-questions-modal question-four-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="question-progress-bar" style="--question-answer-progress: 75%"></div>

        <div class="content">
            <div class="icon-and-skip-button">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path
                            d="M14 0C6.2804 0 0 6.2804 0 14C0 21.7196 6.2804 28 14 28C21.7196 28 28 21.7196 28 14C28 6.2804 21.7196 0 14 0ZM14 25.4545C7.68396 25.4545 2.54545 20.316 2.54545 14C2.54545 7.68396 7.68396 2.54545 14 2.54545C20.316 2.54545 25.4545 7.68396 25.4545 14C25.4545 20.316 20.316 25.4545 14 25.4545Z"
                            fill="black" />
                        <path
                            d="M17.4202 17.4198C15.5344 19.3055 12.4663 19.3056 10.5805 17.4199C10.0835 16.9229 9.27765 16.9229 8.78061 17.4199C8.28357 17.917 8.28357 18.7228 8.78061 19.2198C10.2199 20.6591 12.1097 21.3784 14.0004 21.3784C15.8905 21.3784 17.7813 20.6588 19.2202 19.2198C19.7172 18.7228 19.7172 17.917 19.2202 17.4199C18.7231 16.9228 17.9172 16.9229 17.4202 17.4198ZM9.76977 12.4846C10.0863 12.169 10.267 11.7312 10.267 11.2849C10.267 10.8386 10.0863 10.4007 9.76977 10.0851C9.45414 9.76947 9.01632 9.58789 8.57002 9.58789C8.12278 9.58789 7.6859 9.76947 7.37017 10.0851C7.05377 10.4007 6.87305 10.8386 6.87305 11.2849C6.87305 11.7312 7.05377 12.169 7.37017 12.4846C7.6859 12.8011 8.12371 12.9818 8.57002 12.9818C9.01632 12.9818 9.45414 12.8011 9.76977 12.4846ZM19.4306 9.58789C18.9843 9.58789 18.5465 9.76947 18.2308 10.0851C17.9136 10.404 17.735 10.8351 17.7337 11.2849C17.7337 11.732 17.9152 12.169 18.2308 12.4846C18.5465 12.8011 18.9843 12.9818 19.4306 12.9818C19.8769 12.9818 20.3147 12.8011 20.6304 12.4846C20.946 12.169 21.1276 11.732 21.1276 11.2849C21.1276 10.8386 20.9459 10.4007 20.6304 10.0851C20.3147 9.76947 19.8769 9.58789 19.4306 9.58789Z"
                            fill="black" />
                    </svg>
                </div>

                <button type="button" class="anonymous-feedback-last-modal-open">
                    Skip
                </button>
            </div>

            <div class="heading-and-pera">
                <h1 class="heading">How well did Florida 1 needs your support?</h1>
                <p>This rating is anonymous</p>
            </div>

            <div class="rating-1-to-10-options">
                <ul class="options disabled-btn-remove-4">
                    <li><button>1</button></li>
                    <li><button>2</button></li>
                    <li><button>3</button></li>
                    <li><button>4</button></li>
                    <li><button>5</button></li>
                    <li><button>6</button></li>
                    <li><button>7</button></li>
                    <li><button>8</button></li>
                    <li><button>9</button></li>
                    <li><button>10</button></li>
                </ul>

                <div class="rating-description">
                    <p>Not at all</p>
                    <p>Fully</p>
                </div>
            </div>
        </div>

        <button class="red-button anonymous-feedback-last-modal-open disabled-button">
            Next
        </button>
    </main>

    <!-- Please write down your review for Florida 1 ! -->
    <main class="modal-basic-style rate-your-teacher-4-questions-modal anonymous-feedback-last-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="close-icon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="question-progress-bar" style="--question-answer-progress: 100%"></div>

        <div class="content">
            <div class="icon-and-skip-button">
                <div class="icon-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                        <path
                            d="M14 0C6.2804 0 0 6.2804 0 14C0 21.7196 6.2804 28 14 28C21.7196 28 28 21.7196 28 14C28 6.2804 21.7196 0 14 0ZM14 25.4545C7.68396 25.4545 2.54545 20.316 2.54545 14C2.54545 7.68396 7.68396 2.54545 14 2.54545C20.316 2.54545 25.4545 7.68396 25.4545 14C25.4545 20.316 20.316 25.4545 14 25.4545Z"
                            fill="black" />
                        <path
                            d="M17.4202 17.4198C15.5344 19.3055 12.4663 19.3056 10.5805 17.4199C10.0835 16.9229 9.27765 16.9229 8.78061 17.4199C8.28357 17.917 8.28357 18.7228 8.78061 19.2198C10.2199 20.6591 12.1097 21.3784 14.0004 21.3784C15.8905 21.3784 17.7813 20.6588 19.2202 19.2198C19.7172 18.7228 19.7172 17.917 19.2202 17.4199C18.7231 16.9228 17.9172 16.9229 17.4202 17.4198ZM9.76977 12.4846C10.0863 12.169 10.267 11.7312 10.267 11.2849C10.267 10.8386 10.0863 10.4007 9.76977 10.0851C9.45414 9.76947 9.01632 9.58789 8.57002 9.58789C8.12278 9.58789 7.6859 9.76947 7.37017 10.0851C7.05377 10.4007 6.87305 10.8386 6.87305 11.2849C6.87305 11.7312 7.05377 12.169 7.37017 12.4846C7.6859 12.8011 8.12371 12.9818 8.57002 12.9818C9.01632 12.9818 9.45414 12.8011 9.76977 12.4846ZM19.4306 9.58789C18.9843 9.58789 18.5465 9.76947 18.2308 10.0851C17.9136 10.404 17.735 10.8351 17.7337 11.2849C17.7337 11.732 17.9152 12.169 18.2308 12.4846C18.5465 12.8011 18.9843 12.9818 19.4306 12.9818C19.8769 12.9818 20.3147 12.8011 20.6304 12.4846C20.946 12.169 21.1276 11.732 21.1276 11.2849C21.1276 10.8386 20.9459 10.4007 20.6304 10.0851C20.3147 9.76947 19.8769 9.58789 19.4306 9.58789Z"
                            fill="black" />
                    </svg>
                </div>
            </div>

            <div class="heading-and-pera">
                <h1 class="heading">Please write down your review for Florida 1 !</h1>
                <p>This rating is anonymous</p>
            </div>

            <textarea name="student-review" id="student-review"
                placeholder="How was your learning experience? Write your review here..."></textarea>
        </div>

        <button class="red-button backdrop-level-2-close">Done</button>
    </main>

    <!-- How Would You Prefer to Share Your Feedback for Daniela Canelon? -->
    <main class="modal-basic-style give-feedback-to-teacher-modal">
        <div class="closeIcon backdrop-level-2-close desktop">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="heading-options">
            <div class="image-and-heading">
                <div class="mobile back-custom-icon">
                    <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="24px" height="24px" viewBox="0 0 66.91 122.88"
                        style="enable-background: new 0 0 66.91 122.88" xml:space="preserve">
                        <g>
                            <path
                                d="M64.96,111.2c2.65,2.73,2.59,7.08-0.13,9.73c-2.73,2.65-7.08,2.59-9.73-0.14L1.97,66.01l4.93-4.8l-4.95,4.8 c-2.65-2.74-2.59-7.1,0.15-9.76c0.08-0.08,0.16-0.15,0.24-0.22L55.1,2.09c2.65-2.73,7-2.79,9.73-0.14 c2.73,2.65,2.78,7.01,0.13,9.73L16.5,61.23L64.96,111.2L64.96,111.2L64.96,111.2z" />
                        </g>
                    </svg>
                </div>
                <div class="image-container">
                    <img src="../img/subs/1.png" alt="teacher" />
                </div>

                <h1>
                    How Would You Prefer to Share Your Feedback for Daniela Canelon?
                </h1>
            </div>

            <div class="bullet-select-options">
                <button>
                    <div class="icon-and-text">
                        <img src="../img/subs/icons/feedback-to-group.png" alt="" />
                        <p class="public-review-for-teacher">Public Review</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>

                <button>
                    <div class="icon-and-text">
                        <img src="../img/subs/icons/anonymous.png" alt="" />
                        <p>Anonymous feedback</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>
            </div>
        </div>

        <button class="red-button disabled-button">Continue</button>
    </main>

    <!-- Please write down your review for Daniela Canelon? -->
    <main class="modal-basic-style public-feedback-to-teacher-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="closeIcon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="heading-options">
            <div class="image-and-heading">
                <div class="image-container">
                    <img src="../img/subs/1.png" alt="teacher" />
                </div>

                <h1>Please write down your review for Daniela Canelon?</h1>

                <p>Help other students choose the right tutor</p>
            </div>

            <div class="selectable-stars outline-and-fill-star-container-two">
                <div class="outline-and-fill-star">
                    <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                        <path
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                        class="outline-star">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                            fill="#4D4C5C" />
                    </svg>
                </div>
                <div class="outline-and-fill-star">
                    <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                        <path
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                        class="outline-star">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                            fill="#4D4C5C" />
                    </svg>
                </div>
                <div class="outline-and-fill-star">
                    <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                        <path
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                        class="outline-star">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                            fill="#4D4C5C" />
                    </svg>
                </div>
                <div class="outline-and-fill-star">
                    <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                        <path
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                        class="outline-star">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                            fill="#4D4C5C" />
                    </svg>
                </div>
                <div class="outline-and-fill-star">
                    <svg class="star fill-star" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 33">
                        <path
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z" />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="33" viewBox="0 0 36 33" fill="none"
                        class="outline-star">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M22.4429 12.0637L17.9989 0.179688L13.5549 12.0637L0.879883 12.6177L10.8089 20.5157L7.41888 32.7417L17.9989 25.7397L28.5789 32.7417L25.1889 20.5157L35.1179 12.6177L22.4429 12.0637ZM20.4689 14.7817L17.9989 8.17969L15.5309 14.7817L8.48888 15.0897L14.0049 19.4777L12.1219 26.2697L17.9999 22.3797L23.8779 26.2697L21.9939 19.4777L27.5099 15.0897L20.4689 14.7817Z"
                            fill="#4D4C5C" />
                    </svg>
                </div>
            </div>

            <textarea name="review-text-area" id="review-text-area"
                placeholder="How was your learning experience? Write your review here..." required
                autocomplete="off"></textarea>
        </div>

        <button class="red-button success-modal-for-providing-feedback-modal-open">
            Post review
        </button>
    </main>

    <!-- How did it go with Daniela Canelon? -->
    <main class="modal-basic-style anonymous-feedback-to-teacher-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="closeIcon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="heading-options">
            <div class="image-and-heading">
                <div class="image-container">
                    <img src="../img/subs/1.png" alt="teacher" />
                </div>

                <h1>How did it go with Daniela Canelon?</h1>

                <p>This rating is anonymous</p>
            </div>

            <div class="bad-okay-great">
                <button class="card bad-option-select-modal-open">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.7199 19.0841L15.4812 17.891L15.004 15.5047H19.1835C19.6995 15.5047 20.2095 15.3931 20.6783 15.1776C21.1472 14.962 21.5639 14.6477 21.8999 14.256C22.2359 13.8644 22.4833 13.4047 22.625 12.9085C22.7668 12.4123 22.7995 11.8913 22.7211 11.3813L21.4361 3.02944C21.3061 2.18438 20.878 1.41376 20.2291 0.857013C19.5802 0.300268 18.7535 -0.00581905 17.8985 -0.00585938H11.2051C9.79182 -0.00570537 8.41021 0.412761 7.23438 1.19681L5.45901 2.38038H0.686523V13.1185H5.45901L9.20064 19.6663C9.51367 20.2143 9.96604 20.6698 10.5119 20.9867C11.0577 21.3035 11.6776 21.4703 12.3087 21.4703H16.1971L15.7199 19.0841ZM8.55874 3.18216L7.84525 3.65702V12.4849L11.2731 18.4828C11.3774 18.6654 11.5281 18.8172 11.71 18.9228C11.8919 19.0284 12.0984 19.084 12.3087 19.0841H13.2871L12.6643 15.9724L12.0928 13.1185H19.1835C19.3555 13.1184 19.5254 13.0812 19.6816 13.0093C19.8379 12.9374 19.9767 12.8326 20.0887 12.7021C20.2007 12.5715 20.2831 12.4183 20.3303 12.253C20.3775 12.0876 20.3884 11.914 20.3623 11.744L19.0785 3.39215C19.0352 3.11033 18.8923 2.85335 18.6759 2.66775C18.4594 2.48215 18.1836 2.38021 17.8985 2.38038H11.2051C10.2632 2.38064 9.34241 2.65961 8.55874 3.18216Z"
                            fill="#121117" />
                    </svg>

                    Bad
                </button>

                <button class="card">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="22" viewBox="0 0 23 22" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.6329 2.38038L15.3943 3.57351L14.9171 5.95975H19.0966C19.6126 5.95977 20.1225 6.07138 20.5914 6.28691C21.0603 6.50245 21.477 6.81681 21.813 7.20846C22.149 7.60012 22.3964 8.05979 22.5381 8.55598C22.6798 9.05217 22.7126 9.57314 22.6342 10.0832L21.3492 18.435C21.2192 19.2801 20.7911 20.0507 20.1422 20.6075C19.4933 21.1642 18.6666 21.4703 17.8116 21.4703H11.1182C9.7049 21.4702 8.3233 21.0517 7.14746 20.2677L5.3721 19.0841H0.599609V8.34599H5.3721L9.11373 1.79814C9.42676 1.25013 9.87912 0.794626 10.425 0.477811C10.9708 0.160996 11.5907 -0.0058662 12.2218 -0.00585937H16.1102L15.6329 2.38038ZM8.47183 18.2823L7.75834 17.8074V8.97835L11.1862 2.98052C11.2905 2.79831 11.4411 2.64687 11.6228 2.54149C11.8044 2.43612 12.0106 2.38054 12.2206 2.38038H13.199L12.5762 5.49205L12.0059 8.34599H19.0966C19.2686 8.34606 19.4385 8.3833 19.5947 8.45517C19.751 8.52704 19.8898 8.63184 20.0018 8.76238C20.1137 8.89293 20.1962 9.04613 20.2434 9.2115C20.2906 9.37687 20.3015 9.55049 20.2754 9.72047L18.9916 18.0723C18.9482 18.3541 18.8054 18.6111 18.5889 18.7967C18.3725 18.9823 18.0967 19.0843 17.8116 19.0841H11.1182C10.1763 19.0838 9.25549 18.8049 8.47183 18.2823Z"
                            fill="#121117" />
                    </svg>

                    Okay
                </button>

                <button class="card great-option-select-modal-open">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.6826 8.94185L15.4562 10.072L15.0043 12.3342H18.9657C21.0453 12.3342 22.6346 14.1874 22.3196 16.2429L21.1017 24.1595C20.9784 24.9606 20.5724 25.691 19.9572 26.2187C19.3421 26.7464 18.5583 27.0365 17.7479 27.0364H11.4034C10.0638 27.0363 8.75426 26.6396 7.63973 25.8964L5.95922 24.7761H2.72168V14.5972H5.95653L9.50458 8.38883C9.80126 7.86987 10.2298 7.4385 10.7468 7.13837C11.2637 6.83824 11.8508 6.68 12.4486 6.67969H16.1345L15.6826 8.94185ZM8.89429 24.0146L8.21869 23.5636V15.1968L11.467 9.51096C11.566 9.33791 11.7091 9.19413 11.8816 9.09418C12.0542 8.99424 12.2501 8.94168 12.4495 8.94185H13.3757L12.786 11.8903L12.2455 14.5963H18.9657C19.6592 14.5963 20.189 15.2138 20.0843 15.8992L18.8655 23.815C18.8245 24.082 18.6892 24.3255 18.4842 24.5015C18.2792 24.6774 18.018 24.7742 17.7479 24.7743H11.4034C10.5104 24.7743 9.63734 24.5099 8.89429 24.0146Z"
                            fill="#121117" />
                        <path
                            d="M20.9241 6.96594H24.8856C26.9652 6.96594 28.5553 8.81827 28.2394 10.8737L27.0216 18.7904C26.8982 19.5914 26.4923 20.3219 25.8771 20.8496C25.2619 21.3773 24.4782 21.6673 23.6677 21.6673H22.8561L23.1729 19.4051H23.6677C24.2261 19.4051 24.7012 18.998 24.7862 18.4459L26.0032 10.5301C26.028 10.369 26.0176 10.2044 25.9728 10.0476C25.9281 9.89083 25.8499 9.7456 25.7438 9.62185C25.6376 9.49811 25.506 9.39877 25.3578 9.33066C25.2097 9.26254 25.0486 9.22725 24.8856 9.22721H18.1653L19.2964 3.57181H18.3693C17.9631 3.57181 17.589 3.79015 17.3877 4.14182L16.5922 5.33733H13.9873L15.4235 3.01969C15.7203 2.50041 16.1491 2.06881 16.6664 1.76866C17.1837 1.4685 17.7712 1.31046 18.3693 1.31055H22.0552L20.9241 6.96594Z"
                            fill="#121117" />
                    </svg>

                    Great
                </button>
            </div>
        </div>
    </main>

    <!-- Awesome! What did you like? -->
    <main class="modal-basic-style great-option-select-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="closeIcon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="heading-options">
            <div class="heading-and-pera">
                <h1>Awesome! What did you like?</h1>
                <p>Choose one or more options</p>
            </div>

            <div class="suggested-feedback-options">
                <button class="parent-option" data-target="professional-approach">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6 0H4V3H0V17H18V3H14V0H6ZM12 2H6V3H12V2ZM6 5H12V15H6V5ZM16 15H14V5H16V15ZM4 5H2V15H4V5Z"
                            fill="#121117" />
                    </svg>

                    Professional approach
                </button>
                <div class="nested-options" id="professional-approach">
                    <button class="nested">Polite behavior</button>
                    <button class="nested">Organized</button>
                    <button class="nested">Disciplined</button>
                </div>

                <button class="parent-option" data-target="lesson-delivery">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path
                            d="M11 18L4 14.2V8.2L0 6L11 0L22 6V14H20V7.1L18 8.2V14.2L11 18ZM11 9.7L17.85 6L11 2.3L4.15 6L11 9.7ZM11 15.725L16 13.025V9.25L11 12L6 9.25V13.025L11 15.725Z"
                            fill="#121117" />
                    </svg>

                    Lesson delivery
                </button>
                <div class="nested-options" id="lesson-delivery">
                    <button class="nested">Right pace</button>
                    <button class="nested">Good preparation</button>
                    <button class="nested">On time</button>
                    <button class="nested">Knowledgeable</button>
                </div>

                <button class="parent-option" data-target="call-and-classroom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11 0H7V2H0V16H3V18H6V16H12V18H15V16H18V2H11V0ZM15 14H16V4H2V14H15ZM4 6H12V8H4V6ZM8 10H4V12H8V10Z"
                            fill="#121117" />
                    </svg>

                    Call and classroom
                </button>
                <div class="nested-options" id="call-and-classroom">
                    <button class="nested">Technical quality</button>
                    <button class="nested">Clear audio</button>
                    <button class="nested">No interruptions</button>
                </div>

                <button class="parent-option" data-target="tutor-personality">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9 16C8.08075 16 7.17049 15.8189 6.32122 15.4672C5.47194 15.1154 4.70026 14.5998 4.05025 13.9497C3.40024 13.2997 2.88463 12.5281 2.53284 11.6788C2.18106 10.8295 2 9.91925 2 9C2 8.08075 2.18106 7.17049 2.53284 6.32122C2.88463 5.47194 3.40024 4.70026 4.05025 4.05025C4.70026 3.40024 5.47194 2.88463 6.32122 2.53284C7.17049 2.18106 8.08075 2 9 2C10.8565 2 12.637 2.7375 13.9497 4.05025C15.2625 5.36301 16 7.14348 16 9C16 10.8565 15.2625 12.637 13.9497 13.9497C12.637 15.2625 10.8565 16 9 16ZM0 9C-1.76116e-08 7.8181 0.232792 6.64778 0.685084 5.55585C1.13738 4.46392 1.80031 3.47177 2.63604 2.63604C3.47177 1.80031 4.46392 1.13738 5.55585 0.685084C6.64778 0.232792 7.8181 0 9 0C10.1819 0 11.3522 0.232792 12.4442 0.685084C13.5361 1.13738 14.5282 1.80031 15.364 2.63604C16.1997 3.47177 16.8626 4.46392 17.3149 5.55585C17.7672 6.64778 18 7.8181 18 9C18 11.3869 17.0518 13.6761 15.364 15.364C13.6761 17.0518 11.3869 18 9 18C6.61305 18 4.32387 17.0518 2.63604 15.364C0.948211 13.6761 3.55683e-08 11.3869 0 9ZM8 6H5V9H8V6ZM10 6H13V9H10V6ZM9 14C9.9731 14.0001 10.9251 13.7164 11.7393 13.1835C12.5536 12.6507 13.1946 11.8918 13.584 11H4.416C4.80536 11.8918 5.44644 12.6507 6.26067 13.1835C7.0749 13.7164 8.0269 14.0001 9 14Z"
                            fill="#121117" />
                    </svg>

                    Tutor personality
                </button>
                <div class="nested-options" id="tutor-personality">
                    <button class="nested">Friendly</button>
                    <button class="nested">Supportive</button>
                    <button class="nested">Motivating</button>
                </div>

                <button class="parent-option" data-target="clear-communication">
                    Clear communication
                </button>

                <button class="parent-option" data-target="something-else">
                    Something else
                </button>
            </div>
        </div>

        <button class="red-button anonymous-teacher-feedback-last-modal-open">
            Give Feedback
        </button>
    </main>

    <!-- What did Not like in Daniela? -->
    <main class="modal-basic-style bad-option-select-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="closeIcon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="heading-options">
            <div class="heading-and-pera">
                <h1>What did Not like in Daniela?</h1>
                <p>Choose one or more options</p>
            </div>

            <div class="suggested-feedback-options">
                <button class="parent-option" data-target="unprofessional-approach">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6 0H4V3H0V17H18V3H14V0H6ZM12 2H6V3H12V2ZM6 5H12V15H6V5ZM16 15H14V5H16V15ZM4 5H2V15H4V5Z"
                            fill="#121117" />
                    </svg>

                    Unprofessional approach
                </button>
                <div class="nested-options" id="unprofessional-approach">
                    <button class="nested">Rude behavior</button>
                    <button class="nested">Disorganized</button>
                    <button class="nested">Irresponsible</button>
                </div>

                <button class="parent-option" data-target="poor-lesson-delivery">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
                        <path
                            d="M11 18L4 14.2V8.2L0 6L11 0L22 6V14H20V7.1L18 8.2V14.2L11 18ZM11 9.7L17.85 6L11 2.3L4.15 6L11 9.7ZM11 15.725L16 13.025V9.25L11 12L6 9.25V13.025L11 15.725Z"
                            fill="#121117" />
                    </svg>

                    Poor lesson delivery
                </button>
                <div class="nested-options" id="poor-lesson-delivery">
                    <button class="nested">Too fast pace</button>
                    <button class="nested">Unprepared</button>
                    <button class="nested">Often late</button>
                    <button class="nested">Lack of knowledge</button>
                </div>

                <button class="parent-option" data-target="technical-issues">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11 0H7V2H0V16H3V18H6V16H12V18H15V16H18V2H11V0ZM15 14H16V4H2V14H15ZM4 6H12V8H4V6ZM8 10H4V12H8V10Z"
                            fill="#121117" />
                    </svg>

                    Technical issues
                </button>
                <div class="nested-options" id="technical-issues">
                    <button class="nested">Bad audio</button>
                    <button class="nested">Frequent disconnections</button>
                    <button class="nested">Poor video quality</button>
                </div>

                <button class="parent-option" data-target="personality-issues">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9 16C8.08075 16 7.17049 15.8189 6.32122 15.4672C5.47194 15.1154 4.70026 14.5998 4.05025 13.9497C3.40024 13.2997 2.88463 12.5281 2.53284 11.6788C2.18106 10.8295 2 9.91925 2 9C2 8.08075 2.18106 7.17049 2.53284 6.32122C2.88463 5.47194 3.40024 4.70026 4.05025 4.05025C4.70026 3.40024 5.47194 2.88463 6.32122 2.53284C7.17049 2.18106 8.08075 2 9 2C10.8565 2 12.637 2.7375 13.9497 4.05025C15.2625 5.36301 16 7.14348 16 9C16 10.8565 15.2625 12.637 13.9497 13.9497C12.637 15.2625 10.8565 16 9 16ZM0 9C-1.76116e-08 7.8181 0.232792 6.64778 0.685084 5.55585C1.13738 4.46392 1.80031 3.47177 2.63604 2.63604C3.47177 1.80031 4.46392 1.13738 5.55585 0.685084C6.64778 0.232792 7.8181 0 9 0C10.1819 0 11.3522 0.232792 12.4442 0.685084C13.5361 1.13738 14.5282 1.80031 15.364 2.63604C16.1997 3.47177 16.8626 4.46392 17.3149 5.55585C17.7672 6.64778 18 7.8181 18 9C18 11.3869 17.0518 13.6761 15.364 15.364C13.6761 17.0518 11.3869 18 9 18C6.61305 18 4.32387 17.0518 2.63604 15.364C0.948211 13.6761 3.55683e-08 11.3869 0 9ZM8 6H5V9H8V6ZM10 6H13V9H10V6ZM9 14C9.9731 14.0001 10.9251 13.7164 11.7393 13.1835C12.5536 12.6507 13.1946 11.8918 13.584 11H4.416C4.80536 11.8918 5.44644 12.6507 6.26067 13.1835C7.0749 13.7164 8.0269 14.0001 9 14Z"
                            fill="#121117" />
                    </svg>

                    Personality issues
                </button>
                <div class="nested-options" id="personality-issues">
                    <button class="nested">Unfriendly</button>
                    <button class="nested">Not supportive</button>
                    <button class="nested">Demotivating</button>
                </div>

                <button class="parent-option" data-target="unclear-communication">
                    Unclear communication
                </button>

                <button class="parent-option" data-target="other-negative">
                    Something else
                </button>
            </div>
        </div>

        <button class="red-button anonymous-teacher-feedback-last-modal-open">
            Give Feedback
        </button>
    </main>

    <!-- Please write down your review for Daniela Canelon? -->
    <main class="modal-basic-style anonymous-teacher-feedback-last-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="closeIcon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="heading-options">
            <div class="image-and-heading">
                <div class="image-container">
                    <img src="../img/subs/1.png" alt="teacher" />
                </div>

                <h1>Please write down your review for Daniela Canelon?</h1>

                <p>This rating is anonymous</p>
            </div>

            <textarea name="review-text-area" id="review-text-area"
                placeholder="How was your learning experience? Write your review here..." required
                autocomplete="off"></textarea>
        </div>

        <button class="red-button success-modal-for-providing-feedback-modal-open">
            Done
        </button>
    </main>

    <!-- Tell Us What Happened -->
    <main class="modal-basic-style tell-us-what-happened-modal">
        <div class="closeIcon backdrop-level-2-close desktop">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>
        <div class="mobile back-custom-icon">
            <?xml version="1.0" encoding="utf-8"?><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px"
                viewBox="0 0 66.91 122.88" style="enable-background: new 0 0 66.91 122.88" xml:space="preserve">
                <g>
                    <path
                        d="M64.96,111.2c2.65,2.73,2.59,7.08-0.13,9.73c-2.73,2.65-7.08,2.59-9.73-0.14L1.97,66.01l4.93-4.8l-4.95,4.8 c-2.65-2.74-2.59-7.1,0.15-9.76c0.08-0.08,0.16-0.15,0.24-0.22L55.1,2.09c2.65-2.73,7-2.79,9.73-0.14 c2.73,2.65,2.78,7.01,0.13,9.73L16.5,61.23L64.96,111.2L64.96,111.2L64.96,111.2z" />
                </g>
            </svg>
        </div>
        <div class="main-content">
            <div class="icon-and-content">
                <img src="../img/subs/icons/report-a-issue.png" alt="" />

                <div class="content">
                    <h1>Tell Us What Happened</h1>
                    <p>Helps us impove by reporting an issue</p>
                </div>
            </div>

            <div class="bullet-select-options">
                <button>
                    <div class="icon-and-text">
                        <p>Difficulty in Understanding</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>

                <button>
                    <div class="icon-and-text">
                        <p>Unequal Participation</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>

                <button>
                    <div class="icon-and-text">
                        <p>Lack of Feedback</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>

                <button>
                    <div class="icon-and-text">
                        <p>Distractions and Lack of Focus</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>

                <button>
                    <div class="icon-and-text">
                        <p>Other</p>
                    </div>
                    <div class="circle-outline">
                        <div class="fill-circle"></div>
                    </div>
                </button>
            </div>
        </div>

        <button class="red-button explain-your-issue-modal-open disabled-button">
            Continue
        </button>
    </main>

    <!-- Please Explain your Issue -->
    <main class="modal-basic-style explain-your-issue-modal">
        <div class="back-icon back-modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M3.91406 8.9932L15.9141 8.9932L15.9141 6.99319L3.91406 6.9932L9.20706 1.7002L7.79306 0.286195L0.0860627 7.9932L7.79306 15.7002L9.20706 14.2862L3.91406 8.9932Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="closeIcon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="main-content">
            <div class="icon-and-content">
                <img src="../img/subs/icons/report-a-issue.png" alt="" />

                <div class="content">
                    <h1>Please Explain your Issue</h1>
                    <p>Helps us impove by reporting an issue</p>
                </div>
            </div>

            <textarea name="review-text-area" id="review-text-area"
                placeholder="How was your learning experience? Write your review here..." autocomplete="off"></textarea>
        </div>

        <button class="red-button issue-reported-modal-open">
            Report an issue
        </button>
    </main>

    <!-- Issue have been reported thanks for your feedback -->
    <main class="modal-basic-style issue-reported-modal">
        <div class="closeIcon backdrop-level-2-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1.414 0L0 1.414L4.95 6.364L0 11.314L1.414 12.728L6.364 7.778L11.314 12.728L12.728 11.314L7.778 6.364L12.728 1.414L11.314 0L6.364 4.95L1.414 0Z"
                    fill="#121117" />
            </svg>
        </div>

        <div class="icon-and-heading">
            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42" viewBox="0 0 43 42" fill="none">
                    <path
                        d="M21.5 14.2245V21.1412M21.5 28.0579H21.5173M18.5431 5.33662L3.89704 29.787C3.59508 30.31 3.4353 30.9029 3.43361 31.5067C3.43192 32.1106 3.58837 32.7044 3.88741 33.229C4.18644 33.7536 4.61763 34.1908 5.13808 34.497C5.65853 34.8033 6.25009 34.9679 6.85392 34.9745H36.146C36.7498 34.9679 37.3414 34.8033 37.8618 34.497C38.3823 34.1908 38.8135 33.7536 39.1125 33.229C39.4115 32.7044 39.568 32.1106 39.5663 31.5067C39.5646 30.9029 39.4048 30.31 39.1029 29.787L24.4568 5.33662C24.1486 4.82843 23.7145 4.40826 23.1966 4.11666C22.6787 3.82507 22.0943 3.67188 21.5 3.67188C20.9056 3.67188 20.3212 3.82507 19.8033 4.11666C19.2854 4.40826 18.8513 4.82843 18.5431 5.33662Z"
                        stroke="#FF2500" stroke-width="3.45833" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            <h1>Issue have been reported thanks for your feedback</h1>
        </div>

        <button class="red-button backdrop-level-2-close">Done</button>
    </main>
    <section class="backdrop"></section>
    <section class="backdrop_nested"></section>
    <section class="calendar_backdrop"></section>
    <!-- prefer to share your feedback for Florida -->

</div>

<?php // 1️⃣ Check if the user has the "student" role in Moodle.
$context = context_system::instance();
//$isStudent = user_has_role_assignment($user->id, 5, $context->id); // 5 is usually the student role ID

// Check if the user is a student (5) or teacher (3)
$isStudent = (
    is_only_student($user->id)
);



if ($isStudent) {
    // 2️⃣ Fetch all subscriptions from paypal_subscriptions.
    $paypalSubscriptions = $DB->get_records_sql("SELECT email, status FROM {paypal_subscriptions} ORDER BY id DESC");
    
    // 2️⃣ Fetch all subscriptions from local_subscriptions.
    //$localSubscriptions = $DB->get_records_sql("SELECT sub_email AS email, status FROM {local_subscriptions} ORDER BY id DESC");

    // 2️⃣ Fetch subscriptions from local_subscriptions, normalizing the status.
    $localSubscriptionsRaw = $DB->get_records_sql("
        SELECT sub_email AS email, sub_status, sub_history, sub_reference
        FROM {local_subscriptions}
        ORDER BY id DESC
    ");


    foreach ($localSubscriptionsRaw as $sub) {
    $code = (int)$sub->sub_status;

    if ($code === 1) {
        $sub->status = 'active';
    } elseif ($code === 5 ) {
        $sub->status = 'declined';
    } else {
        $sub->status = 'inactive';
    }

    unset($sub->sub_status); // Optional: remove original field.
    $localSubscriptions[] = $sub;
}

   // 2️⃣ Fetch all subscriptions from patreon_subscriptions.
$patreonSubscriptionsRaw = $DB->get_records_sql("
    SELECT email, status, planid, subscriber_id, price
    FROM {membership_patreon_subscriptions}
    ORDER BY id DESC
");
$patreonSubscriptions = [];
foreach ($patreonSubscriptionsRaw as $psub) {
    $code = $psub->status;

    if ($code === 'active_patron') {
        $psub->status = 'active';
    } elseif ($code === 'former_patron') {
        $psub->status = 'inactive';
    } else {
        $psub->status = 'inactive';
    }

    $patreonSubscriptions[] = $psub;
}

// ✅ Merge all subscription arrays (PayPal + Local + Patreon).
$allSubscriptions = array_merge($paypalSubscriptions, $localSubscriptions, $patreonSubscriptions);
    
    $subscriptionIsActive = false;
    $subscriptionIsDeclined = false;
    $forcedSubscriptionId = '';
    
    
    foreach ($allSubscriptions as $subscription) {
        if (strtolower(trim($subscription->email)) === strtolower(trim($user->email))) {
      
            // Found the user's subscription.
            if (strtolower($subscription->status) === 'active') {
                $subscriptionIsActive = true;
                if($subscription->price)
                {
                   $price = $subscription->price;
                }
               
                break; // No need to check further.
            }
            

            if($subscription->price)
                {
                   $price = $subscription->price;
                }

            if (strtolower($subscription->status) === 'declined') {

                $subscriptionIsDeclined = true;
                 $forcedSubscriptionId = $subscription->sub_reference;
                 //$forcedSubscriptionId = 'cvbv9k';
                break; // No need to check further.
            }
            
             // If this is a local subscription, sub_history will exist (JSON array).
        if (!empty($subscription->sub_history)) {
            $hist = json_decode($subscription->sub_history, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($hist)) {
                // Use the last entry that has a plan_price.
                for ($i = count($hist) - 1; $i >= 0; $i--) {
                    if (isset($hist[$i]['plan_price']) && $hist[$i]['plan_price'] !== '') {
                        $price = (float)$hist[$i]['plan_price']; // e.g., 15.0
                        break;
                    }
                }
            }
        }

     
            
            
        }
    }
    
    
    // 3️⃣ If user subscription is not active, include the file.
     if (!$subscriptionIsActive) {

    $manualSubscriptions = $DB->get_records_sql("
        SELECT id, start_date, end_date, status
        FROM {manual_user_registrations}
        WHERE userid = ?
        ORDER BY id DESC
    ", [$user->id]);

    $hasManual = false;
    $now = time();

    foreach ($manualSubscriptions as $manualSub) {
        $hasManual = true;
        $start = (int)$manualSub->start_date;
        $end = (int)$manualSub->end_date;
        $status = strtolower($manualSub->status);

        if ($status === 'active') {
            if ($start <= $now && $now <= $end) {
                $subscriptionIsActive = true;
                exit; // ✅ Valid subscription, stop here
            } elseif ($start > $now) {
                // Future subscription
                echo '<script>';
                echo 'window.subscriptionStartDate = "' . date('d/m/Y', $start) . '";';
                echo 'window.subscriptionEndDate = "' . date('d/m/Y', $end) . '";';
                echo '</script>';

                require_once('user_pay_subscription_dates_modal.php');
                exit;
            } elseif ($end < $now) {
                // ❌ Expired subscription — deactivate and show contact modal
                $DB->set_field('manual_user_registrations', 'status', 'inactive', ['id' => $manualSub->id]);

                require_once('user_pay_subscription_contact_modal.php');
                exit;
            }
        }
    }

      if (!$subscriptionIsActive) {

         $subid = $DB->get_field('user_info_data', 'data', [
    'userid' => $user->id,
    'fieldid' => $DB->get_field('user_info_field', 'id', ['shortname' => 'SubID'])
]);

          // Step 2: If SubID exists, check in paypal_subscriptions table
    if (!empty($subid)) {
        $record = $DB->get_record('paypal_subscriptions', ['subscription_id' => $subid], 'status');

        if ($record) {
            $status = $record->status;

            if($status === 'active')
            {
                $subscriptionIsActive = true;
            }

            // Now you can use $status as needed
            // Example: echo $status;
        } else {
            // No matching subscription found
            $status = null;
        }
    } else {
        // SubID is empty or not set
        $status = null;
    }

      }
      

    // ❌ No manual subscriptions at all or not active
    if (!$subscriptionIsActive || !$hasManual) {
        if($subscriptionIsActive)
        {

        }else{
            
            if($hasManual)
            {

            }else{
                

                      $subid = $DB->get_field('user_info_data', 'data', [
                            'userid' => $user->id,
                            'fieldid' => $DB->get_field('user_info_field', 'id', ['shortname' => 'SubID'])
                        ]);

                        if($subid)
                        {
                            $record = $DB->get_record('paypal_subscriptions', ['subscription_id' => $subid], 'price');

                            if($record)
                            {
                                $price = $record->price;

                            }else{
                              $record = $DB->get_record('local_subscriptions', ['sub_reference' => $subid], 'sub_history');

                                $planprice = null;

                                if ($record && !empty($record->sub_history)) {
                                    $history = json_decode($record->sub_history, true); // Decode as associative array

                                    if (is_array($history) && isset($history[0]['plan_price'])) {
                                        $price = $history[0]['plan_price'];

                                        // Optional: echo or use it
                                        // echo "Plan Price: $planprice";
                                    }
                                }
                            }
                        }else{
                            //$price = 73;
                            
                        }
                        

                        // ✅ Declare it global before including the file
               global $price;

               if($subscriptionIsDeclined)
               {
                global $forcedSubscriptionId;
                     require_once('userSubscritionReTryPayment.php'); 
                     //require_once('user_pay_subscription.php');
               }else{
               require_once('user_pay_subscription.php');
               }
               
            }
          
        }
        
    }
}
}else{
    require_login();
    if(!is_siteadmin($user->id)){
        if (!$isteacher) {
        $price = 73;
               global $price;
               require_once('user_pay_subscription.php');
            }
    }
}

?>




<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="../js/calendar.js?v=<?php echo time(); ?>"></script>
<script src="../js/MessageTypingArea.js?v=<?php echo time(); ?>"></script>
<script src="../js/script.js?v=<?php echo time(); ?>"></script>
<script src="../js/modifyindex.js?v=<?php echo time(); ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<?php

/**
 * Return true if $sectionname is for the given teacher ($fname, $lname).
 * Accepts formats like "Teacher Axley P." or "Teacher Axley Patel".
 */
function section_is_for_teacher(?string $sectionname, string $fname, string $lname): bool {
    if (empty($sectionname)) {
        return false;
    }

    // 1) Extract the part after the word "Teacher" if present
    $teacherpart = $sectionname;
    if (preg_match('/\bTeacher\b[[:space:]:\-–—]*(.+)$/ui', $sectionname, $m)) {
        $teacherpart = trim($m[1]);
    }

    // 2) Normalize spacing & strip noisy chars (keep letters, digits, space, dot, hyphen, apostrophe)
    $teacherpart = preg_replace('/\s+/u', ' ', $teacherpart);
    $teacherpart = trim(preg_replace("/[^\p{L}\p{N}\s.\-']+/u", '', $teacherpart));

    if ($teacherpart === '') {
        return false;
    }

    // 3) Split into tokens and pick first & last token
    $pieces = preg_split('/\s+/u', $teacherpart, -1, PREG_SPLIT_NO_EMPTY);
    if (!$pieces || count($pieces) < 1) {
        return false;
    }
    $tFirst = $pieces[0];
    $tLast  = count($pieces) > 1 ? end($pieces) : '';

    // 4) Lowercase comparisons (Moodle-safe)
    $fnameL = core_text::strtolower(trim($fname));
    $lnameL = core_text::strtolower(trim($lname));
    $tFirstL = core_text::strtolower($tFirst);
    $tLastL  = core_text::strtolower(rtrim($tLast, '.')); // allow "P."

    // Derive last-name initial (first letter in the surname)
    $lnameInitial = '';
    if (preg_match('/\p{L}/u', $lname, $mm)) { // first letter-like char
        $lnameInitial = core_text::strtolower($mm[0]);
    }

    // Must match first name exactly, and last either full match or initial match
    $firstMatches = ($tFirstL === $fnameL);
    $lastMatches  = ($tLastL === $lnameL) || ($tLastL !== '' && $tLastL === $lnameInitial);

    return $firstMatches && $lastMatches;
}


/**
 * From a CM availability JSON, find the profile condition "email == X"
 * and return the matching user record (or null if not found).
 *
 * @param string|null $availabilityjson  Raw JSON from $cm->availability
 * @param string      $fields            Fields to select from 'user' (default small set; use '*' if you need all)
 * @return stdClass|null                 user record or null
 */
function availability_extract_user(?string $availabilityjson, string $fields = 'id,firstname,lastname,email'): ?stdClass {
    global $DB;

    if (empty($availabilityjson)) {
        return null;
    }

    $tree = json_decode($availabilityjson, true);
    if (!is_array($tree)) {
        // Uncomment to debug malformed JSON:
        // error_log('availability JSON decode error: ' . json_last_error_msg() . ' | payload: ' . $availabilityjson);
        return null;
    }

    // DFS over the availability tree
    $stack = [$tree];
    while ($stack) {
        $node = array_pop($stack);
        if (!is_array($node)) {
            continue;
        }

        // Check a profile condition node
        if (($node['type'] ?? null) === 'profile') {
            // Moodle stores profile field under 'sf' (short field). Fallback to 'field' just in case.
            $field = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
            if ($field === 'email') {
                // Value usually in 'v'; fallback to 'value'
                $val = $node['v'] ?? $node['value'] ?? null;
                if (is_string($val) && $val !== '') {
                    $email = trim($val);

                    // Resolve user by email (case-insensitive), not deleted
                    $user = $DB->get_record_select(
                        'user',
                        'LOWER(email) = LOWER(:email) AND deleted = 0',
                        ['email' => $email],
                        $fields
                    );
                    return $user ?: null;
                }
            }
        }

        // Traverse children under 'c'
        if (!empty($node['c']) && is_array($node['c'])) {
            foreach ($node['c'] as $child) {
                if (is_array($child)) {
                    $stack[] = $child;
                }
            }
        }

        // Some trees include 'showc' (often [true]); only push arrays
        if (!empty($node['showc']) && is_array($node['showc'])) {
            foreach ($node['showc'] as $child) {
                if (is_array($child)) {
                    $stack[] = $child;
                }
            }
        }
    }

    return null;
}

/**
 * Convenience: nice date/time bits in user TZ.
 */
function format_session_times(int $startts, int $endts): array {
    if ($endts <= $startts) {
        $endts = $startts + 3600; // fallback 60m
    }
    $fullDayName    = userdate($startts, '%A');       // Monday
    $displayDate    = userdate($startts, '%B %e');    // August 23
    $formattedStart = trim(userdate($startts, '%l:%M %p'));
    $formattedEnd   = trim(userdate($endts,   '%l:%M %p'));
    return [$displayDate, $fullDayName . ' at ' . $formattedStart . ' - ' . $formattedEnd];
}


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


?>




<?php

echo $OUTPUT->footer();