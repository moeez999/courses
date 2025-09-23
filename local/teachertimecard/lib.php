<?php
defined('MOODLE_INTERNAL') || die();

function local_teachertimecard_extend_navigation(global_navigation $navigation) {
    global $PAGE, $USER;

    if (isloggedin() && has_capability('local/teachertimecard:view', context_system::instance())) {
        $node = $navigation->add(
            get_string('pluginname', 'local_teachertimecard'),
            new moodle_url('/local/teachertimecard/index.php'),
            navigation_node::TYPE_CUSTOM,
            null,
            'local_teachertimecard',
            new pix_icon('i/calendar', '')
        );
        $node->showinflatnavigation = true;
    }
}

// In your index.php or data function
function get_teacher_cohorts($teacherid) {
    global $DB;
    
    // Get all cohorts where teacher is either main or guide teacher
    $sql = "SELECT c.* 
            FROM {cohort} c 
            WHERE c.cohortmainteacher = ? OR c.cohortguideteacher = ?";
    
    $all_cohorts = $DB->get_records_sql($sql, [$teacherid, $teacherid]);
    
    // Separate into main and guide cohorts
    $result = [
        'main_cohorts' => [],
        'guide_cohorts' => []
    ];
    
    foreach ($all_cohorts as $cohort) {
        if ($cohort->cohortmainteacher == $teacherid) {
            $result['main_cohorts'][$cohort->id] = $cohort;
        } 
        if ($cohort->cohortguideteacher == $teacherid) {
            $result['guide_cohorts'][$cohort->id] = $cohort;
        }
    }
    //print_r($result);
    return $result;
}

function get_cohort_meet_activities($teacherid, $startdate, $enddate) {
    global $DB;

    // 1. Get teacher's cohorts
    $cohorts_data = get_teacher_cohorts($teacherid);
    
    // 2. Get teacher's rates
    $rates = get_teacher_rates($teacherid);
    
    // 3. Get paid session IDs for this teacher WITHIN THE DATE RANGE
    $startdate_str = date('Y-m-d H:i:s', $startdate);
    $enddate_str = date('Y-m-d H:i:s', $enddate);
    
    $paid_session_ids = $DB->get_fieldset_sql("
        SELECT ps.session_id 
        FROM {local_teachertimecard_paid_sessions} ps
        JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
        WHERE p.teacherid = :teacherid 
        AND p.status = 'completed'
        AND p.period_start <= :enddate
        AND p.period_end >= :startdate
    ", [
        'teacherid' => $teacherid,
        'startdate' => $startdate,
        'enddate' => $enddate
    ]);
    
    // Initialize result structure
    $result = [
        'main_sessions' => [],
        'practice_sessions' => []
    ];

    // Process main cohorts (main sessions)
    if (!empty($cohorts_data['main_cohorts'])) {
        foreach ($cohorts_data['main_cohorts'] as $cohort) {
            $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period
                    FROM {google_meet_activities} a
                    JOIN {googlemeet} g ON 
                        LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                        LOWER(CONCAT(
                            SUBSTRING(a.meeting_code, 1, 3), '-',
                            SUBSTRING(a.meeting_code, 4, 4), '-',
                            SUBSTRING(a.meeting_code, 8, 3)
                        ))
                    WHERE g.name LIKE :cohortpattern
                      AND g.name LIKE '%Main%'
                      AND a.activity_time BETWEEN :startdate AND :enddate 
                      AND a.identifier = a.organizer_email
                    ORDER BY a.activity_time ASC";

            $params = [
                'cohortpattern' => $cohort->idnumber.'%',
                'startdate' => $startdate_str,
                'enddate' => $enddate_str
            ];
 
            $sessions = $DB->get_records_sql($sql, $params);
            foreach ($sessions as $session) {
                $session->activity_timestamp = strtotime($session->activity_time);
                $session->session_type = 'main';
                $session->hourly_rate = $rates['group_rate'];
                $session->is_paid = in_array($session->id, $paid_session_ids);
                $session->payment_amount = round($session->duration_seconds / 3600) * $rates['group_rate'];
                $result['main_sessions'][] = $session;
            }
        }
    }

    // Process guide cohorts (practice sessions)
    if (!empty($cohorts_data['guide_cohorts'])) {
        foreach ($cohorts_data['guide_cohorts'] as $cohort) {
            $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period
                    FROM {google_meet_activities} a
                    JOIN {googlemeet} g ON 
                        LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                        LOWER(CONCAT(
                            SUBSTRING(a.meeting_code, 1, 3), '-',
                            SUBSTRING(a.meeting_code, 4, 4), '-',
                            SUBSTRING(a.meeting_code, 8, 3)
                        ))
                    WHERE g.name LIKE :cohortpattern
                      AND g.name LIKE '%Practice%'
                      AND a.activity_time BETWEEN :startdate AND :enddate 
                      AND a.identifier = a.organizer_email
                    ORDER BY a.activity_time ASC";

            $params = [
                'cohortpattern' => $cohort->idnumber.'%',
                'startdate' => $startdate_str,
                'enddate' => $enddate_str
            ];

            $sessions = $DB->get_records_sql($sql, $params);
            foreach ($sessions as $session) {
                $session->activity_timestamp = strtotime($session->activity_time);
                $session->session_type = 'practice';
                $session->hourly_rate = $rates['single_rate'];
                $session->is_paid = in_array($session->id, $paid_session_ids);
                $session->payment_amount = round($session->duration_seconds / 3600) * $rates['single_rate'];
                $result['practice_sessions'][] = $session;
            }
        }
    }

    // Organize by date and calculate totals
    $organized = [];
    $grand_totals = [
        'taught' => 0,
        'covered' => 0,
        'missed' => 0,
        'paid_hours' => 0,
        'pending_hours' => 0,
        'paid_amount' => 0,
        'pending_amount' => 0
    ];
    
    // Process main sessions
    foreach ($result['main_sessions'] as $session) {
        $date = date('Y-m-d', $session->activity_timestamp);
        if (!isset($organized[$date])) {
            $organized[$date] = [
                'date' => $date,
                'main_sessions' => [],
                'practice_sessions' => [],
                'total_main' => 0,
                'total_practice' => 0,
                'total_taught' => 0,
                'total_covered' => 0,
                'total_missed' => 0,
                'paid_hours' => 0,
                'pending_hours' => 0,
                'paid_amount' => 0,
                'pending_amount' => 0
            ];
        }
        
        $organized[$date]['main_sessions'][] = $session;
        $hours = $session->duration_seconds / 3600;
        $organized[$date]['total_main'] += $hours;
        $grand_totals['taught'] += $hours;
        
        // Track paid vs pending
        if ($session->is_paid) {
            $organized[$date]['paid_hours'] += $hours;
            $organized[$date]['paid_amount'] += $session->payment_amount;
            $grand_totals['paid_hours'] += $hours;
            $grand_totals['paid_amount'] += $session->payment_amount;
        } else {
            $organized[$date]['pending_hours'] += $hours;
            $organized[$date]['pending_amount'] += $session->payment_amount;
            $grand_totals['pending_hours'] += $hours;
            $grand_totals['pending_amount'] += $session->payment_amount;
        }
    }
    
    // Process practice sessions
    foreach ($result['practice_sessions'] as $session) {
        $date = date('Y-m-d', $session->activity_timestamp);
        if (!isset($organized[$date])) {
            $organized[$date] = [
                'date' => $date,
                'main_sessions' => [],
                'practice_sessions' => [],
                'total_main' => 0,
                'total_practice' => 0,
                'total_taught' => 0,
                'total_covered' => 0,
                'total_missed' => 0,
                'paid_hours' => 0,
                'pending_hours' => 0,
                'paid_amount' => 0,
                'pending_amount' => 0
            ];
        }
        
        $organized[$date]['practice_sessions'][] = $session;
        $hours = $session->duration_seconds / 3600;
        $organized[$date]['total_practice'] += $hours;
        $grand_totals['taught'] += $hours;
        
        // Track paid vs pending
        if ($session->is_paid) {
            $organized[$date]['paid_hours'] += $hours;
            $organized[$date]['paid_amount'] += $session->payment_amount;
            $grand_totals['paid_hours'] += $hours;
            $grand_totals['paid_amount'] += $session->payment_amount;
        } else {
            $organized[$date]['pending_hours'] += $hours;
            $organized[$date]['pending_amount'] += $session->payment_amount;
            $grand_totals['pending_hours'] += $hours;
            $grand_totals['pending_amount'] += $session->payment_amount;
        }
    }
    
    // Calculate missed hours (10% of taught hours) and add to grand total
    foreach ($organized as &$day) {
        $day['total_missed'] = round($day['total_taught'] * 0.1, 1);
        $grand_totals['missed'] += $day['total_missed'];
    }

    // Sort by date
    ksort($organized);

    // Round all totals
    $grand_totals['taught'] = round($grand_totals['taught']);
    $grand_totals['paid_hours'] = round($grand_totals['paid_hours']);
    $grand_totals['pending_hours'] = round($grand_totals['pending_hours']);
    $grand_totals['paid_amount'] = round($grand_totals['paid_amount'], 2);
    $grand_totals['pending_amount'] = round($grand_totals['pending_amount'], 2);
    $grand_totals['missed'] = round($grand_totals['missed']);
    $grand_totals['covered'] = round($grand_totals['covered']);
    

    // Add grand totals to the result
    return [
        'days' => $organized,
        'totals' => $grand_totals,
        'rates' => $rates // Include rates for reference
    ];
} 

function display_teacher_sessions_table($organized_sessions, $teacherid, $start_timestamp, $end_timestamp) {
    global $DB;
    
    $output = '';
    
    // Convert timestamps to date strings for SQL
    $start_date = date('Y-m-d', $start_timestamp);
    $end_date = date('Y-m-d', $end_timestamp);
    
    // Get paid session IDs within the date range
    $paid_sessions = $DB->get_records_sql("
        SELECT ps.session_id, ps.session_date
        FROM {local_teachertimecard_paid_sessions} ps
        JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
        WHERE p.teacherid = :teacherid 
        AND p.status = 'completed'
        AND ps.session_date BETWEEN :start_date AND :end_date
    ", [
        'teacherid' => $teacherid,
        'start_date' => $start_date,
        'end_date' => $end_date
    ]);
    
    // Create array of paid session IDs for quick lookup
    $paid_session_ids = array_column($paid_sessions, 'session_id');
    
    // Group paid sessions by date
    $paid_sessions_by_date = [];
    foreach ($paid_sessions as $session) {
        $paid_sessions_by_date[$session->session_date][] = $session->session_id;
    }
    
    foreach ($organized_sessions['days'] as $day) {
        // Sort sessions by start_timestamp
        usort($day['main_sessions'], function($a, $b) {
            return $a->start_timestamp - $b->start_timestamp;
        });
        
        usort($day['practice_sessions'], function($a, $b) {
            return $a->start_timestamp - $b->start_timestamp;
        });

        // Format the date
        $day_name = date('D', strtotime($day['date']));
        $month_day = date('M-j', strtotime($day['date']));
        
        $main_dots = '';
        $main_sessions_grouped = [];
        foreach ($day['main_sessions'] as $session) {
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);
            
            if (!isset($main_sessions_grouped[$prefix])) {
                $main_sessions_grouped[$prefix] = [
                    'count' => 0,
                    'tooltip_content' => '',
                    'meeting_part1' => $meeting_parts[0] ?? '',
                    'meeting_part2' => $meeting_parts[1] ?? '',
                    'paid_count' => 0,
                    'total_count' => 0
                ];
            }
            
            $main_sessions_grouped[$prefix]['count']++;
            $main_sessions_grouped[$prefix]['total_count']++;
            
            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);
            if ($is_paid) {
                $main_sessions_grouped[$prefix]['paid_count']++;
            }
            
            $duration_mins = round($session->duration_seconds / 60);
            $time = date('H:i a', strtotime($session->activity_time));
            $starttime = date('H:i a', $session->start_timestamp);
            
            $paid_indicator = $is_paid ? ' ✓' : '';
            $paid_class = $is_paid ? ' paid-session' : '';
            
            $main_sessions_grouped[$prefix]['tooltip_content'] .= 
                "<div class='tooltip-row{$paid_class}'>
                    <span class='tooltip-time'>{$starttime}</span>
                    <span class='tooltip-time'>{$time}</span>
                    <span class='tooltip-duration'>{$duration_mins} mins{$paid_indicator}</span> 
                </div>";
        }

        foreach ($main_sessions_grouped as $prefix => $group) {
            $header = "{$group['meeting_part1']} - {$group['meeting_part2']}";
            $id = $group['id'];
            
            // Add payment indicator to dot
            $payment_indicator = '';
            if ($group['paid_count'] > 0) {
                if ($group['paid_count'] == $group['total_count']) {
                    // All sessions paid → green check
                    $payment_indicator = "<span class='payment-indicator full'></span>";
                } else {
                    // Some sessions paid → info icon
                    $payment_indicator = "<span class='payment-indicator partial'></span>";
                }
            }
            
            $main_dots .= 
                "<div class='session-dot-container'>
                    <div class='session-dot'>{$prefix}{$id}{$payment_indicator}</div>
                    <div class='session-tooltip alert-box'>
                        <div class='tooltip-header'>{$header}</div>
                        {$group['tooltip_content']}
                    </div>
                </div>";
        }

        // Generate practice session dots with grouped tooltips
        $practice_dots = '';
        $practice_sessions_grouped = [];
        foreach ($day['practice_sessions'] as $session) {
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);
            
            if (!isset($practice_sessions_grouped[$prefix])) {
                $practice_sessions_grouped[$prefix] = [
                    'count' => 0,
                    'tooltip_content' => '',
                    'meeting_part1' => $meeting_parts[0] ?? '',
                    'meeting_part2' => $meeting_parts[1] ?? '',
                    'paid_count' => 0,
                    'total_count' => 0
                ];
            }
            
            $practice_sessions_grouped[$prefix]['count']++;
            $practice_sessions_grouped[$prefix]['total_count']++;
            
            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);
            if ($is_paid) {
                $practice_sessions_grouped[$prefix]['paid_count']++;
            }
            
            $duration_mins = round($session->duration_seconds / 60);
            $time = date('H:i', strtotime($session->activity_time));
            $starttime = date('H:i a', $session->start_timestamp);
            
            $paid_indicator = $is_paid ? ' ✓' : '';
            $paid_class = $is_paid ? ' paid-session' : '';
             
            $practice_sessions_grouped[$prefix]['tooltip_content'] .= 
                "<div class='tooltip-row{$paid_class}'>
                    <span class='tooltip-time'>{$starttime}</span>
                    <span class='tooltip-time'>{$time}</span>
                    <span class='tooltip-duration'>{$duration_mins} mins{$paid_indicator}</span>
                </div>";
        }

        foreach ($practice_sessions_grouped as $prefix => $group) {
            $header = "{$group['meeting_part1']} - {$group['meeting_part2']}";
            
            // Add payment indicator to dot
            $payment_indicator = '';
            if ($group['paid_count'] > 0) {
                if ($group['paid_count'] == $group['total_count']) {
                    // All sessions paid → green check
                    $payment_indicator = "<span class='payment-indicator full'></span>";
                } else {
                    // Some sessions paid → info icon
                    $payment_indicator = "<span class='payment-indicator partial'></span>";
                }
            }

            
            $practice_dots .= 
                "<div class='session-dot-container'>
                    <div class='session-dot practice-dot'>{$prefix}{$payment_indicator}</div>
                    <div class='session-tooltip alert-box'>
                        <div class='tooltip-header'>{$header}</div>
                        {$group['tooltip_content']}
                    </div>
                </div>";
        }
        
        // Format hours
        $taught_hrs = round($day['total_practice'] + $day['total_main']);
        $covered_hrs = round($day['total_covered']);
        $missed_hrs = round($day['total_missed']);
        
        // Determine overall payment status for the day
        $all_sessions = array_merge($day['main_sessions'], $day['practice_sessions']);
        $all_paid = true;
        $some_paid = false;
        
        foreach ($all_sessions as $session) {
            if (in_array($session->id, $paid_session_ids)) {
                $some_paid = true;
            } else {
                $all_paid = false;
            }
        }
        
        $status_class = '';
        $status_text = '';
        $status_icon = '';
        
        if ($all_paid && count($all_sessions) > 0) {
            $status_class = 'paid';
            $status_text = 'Paid';
            $status_icon = '<img
                          src="./assets/check.svg"
                          alt=""
                          class="check-icon"
                        />';  
        } elseif ($some_paid) {
            $status_class = 'partially-paid';
            $status_text = 'Partial Paid';
            $status_icon = '';
        } else {
            $status_class = 'to-be-paid';
            $status_text = 'To be paid';
            $status_icon = '';
        }
        
        $output .= '
        <tr>
            <td class="date">
                ' . $day_name . ' <br />
                ' . $month_day . '
            </td>
            <td class="main-cell poppins">
                <div class="session-dots">
                ' . $main_dots . '
                </div>
            </td>
            <td class="practice-cell">
                <div class="session-dots">
                ' . $practice_dots . '
                </div>
            </td>
            <td class="taught">' . $taught_hrs . ' Hrs</td>
            <td class="covered">' . $covered_hrs . ' Hrs</td>
            <td class="missed">' . $missed_hrs . ' Hrs</td>
            <td class="note">
                <div class="note-container">
                <img src="./assets/note.svg" alt="note" class="note-icon" />
                </div>
            </td>
            <td class="status">
                <div class="status-container">
                <div class="status-badge ' . $status_class . '">
                     ' . $status_icon . ' 
                    <p>' . $status_text . '</p>
                </div>  
                <div class="edit-big-container">
                    <div class="edit-container" data-date="' . $day['date'] . '" data-teacherid="' . $teacherid . '">
                        <img src="./assets/edit.svg" alt="" class="edit-icon" />
                    </div>
                </div>
                </div>
            </td>
        </tr>';
    }
    
    return $output;
}

function xdisplay_teacher_sessions_timeline($organized_sessions, $teacherid, $start_timestamp, $end_timestamp) {
    global $DB;
    
    $output = '
    <table>
        <thead>
            <tr>
                <th class="date-header">'.get_string('date', 'local_teachertimecard').'</th>
                <th class="timeline-header">
                    <div class="timeline-hours-container">';
    
    // Generate 24-hour headers (12AM to 11PM)
    for ($h = 0; $h < 24; $h++) {
        $hour_display = date('ga', mktime($h, 0, 0));
        $output .= '<div class="hour-header">' . $hour_display . '</div>';
    }
    
    $output .= '
                    </div>
                </th>
                <th class="sticky-timeline-header">Status</th>
            </tr>
        </thead>
        <tbody id="timeline-body">';

    // If no sessions data, show empty state
    if (empty($organized_sessions['days'])) {
        $output .= '
        <tr>
            <td colspan="3" class="no-sessions-message">
                ' . get_string('nosessionsfound', 'local_teachertimecard') . '
            </td>
        </tr>';
    }

    // Convert timestamps to date strings for SQL
    $start_date = date('Y-m-d', $start_timestamp);
    $end_date = date('Y-m-d', $end_timestamp);
    
    // Get paid session IDs within the date range
    $paid_sessions = $DB->get_records_sql("
        SELECT ps.session_id, ps.session_date
        FROM {local_teachertimecard_paid_sessions} ps
        JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
        WHERE p.teacherid = :teacherid 
        AND p.status = 'completed'
        AND ps.session_date BETWEEN :start_date AND :end_date
    ", [
        'teacherid' => $teacherid,
        'start_date' => $start_date,
        'end_date' => $end_date
    ]);
    
    // Create array of paid session IDs for quick lookup
    $paid_session_ids = array_column($paid_sessions, 'session_id');

    foreach ($organized_sessions['days'] as $day) {
        // Format the date as "Mon<br>Oct-1"
        $day_name = date('D', strtotime($day['date']));
        $month_day = date('M-j', strtotime($day['date']));
        
        // Initialize hourly columns
        $hourly_columns = array_fill(0, 24, ''); // 24 hours (0-23)
        
        // Group sessions by hour to check payment status
        $hourly_payment_status = array_fill(0, 24, ['paid_count' => 0, 'total_count' => 0]);
        
        // Process main sessions
        foreach ($day['main_sessions'] as $session) {
            $start_hour = (int)date('G', $session->start_timestamp);
            $start_minute = (int)date('i', $session->start_timestamp);
            $duration = round(($session->duration_seconds) / 60); // Duration in minutes
            $start_time = date('h:i a', $session->start_timestamp);
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);
            
            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);
            
            // Update payment status for this hour
            $hourly_payment_status[$start_hour]['total_count']++;
            if ($is_paid) {
                $hourly_payment_status[$start_hour]['paid_count']++;
            }
            
            // Calculate position and width
            $position = round(($start_minute / 60) * 100);
            $width = round(($duration / 60) * 100); // Width as percentage of hour
            
            // Only show hours between 0 and 23
            if ($start_hour >= 0 && $start_hour <= 23) {
                $hourly_columns[$start_hour] .= "<div class='session-progress main-session' style='left: {$position}%; width: {$width}%' title='{$prefix} {$start_time} - {$duration}min'>$prefix</div>";
            }
        }
        
        // Process practice sessions
        foreach ($day['practice_sessions'] as $session) {
            $start_hour = (int)date('G', $session->start_timestamp);
            $start_minute = (int)date('i', $session->start_timestamp);
            $duration = round(($session->duration_seconds) / 60); // Duration in minutes
            $start_time = date('h:i a', $session->start_timestamp);
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);
            
            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);
            
            // Update payment status for this hour
            $hourly_payment_status[$start_hour]['total_count']++;
            if ($is_paid) {
                $hourly_payment_status[$start_hour]['paid_count']++;
            }
            
            // Calculate position and width
            $position = round(($start_minute / 60) * 100);
            $width = round(($duration / 60) * 100); // Width as percentage of hour
            
            // Only show hours between 0 and 23
            if ($start_hour >= 0 && $start_hour <= 23) {
                $hourly_columns[$start_hour] .= "<div class='session-progress practice-session' style='left: {$position}%; width: {$width}%' title='{$prefix} {$start_time} - {$duration}min'>$prefix</div>";
            }
        }
        
        // Format hours (round to nearest whole number)
        $taught_hrs = round($day['total_practice'] + $day['total_main']);
        $covered_hrs = round($day['total_covered']);
        $missed_hrs = round($day['total_missed']);
        
        // Determine overall payment status for the day
        $all_sessions = array_merge($day['main_sessions'], $day['practice_sessions']);
        $all_paid = true;
        $some_paid = false;
        
        foreach ($all_sessions as $session) {
            if (in_array($session->id, $paid_session_ids)) {
                $some_paid = true;
            } else {
                $all_paid = false;
            }
        }
        
        $status_class = '';
        $status_text = '';
        $status_icon = '';
        
        if ($all_paid && count($all_sessions) > 0) {
            $status_class = 'paid';
            $status_text = 'Paid';
            $status_icon = '<img src="./assets/check.svg" alt="" class="check-icon" />';  
        } elseif ($some_paid) {
            $status_class = 'partially-paid';
            $status_text = 'Partial Paid';
            $status_icon = '';
        } else {
            $status_class = 'to-be-paid';
            $status_text = 'To be paid';
            $status_icon = '';
        }
        
        // Build the row
        $output .= '
        <tr>
            <td class="date-timeline">
                ' . $day_name . ' <br />
                ' . $month_day . '
            </td>
            <td class="timeline-content-cell">
                <div class="timeline-hours-container">';
        
        // Add hourly columns (0 to 23) with payment indicators
        for ($h = 0; $h < 24; $h++) {
            $content = $hourly_columns[$h] ?: '';
            
            // Add payment indicator for this hour if needed
            $payment_indicator = '';
            if ($hourly_payment_status[$h]['paid_count'] > 0) {
                if ($hourly_payment_status[$h]['paid_count'] == $hourly_payment_status[$h]['total_count']) {
                    // All sessions in this hour are paid
                    $payment_indicator = "<span class='payment-indicator-timeline full'></span>";
                } else {
                    // Some sessions in this hour are paid
                    $payment_indicator = "<span class='payment-indicator-timeline partial'></span>";
                }
            } 
            
            $output .= '<div class="hour-cell">
                <div class="hour-content">
                    ' . $content . '
                    ' . $payment_indicator . '
                </div>
            </div>';
        }
        
        // Add status column
        $output .= '</div>
            </td>
            <td class="sticky-timeline">
                <div class="status-container-timeline">
                    <div class="status-badge-timeline ' . $status_class . '">
                        ' . $status_icon . '
                        <p>' . $status_text . '</p>
                    </div>
                    <div class="edit-big-container-timeline">
                        <div class="edit-container" data-date="' . $day['date'] . '" data-teacherid="' . $teacherid . '">
                            <img src="./assets/edit.svg" alt="" class="edit-icon" />
                        </div>
                    </div>
                </div>
            </td>
        </tr>';
    }
    
    $output .= '
        </tbody>
    </table>
     ';
    
    return $output;
}
 
 function display_teacher_sessions_timeline($organized_sessions, $teacherid, $start_timestamp, $end_timestamp) {
    global $DB;
    
    $output = '
    <table>
        <thead>
            <tr>
                <th class="date-header">'.get_string('date', 'local_teachertimecard').'</th>
                <th class="timeline-header">
                    <div class="timeline-hours-container">';
    
    // Generate 24-hour headers (12AM to 11PM)
    for ($h = 0; $h < 24; $h++) {
        $hour_display = date('ga', mktime($h, 0, 0));
        $output .= '<div class="hour-header">' . $hour_display . '</div>';
    }
    
    $output .= '
                    </div>
                </th>
                <th class="sticky-timeline-header">Status</th>
            </tr>
        </thead>
        <tbody id="timeline-body">';

    // If no sessions data, show empty state
    if (empty($organized_sessions['days'])) {
        $output .= '
        <tr>
            <td colspan="3" class="no-sessions-message">
                ' . get_string('nosessionsfound', 'local_teachertimecard') . '
            </td>
        </tr>';
    }

    // Convert timestamps to date strings for SQL
    $start_date = date('Y-m-d', $start_timestamp);
    $end_date = date('Y-m-d', $end_timestamp);
    
    // Get paid session IDs within the date range
    $paid_sessions = $DB->get_records_sql("
        SELECT ps.session_id, ps.session_date
        FROM {local_teachertimecard_paid_sessions} ps
        JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
        WHERE p.teacherid = :teacherid 
        AND p.status = 'completed'
        AND ps.session_date BETWEEN :start_date AND :end_date
    ", [
        'teacherid' => $teacherid,
        'start_date' => $start_date,
        'end_date' => $end_date
    ]);
    
    // Create array of paid session IDs for quick lookup
    $paid_session_ids = array_column($paid_sessions, 'session_id');
    //print_r($paid_session_ids);

    foreach ($organized_sessions['days'] as $day) {
        // Format the date as "Mon<br>Oct-1"
        $day_name = date('D', strtotime($day['date']));
        $month_day = date('M-j', strtotime($day['date']));
        
        // Initialize hourly columns
        $hourly_columns = array_fill(0, 24, ''); // 24 hours (0-23)
        
        // Group sessions by hour to check payment status
        $hourly_payment_status = array_fill(0, 24, ['paid_count' => 0, 'total_count' => 0]);
        
        // Process main sessions
        foreach ($day['main_sessions'] as $session) {
            $start_hour = (int)date('G', $session->start_timestamp);
            $start_minute = (int)date('i', $session->start_timestamp);
            $duration = round(($session->duration_seconds) / 60); // Duration in minutes
            $start_time = date('h:i a', $session->start_timestamp);
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);
            
            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);
            //print_r($is_paid);

            
            // Update payment status for this hour
            $hourly_payment_status[$start_hour]['total_count']++;
            if ($is_paid) {
                $hourly_payment_status[$start_hour]['paid_count']++;
            }
            
            // Calculate position and width
            $position = round(($start_minute / 60) * 100);
            $width = round(($duration / 60) * 100); // Width as percentage of hour
            
            // Add payment indicator to session
            $payment_indicator = $is_paid ? '<span class="payment-indicator-timeline full"></span>' : '';
            
            // Only show hours between 0 and 23
            if ($start_hour >= 0 && $start_hour <= 23) {
                $hourly_columns[$start_hour] .= "<div class='session-progress main-session' style='left: {$position}%; width: {$width}%' title='{$prefix} {$start_time} - {$duration}min'> $prefix$payment_indicator</div>";
            }
        }
        
        // Process practice sessions
        foreach ($day['practice_sessions'] as $session) {
            $start_hour = (int)date('G', $session->start_timestamp);
            $start_minute = (int)date('i', $session->start_timestamp);
            $duration = round(($session->duration_seconds) / 60); // Duration in minutes
            $start_time = date('h:i a', $session->start_timestamp);
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);
            
            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);
            
            // Update payment status for this hour
            $hourly_payment_status[$start_hour]['total_count']++;
            if ($is_paid) {
                $hourly_payment_status[$start_hour]['paid_count']++;
            }
            
            // Calculate position and width
            $position = round(($start_minute / 60) * 100);
            $width = round(($duration / 60) * 100); // Width as percentage of hour
            
            // Add payment indicator to session
            $payment_indicator = $is_paid ? '<span class="payment-indicator-timeline full"></span>' : '';
            
            // Only show hours between 0 and 23
            if ($start_hour >= 0 && $start_hour <= 23) {
                $hourly_columns[$start_hour] .= "<div class='session-progress practice-session' style='left: {$position}%; width: {$width}%' title='{$prefix} {$start_time} - {$duration}min'>$prefix$payment_indicator</div>";
            }
        }
        
        // Format hours (round to nearest whole number)
        $taught_hrs = round($day['total_practice'] + $day['total_main']);
        $covered_hrs = round($day['total_covered']);
        $missed_hrs = round($day['total_missed']);
        
        // Determine overall payment status for the day
        $all_sessions = array_merge($day['main_sessions'], $day['practice_sessions']);
        $all_paid = true;
        $some_paid = false;
        
        foreach ($all_sessions as $session) {
            if (in_array($session->id, $paid_session_ids)) {
                $some_paid = true;
            } else {
                $all_paid = false;
            }
        }
        
        $status_class = '';
        $status_text = '';
        $status_icon = '';
        
        if ($all_paid && count($all_sessions) > 0) {
            $status_class = 'paid';
            $status_text = 'Paid';
            $status_icon = '<img src="./assets/check.svg" alt="" class="check-icon" />';  
        } elseif ($some_paid) {
            $status_class = 'partially-paid';
            $status_text = 'Partial Paid';
            $status_icon = '';
        } else {
            $status_class = 'to-be-paid';
            $status_text = 'To be paid';
            $status_icon = '';
        }
        
        // Build the row
        $output .= '
        <tr>
            <td class="date-timeline">
                ' . $day_name . ' <br />
                ' . $month_day . '
            </td>
            <td class="timeline-content-cell">
                <div class="timeline-hours-container">';
        
        // Add hourly columns (0 to 23) with payment indicators
        for ($h = 0; $h < 24; $h++) {
            $content = $hourly_columns[$h] ?: '';
            
            // Add payment indicator for this hour if needed
            $payment_indicator = '';
            // if ($hourly_payment_status[$h]['paid_count'] > 0) {
            //     if ($hourly_payment_status[$h]['paid_count'] == $hourly_payment_status[$h]['total_count']) {
            //         // All sessions in this hour are paid
            //         $payment_indicator = "<span class='payment-indicator-timeline full'></span>";
            //     } else {
            //         // Some sessions in this hour are paid
            //         $payment_indicator = "<span class='payment-indicator-timeline partial'></span>";
            //     }
            // } 
            
            $output .= '<div class="hour-cell">
                <div class="hour-content">
                    ' . $content . '
                    ' . $payment_indicator . '
                </div>
            </div>';
        }
        
        // Add status column
        $output .= '</div>
            </td>
            <td class="sticky-timeline">
                <div class="status-container-timeline">
                    <div class="status-badge-timeline ' . $status_class . '">
                        ' . $status_icon . '
                        <p>' . $status_text . '</p>
                    </div>
                    <div class="edit-big-container-timeline">
                        <div class="edit-container" data-date="' . $day['date'] . '" data-teacherid="' . $teacherid . '">
                            <img src="./assets/edit.svg" alt="" class="edit-icon" />
                        </div>
                    </div>
                </div>
            </td>
        </tr>';
    }
    
    $output .= '
        </tbody>
    </table>
     ';
    
    return $output;
}
 



/**
 * Get general notes for a teacher within a date range
 */
function get_general_notes($teacherid, $start_timestamp, $end_timestamp) {
    global $DB, $USER;
    
    $start_date = date('Y-m-d', $start_timestamp);
    $end_date = date('Y-m-d', $end_timestamp);
    
    return $DB->get_records_sql("
        SELECT n.*, u.firstname, u.lastname
        FROM {local_teachertimecard_notes} n
        JOIN {user} u ON n.created_by = u.id
        WHERE n.teacherid = :teacherid 
        AND n.date BETWEEN :startdate AND :enddate
        ORDER BY n.timecreated DESC
    ", [
        'teacherid' => $teacherid,
        'startdate' => $start_date,
        'enddate' => $end_date
    ]);
}

/**
 * Display general notes in HTML format
 */
function display_general_notes($notes, $in_popup = false) {
    if (empty($notes)) {
        return '<div class="no-notes">' . get_string('nonotesavailable', 'local_teachertimecard') . '</div>';
    }
    
    $output = '';
    foreach ($notes as $note) {
        $formatted_date = date('D jS M', $note->timecreated);
        $teacher_name = fullname((object)['firstname' => $note->firstname, 'lastname' => $note->lastname]);
        
        $output .= '
        <div class="note-item' . ($in_popup ? ' popup-note' : '') . '">
            ' . ($in_popup ? '<input type="checkbox" class="remove-checkbox" data-id="' . $note->id . '" style="display: none;">' : '') . '
            <div class="note-header">
                <span>By ' . $teacher_name . ' on ' . $formatted_date . '</span>
            </div>
            <div class="note-content">
                ' . format_text($note->note, FORMAT_PLAIN) . '
            </div>
        </div>';
    }
    
    return $output;
}

/**
 * Save a general note to the database
 */
function save_general_note($teacherid, $date, $note, $userid) {
    global $DB;
    
    $record = new stdClass();
    $record->teacherid = $teacherid;
    $record->date = $date;
    $record->note = $note;
    $record->created_by = $userid;
    $record->timecreated = time();
    $record->timemodified = time();
    
    return $DB->insert_record('local_teachertimecard_notes', $record);
}

/**
 * Delete general notes
 */
function delete_general_notes($note_ids) {
    global $DB;
    
    if (empty($note_ids)) {
        return false;
    }
    
    list($sql, $params) = $DB->get_in_or_equal($note_ids);
    return $DB->delete_records_select('local_teachertimecard_notes', "id $sql", $params);
}


/**
 * Get HTML for general notes in the popup
 */
function get_general_notes_html($teacherid, $date) {
    global $DB, $USER;
    
    // Get notes for this teacher and date
    $notes = $DB->get_records_sql("
        SELECT n.*, u.firstname, u.lastname
        FROM {local_teachertimecard_notes} n
        JOIN {user} u ON n.created_by = u.id
        WHERE n.teacherid = :teacherid 
        AND n.date = :date
        ORDER BY n.timecreated DESC
    ", [
        'teacherid' => $teacherid,
        'date' => $date
    ]);
    
    if (empty($notes)) {
        return '
        <div class="general-notes-item">
            <p class="note-title">No notes available</p>
        </div>';
    }
    
    $html = '';
    foreach ($notes as $note) {
        $formatted_date = date('D jS M', $note->timecreated);
        $teacher_name = fullname((object)['firstname' => $note->firstname, 'lastname' => $note->lastname]);
        
        $html .= '
        <div class="general-notes-item" data-noteid="' . $note->id . '">
            <input type="checkbox" class="note-checkbox" style="display: none;">
            <div class="note-header">
                <span>By ' . $teacher_name . ' on ' . $formatted_date . '</span>
            </div>
            <div class="note-content">
                ' . format_text($note->note, FORMAT_PLAIN) . '
            </div>
        </div>';
    }
    
    return $html;
}









/**
 * Get teacher's hourly rates from user table
 */
function get_teacher_rates($teacherid) {
    global $DB;
    
    $teacher = $DB->get_record('local_teachertimecard_rates', ['teacherid' => $teacherid], 'id, group_rate, single_rate');
    
    return [
        'group_rate' => $teacher->group_rate ?? 0,
        'single_rate' => $teacher->single_rate ?? 0
    ];
}

 

 

/**
 * Process payment and save to database
 */
function process_teacher_payment($teacherid, $amount, $currency, $payment_method, $period_start, $period_end, $session_details, $userid) {
    global $DB;
    
    // Start transaction
    $transaction = $DB->start_delegated_transaction();
    
    try {
        // Create payment record
        $payment = new stdClass();
        $payment->teacherid = $teacherid;
        $payment->amount = $amount;
        $payment->currency = $currency;
        $payment->payment_method = $payment_method;
        $payment->period_start = $period_start;
        $payment->period_end = $period_end;
        $payment->sessions_included = json_encode(array_column($session_details, 'session_id'));
        $payment->status = 'completed';
        $payment->created_by = $userid;
        $payment->timecreated = time();
        $payment->timemodified = time();
        
        $payment_id = $DB->insert_record('local_teachertimecard_payments', $payment);
        
        // Create paid session records
        foreach ($session_details as $session) {
            $paid_session = new stdClass();
            $paid_session->payment_id = $payment_id;
            $paid_session->session_id = $session['session_id'];
            $paid_session->session_date = $session['session_date'];
            $paid_session->session_type = $session['session_type'];
            $paid_session->duration = $session['duration'];
            $paid_session->rate = $session['rate'];
            $paid_session->amount = $session['amount'];
            $paid_session->timecreated = time();
            
            $DB->insert_record('local_teachertimecard_paid_sessions', $paid_session);
        }
        
        $transaction->allow_commit();
        return $payment_id;
        
    } catch (Exception $e) {
        $transaction->rollback($e);
        return false;
    }
}

/**
 * Get payment history for a teacher
 */
function get_payment_history($teacherid, $limit = 10) {
    global $DB;
    
    return $DB->get_records_sql("
        SELECT p.*, u.firstname, u.lastname
        FROM {local_teachertimecard_payments} p
        JOIN {user} u ON p.created_by = u.id
        WHERE p.teacherid = :teacherid
        ORDER BY p.timecreated DESC
        LIMIT :limit
    ", ['teacherid' => $teacherid, 'limit' => $limit]);
}



/**
 * Get unpaid sessions for a teacher within date range
 */
function get_unpaid_sessions($teacherid, $start_timestamp, $end_timestamp) {
    global $DB;
    
    // Get paid session IDs within this date range
    $paid_session_ids = $DB->get_fieldset_sql("
        SELECT ps.session_id 
        FROM {local_teachertimecard_paid_sessions} ps
        JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
        WHERE p.teacherid = :teacherid 
        AND p.status = 'completed'
        AND p.period_start <= :end_timestamp
        AND p.period_end >= :start_timestamp
    ", [
        'teacherid' => $teacherid,
        'start_timestamp' => $start_timestamp,
        'end_timestamp' => $end_timestamp
    ]);
    
    // Get all sessions with the enhanced data structure
    $all_sessions = get_cohort_meet_activities($teacherid, $start_timestamp, $end_timestamp);
    
    // Filter out paid sessions and prepare for payment calculation
    $unpaid_sessions = [
        'main_sessions' => [],
        'practice_sessions' => [],
        'totals' => [
            'total_taught' => 0,
            'total_covered' => 0,
            'total_missed' => 0
        ]
    ];
    
    // Process main sessions from the days array
    foreach ($all_sessions['days'] as $day) {
        foreach ($day['main_sessions'] as $session) {
            if (!in_array($session->id, $paid_session_ids)) {
                $unpaid_sessions['main_sessions'][] = $session;
                $unpaid_sessions['totals']['total_taught'] += $session->duration_seconds / 3600;
            }
        }
    }
    
    // Process practice sessions from the days array
    foreach ($all_sessions['days'] as $day) {
        foreach ($day['practice_sessions'] as $session) {
            if (!in_array($session->id, $paid_session_ids)) {
                $unpaid_sessions['practice_sessions'][] = $session;
                $unpaid_sessions['totals']['total_taught'] += $session->duration_seconds / 3600;
            }
        }
    }
    
    // Round totals
    $unpaid_sessions['totals']['total_taught'] = round($unpaid_sessions['totals']['total_taught'], 1);
    
    return $unpaid_sessions;
}

/**
 * Calculate payment amount for sessions
 */
function calculate_payment_amount($sessions, $rates) {
    $total_amount = 0;
    $total_hours = 0;
    $session_details = [];
    
    // Calculate for main sessions (group rate)
    foreach ($sessions['main_sessions'] as $session) {
        $hours = round($session->duration_seconds / 3600);
        $amount = $hours * $rates['group_rate'];
        $total_amount += $amount;
        $total_hours += $hours;
        
        $session_details[] = [
            'session_id' => $session->id,
            'session_type' => 'main',
            'duration' => $hours,
            'rate' => $rates['group_rate'],
            'amount' => $amount
        ];
    }
    
    // Calculate for practice sessions (single rate)
    foreach ($sessions['practice_sessions'] as $session) {
        $hours = round($session->duration_seconds / 3600);
        $amount = $hours * $rates['single_rate'];
        $total_amount += $amount;
        $total_hours += $hours;
        
        $session_details[] = [
            'session_id' => $session->id,
            'session_type' => 'practice',
            'duration' => $hours,
            'rate' => $rates['single_rate'],
            'amount' => $amount
        ];
    }
    
    return [
        'total_amount' => round($total_amount, 2),
        'total_hours' => round($total_hours),
        'session_details' => $session_details
    ];
}