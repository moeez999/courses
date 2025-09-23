<?php
require_once('../config.php');
require_once(__DIR__ . '/lib.php');

global $DB;

if (isset($_POST['cohortid'])) {

    // Fetch the course details using the idnumber.
    $course = $DB->get_record('course', ['idnumber' => 'CR001'], '*');

    $cohortid = intval($_POST['cohortid']);

  
                            

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

                    $i = 0;
                
                    foreach ($allowed_sections as $section) {

                        if($i == 0)
                        {
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
                                        $schedules[] = [
                                            'starthour' => $googleMeetActivity->starthour,
                                            'startminute' => $googleMeetActivity->startminute,
                                            'days' => $googleMeetActivity->days,
                                        ];
                
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
                        $i++;
                    }
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
                        foreach ($googleMeetActivities as $activity) {
                            
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
                            
                                usort($activeDays, function($a, $b) use ($dayMap) {
                                    return $dayMap[$a] - $dayMap[$b];
                                });
                            
                                // Collect formatted classes
                                $today = new DateTime();
                                $classCount = 0;
                                $maxClasses = 12;
                                $weekOffset = 1;
                            
                                while ($classCount < $maxClasses) {
                                    foreach ($activeDays as $dayKey) {
                                        if ($classCount >= $maxClasses) break;
                            
                                        $nextDate = new DateTime("next " . $fullDayMap[$dayKey]);
                                        $nextDate->modify("+".($weekOffset - 1)." week");
                            
                                        $fullDayName = $nextDate->format('l'); // e.g., Thursday
                                        $formattedTime = date('g:i A', strtotime(sprintf('%02d:%02d', $googleMeet->starthour, $googleMeet->startminute)));
                            
                                        // Determine class type based on name
                                        $classType = 'Group Class';
                                        if (strpos($googleMeet->name, 'Main') !== false) {
                                            $classType = 'Main Class';
                                        } elseif (strpos($googleMeet->name, 'Practice') !== false) {
                                            $classType = 'Practice Class';
                                        }
                            
                                        $allMeetFutureDates[] = [
                                            'date' => $nextDate->format('Y-m-d'),
                                            'class_display' => [
                                                'date' => $nextDate->format('F j'), // e.g., April 4
                                                'day_time' => $fullDayName . ' at ' . $formattedTime, // e.g., Thursday at 10:30 AM
                                                'short_text' => $classType,
                                                'type' => 'group',
                                                'image' => '',
                                                'user' => ''
                                            ]
                                        ];
                            
                                        $classCount++;
                                    }
                                    $weekOffset++;
                                }
                            
                            
                            // Sort by actual date
                            usort($allMeetFutureDates, function($a, $b) {
                                return strtotime($a['date']) - strtotime($b['date']);
                            });
                            
                            // Slice top 12 and return only the display info
                            $finalUpcoming12 = array_map(function($entry) {
                                return $entry['class_display'];
                            }, array_slice($allMeetFutureDates, 0, 12));

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

                                foreach ($recurringDays as $dayName => $isActive) {
                                    if ($isActive !== "1") continue;

                                    $fullDayName = $fullDayMap[$dayName];

                                    // Find the next occurrence of this day
                                    $targetWeekday = $dayMap[$dayName];
                                    $nextDate = clone $today;
                                    $daysToAdd = ($targetWeekday - (int)$today->format('w') + 7) % 7;
                                    if ($daysToAdd === 0) $daysToAdd = 7; // Skip today, take next week's same day

                                    $nextDate->modify("+$daysToAdd days");

                                    // Determine class type based on name
                                    $classType = 'Group Class'; // default fallback

                                    if (strpos($googleMeet->name, 'Main') !== false) {
                                        $classType = 'Main Class';
                                    } elseif (strpos($googleMeet->name, 'Practice') !== false) {
                                        $classType = 'Practice Class';
                                    }

                                    // Build entry
                                    $classes[] = [
                                        'date' => $nextDate->format('F j'), // Ex: April 4
                                        'day_time' => $fullDayName . ' at ' . $formattedTimee,
                                        'short_text' => $classType,
                                        'type' => 'group',
                                        'image' => '',
                                        'user' => '' // You can add teacher's name here later
                                    ];
                                }
                             
                            
                        }
                    } 
                } else {
                    //echo "No topics are restricted to cohort ID $cohortid in this course.";
                }
                
                // Fetch the Google Meet activity record
                if($mostUpcomingSchedule){
                    $googleMeet = $DB->get_record('googlemeet', ['id' => $mostUpcomingSchedule->googlemeetid], '*', MUST_EXIST);
                
                }
                // Fetch the Google Meet activity record
                if ($mostUpcomingSchedule) {
                    $googleMeet = $DB->get_record('googlemeet', ['id' => $mostUpcomingSchedule->googlemeetid], '*', MUST_EXIST);

                    // Extract recurrence details
                    $eventDate = date('Y-m-d', $googleMeet->eventdate); // Start date of the recurring event
                    $startHour = str_pad($googleMeet->starthour, 2, '0', STR_PAD_LEFT); // Ensure 2-digit format
                    $startMinute = str_pad($googleMeet->startminute, 2, '0', STR_PAD_LEFT);
                    $endHour = str_pad($googleMeet->endhour, 2, '0', STR_PAD_LEFT);
                    $endMinute = str_pad($googleMeet->endminute, 2, '0', STR_PAD_LEFT);
                    $meetName = $googleMeet->originalname;

                    $customTitle = null;
                    $sessionMessage = null;
                    
                    // Check for "Main Classes" or "Practice Session"
                    if (preg_match('/(.*?)\s+(Main Classes|Practice Session)/i', $meetName, $matches)) {
                        $extractedText = trim($matches[1]); // Text before "Main Classes" or "Practice Session"
                        $sessionType = $matches[2]; // Capture either "Main Classes" or "Practice Session"
                    
                        // Format custom title
                        if (stripos($sessionType, 'Main Classes') !== false) {
                            $customTitle = "Main Class with Prof. $teacherName, $extractedText";
                        } elseif (stripos($sessionType, 'Practice Session') !== false) {
                            $customTitle = "Practice Class with Prof. $teacherName, $extractedText";
                        }

                        // Determine class type based on name
                        $sessionTypee = 'Group Class'; // default fallback

                        if (strpos($sessionType, 'Main') !== false) {
                            $sessionTypee = 'Main Class';
                        } elseif (strpos($sessionType, 'Practice') !== false) {
                            $sessionTypee = 'Practice Class';
                        }
                    
                        // Format session message
                        $sessionMessage = "Your $sessionTypee Starts Soon";
                    }
                    
                    // Output results
                    // if ($customTitle) {
                    //     echo $customTitle . PHP_EOL;
                    // }
                    // if ($sessionMessage) {
                    //     echo $sessionMessage . PHP_EOL;
                    // }

                    
                    // Decode the repeating days JSON ({"Mon":"1","Tue":"1","Wed":"1"})
                    $recurringDays = json_decode($googleMeet->days, true); 

                    // Get today's and tomorrow's weekday names
                    $todayName = date('D');  // e.g., "Mon"
                    $tomorrowName = date('D', strtotime('+1 day')); // e.g., "Tue"

                    $savedDate = null;
                    $upcomingMeetingDay = null;

                    // Check if the meeting repeats today or tomorrow
                    if (!empty($recurringDays[$todayName])) {
                        $savedDate = 'today';
                        $upcomingMeetingDay = date('l'); // Full day name (e.g., Monday)
                    } elseif (!empty($recurringDays[$tomorrowName])) {
                        $savedDate = 'tomorrow';
                        $upcomingMeetingDay = date('l', strtotime('+1 day')); // Full day name (e.g., Tuesday)
                    } else {
                        // If not today or tomorrow, find the next occurrence
                        $currentDate = strtotime('today');
                        for ($i = 2; $i <= 7; $i++) { // Check the next 7 days
                            $nextDate = strtotime("+$i days", $currentDate);
                            $nextDayName = date('D', $nextDate);
                            
                            if (!empty($recurringDays[$nextDayName])) {
                                $savedDate = date('j F Y', $nextDate); // Format as "7 April 2025"
                                $upcomingMeetingDay = date('l', $nextDate); // Full day name (e.g., Monday)
                                break;
                            }
                        }
                    }

                    // Concatenate the meeting day and time
                    if ($upcomingMeetingDay) {
                        // Create 12-hour format times with AM/PM
                        $startTimeFormatted = date("g:i A", strtotime("$startHour:$startMinute"));
                        $endTimeFormatted = date("g:i A", strtotime("$endHour:$endMinute"));
                        $meetingSchedule = "$upcomingMeetingDay at $startTimeFormatted";
                        //echo "Upcoming Meeting: " . $meetingSchedule;
                    }
                }

                // Extract the URL from the record
                $googleMeetURL = $googleMeet->url;
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

header('Content-Type: application/json');

echo json_encode([
    // 'cohortId'            => $cohortid,
    // 'googleMeetUrl'       => $googleMeetURL ?? null,
    // 'customTitle'         => $customTitle ?? null,
    // 'sessionMessage'      => $sessionMessage ?? null,
    // 'meetingSchedule'     => $meetingSchedule ?? null,
    // 'finalUpcoming12'     => $finalUpcoming12 ?? [],
    // 'classes'             => $classes ?? [],
    // 'allDaysWithHours'    => $allDaysWithHours ?? [],
    // 'teacherName'         => $teacherName ?? '',
    // 'mostUpcomingSchedule'=> $mostUpcomingSchedule ?? null,
    // 'cohortData'          => $cohortData ?? [],
    // 'allowedSections'     => $allowed_sections ?? [],
    // 'googleMeetActivities'=> $googleMeetActivities ?? [],
    'dayOrder'            => $dayOrder,
    'allDaysWithHours'    => $allDaysWithHours,
    'cohortId' => $cohortid,
    'courseId' => $course->id,
]);
exit;
                        

}else {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}