<?php define('NO_MOODLE_COOKIES', true);
define('AJAX_SCRIPT', true);
ob_start();
require_once(__DIR__ . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->dirroot . '/user/profile/lib.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->libdir.'/filelib.php');

// Debug mode - set to true to enable debug output
define('DEBUG_MODE', true);

// Debug function
function debug_log($message, $data = null) {
    if (DEBUG_MODE) {
        error_log("[DEBUG] " . $message);
        if ($data !== null) {
            error_log(print_r($data, true));
        }
    }
}

// Set JSON headers
// Enforce JSON output
header('Content-Type: application/json');
@header('X-Content-Type-Options: nosniff');
 

// Handle API requests
try {
    // Get the raw POST data
    $input = file_get_contents('php://input'); 
    $data = json_decode($input, true);
    debug_log("Decoded input data", $data);
    
    // Verify required parameters
    if (!isset($data['action'])) {
        throw new Exception('No action specified');
    }
    
    // Route actions
    switch ($data['action']) {
        case 'get_attendance_topic':
            if (empty($data['email'])) {
                throw new Exception('Email parameter is required');
            }
            $weeks = 5;
            $period = 'day';
            $topic = isset($data['topic']) ? $data['topic'] : null;
            
            $response = getAttendanceTopicForAPI($data['email'], $weeks, $period, $topic);
            break;
        case 'get_attendance_data':
            if (empty($data['email'])) {
                throw new Exception('Email parameter is required');
            }
            $weeks = isset($data['weeks']) ? (int)$data['weeks'] : 8;
            $period = isset($data['period']) ? $data['period'] : 'week';
            $topic = isset($data['topic']) ? $data['topic'] : null;
            
            $response = getAttendanceDataForAPI($data['email'], $weeks, $period, $topic);
            break;
            
        case 'get_attendance_by_date':
            if (empty($data['email'])) {
                throw new Exception('Email parameter is required');
            }
            if (empty($data['from']) || empty($data['to'])) {
                throw new Exception('Both from and to dates are required');
            }
            $topic = isset($data['topic']) ? $data['topic'] : null;
            
            $response = getAttendanceDataByDateForAPI($data['email'], $data['from'], $data['to'], $topic);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
    
    // Return successful response
    $output = [
        'status' => 'success',
        'data' => $response
    ];
    ob_end_clean(); 
echo json_encode($output);
exit; // Critical - stop all further execution
    
} catch (Exception $e) {
    // Return error response
    
    http_response_code(400);
    ob_end_clean(); 
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
function formatDateWithOrdinal(DateTime $date) {
    $day = $date->format('j');
    $suffix = 'th';
    
    if ($day % 100 < 11 || $day % 100 > 13) {
        switch($day % 10) {
            case 1:  $suffix = 'st'; break;
            case 2:  $suffix = 'nd'; break;
            case 3:  $suffix = 'rd'; break;
        }
    }
    
    return $date->format('D, F ') . $day . $suffix;
}
/**
 * Get attendance data formatted for API response
 */


 
function groupAttendanceByPeriod($dailyData, $period = 'week') {
    $groupedData = [];
    
    // First sort the daily data by date (newest first)
    krsort($dailyData);
    
    foreach ($dailyData as $date => $dayData) { 
        $currentDate = new DateTime($dayData['period']);
        
        // Determine period key and label
        switch ($period) {
            case 'week':
                $periodKey = $currentDate->format('W-Y');
                $periodLabel = 'Week ' . $currentDate->format('W') . ' ' . $currentDate->format('Y');
                break;
            case 'month':
                $periodKey = $currentDate->format('m-Y');
                $periodLabel = $currentDate->format('M Y');
                break;
            case '3months':
                $month = $currentDate->format('n');
                $quarter = ceil($month / 3);
                $periodKey = $quarter . '-' . $currentDate->format('Y');
                $periodLabel = 'Q' . $quarter . ' ' . $currentDate->format('Y');
                break;
            case '6months':
                $month = $currentDate->format('n');
                $half = ceil($month / 6);
                $periodKey = $half . '-' . $currentDate->format('Y');
                $periodLabel = 'H' . $half . ' ' . $currentDate->format('Y');
                break;
            default:
                return array_values($dailyData);
        }
        
        $groupedData['period'] =  $periodKey;
        $groupedData['periodperiod_label'] = $periodLabel;
        // Initialize period if not exists
        if (!isset($groupedData[$periodKey])) {
            $groupedData[$periodKey] = [
                'period' => $periodKey,
                'period_label' => $periodLabel,
                'expected_type' => $dayData['expected_type'],
                'main' => [
                    'hours' => 0,        // Total minutes attended
                    'attendance' => 0,   // Will be average % for periods > day
                    'count' => 0,        // Session count
                    'expected_sessions' => 0 // Total expected minutes
                ],
                'practice' => [
                    'hours' => 0,
                    'attendance' => 0,
                    'count' => 0,
                    'expected_sessions' => 0
                ],
                'days_in_period' => 0    // Track days contributing to this period
            ];
        }
        
        $groupedData[$periodKey]['days_in_period']++;
         
    }
   
    
    return array_values($groupedData);
}


 
function getAttendanceDataForAPI($userEmail, $weeks = 5, $period = 'week', $topic = null) {
    global $DB;
     
    // 1. Get the current cohort for this user (only one)
    $cohortSql = "SELECT c.id, c.startdate, c.enddate, c.idnumber
                FROM {cohort_members} cm
                JOIN {cohort} c ON cm.cohortid = c.id
                JOIN {user} u ON cm.userid = u.id
                WHERE u.email = ? AND c.startdate IS NOT NULL
                ORDER BY c.startdate DESC
                LIMIT 1";

    $currentCohort = $DB->get_record_sql($cohortSql, [$userEmail]);

    // Initialize session data array
    $sessionData = [];

    if ($currentCohort) {
        // 2. Get all googlemeet sessions for this cohort
        $googlemeetSql = "SELECT days, name 
                        FROM {googlemeet}
                        WHERE name LIKE CONCAT(?, '%')";
        
        $googlemeetSessions = $DB->get_records_sql($googlemeetSql, [$currentCohort->idnumber]);

        // 3. Process each googlemeet session
        foreach ($googlemeetSessions as $session) {
            // Parse schedule days if available
            $scheduleDays = [];
            if (!empty($session->days)) {
                $scheduleDays = json_decode($session->days, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $scheduleDays = [];
                }
            }

            // Determine session type based on googlemeet name
            $type = (stripos($session->name, 'practice') !== false || 
                    stripos($session->name, 'practical') !== false)
                ? 'practice' : 'main';

            

            // Add each scheduled day as a separate session
            foreach (array_keys($scheduleDays) as $day) {
                $sessionData[] = [
                    'session' => [
                        'cohort_id' => $currentCohort->id,
                        'googlemeet_name' => $session->name,
                        'schedule_day' => $day,
                        'type' => $type 
                    ]
                ];
            }
        }
    }

 
    // $startDate = date('Y-m-d H:i:s', $cohortDetails->startdate);
    // Get current datetime
    $currentDate = new DateTime();

    

     
    //$endDate = date('Y-m-d H:i:s');
    
    // Calculate start date based on period type
    // switch ($period) {
    //     case 'day':
    //         $startDate = date('Y-m-d H:i:s', strtotime("-$weeks days"));
    //         break;
    //     case 'week':
    //         $startDate = date('Y-m-d H:i:s', strtotime("-$weeks weeks"));
    //         break;
    //     case 'month':
    //         $startDate = date('Y-m-d H:i:s', strtotime("-$weeks months"));
    //         break;
    //     case '3months':
    //         $startDate = date('Y-m-d H:i:s', strtotime("-3 months"));
    //         break;
    //     case '6months':
    //         $startDate = date('Y-m-d H:i:s', strtotime("-6 months"));
    //         break;
    //     default:
    //         $startDate = date('Y-m-d H:i:s', strtotime("-$weeks weeks"));
    // }
    

    // Initialize cohort dates
    $cohortStartDate = new DateTime();
    $cohortStartDate->setTimestamp($currentCohort->startdate);

    // Calculate period-based start date
    $periodStartDate = new DateTime();
    switch ($period) {
        case 'day':
            $periodStartDate->modify("-$weeks days");
            break;
        case 'week':
            $periodStartDate->modify("-$weeks weeks");
            break;
        case 'month':
            $periodStartDate->modify("-$weeks months");
            break;
        case '3months':
            $periodStartDate->modify("-3 months");
            break;
        case '6months':
            $periodStartDate->modify("-6 months");
            break;
        default:
            $periodStartDate->modify("-$weeks weeks");
    }

    // Determine actual start date (never before cohort start)
    $startDateObj = ($periodStartDate > $cohortStartDate) ? $periodStartDate : $cohortStartDate;

    // Handle end date
    $endDateObj = new DateTime();
    if (!empty($currentCohort->enddate)) {
        $cohortEndDate = new DateTime();
        $cohortEndDate->setTimestamp($currentCohort->enddate);
        $endDateObj = ($cohortEndDate < $endDateObj) ? $cohortEndDate : $endDateObj;
    }

    // Final date formatting
    $startDate = $startDateObj->format('Y-m-d H:i:s');
    $endDate = $endDateObj->format('Y-m-d H:i:s');


    // Build the base query
    $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period
            FROM {google_meet_activities} a
            LEFT JOIN {googlemeet} g ON 
                LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                LOWER(CONCAT(
                    SUBSTRING(a.meeting_code, 1, 3), '-',
                    SUBSTRING(a.meeting_code, 4, 4), '-',
                    SUBSTRING(a.meeting_code, 8, 3)
                ))
            WHERE a.identifier = ? AND a.activity_time BETWEEN ? AND ?";
    
    $params = [$userEmail, $startDate, $endDate];
    
    // Add topic filter if provided
    // if ($topic) {
    //     $sql .= " AND g.name LIKE ?";
    //     $params[] = "%$topic%";
    // }
    
    $sql .= " ORDER BY a.activity_time DESC";
    
    $activities = $DB->get_records_sql($sql, $params);
    
    // Initialize empty periods structure
    $groupedData = [];
    
    // Generate period keys based on the requested period type
    $currentDate = new DateTime($endDate);
    $interval = new DateInterval('P1D'); // 1 day interval
    
    for ($i = 0; $i < $weeks; $i++) {
        $periodKey = '';
        $periodLabel = '';
        
        switch ($period) {
            case 'day':
                $periodKey = $currentDate->format('Y-m-d');
                //$periodLabel = $currentDate->format('d/m');
                $periodLabel = formatDateWithOrdinal($currentDate);
                //$currentDate->sub(new DateInterval('P1D'));
                $datesub = 'P1D';
                break;
            case 'week':
                $periodKey = $currentDate->format('W-Y');
                $periodLabel = 'Week ' . $currentDate->format('W') . ' ' . $currentDate->format('Y');
                //$currentDate->sub(new DateInterval('P1W'));
                $datesub = 'P1W';
                break;
            case 'month':
            case '3months':
            case '6months':
                $periodKey = $currentDate->format('m-Y');
                $periodLabel = $currentDate->format('M Y');
                //$currentDate->sub(new DateInterval('P1M'));
                $datesub = 'P1M';
                break;
            default:
                $periodKey = $currentDate->format('W-Y');
                //$currentDate->sub(new DateInterval('P1W'));
                $datesub = 'P1W';
        }
        if ($period == 'day') {
            $dayOfWeek = $currentDate->format('D'); // Get day name (Mon, Tue, etc)
            
            // Check if this day exists in sessionData
            foreach ($sessionData as $session) {
                if ($session['session']['schedule_day'] === $dayOfWeek) {
                    debug_log("session matching", $periodKey.$session['session']['schedule_day'].$dayOfWeek);
                    $sessionType = $session['session']['type'];
                    
                    
                    $groupedData[$periodKey] = [
                        'period' => $periodKey,
                        'period_label' => $periodLabel,
                        'expected_type' => $sessionType,
                        'main' => [
                            'hours' => '0/0',
                            'attendance' => 0,
                            'count' => 0,
                            'expected_sessions' => 0
                        ],
                        'practice' => [
                            'hours' => '0/0',
                            'attendance' => 0,
                            'count' => 0,
                            'expected_sessions' => 0
                        ]
                    ];
                }
            }
        } else {
            $groupedData[$periodKey] = [
                'period' => $periodKey,
                'period_label' => $periodLabel,
                'expected_type' => 'any',
                'main' => [
                    'hours' => '0/0',
                    'attendance' => 0,
                    'count' => 0,
                    'expected_sessions' => 0
                ],
                'practice' => [
                    'hours' => '0/0',
                    'attendance' => 0,
                    'count' => 0,
                    'expected_sessions' => 0
                ]
            ];
        }
        $currentDate->sub(new DateInterval($datesub));
    }
    
    if (!empty($activities)) {
        // Process activities and populate groupedData
        foreach ($activities as $activity) {
            $activityDate = new DateTime($activity->activity_time);
            $durationHours = round($activity->duration_seconds / 3600, 2);
            
            // Determine period key based on selected period type
            $periodKey = '';
            switch ($period) {
                case 'day':
                    $periodKey = $activityDate->format('Y-m-d');
                    break;
                case 'week':
                    $periodKey = $activityDate->format('W-Y');
                    break;
                case 'month':
                case '3months':
                case '6months':
                    $periodKey = $activityDate->format('m-Y');
                    break;
                default:
                    $periodKey = $activityDate->format('W-Y');
            }
            
            $type = !empty($activity->meeting_type) && 
                   (stripos($activity->meeting_type, 'Practice') !== false || 
                    stripos($activity->meeting_type, 'Practical') !== false)
                   ? 'practice' : 'main';
            
            // Initialize period if not exists
            if (!isset($groupedData[$periodKey])) {
                $groupedData[$periodKey] = [
                    'period' => $periodKey, //$periodLabel = formatDateWithOrdinal($currentDate);
                    'period_label' => $period === 'day' 
                            ? formatDateWithOrdinal($activityDate) 
                            : ($period === 'week' 
                                ? 'Week ' . $activityDate->format('W, Y') 
                                : $activityDate->format('F Y')
                            ),  //$activityDate->format($period === 'day' ? 'd/m' : ($period === 'week' ? 'W Y' : 'M Y')),
                    'expected_type' => 'any',        
                    'main' => [
                        'hours' => '0/0',
                        'attendance' => 0,
                        'count' => 0,
                        'expected_sessions' => 0
                    ],
                    'practice' => [
                        'hours' => '0/0',
                        'attendance' => 0,
                        'count' => 0,
                        'expected_sessions' => 0
                    ]
                ];
            }
            
            // Update hours tracking
            list($currentHours, $totalHours) = explode('/', $groupedData[$periodKey][$type]['hours']);
            $groupedData[$periodKey][$type]['hours'] = 
                number_format($currentHours + $durationHours, 2) . '/' . 
                number_format($totalHours + $durationHours, 2);
            
            // Update session count
            $groupedData[$periodKey][$type]['count']++;
            
            // For daily view, each day is considered one expected session
            if ($period === 'day') {
                $groupedData[$periodKey][$type]['expected_sessions'] = 1;
                $groupedData[$periodKey]['expected_type'] = $type;
                $groupedData[$periodKey][$type]['attendance'] =  number_format($currentHours + $durationHours, 2)*60;
                    //$groupedData[$periodKey][$type]['count'] > 0 ? 100 : 0;
            }
        }
        
        // For weekly/monthly views, calculate expected sessions
        if ($period !== 'day') {
            // First pass: collect all days schedules for each week/month
            $periodSchedules = [];
            foreach ($activities as $activity) {
                $activityDate = new DateTime($activity->activity_time);
                
                // Determine period key
                $periodKey = '';
                switch ($period) {
                    case 'week':
                        $periodKey = $activityDate->format('W-Y');
                        break;
                    case 'month':
                    case '3months':
                    case '6months':
                        $periodKey = $activityDate->format('m-Y');
                        break;
                    default:
                        $periodKey = $activityDate->format('W-Y');
                }
                
                $type = !empty($activity->meeting_type) && 
                       (stripos($activity->meeting_type, 'Practice') !== false || 
                        stripos($activity->meeting_type, 'Practical') !== false)
                       ? 'practice' : 'main';
                
                // if (!empty($activity->days)) {
                //     $days = json_decode($activity->days, true);
                //     if (json_last_error() === JSON_ERROR_NONE) {
                //         if (!isset($periodSchedules[$periodKey])) {
                //             $periodSchedules[$periodKey] = ['main' => [], 'practice' => []];
                //         }
                //         $periodSchedules[$periodKey][$type] = array_unique(array_merge(
                //             $periodSchedules[$periodKey][$type],
                //             array_keys($days))
                //         );
                //     }
                // }

                if (!empty($activity->days)) {
                    $days = json_decode($activity->days, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($days)) {
                         
                        if (!isset($periodSchedules[$periodKey])) {
                            $periodSchedules[$periodKey] = ['main' => [], 'practice' => []];
                        }

                        // Map day names to numbers (1=Monday to 7=Sunday)
                        $dayMap = [
                            'Mon' => 1, 'Tue' => 2, 'Wed' => 3,
                            'Thu' => 4, 'Fri' => 5, 'Sat' => 6, 'Sun' => 7
                        ];
                        
                        // Convert scheduled days to numbers (e.g., ["Mon", "Wed"] => [1, 3])
                        $scheduledDays = [];
                        foreach (array_keys($days) as $dayName) {
                            if (isset($dayMap[$dayName])) {
                                $scheduledDays[] = $dayMap[$dayName];
                            }
                        }
                        if ($period === 'month' || $period === '3months' || $period === '6months') {
                            // Safely process monthly schedule
                            try {
                                list( $month,$year) = explode('-', $periodKey);
                                $year = (int)$year;
                                $month = (int)$month;
                                
                                if ($month < 1 || $month > 12) {
                                    error_log("Invalid month value: $month");
                                    continue;
                                }
                                
                                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                $expectedSessions = 0;
                                
                                for ($day = 1; $day <= $daysInMonth; $day++) {
                                    $date = new DateTime("$year-$month-$day");
                                    $dayOfWeek = $date->format('N'); // 1-7
                                    if (in_array($dayOfWeek, $scheduledDays)) {
                                        $expectedSessions++;
                                    }
                                }
                                
                                // Store the total count for this activity
                                if (!isset($periodSchedules[$periodKey][$type]['total'])) {
                                    $periodSchedules[$periodKey][$type]['total'] = 0;
                                }
                                $periodSchedules[$periodKey][$type]['total'] += $expectedSessions;
                                
                                // Also store the individual days for debugging
                                $periodSchedules[$periodKey][$type]['days'] = array_keys($days);
                                
                            } catch (Exception $e) {
                                error_log("Error processing month $year-$month: " . $e->getMessage());
                                continue;
                            }
                        } else {
                            // For weekly periods, use scheduled days directly
                            $periodSchedules[$periodKey][$type] = array_unique(array_merge(
                                $periodSchedules[$periodKey][$type],
                                array_keys($days))
                            );
                            debug_log("expectedSessions", $periodSchedules[$periodKey][$type] );
                        }
                    }
                }

            }
            
            // Update expected sessions in groupedData
            foreach ($periodSchedules as $periodKey => $schedule) {
                if (isset($groupedData[$periodKey])) {
                    if ($period === 'month' || $period === '3months' || $period === '6months') {
                        // For monthly periods, use the pre-calculated totals
                        $groupedData[$periodKey]['main']['expected_sessions'] = 
                            !empty($schedule['main']['total']) ? $schedule['main']['total'] : 0;
                        $groupedData[$periodKey]['practice']['expected_sessions'] = 
                            !empty($schedule['practice']['total']) ? $schedule['practice']['total'] : 0;
                    } else {
                        // For weekly periods, count unique days
                        $groupedData[$periodKey]['main']['expected_sessions'] = 
                            is_array($schedule['main']) ? count($schedule['main']) : 0;
                        $groupedData[$periodKey]['practice']['expected_sessions'] = 
                            is_array($schedule['practice']) ? count($schedule['practice']) : 0;
                    }
                    
                    // Calculate attendance percentage
                    if ($groupedData[$periodKey]['main']['expected_sessions'] > 0) {
                        $groupedData[$periodKey]['main']['attendance'] = min(100, 
                            ($groupedData[$periodKey]['main']['count'] / $groupedData[$periodKey]['main']['expected_sessions']) * 100
                        );
                        $groupedData[$periodKey]['main']['hours'] = $groupedData[$periodKey]['main']['count'] . '/' . $groupedData[$periodKey]['main']['expected_sessions'];
                    }
                    if ($groupedData[$periodKey]['practice']['expected_sessions'] > 0) {
                        $groupedData[$periodKey]['practice']['attendance'] = min(100, 
                            ($groupedData[$periodKey]['practice']['count'] / $groupedData[$periodKey]['practice']['expected_sessions']) * 100
                        );
                        $groupedData[$periodKey]['practice']['hours'] = $groupedData[$periodKey]['practice']['count'] . '/' . $groupedData[$periodKey]['practice']['expected_sessions'];
                    }
                }
            }
        }

        
         
    }
    //debug_log("Final output", $groupedData);
    // Sort by period (newest first) and convert to indexed array
    // After processing activities but before finalizing groupedData
    foreach ($groupedData as $periodKey => &$periodData) {
        // Process only if expected_sessions is 0 for either type
        $needsProcessing = [
            'main' => ($periodData['main']['expected_sessions'] == 0),
            'practice' => ($periodData['practice']['expected_sessions'] == 0)
        ];

        // Skip if nothing needs processing
        if (!$needsProcessing['main'] && !$needsProcessing['practice']) {
            continue;
        }

        if ($period === 'month' || $period === '3months' || $period === '6months') {
            // Monthly period processing
            list($month, $year) = explode('-', $periodKey);
            $year = (int)$year;
            $month = (int)$month;
            
            foreach ($sessionData as $session) {
                $type = $session['session']['type'];
                
                // Skip if we don't need to process this type
                if (!$needsProcessing[$type]) {
                    continue;
                }

                try {
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $dayName = $session['session']['schedule_day'] ?? null;
                    
                    // Simple day mapping
                    $dayMap = [
                        'Mon' => 1, 'Tue' => 2, 'Wed' => 3,
                        'Thu' => 4, 'Fri' => 5, 'Sat' => 6, 'Sun' => 7
                    ];
                    
                    if (isset($dayMap[$dayName])) {
                        $dayNumber = $dayMap[$dayName];
                        $expectedSessions = 0;
                        
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $date = new DateTime("$year-$month-$day");
                            if ($date->format('N') == $dayNumber) {
                                $expectedSessions++;
                            }
                        }
                        
                        $periodData[$type]['expected_sessions'] += $expectedSessions;
                    }
                } catch (Exception $e) {
                    error_log("Error processing month $month-$year: " . $e->getMessage());
                }
            }
        } 
        elseif ($period === 'week') {
            // Weekly period processing
            foreach ($sessionData as $session) {
                $type = $session['session']['type'];
                
                // Skip if we don't need to process this type
                if (!$needsProcessing[$type]) {
                    continue;
                }

                // Just count 1 session per scheduled day in the week
                $periodData[$type]['expected_sessions']++;
            }
        }

        // Recalculate attendance for both types
        foreach (['main', 'practice'] as $type) {
            if ($periodData[$type]['expected_sessions'] > 0) {
                 
                $periodData[$type]['hours'] = $periodData[$type]['count'] . '/' . 
                                        $periodData[$type]['expected_sessions'];
            }
        }
    }
    unset($periodData); // Break the reference
    krsort($groupedData);
    return array_values($groupedData);
}
function getAttendanceTopicForAPI($userEmail, $weeks = 5, $period = 'day', $topic = null) {
    global $DB;
    
    // Get all Google Meet modules in the specified section
    $modules = $DB->get_records('course_modules', ['section' => $topic, 'module' => 24]); // 24 is Google Meet module ID
    
    if (empty($modules)) {
        return [];
    }
    
    // Collect all Google Meet URLs
    $meetUrls = [];
    foreach ($modules as $module) {
        $googleMeet = $DB->get_record('googlemeet', ['id' => $module->instance]);
        if ($googleMeet) {
            $meetUrls[] = $googleMeet->url;
        }
    }
    
    if (empty($meetUrls)) {
        return [];
    }
    
    // Build query to get activities matching these Google Meet URLs
    list($urlSql, $params) = $DB->get_in_or_equal($meetUrls, SQL_PARAMS_NAMED, 'url');
    array_unshift($params, $userEmail);
    
    $sql = "SELECT a.*, g.name as meeting_type
            FROM {google_meet_activities} a
            JOIN {googlemeet} g ON 
                LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                LOWER(CONCAT(
                    SUBSTRING(a.meeting_code, 1, 3), '-',
                    SUBSTRING(a.meeting_code, 4, 4), '-',
                    SUBSTRING(a.meeting_code, 8, 3)
                ))
            WHERE a.identifier = ? 
            AND g.url $urlSql
            ORDER BY a.activity_time DESC";
    
    $activities = $DB->get_records_sql($sql, $params);
    
    // Initialize empty periods structure for days
    $groupedData = [];
    $currentDate = new DateTime();
    
    for ($i = 0; $i < $weeks; $i++) {
        $periodKey = $currentDate->format('Y-m-d');
        $periodLabel = $currentDate->format('d/m');
        
        $groupedData[$periodKey] = [
            'period' => $periodKey,
            'period_label' => $periodLabel,
            'hours' => '0/0',
            'attendance' => 0,
            'count' => 0,
            'expected_sessions' => 0
        ];
        
        $currentDate->sub(new DateInterval('P1D'));
    }
    
    if (!empty($activities)) {
        foreach ($activities as $activity) {
            $activityDate = new DateTime($activity->activity_time);
            $periodKey = $activityDate->format('Y-m-d');
            $durationHours = round($activity->duration_seconds / 3600, 2);
            
            if (!isset($groupedData[$periodKey])) {
                $groupedData[$periodKey] = [
                    'period' => $periodKey,
                    'period_label' => $activityDate->format('d/m'),
                    'hours' => '0/0',
                    'attendance' => 0,
                    'count' => 0,
                    'expected_sessions' => 0
                ];
            }
            
            // Update hours tracking
            list($currentHours, $totalHours) = explode('/', $groupedData[$periodKey]['hours']);
            $groupedData[$periodKey]['hours'] = 
                number_format($currentHours + $durationHours, 2) . '/' . 
                number_format($totalHours + $durationHours, 2);
            
            // Update session count and attendance
            $groupedData[$periodKey]['count']++;
            $groupedData[$periodKey]['expected_sessions'] = 1; // Each day counts as one expected session
            $groupedData[$periodKey]['attendance'] = 
                $groupedData[$periodKey]['count'] > 0 ? 100 : 0;
        }
    }
    
    // Sort by date (newest first) and convert to indexed array
    krsort($groupedData);
    return array_values($groupedData);
}

/**
 * Get attendance data by date range formatted for API response
 */
function getAttendanceDataByDateForAPI($userEmail, $fromDate, $toDate, $topic = null) {
    global $DB;
     
    // 1. Get the current cohort for this user (only one)
    $cohortSql = "SELECT c.id, c.startdate, c.enddate, c.idnumber
                FROM {cohort_members} cm
                JOIN {cohort} c ON cm.cohortid = c.id
                JOIN {user} u ON cm.userid = u.id
                WHERE u.email = ? AND c.startdate IS NOT NULL
                ORDER BY c.startdate DESC
                LIMIT 1";

    $currentCohort = $DB->get_record_sql($cohortSql, [$userEmail]);

    // Initialize session data array
    $sessionData = [];

    if ($currentCohort) {
        // 2. Get all googlemeet sessions for this cohort
        $googlemeetSql = "SELECT days, name 
                        FROM {googlemeet}
                        WHERE name LIKE CONCAT(?, '%')";
        
        $googlemeetSessions = $DB->get_records_sql($googlemeetSql, [$currentCohort->idnumber]);

        // 3. Process each googlemeet session
        foreach ($googlemeetSessions as $session) {
            // Parse schedule days if available
            $scheduleDays = [];
            if (!empty($session->days)) {
                $scheduleDays = json_decode($session->days, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $scheduleDays = [];
                }
            }

            // Determine session type based on googlemeet name
            $type = (stripos($session->name, 'practice') !== false || 
                    stripos($session->name, 'practical') !== false)
                ? 'practice' : 'main';

            

            // Add each scheduled day as a separate session
            foreach (array_keys($scheduleDays) as $day) {
                $sessionData[] = [
                    'session' => [
                        'cohort_id' => $currentCohort->id,
                        'googlemeet_name' => $session->name,
                        'schedule_day' => $day,
                        'type' => $type 
                    ]
                ];
            }
        }
    }
 
    $startDate = $fromDate;
    $endDate   = $toDate;
    //debug_log("Final output", $startDate.$endDate);
    // Build the base query
    $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period
            FROM {google_meet_activities} a
            LEFT JOIN {googlemeet} g ON 
                LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                LOWER(CONCAT(
                    SUBSTRING(a.meeting_code, 1, 3), '-',
                    SUBSTRING(a.meeting_code, 4, 4), '-',
                    SUBSTRING(a.meeting_code, 8, 3)
                ))
            WHERE a.identifier = ? AND a.activity_time BETWEEN ? AND ?";
    
    $params = [$userEmail, $startDate, $endDate];
    
    $startDatet = new DateTime($startDate);
    $endDatet = new DateTime($endDate);

    $interval = $startDatet->diff($endDatet);
    $daysDifference = $interval->days;
    $sql .= " ORDER BY a.activity_time DESC";
    
    $activities = $DB->get_records_sql($sql, $params);
    
    // Initialize empty periods structure
    $groupedData = [];
    
    // Generate period keys based on the requested period type
    $currentDate = new DateTime($endDate);
    $interval = new DateInterval('P1D'); // 1 day interval
    $period ='day';
    for ($i = 0; $i < $daysDifference; $i++) {
        $periodKey = '';
        $periodLabel = '';
         
        $periodKey = $currentDate->format('Y-m-d'); 
        $periodLabel = formatDateWithOrdinal($currentDate);
        
                 
       
            $dayOfWeek = $currentDate->format('D'); // Get day name (Mon, Tue, etc)
            //debug_log("sessionData", $sessionData);
            // Check if this day exists in sessionData
            foreach ($sessionData as $session) {
                //debug_log("session", $session);
                
                if ($session['session']['schedule_day'] === $dayOfWeek) {
                    
                    $sessionType = $session['session']['type'];
                    
                    
                    $groupedData[$periodKey] = [
                        'period' => $periodKey,
                        'period_label' => $periodLabel,
                        'expected_type' => $sessionType,
                        'main' => [
                            'hours' => '0/0',
                            'attendance' => 0,
                            'count' => 0,
                            'expected_sessions' => 0
                        ],
                        'practice' => [
                            'hours' => '0/0',
                            'attendance' => 0,
                            'count' => 0,
                            'expected_sessions' => 0
                        ]
                    ];
                }
            }
         $currentDate->sub(new DateInterval('P1D'));
    }
    
    if (!empty($activities)) {
        // Process activities and populate groupedData
        foreach ($activities as $activity) {
            $activityDate = new DateTime($activity->activity_time);
            $durationHours = round($activity->duration_seconds / 3600, 2);
             
            $periodKey = $activityDate->format('Y-m-d');
            
            $type = !empty($activity->meeting_type) && 
                   (stripos($activity->meeting_type, 'Practice') !== false || 
                    stripos($activity->meeting_type, 'Practical') !== false)
                   ? 'practice' : 'main';
            
            // Initialize period if not exists
            if (!isset($groupedData[$periodKey])) {
                $groupedData[$periodKey] = [
                    'period' => $periodKey, //$periodLabel = formatDateWithOrdinal($currentDate);
                    'period_label' => $period === 'day' 
                            ? formatDateWithOrdinal($activityDate) 
                            : ($period === 'week' 
                                ? 'Week ' . $activityDate->format('W, Y') 
                                : $activityDate->format('F Y')
                            ),  //$activityDate->format($period === 'day' ? 'd/m' : ($period === 'week' ? 'W Y' : 'M Y')),
                    'expected_type' => 'any',        
                    'main' => [
                        'hours' => '0/0',
                        'attendance' => 0,
                        'count' => 0,
                        'expected_sessions' => 0
                    ],
                    'practice' => [
                        'hours' => '0/0',
                        'attendance' => 0,
                        'count' => 0,
                        'expected_sessions' => 0
                    ]
                ];
            }
            
            // Update hours tracking
            list($currentHours, $totalHours) = explode('/', $groupedData[$periodKey][$type]['hours']);
            $groupedData[$periodKey][$type]['hours'] = 
                number_format($currentHours + $durationHours, 2) . '/' . 
                number_format($totalHours + $durationHours, 2);
            
            // Update session count
            $groupedData[$periodKey][$type]['count']++;
            
            // For daily view, each day is considered one expected session
            if ($period === 'day') {
                $groupedData[$periodKey][$type]['expected_sessions'] = 1;
                $groupedData[$periodKey]['expected_type'] = $type;
                $groupedData[$periodKey][$type]['attendance'] =  number_format($currentHours + $durationHours, 2)*60;
                    //$groupedData[$periodKey][$type]['count'] > 0 ? 100 : 0;
            }
        }
        
        // For weekly/monthly views, calculate expected sessions
         

        
         
    }
    //debug_log("Final output", $groupedData);
    // Sort by period (newest first) and convert to indexed array
    krsort($groupedData);
    return array_values($groupedData);
}
/*function getAttendanceDataByDateForAPI($userEmail, $fromDate, $toDate, $topic = null) {
    global $DB;
    
    // Validate dates
    if (!strtotime($fromDate) || !strtotime($toDate)) {
        throw new Exception('Invalid date format');
    }
    
    // Build the base query
    $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period
            FROM {google_meet_activities} a
            LEFT JOIN {googlemeet} g ON 
                LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                LOWER(CONCAT(
                    SUBSTRING(a.meeting_code, 1, 3), '-',
                    SUBSTRING(a.meeting_code, 4, 4), '-',
                    SUBSTRING(a.meeting_code, 8, 3)
                ))
            WHERE a.identifier = ? AND a.activity_time BETWEEN ? AND ?";
    
    $params = [$userEmail, $fromDate, $toDate];
    
    // Add topic filter if provided
    // if ($topic) {
    //     $sql .= " AND g.name LIKE ?";
    //     $params[] = "%$topic%";
    // }
    
    $sql .= " ORDER BY a.activity_time DESC";
    
    $activities = $DB->get_records_sql($sql, $params);
    
    // Group data by day
    $groupedData = [];
    
    // Initialize date period
    $start = new DateTime($fromDate);
    $end = new DateTime($toDate);
    $interval = new DateInterval('P1D');
    $dateRange = new DatePeriod($start, $interval, $end);
    
    // Initialize all days in the range
    foreach ($dateRange as $date) {
        $periodKey = $date->format('Y-m-d');
        $groupedData[$periodKey] = [
            'period' => $periodKey,
            'period_label' => $date->format('d/m'),
            'main' => [
                'hours' => '0/0',
                'attendance' => 0,
                'count' => 0,
                'expected_sessions' => 1 // Each day counts as one expected session
            ],
            'practice' => [
                'hours' => '0/0',
                'attendance' => 0,
                'count' => 0,
                'expected_sessions' => 1 // Each day counts as one expected session
            ]
        ];
    }
    
    if (!empty($activities)) {
        foreach ($activities as $activity) {
            $activityDate = new DateTime($activity->activity_time);
            $periodKey = $activityDate->format('Y-m-d');
            $durationHours = round($activity->duration_seconds / 3600, 2);
            
            $type = !empty($activity->meeting_type) && 
                   (stripos($activity->meeting_type, 'Practice') !== false || 
                    stripos($activity->meeting_type, 'Practical') !== false)
                   ? 'practice' : 'main';
            
            if (isset($groupedData[$periodKey])) {
                // Update hours tracking
                list($currentHours, $totalHours) = explode('/', $groupedData[$periodKey][$type]['hours']);
                $groupedData[$periodKey][$type]['hours'] = 
                    number_format($currentHours + $durationHours, 2) . '/' . 
                    number_format($totalHours + $durationHours, 2);
                
                // Update session count and attendance
                $groupedData[$periodKey][$type]['count']++;
                $groupedData[$periodKey][$type]['attendance'] = 
                    $groupedData[$periodKey][$type]['count'] > 0 ? 100 : 0;
            }
        }
    }
    
    // Sort by period (newest first) and convert to indexed array
    krsort($groupedData);
    return array_values($groupedData);
}*/