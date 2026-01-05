<?php
defined('MOODLE_INTERNAL') || die();

function local_teachertimecard_extend_navigation(global_navigation $navigation)
{
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
function get_teacher_cohorts($teacherid)
{
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

function get_cohort_meet_activities($teacherid, $startdate, $enddate)
{
    global $DB;
    $teacher_name = $DB->get_record_sql(
        "SELECT id, firstname 
        FROM {user} 
        WHERE id = ?",
        [$teacherid]
    );
    //echo $teacher_name->firstname;
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
    $result['main_sessions'] = [];

    // 1. Get cohort sessions (Main sessions)
    if (!empty($cohorts_data['main_cohorts'])) {
        foreach ($cohorts_data['main_cohorts'] as $cohort) {
            $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period, r.webviewlink
                    FROM {google_meet_activities} a
                    JOIN {googlemeet} g ON 
                        LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                        LOWER(CONCAT(
                            SUBSTRING(a.meeting_code, 1, 3), '-',
                            SUBSTRING(a.meeting_code, 4, 4), '-',
                            SUBSTRING(a.meeting_code, 8, 3)
                        ))
                    JOIN {googlemeet_recordings} r ON r.googlemeetid = g.id    
                    WHERE (g.name LIKE :cohortpattern AND g.name LIKE '%Main%')
                        AND a.activity_time BETWEEN :startdate AND :enddate 
                        AND a.identifier = a.organizer_email
                    GROUP BY a.id, g.id ORDER BY a.activity_time ASC";

            $params = [
                'cohortpattern' => $cohort->idnumber . '%',
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

    // 2. Get 1:1 sessions separately (outside cohort loop)
    $sql_1on1 = "SELECT a.*, g.name as meeting_type, g.days, g.period, r.webviewlink
                FROM {google_meet_activities} a
                JOIN {googlemeet} g ON 
                    LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                    LOWER(CONCAT(
                        SUBSTRING(a.meeting_code, 1, 3), '-',
                        SUBSTRING(a.meeting_code, 4, 4), '-',
                        SUBSTRING(a.meeting_code, 8, 3)
                    ))
                JOIN {googlemeet_recordings} r ON r.googlemeetid = g.id    
                WHERE (g.name LIKE '%1:1%' AND g.name LIKE :teache_name)
                    AND a.activity_time BETWEEN :startdate AND :enddate 
                    AND a.identifier = a.organizer_email
                GROUP BY a.id, g.id ORDER BY a.activity_time ASC";

    $params_1on1 = [
        'teache_name' => '%' . $teacher_name->firstname,
        'startdate' => $startdate_str,
        'enddate' => $enddate_str
    ];

    $sessions_1on1 = $DB->get_records_sql($sql_1on1, $params_1on1);

    // Add 1:1 sessions to main_sessions
    foreach ($sessions_1on1 as $session) {
        $session->activity_timestamp = strtotime($session->activity_time);
        $session->session_type = 'individual';
        $session->hourly_rate = $rates['single_rate'];
        $session->is_paid = in_array($session->id, $paid_session_ids);
        $session->payment_amount = round($session->duration_seconds / 3600) * $rates['single_rate'];
        $result['main_sessions'][] = $session;
    }

    // Optional: Sort all sessions by activity time
    usort($result['main_sessions'], function($a, $b) {
        return $a->activity_timestamp - $b->activity_timestamp;
    });

    // Process guide cohorts (practice sessions)
    if (!empty($cohorts_data['guide_cohorts'])) {
        foreach ($cohorts_data['guide_cohorts'] as $cohort) {
            $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period, r.webviewlink
                    FROM {google_meet_activities} a
                    JOIN {googlemeet} g ON 
                        LOWER(REPLACE(g.url, 'https://meet.google.com/', '')) = 
                        LOWER(CONCAT(
                            SUBSTRING(a.meeting_code, 1, 3), '-',
                            SUBSTRING(a.meeting_code, 4, 4), '-',
                            SUBSTRING(a.meeting_code, 8, 3)
                        ))
                    JOIN {googlemeet_recordings} r ON r.googlemeetid = g.id     
                    WHERE g.name LIKE :cohortpattern
                      AND g.name LIKE '%Practice%'
                      AND a.activity_time BETWEEN :startdate AND :enddate 
                      AND a.identifier = a.organizer_email
                    ORDER BY a.activity_time ASC";

            $params = [
                'cohortpattern' => $cohort->idnumber . '%',
                'startdate' => $startdate_str,
                'enddate' => $enddate_str
            ];

            $sessions = $DB->get_records_sql($sql, $params);
            foreach ($sessions as $session) {
                $session->activity_timestamp = strtotime($session->activity_time);
                $session->session_type = 'practice';
                $session->hourly_rate = $rates['group_rate'];
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
function display_teacher_sessions_table($organized_sessions, $teacherid, $start_timestamp, $end_timestamp)
{
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
    
    // Reverse the days array to show latest date first
    $days = array_reverse($organized_sessions['days']);

    foreach ($days as $day) {
        // Sort sessions by start_timestamp
        usort($day['main_sessions'], function ($a, $b) {
            return $a->start_timestamp - $b->start_timestamp;
        });

        usort($day['practice_sessions'], function ($a, $b) {
            return $a->start_timestamp - $b->start_timestamp;
        });

        // Format the date
        $day_name = date('D', strtotime($day['date']));
        $month_day = date('M-j', strtotime($day['date']));

        $main_dots = '';
        $main_sessions_grouped = [];
        //print_r($day['main_sessions'] );
        foreach ($day['main_sessions'] as $session) {
            if($session->session_type=="individual"){
                $meeting_parts = explode(' ', $session->meeting_type);
                $prefix = strtoupper($meeting_parts[1]);   
            } else {
                $meeting_parts = explode('-', $session->meeting_type);
                $prefix = strtoupper($meeting_parts[0]);
            }

            if (!isset($main_sessions_grouped[$prefix])) {
                $main_sessions_grouped[$prefix] = [
                    'count' => 0,
                    'tooltip_content' => '',
                    'meeting_part1' => $meeting_parts[0] ?? '',
                    'meeting_part2' => $meeting_parts[1] ?? '',
                    'paid_count' => 0,
                    'total_count' => 0,
                    'recording_links' => ''
                ];
            }

            $main_sessions_grouped[$prefix]['count']++;
            $main_sessions_grouped[$prefix]['total_count']++;

            // Check if session is paid
            $is_paid = true;//in_array($session->id, $paid_session_ids);
            if ($is_paid) {
                $main_sessions_grouped[$prefix]['paid_count']++;
            }

            $duration_mins = round($session->duration_seconds / 60);
            $time = date('H:i a', strtotime($session->activity_time));
            $starttime = date('H:i a', $session->start_timestamp);

            $paid_indicator = $is_paid ? ' ✓' : '';
            $paid_class = $is_paid ? ' paid-session' : '';

            // Generate recording URL - modify this according to your URL structure
            $recording_url = $session->webviewlink; // Replace with actual recording URL logic

            $main_sessions_grouped[$prefix]['tooltip_content'] .=
                "<div class='tooltip-row{$paid_class}'>
                    <span class='tooltip-time'>{$starttime}</span>
                    <span class='tooltip-time'>{$time}{$session->id}</span>
                    <span class='tooltip-duration'>{$duration_mins} mins{$paid_indicator}</span> 
                </div>";

            // Add recording link for this session
            $main_sessions_grouped[$prefix]['recording_links'] .=
                "<a href='{$recording_url}' class='recording-link' target='_blank'>
                    View Recording - {$starttime}
                </a>";
        }

        foreach ($main_sessions_grouped as $prefix => $group) {
            $header = "{$group['meeting_part1']} - {$group['meeting_part2']}";
            $id = $group['id'];

            // Add payment indicator to dot
            $payment_indicator = '';
            if ($group['paid_count'] > 0) {
                if ($group['paid_count'] == $group['total_count']) {
                    $payment_indicator = "<span class='paid-indicator full'></span>";
                } else {
                    $payment_indicator = "<span class='paid-indicator partial'></span>";
                }
            }

            $main_dots .=
                "<div class='session-dot-container' 
                      data-tooltip-id='main-{$day['date']}-{$prefix}'>
                    <div class='session-dot'>{$prefix}{$id}{$payment_indicator}</div>
                </div>";

            // Create alert box for this group (positioned absolutely like tooltip)
            $output .= "
            <div class='session-tooltip alert-box-tooltip' id='main-{$day['date']}-{$prefix}'>
                <div class='tooltip-header'>{$header}</div>
                <div class='tooltip-content'>
                    {$group['tooltip_content']}
                </div>
                <div class='tooltip-foot'>
                    <div class='recording-links-container'>
                        {$group['recording_links']}
                    </div>
                </div>
                <div class='tooltip-close' onclick='closeTooltip(\"main-{$day['date']}-{$prefix}\")'>×</div>
            </div>";
        }

        // Generate practice session dots with grouped alert boxes
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
                    'total_count' => 0,
                    'recording_links' => ''
                ];
            }

            $practice_sessions_grouped[$prefix]['count']++;
            $practice_sessions_grouped[$prefix]['total_count']++;

            // Check if session is paid
            $is_paid = true;//in_array($session->id, $paid_session_ids);
            if ($is_paid) {
                $practice_sessions_grouped[$prefix]['paid_count']++;
            }

            $duration_mins = round($session->duration_seconds / 60);
            $time = date('H:i', strtotime($session->activity_time));
            $starttime = date('H:i a', $session->start_timestamp);

            $paid_indicator = $is_paid ? ' ✓' : '';
            $paid_class = $is_paid ? ' paid-session' : '';

            // Generate recording URL
            $recording_url = $session->webviewlink;

            $practice_sessions_grouped[$prefix]['tooltip_content'] .=
                "<div class='tooltip-row{$paid_class}'>
                    <span class='tooltip-time'>{$starttime}</span>
                    <span class='tooltip-time'>{$time}</span>
                    <span class='tooltip-duration'>{$duration_mins} mins{$paid_indicator}</span>
                </div>";

            // Add recording link for this session
            $practice_sessions_grouped[$prefix]['recording_links'] .=
                "<a href='{$recording_url}' class='recording-link' target='_blank'>
                    View Recording - {$starttime}
                </a>";
        }

        foreach ($practice_sessions_grouped as $prefix => $group) {
            $header = "{$group['meeting_part1']} - {$group['meeting_part2']}";

            // Add payment indicator to dot
            $payment_indicator = '';
            if ($group['paid_count'] > 0) {
                if ($group['paid_count'] == $group['total_count']) {
                    $payment_indicator = "<span class='paid-indicator full'></span>";
                } else {
                    $payment_indicator = "<span class='paid-indicator partial'></span>";
                }
            }

            $practice_dots .=
                "<div class='session-dot-container' 
                      data-tooltip-id='practice-{$day['date']}-{$prefix}'>
                    <div class='session-dot'>{$prefix}{$payment_indicator}</div>
                </div>";

            // Create alert box for this practice group
            $output .= "
            <div class='session-tooltip alert-box-tooltip' id='practice-{$day['date']}-{$prefix}'>
                <div class='tooltip-header'>{$header}</div>
                <div class='tooltip-content'>
                    {$group['tooltip_content']}
                </div>
                <div class='tooltip-foot'>
                    <div class='recording-links-container'>
                        {$group['recording_links']}
                    </div>
                </div>
                <div class='tooltip-close' onclick='closeTooltip(\"practice-{$day['date']}-{$prefix}\")'>×</div>
            </div>";
        }

        // ... rest of your code (hours calculation, status, etc.) remains the same ...
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

    // Add JavaScript for tooltip behavior with fixed positioning
    $output .= '
    <script>
    (function($) {
        const GAP = 8; // space from the trigger
        const PAD = 8; // clamp inside viewport
        const DISPLAY_TIME = 2000; // 2 seconds display time

        let closeTimer = null;
        let currentTooltip = null;
        let currentDot = null;

        function place($dot, $tip) {
            const dotOffset = $dot.offset();
            const dotWidth = $dot.outerWidth();
            const dotHeight = $dot.outerHeight();
            const tipWidth = $tip.outerWidth();
            const tipHeight = $tip.outerHeight();
            
            const scrollTop = $(window).scrollTop();
            const scrollLeft = $(window).scrollLeft();
            const windowHeight = $(window).height();
            const windowWidth = $(window).width();

            // Default position: above the dot, centered
            let top = dotOffset.top - tipHeight - GAP;
            let left = dotOffset.left + (dotWidth / 2) - (tipWidth / 2);

            // Flip to below if not enough space above
            if (top < scrollTop + PAD) {
                top = dotOffset.top + dotHeight + GAP;
            }

            // Clamp horizontally within viewport
            left = Math.max(scrollLeft + PAD, Math.min(left, scrollLeft + windowWidth - tipWidth - PAD));
            
            // Clamp vertically within viewport
            if (top + tipHeight > scrollTop + windowHeight - PAD) {
                top = Math.max(scrollTop + PAD, scrollTop + windowHeight - tipHeight - PAD);
            }

            $tip.css({
                top: Math.round(top),
                left: Math.round(left)
            });
        }

        function openTooltip($dot) {
            const tooltipId = $dot.data("tooltip-id");
            const $tip = $("#" + tooltipId);
            if (!$tip.length) return;

            // Close current tooltip immediately if different
            if (currentTooltip && !currentTooltip.is($tip)) {
                closeCurrentTooltip();
            }

            $tip.css({
                display: "block",
                opacity: 0,
                visibility: "hidden"
            });

            // Position and show
            requestAnimationFrame(function() {
                place($dot, $tip);
                $tip.css({
                    visibility: "visible",
                    opacity: 1
                });
            });

            // Clear any existing timer
            clearTimeout(closeTimer);
            currentTooltip = $tip;
            currentDot = $dot;

            const onScrollResize = function() {
                if (currentTooltip && currentDot) {
                    requestAnimationFrame(function() {
                        place(currentDot, currentTooltip);
                    });
                }
            };

            $(window).on("scroll.sessiontip resize.sessiontip", onScrollResize);
            $dot.data("sessiontip-cleanup", function() {
                $(window).off("scroll.sessiontip resize.sessiontip", onScrollResize);
            });
        }

        function closeCurrentTooltip() {
            if (currentTooltip) {
                currentTooltip.css({
                    opacity: 0,
                    visibility: "hidden",
                    display: "none"
                });
                
                // Clean up event listeners
                if (currentDot) {
                    const cleanup = currentDot.data("sessiontip-cleanup");
                    if (cleanup) cleanup();
                    currentDot.removeData("sessiontip-cleanup");
                }
                
                currentTooltip = null;
                currentDot = null;
            }
            clearTimeout(closeTimer);
        }

        function startCloseTimer() {
            clearTimeout(closeTimer);
            closeTimer = setTimeout(function() {
                closeCurrentTooltip();
            }, DISPLAY_TIME);
        }

        function closeTooltip(id) {
            const $tip = $("#" + id);
            if ($tip.length) {
                $tip.css({
                    opacity: 0,
                    visibility: "hidden",
                    display: "none"
                });
                if (currentTooltip && currentTooltip.is($tip)) {
                    closeCurrentTooltip();
                }
            }
        }

        // Hover bindings
        $(document)
            .on("mouseenter", ".session-dot-container", function() {
                const $dot = $(this);
                openTooltip($dot);
            })
            .on("mouseleave", ".session-dot-container", function() {
                // Only start timer if not hovering over the tooltip
                if (!currentTooltip || !currentTooltip.is(":hover")) {
                    startCloseTimer();
                }
            })
            .on("mouseenter", ".session-tooltip", function() {
                // Cancel close timer when hovering tooltip
                clearTimeout(closeTimer);
            })
            .on("mouseleave", ".session-tooltip", function() {
                // Start close timer when leaving tooltip
                startCloseTimer();
            });

        // Reposition tooltips on window resize and scroll
        $(window).on("scroll.sessiontip resize.sessiontip", function() {
            if (currentTooltip && currentDot) {
                requestAnimationFrame(function() {
                    place(currentDot, currentTooltip);
                });
            }
        });

        // Global close function
        window.closeTooltip = closeTooltip;

    })(jQuery);
    </script>';

    // Add CSS for tooltip-style alert boxes
    $output .= '
    <style>
    .session-tooltip {
        position: fixed; /* Changed from absolute to fixed */
        background: white;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 12px;
        z-index: 10000; /* Higher z-index */
        min-width: 250px;
        max-width: 300px;
        display: none;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        pointer-events: auto;
    }

    .session-tooltip::before {
        content: "";
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 8px 8px 0;
        border-style: solid;
        border-color: white transparent transparent;
        filter: drop-shadow(0 2px 1px rgba(0, 0, 0, 0.1));
    }

    /* Arrow position for tooltips below the dot */
    .session-tooltip.tooltip-below::before {
        top: -8px;
        bottom: auto;
        border-width: 0 8px 8px;
        border-color: transparent transparent white;
    }

    .tooltip-header {
        font-weight: bold;
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #333;
    }

    .tooltip-content {
        margin-bottom: 10px;
    }

    .tooltip-row {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        font-size: 12px;
        border-bottom: 1px solid #f5f5f5;
    }

    .tooltip-row:last-child {
        border-bottom: none;
    }

    .tooltip-time {
        color: #666;
    }

    .tooltip-duration {
        color: #333;
        font-weight: 500;
    }

    .tooltip-foot {
        border-top: 1px solid #eee;
        padding-top: 8px;
    }

    .recording-links-container {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .recording-link {
        font-size: 11px;
        color: #007bff;
        text-decoration: none;
        padding: 3px 6px;
        border-radius: 3px;
        transition: background-color 0.2s;
    }

    .recording-link:hover {
        background-color: #f8f9fa;
        text-decoration: underline;
    }

    .paid-session {
        background-color: #f0fff0;
    }

    .tooltip-close {
        position: absolute;
        top: 6px;
        right: 8px;
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: #999;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        z-index: 10001;
    }

    .tooltip-close:hover {
        background-color: #f5f5f5;
        color: #666;
    }

    .session-dot-container {
        display: inline-block;
        margin: 2px;
        position: relative;
    }

    .session-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        cursor: pointer;
        position: relative;
    }

    .practice-dot {
        background-color: #e3f2fd;
        color: #1976d2;
    }
 
    </style>';

    return $output;
}
 




 
 


function display_teacher_sessions_timeline($organized_sessions, $teacherid, $start_timestamp, $end_timestamp)
{
    global $DB;

    $output = '
    <table>
        <thead>
            <tr>
                <th class="date-header">' . get_string('date', 'local_teachertimecard') . '</th>
                <th class="timeline-header">
                    <div class="timeline-hours-container">';

    // Generate 24-hour headers starting from 9AM (9AM to 8AM next day)
    for ($h = 0; $h < 24; $h++) {
        $display_hour = ($h + 9) % 24; // Start from 9AM
        $hour_display = date('ga', mktime($display_hour, 0, 0));
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

    // Reverse the days array to show latest date first
    $paid_days = array_reverse($organized_sessions['days']);

    foreach ($paid_days as $day) {
        // Format the date as "Mon<br>Oct-1"
        $day_name = date('D', strtotime($day['date']));
        $month_day = date('M-j', strtotime($day['date']));

        // Initialize hourly columns for 24 hours (starting from 9AM)
        $hourly_columns = array_fill(0, 24, '');

        // Group sessions by hour to check payment status
        $hourly_payment_status = array_fill(0, 24, ['paid_count' => 0, 'total_count' => 0]);

        // Process main sessions
        foreach ($day['main_sessions'] as $session) {
            $start_hour_original = (int)date('G', $session->start_timestamp);
            $start_minute = (int)date('i', $session->start_timestamp);
            $duration = round(($session->duration_seconds) / 60); // Duration in minutes
            $start_time = date('h:i a', $session->start_timestamp);
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);

            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);

            // Convert hour to 9AM-based timeline (9AM = hour 0, 10AM = hour 1, etc.)
            $timeline_hour = ($start_hour_original + 15) % 24; // +15 because 24-9=15

            // Update payment status for this hour
            $hourly_payment_status[$timeline_hour]['total_count']++;
            if ($is_paid) {
                $hourly_payment_status[$timeline_hour]['paid_count']++;
            }

            // Calculate position and width
            $position = round(($start_minute / 60) * 100);
            $width = round(($duration / 60) * 100); // Width as percentage of hour

            // Add payment indicator to session
            $payment_indicator = $is_paid ? '<span class="paid-indicator-timeline full"></span>' : '';

            // Only show hours between 0 and 23
            if ($timeline_hour >= 0 && $timeline_hour <= 23) {
                $hourly_columns[$timeline_hour] .= "<div class='session-progress main-session' style='left: {$position}%; width: {$width}%' title='{$prefix} {$start_time} - {$duration}min'> $prefix$payment_indicator</div>";
            }
        }

        // Process practice sessions
        foreach ($day['practice_sessions'] as $session) {
            $start_hour_original = (int)date('G', $session->start_timestamp);
            $start_minute = (int)date('i', $session->start_timestamp);
            $duration = round(($session->duration_seconds) / 60); // Duration in minutes
            $start_time = date('h:i a', $session->start_timestamp);
            $meeting_parts = explode('-', $session->meeting_type);
            $prefix = strtoupper($meeting_parts[0]);

            // Check if session is paid
            $is_paid = in_array($session->id, $paid_session_ids);

            // Convert hour to 9AM-based timeline (9AM = hour 0, 10AM = hour 1, etc.)
            $timeline_hour = ($start_hour_original + 15) % 24; // +15 because 24-9=15

            // Update payment status for this hour
            $hourly_payment_status[$timeline_hour]['total_count']++;
            if ($is_paid) {
                $hourly_payment_status[$timeline_hour]['paid_count']++;
            }

            // Calculate position and width
            $position = round(($start_minute / 60) * 100);
            $width = round(($duration / 60) * 100); // Width as percentage of hour

            // Add payment indicator to session
            $payment_indicator = $is_paid ? '<span class="paid-indicator-timeline full"></span>' : '';

            // Only show hours between 0 and 23
            if ($timeline_hour >= 0 && $timeline_hour <= 23) {
                $hourly_columns[$timeline_hour] .= "<div class='session-progress practice-session' style='left: {$position}%; width: {$width}%' title='{$prefix} {$start_time} - {$duration}min'>$prefix$payment_indicator</div>";
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
                <div class="timeline-hours-scroll-container">
                    <div class="timeline-hours-container">';

        // Add hourly columns (0 to 23) with 9AM starting point
        for ($h = 0; $h < 24; $h++) {
            $content = $hourly_columns[$h] ?: '';

            $output .= '<div class="hour-cell">
                <div class="hour-content">
                    ' . $content . '
                </div>
            </div>';
        }

        $output .= '</div>
                </div>
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
    </table>';

    return $output;
}

/**
 * Get general notes for a teacher within a date range
 */
function get_general_notes($teacherid, $start_timestamp, $end_timestamp)
{
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
function display_general_notes($notes, $in_popup = false)
{
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
function save_general_note($teacherid, $date, $note, $userid)
{
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
function delete_general_notes($note_ids)
{
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
function get_general_notes_html($teacherid, $date)
{
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
function get_teacher_rates($teacherid)
{
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
function process_teacher_payment($teacherid, $amount, $currency, $payment_method, $period_start, $period_end, $session_details, $userid)
{
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
function get_payment_history($teacherid, $limit = 100)
{
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
function get_unpaid_sessions($teacherid, $start_timestamp, $end_timestamp)
{
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
function calculate_payment_amount($sessions, $rates)
{
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


 



/**
 * Get Google Meet schedules for a specific teacher within a date range
 * 
 * @param int $teacherId The teacher's user ID
 * @param string $startDate Start date in Y-m-d format
 * @param string $endDate End date in Y-m-d format
 * @return array Array of scheduled classes
 */
function get_teacher_googlemeet_schedules($teacherId, $startDate, $endDate) {
    global $DB, $USER, $PAGE;
    
    // Validate date range
    $startDateTime = DateTime::createFromFormat('Y-m-d', $startDate);
    $endDateTime = DateTime::createFromFormat('Y-m-d', $endDate);
    
    if (!$startDateTime || !$endDateTime) {
        return ['error' => 'Invalid date format. Use Y-m-d.'];
    }
    
    if ($startDateTime > $endDateTime) {
        return ['error' => 'Start date cannot be after end date.'];
    }

    // Get teacher info
    $teacher = $DB->get_record('user', ['id' => $teacherId]);
    if (!$teacher) {
        return ['error' => 'Teacher not found'];
    }
    
    // Get all sections where this teacher is assigned (using your existing logic)
    $allowed_sections = get_teacher_assigned_sections($teacherId);
    
    if (empty($allowed_sections)) {
        return [];
    }

    $allSchedules = [];

    foreach ($allowed_sections as $section) {
        // Fetch all modules in this section
        $modules = $DB->get_records('course_modules', ['section' => $section->id]);
        
        if (empty($modules)) {
            continue;
        }

        foreach ($modules as $module) {
            // Check if module is Google Meet
            $modinfo = $DB->get_record('modules', ['id' => $module->module]);
            if (!$modinfo || $modinfo->name !== 'googlemeet') {
                continue;
            }

            $googleMeetActivity = $DB->get_record('googlemeet', ['id' => $module->instance]);
            if (!$googleMeetActivity) {
                continue;
            }

            // Get recurring days
            $daysJson = $googleMeetActivity->days ?? '{}';
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

            // Get active days
            $activeDows = [];
            foreach ($recurringDays as $day => $isActive) {
                if ($isActive === "1" && isset($dayMap[$day])) {
                    $activeDows[] = $dayMap[$day];
                }
            }
            
            if (empty($activeDows)) {
                continue;
            }
            sort($activeDows);

            // Prepare class information
            $namePrefix = explode('-', $googleMeetActivity->name)[0] ?? '';
            $badgeText = strtoupper(substr($namePrefix, 0, 4));
            
            $cohort = $DB->get_record('cohort', ['shortname' => $namePrefix], '*', IGNORE_MISSING);
            if (!$cohort) {
                continue;
            }
            
            $cohortColor = $cohort->cohortcolor ?? 'Green';
            
            $classType = 'Group Class';
            if (strpos($googleMeetActivity->name, 'Main') !== false) {
                $classType = 'Main Class';
            } elseif (strpos($googleMeetActivity->name, 'Practice') !== false) {
                $classType = 'Practice Class';
            }

            // Get teacher information
            $teacherInfo = [
                'name' => fullname($teacher),
                'image' => ''
            ];
            
            $userpicture = new user_picture($teacher);
            $imageUrl = $userpicture->get_url($PAGE);
            $teacherInfo['image'] = $imageUrl->out();

            // Calculate time values
            $starthour = (int)$googleMeetActivity->starthour;
            $startminute = (int)$googleMeetActivity->startminute;
            $endhour = isset($googleMeetActivity->endhour) ? (int)$googleMeetActivity->endhour : $starthour;
            $endminute = isset($googleMeetActivity->endminute) ? (int)$googleMeetActivity->endminute : $startminute;
            
            $durationSecs = max(60, (($endhour * 60 + $endminute) - ($starthour * 60 + $startminute)) * 60);
            if ($durationSecs <= 0) { 
                $durationSecs = 3600; 
            }

            // Generate schedules within date range
            $currentDate = clone $startDateTime;
            while ($currentDate <= $endDateTime) {
                $currentDow = (int)$currentDate->format('w'); // 0-6 (Sun-Sat)
                
                // Check if current day is an active day for this activity
                if (in_array($currentDow, $activeDows)) {
                    // Create start and end datetime
                    $startDT = (clone $currentDate)->setTime($starthour, $startminute, 0);
                    $endDT = (clone $startDT)->modify("+{$durationSecs} seconds");

                    // Skip if the class is in the past (optional - remove if you want all classes in range)
                    if ($startDT < new DateTime()) {
                        $currentDate->modify('+1 day');
                        continue;
                    }

                    // Format display values
                    $fullDayName = $fullDayMap[$currentDow];
                    $dateLabel = ($currentDate->format('Y-m-d') === (new DateTime())->format('Y-m-d')) 
                        ? 'Today' 
                        : $currentDate->format('F j');
                    $formattedTime = $startDT->format('g:i A') . ' - ' . $endDT->format('g:i A');

                    // Add to schedules
                    $allSchedules[] = [
                        'timestamp' => $startDT->getTimestamp(),
                        'date' => $currentDate->format('Y-m-d'),
                        'class_display' => [
                            'date' => $dateLabel,
                            'day_time' => $fullDayName . ' at ' . $formattedTime,
                            'short_text' => [
                                'title' => $classType,
                                'badge' => $badgeText,
                                'label' => $cohort->name,
                                'color' => $cohortColor
                            ],
                            'url' => $googleMeetActivity->url,
                            'type' => 'group',
                            'image' => $teacherInfo['image'],
                            'user' => $teacherInfo['name']
                        ]
                    ];
                }
                
                $currentDate->modify('+1 day');
            }
        }
    }

    // Sort all classes by date and time
    if (!empty($allSchedules)) {
        usort($allSchedules, function($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        // Return only class_display for final output
        return array_map(function($entry) {
            return $entry['class_display'];
        }, $allSchedules);
    }

    return [];
}

/**
 * Get sections assigned to teacher (using your existing logic)
 */
function get_teacher_assigned_sections($teacherId) {
    global $DB;
    
    $allowed_sections = [];
    $courseid = 24; // Your course ID
    
    // Check if user is a cohort teacher
    $isteacher = is_cohort_teacher($teacherId);
    
    if (!$isteacher) {
        return [];
    }

    // Get cohorts where user is teacher
    $cohorts = $DB->get_records_sql("
        SELECT c.id, c.name, c.cohortmainteacher, c.cohortguideteacher
        FROM {cohort} c
        WHERE (c.cohortmainteacher = :userid1 OR c.cohortguideteacher = :userid2) 
        AND c.visible = 1", [
        'userid1' => $teacherId,
        'userid2' => $teacherId
    ]);

    if (empty($cohorts)) {
        return [];
    }

    $cohortIds = array_keys($cohorts);

    // Get all sections in the course
    $sections = $DB->get_records('course_sections', ['course' => $courseid], 'section ASC');

    // Loop through sections to find those restricted to the teacher's cohorts
    foreach ($sections as $section) {
        if (!empty($section->availability)) {
            $availability = json_decode($section->availability, true);
            
            // Check if there is a cohort restriction
            if (isset($availability['c']) && is_array($availability['c'])) {
                foreach ($availability['c'] as $condition) {
                    if ($condition['type'] === 'cohort' && in_array($condition['id'], $cohortIds)) {
                        // Determine the user's role in the matched cohort
                        $cohortRole = 'practice'; // default
                        foreach ($cohorts as $cohort) {
                            if ($cohort->id == $condition['id']) {
                                if ($cohort->cohortmainteacher == $teacherId && $cohort->cohortguideteacher == $teacherId) {
                                    $cohortRole = 'main_practice';
                                } elseif ($cohort->cohortmainteacher == $teacherId) {
                                    $cohortRole = 'main';
                                } elseif ($cohort->cohortguideteacher == $teacherId) {
                                    $cohortRole = 'practice';
                                }
                                break;
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

    return $allowed_sections;
}

/**
 * Check if user is a cohort teacher (from your existing code)
 */
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

function get_teacher_sections_googlemeets_and_students_course24x(int $userid): array {
      global $DB, $PAGE, $CFG;

    // 0) Validate teacher user and get their email.
    $teacher = $DB->get_record('user', ['id' => $userid], 'id,firstname,lastname,email,deleted,suspended', IGNORE_MISSING);
    if (!$teacher || empty($teacher->email) || $teacher->deleted || $teacher->suspended) {
        return [];
    }
    $teacherEmail = strtolower(trim($teacher->email));
    $courseid = 24;

    // 1) Helpers: availability JSON parsing.
    $json_to_array = function ($json) {
        if (empty($json)) return null;
        $arr = json_decode($json, true);
        return is_array($arr) ? $arr : null;
    };

    // Exact match check: does availability tree have profile(email) == $target?
    $availability_has_exact_email = function (?string $json, string $target) use ($json_to_array): bool {
        $tree = $json_to_array($json);
        if (!$tree) return false;

        $found = false;
        $walk = function($node) use (&$walk, $target, &$found) {
            if ($found) return;
            if (is_object($node)) $node = (array)$node;
            if (!is_array($node)) return;

            if (($node['type'] ?? '') === 'profile') {
                $sf = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
                if ($sf === 'email') {
                    $val = strtolower(trim((string)($node['v'] ?? $node['value'] ?? '')));
                    $op  = strtolower((string)($node['op'] ?? 'isequalto'));
                    if ($val !== '' && $op === 'isequalto' && $val === $target) {
                        $found = true;
                        return;
                    }
                }
            }
            foreach (['c','showc'] as $k) {
                if (!empty($node[$k]) && is_array($node[$k])) {
                    foreach ($node[$k] as $child) {
                        $walk($child);
                        if ($found) return;
                    }
                }
            }
        };
        $walk($tree);
        return $found;
    };

    // Collect ALL profile(email) values from availability tree (for students).
    $collect_all_emails = function (?string $json) use ($json_to_array): array {
        $tree = $json_to_array($json);
        if (!$tree) return [];
        $out = [];
        $walk = function($node) use (&$walk, &$out) {
            if (is_object($node)) $node = (array)$node;
            if (!is_array($node)) return;

            if (($node['type'] ?? '') === 'profile') {
                $sf = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
                if ($sf === 'email') {
                    $val = trim((string)($node['v'] ?? $node['value'] ?? ''));
                    if ($val !== '') $out[] = $val;
                }
            }
            foreach (['c','showc'] as $k) {
                if (!empty($node[$k]) && is_array($node[$k])) {
                    foreach ($node[$k] as $child) {
                        $walk($child);
                    }
                }
            }
        };
        $walk($tree);
        // Deduplicate case-insensitively
        $lower = array_map('strtolower', $out);
        $uniq  = array_unique($lower);
        return array_values($uniq);
    };
    
    
    $result = [];

    // 2) Get all sections (topics) with availability to find the ones belonging to this teacher.
    $sections = $DB->get_records('course_sections', ['course' => $courseid],
        'section ASC', 'id,section,name,availability');

    foreach ($sections as $section) {
        // Skip sections that aren't tied to this teacher by section-level availability.
        if (!$availability_has_exact_email($section->availability ?? null, $teacherEmail)) {
            continue;
        }

        // 3) Find Google Meet activities in this section.
        $cms = $DB->get_records_sql("
            SELECT cm.id AS cmid, cm.instance, cm.availability
              FROM {course_modules} cm
              JOIN {modules} m ON m.id = cm.module
             WHERE cm.course = :courseid
               AND cm.section = :sectionid
               AND cm.deletioninprogress = 0
               AND m.name = 'googlemeet'
        ", ['courseid' => $courseid, 'sectionid' => $section->id]);

        if (!$cms) continue;

        $meets = [];
        foreach ($cms as $cm) {
            // 4) Collect student emails from the ACTIVITY availability.
            $studentEmails = $collect_all_emails($cm->availability ?? null);
            $students = [];

            if ($studentEmails) {
                list($in, $p) = $DB->get_in_or_equal($studentEmails, SQL_PARAMS_NAMED);
                // case-insensitive match in DB
                $lower = array_map('strtolower', $studentEmails);
                list($inLower, $paramsLower) = $DB->get_in_or_equal($lower, SQL_PARAMS_NAMED);
                // Fetch students (exclude deleted/suspended).
                // Fetch students (exclude deleted/suspended).
                $users = $DB->get_records_sql("
                    SELECT *
                    FROM {user}
                    WHERE LOWER(email) $inLower
                    AND deleted = 0
                    AND suspended = 0
                ", $paramsLower);

                if ($users) {
                    //require_once($CFG->dirroot . '/user/lib.php'); // fullname(), user_picture
                    foreach ($users as $u) {
                        // Build profile image URL (100px)
                        $upic = new user_picture($u);
                        $upic->size = 100; // 0, 35, 100 are common sizes
                        $profile_img_url = $upic->get_url($PAGE)->out(false);

                        $students[] = (object)[
                            'id'            => (int)$u->id,
                            'fullname'      => fullname($u),
                            'email'         => (string)$u->email,
                            'profileimgurl' => $profile_img_url,
                        ];
                    }
                }
            }

            // Get googlemeet instance (for name + meeting URL).
            $gm = $DB->get_record('googlemeet', ['id' => $cm->instance], '*', IGNORE_MISSING);
            if (!$gm) continue;

            // Meeting URL from common fields; fallback to activity view URL.
            $meetingurl = '';
            foreach (['meetingurl','meeting_url','meeturl','joinurl','join_url','url','link','meetinglink','meeting_link'] as $f) {
                if (isset($gm->$f) && !empty($gm->$f)) {
                    $meetingurl = (string)$gm->$f;
                    break;
                }
            }
            $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cm->cmid]))->out(false);

            $meets[] = (object)[
                'cmid'       => (int)$cm->cmid,
                'instanceid' => (int)$cm->instance,
                'name'       => (string)($gm->name ?? ''),
                'meetingurl' => $meetingurl,
                'viewurl'    => $viewurl,
                'students'   => $students,
            ];
        }

        if ($meets) {
            $result[] = (object)[
                'sectionid'   => (int)$section->id,
                'sectionnum'  => (int)$section->section,
                'sectionname' => (string)($section->name ?? ''),
                'meets'       => $meets,
            ];
        }
    } 
    return $result;
}

function get_teacher_sections_googlemeets_and_students_course24(int $userid, ?int $start_date = null, ?int $end_date = null): array {
    global $DB, $PAGE, $CFG;

    // 0) Validate teacher user and get their email.
    $teacher = $DB->get_record('user', ['id' => $userid], 'id,firstname,lastname,email,deleted,suspended', IGNORE_MISSING);
    if (!$teacher || empty($teacher->email) || $teacher->deleted || $teacher->suspended) {
        return [];
    }
    $teacherEmail = strtolower(trim($teacher->email));
    $courseid = 24;

    // 1) Helpers: availability JSON parsing.
    $json_to_array = function ($json) {
        if (empty($json)) return null;
        $arr = json_decode($json, true);
        return is_array($arr) ? $arr : null;
    };

    // Exact match check: does availability tree have profile(email) == $target?
    $availability_has_exact_email = function (?string $json, string $target) use ($json_to_array): bool {
        $tree = $json_to_array($json);
        if (!$tree) return false;

        $found = false;
        $walk = function($node) use (&$walk, $target, &$found) {
            if ($found) return;
            if (is_object($node)) $node = (array)$node;
            if (!is_array($node)) return;

            if (($node['type'] ?? '') === 'profile') {
                $sf = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
                if ($sf === 'email') {
                    $val = strtolower(trim((string)($node['v'] ?? $node['value'] ?? '')));
                    $op  = strtolower((string)($node['op'] ?? 'isequalto'));
                    if ($val !== '' && $op === 'isequalto' && $val === $target) {
                        $found = true;
                        return;
                    }
                }
            }
            foreach (['c','showc'] as $k) {
                if (!empty($node[$k]) && is_array($node[$k])) {
                    foreach ($node[$k] as $child) {
                        $walk($child);
                        if ($found) return;
                    }
                }
            }
        };
        $walk($tree);
        return $found;
    };

    // Collect ALL profile(email) values from availability tree (for students).
    $collect_all_emails = function (?string $json) use ($json_to_array): array {
        $tree = $json_to_array($json);
        if (!$tree) return [];
        $out = [];
        $walk = function($node) use (&$walk, &$out) {
            if (is_object($node)) $node = (array)$node;
            if (!is_array($node)) return;

            if (($node['type'] ?? '') === 'profile') {
                $sf = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
                if ($sf === 'email') {
                    $val = trim((string)($node['v'] ?? $node['value'] ?? ''));
                    if ($val !== '') $out[] = $val;
                }
            }
            foreach (['c','showc'] as $k) {
                if (!empty($node[$k]) && is_array($node[$k])) {
                    foreach ($node[$k] as $child) {
                        $walk($child);
                    }
                }
            }
        };
        $walk($tree);
        // Deduplicate case-insensitively
        $lower = array_map('strtolower', $out);
        $uniq  = array_unique($lower);
        return array_values($uniq);
    };
    
    $result = [];

    // 2) Get all sections (topics) with availability to find the ones belonging to this teacher.
    $sections = $DB->get_records('course_sections', ['course' => $courseid],
        'section ASC', 'id,section,name,availability');

    foreach ($sections as $section) {
        // Skip sections that aren't tied to this teacher by section-level availability.
        if (!$availability_has_exact_email($section->availability ?? null, $teacherEmail)) {
            continue;
        }

        // 3) Find Google Meet activities in this section with optional date filtering
        $sql_where = "
            WHERE cm.course = :courseid
            AND cm.section = :sectionid
            AND cm.deletioninprogress = 0
            AND m.name = 'googlemeet'
        ";
        
        $params = ['courseid' => $courseid, 'sectionid' => $section->id];
        
        // Add date range filtering if provided
        if ($start_date !== null && $end_date !== null) {
            $sql_where .= " AND (
                (gmt.startedat BETWEEN :start_date AND :end_date) OR
                (gmt.endsat BETWEEN :start_date2 AND :end_date2) OR
                (gmt.startedat <= :start_date3 AND gmt.endsat >= :end_date3)
            )";
            $params['start_date'] = $start_date;
            $params['end_date'] = $end_date;
            $params['start_date2'] = $start_date;
            $params['end_date2'] = $end_date;
            $params['start_date3'] = $start_date;
            $params['end_date3'] = $end_date;
            
            $sql = "
                SELECT cm.id AS cmid, cm.instance, cm.availability, gmt.startedat, gmt.endsat
                FROM {course_modules} cm
                JOIN {modules} m ON m.id = cm.module
                JOIN {googlemeet} gm ON gm.id = cm.instance
                LEFT JOIN {googlemeet_times} gmt ON gmt.googlemeetid = gm.id
                $sql_where
            ";
        } else {
            $sql = "
                SELECT cm.id AS cmid, cm.instance, cm.availability
                FROM {course_modules} cm
                JOIN {modules} m ON m.id = cm.module
                WHERE cm.course = :courseid
                AND cm.section = :sectionid
                AND cm.deletioninprogress = 0
                AND m.name = 'googlemeet'
            ";
        }

        $cms = $DB->get_records_sql($sql, $params);

        if (!$cms) continue;

        $meets = [];
        foreach ($cms as $cm) {
            // 4) Collect student emails from the ACTIVITY availability.
            $studentEmails = $collect_all_emails($cm->availability ?? null);
            $students = [];

            if ($studentEmails) {
                list($in, $p) = $DB->get_in_or_equal($studentEmails, SQL_PARAMS_NAMED);
                // case-insensitive match in DB
                $lower = array_map('strtolower', $studentEmails);
                list($inLower, $paramsLower) = $DB->get_in_or_equal($lower, SQL_PARAMS_NAMED);
                // Fetch students (exclude deleted/suspended).
                $users = $DB->get_records_sql("
                    SELECT *
                    FROM {user}
                    WHERE LOWER(email) $inLower
                    AND deleted = 0
                    AND suspended = 0
                ", $paramsLower);

                if ($users) {
                    foreach ($users as $u) {
                        // Build profile image URL (100px)
                        $upic = new user_picture($u);
                        $upic->size = 100;
                        $profile_img_url = $upic->get_url($PAGE)->out(false);

                        $students[] = (object)[
                            'id'            => (int)$u->id,
                            'fullname'      => fullname($u),
                            'email'         => (string)$u->email,
                            'profileimgurl' => $profile_img_url,
                        ];
                    }
                }
            }

            // Get googlemeet instance (for name + meeting URL).
            $gm = $DB->get_record('googlemeet', ['id' => $cm->instance], '*', IGNORE_MISSING);
            if (!$gm) continue;

            // Meeting URL from common fields; fallback to activity view URL.
            $meetingurl = '';
            foreach (['meetingurl','meeting_url','meeturl','joinurl','join_url','url','link','meetinglink','meeting_link'] as $f) {
                if (isset($gm->$f) && !empty($gm->$f)) {
                    $meetingurl = (string)$gm->$f;
                    break;
                }
            }
            $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cm->cmid]))->out(false);

            // Add date information to the meet data
            $meet_data = [
                'cmid'       => (int)$cm->cmid,
                'instanceid' => (int)$cm->instance,
                'name'       => (string)($gm->name ?? ''),
                'meetingurl' => $meetingurl,
                'viewurl'    => $viewurl,
                'students'   => $students,
            ];
            
            // Add date information if available
            if (isset($cm->startedat)) {
                $meet_data['startedat'] = (int)$cm->startedat;
            }
            if (isset($cm->endsat)) {
                $meet_data['endsat'] = (int)$cm->endsat;
            }

            $meets[] = (object)$meet_data;
        }

        if ($meets) {
            $result[] = (object)[
                'sectionid'   => (int)$section->id,
                'sectionnum'  => (int)$section->section,
                'sectionname' => (string)($section->name ?? ''),
                'meets'       => $meets,
            ];
        }
    } 
    return $result;
}









//new functions

function is_cohort_teacher_t($userid) {
    global $DB;
    $sql = "SELECT 1 FROM {cohort} WHERE cohortmainteacher = :uid1 OR cohortguideteacher = :uid2";
    return $DB->record_exists_sql($sql, ['uid1' => (int)$userid, 'uid2' => (int)$userid]);
}

function process_cohorts_data_t($cohorts, $check_visibility = false, $user_id = null) {
    global $DB;
    
    $cohortData = [];
    
    if (!defined('CONTEXT_COHORT')) {
        define('CONTEXT_COHORT', 10);
    }

    foreach ($cohorts as $cohort) {
        if ($check_visibility && isset($cohort->visible) && (int)$cohort->visible === 0) {
            continue;
        }

        $context = context_system::instance();
        
        $rewrittenDescription = file_rewrite_pluginfile_urls(
            $cohort->description,
            'pluginfile.php',
            $context->id,
            'cohort',
            'description',
            $cohort->id
        );

        preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $rewrittenDescription, $matches);
        $imageUrl = isset($matches[1]) ? $matches[1] : '';

        $cohortData[] = [
            'id' => $cohort->id,
            'name' => $cohort->name,
            'image' => $imageUrl,
            'description' => $rewrittenDescription
        ];
    }
    
    return $cohortData;
}

function determine_teacher_role_t($cohorts, $cohort_id, $user_id) {
    foreach ($cohorts as $cohort) {
        if ($cohort->id == $cohort_id) {
            $is_main = $cohort->cohortmainteacher == $user_id;
            $is_guide = $cohort->cohortguideteacher == $user_id;

            if ($is_main && $is_guide) {
                return 'main_practice';
            } elseif ($is_main) {
                return 'main';
            } elseif ($is_guide) {
                return 'practice';
            }
            break;
        }
    }
    return 'practice';
}

function get_cohort_restricted_sections_t($sections, $cohortData, $isteacher, $cohorts, $user_id) {
    $allowed_sections = [];
    $cohort_ids = array_column($cohortData, 'id');

    foreach ($sections as $section) {
        if (empty($section->availability)) {
            continue;
        }

        $availability = json_decode($section->availability, true);
        
        if (!isset($availability['c']) || !is_array($availability['c'])) {
            continue;
        }

        foreach ($availability['c'] as $condition) {
            if ($condition['type'] === 'cohort' && in_array($condition['id'], $cohort_ids)) {
                
                $cohortRole = 'practice';
                
                if ($isteacher) {
                    $cohortRole = determine_teacher_role_t($cohorts, $condition['id'], $user_id);
                }

                $sectionWithRole = (array) $section;
                $sectionWithRole['role'] = $cohortRole;
                $sectionWithRole['cohort_id'] = $condition['id'];
                $allowed_sections[] = (object) $sectionWithRole;
                break;
            }
        }
    }
    
    return $allowed_sections;
}

function check_role_access_t($role, $activity_name) {
    $role = strtolower($role);
    $name = strtolower($activity_name);

    if (strpos($role, '_') !== false) {
        $roles = explode('_', $role);
        foreach ($roles as $r) {
            if (strpos($name, $r) !== false) {
                return true;
            }
        }
        return false;
    } else {
        return strpos($name, $role) !== false;
    }
}

function get_cohort_id_from_section_t($section) {
    if (empty($section->availability)) {
        return null;
    }

    $availability = json_decode($section->availability, true);
    
    if (isset($availability['c']) && is_array($availability['c'])) {
        foreach ($availability['c'] as $condition) {
            if (isset($condition['type']) && $condition['type'] === 'cohort' && isset($condition['id'])) {
                return $condition['id'];
            }
        }
    }
    
    return null;
}

function get_googlemeet_events_t($googlemeetid, $teacherid, $start_timestamp, $end_timestamp, $limitnum = 1000) {
    global $DB;
    
    $params = [
        'googlemeetid' => $googlemeetid,
        'starttime'    => $start_timestamp,
        'endtime'      => $end_timestamp,
        'teacherid'    => $teacherid,
    ];

    $sql = "
    SELECT
        e.id            AS eventid,
        e.eventdate     AS eventdate,
        gm.id           AS googlemeetid,
        gm.name         AS gmname,
        gm.starthour    AS starthour,
        gm.startminute  AS startminute,
        gm.endhour      AS endhour,
        gm.endminute    AS endminute,
        cm.id           AS cmid,
        gm.url           AS url
    FROM {googlemeet_events} e
    JOIN {googlemeet} gm
      ON gm.id = e.googlemeetid
    JOIN {modules} m
      ON m.name = 'googlemeet'
    JOIN {course_modules} cm
      ON cm.instance = gm.id AND cm.module = m.id
    LEFT JOIN {local_meet_event_teachers} emt_any
           ON emt_any.eventid   = e.id
          AND emt_any.is_active = 1
    LEFT JOIN {local_meet_event_teachers} emt_me
           ON emt_me.eventid    = e.id
          AND emt_me.is_active  = 1
          AND emt_me.userid     = :teacherid
    WHERE e.googlemeetid = :googlemeetid
      AND e.eventdate BETWEEN :starttime AND :endtime
      AND (
            emt_any.id IS NULL       -- no override => include
            OR emt_me.id IS NOT NULL -- overridden to THIS teacher => include
          )
    ORDER BY e.eventdate ASC
    ";

    return $DB->get_records_sql($sql, $params, 0, $limitnum);
}

function get_teacher_sections_googlemeets_and_students_course24_t(int $userid, $start_timestamp = null, $end_timestamp = null) {
    global $DB, $PAGE, $CFG;

    // 0) Validate teacher user and get their email.
    $teacher = $DB->get_record('user', ['id' => $userid], 'id,firstname,lastname,email,deleted,suspended', IGNORE_MISSING);
    if (!$teacher || empty($teacher->email) || $teacher->deleted || $teacher->suspended) {
        return [];
    }
    $teacherEmail = strtolower(trim($teacher->email));
    $courseid = 24;

    // 1) Helpers: availability JSON parsing.
    $json_to_array = function ($json) {
        if (empty($json)) return null;
        $arr = json_decode($json, true);
        return is_array($arr) ? $arr : null;
    };

    // Exact match check: does availability tree have profile(email) == $target?
    $availability_has_exact_email = function (?string $json, string $target) use ($json_to_array): bool {
        $tree = $json_to_array($json);
        if (!$tree) return false;

        $found = false;
        $walk = function($node) use (&$walk, $target, &$found) {
            if ($found) return;
            if (is_object($node)) $node = (array)$node;
            if (!is_array($node)) return;

            if (($node['type'] ?? '') === 'profile') {
                $sf = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
                if ($sf === 'email') {
                    $val = strtolower(trim((string)($node['v'] ?? $node['value'] ?? '')));
                    $op  = strtolower((string)($node['op'] ?? 'isequalto'));
                    if ($val !== '' && $op === 'isequalto' && $val === $target) {
                        $found = true;
                        return;
                    }
                }
            }
            foreach (['c','showc'] as $k) {
                if (!empty($node[$k]) && is_array($node[$k])) {
                    foreach ($node[$k] as $child) {
                        $walk($child);
                        if ($found) return;
                    }
                }
            }
        };
        $walk($tree);
        return $found;
    };

    // Collect ALL profile(email) values from availability tree (for students).
    $collect_all_emails = function (?string $json) use ($json_to_array): array {
        $tree = $json_to_array($json);
        if (!$tree) return [];
        $out = [];
        $walk = function($node) use (&$walk, &$out) {
            if (is_object($node)) $node = (array)$node;
            if (!is_array($node)) return;

            if (($node['type'] ?? '') === 'profile') {
                $sf = strtolower((string)($node['sf'] ?? $node['field'] ?? ''));
                if ($sf === 'email') {
                    $val = trim((string)($node['v'] ?? $node['value'] ?? ''));
                    if ($val !== '') $out[] = $val;
                }
            }
            foreach (['c','showc'] as $k) {
                if (!empty($node[$k]) && is_array($node[$k])) {
                    foreach ($node[$k] as $child) {
                        $walk($child);
                    }
                }
            }
        };
        $walk($tree);
        // Deduplicate case-insensitively
        $lower = array_map('strtolower', $out);
        $uniq  = array_unique($lower);
        return array_values($uniq);
    };

    $result = [];

    // 2) Get all sections (topics) with availability to find the ones belonging to this teacher.
    $sections = $DB->get_records('course_sections', ['course' => $courseid],
        'section ASC', 'id,section,name,availability');

    foreach ($sections as $section) {
        // Skip sections that aren't tied to this teacher by section-level availability.
        if (!$availability_has_exact_email($section->availability ?? null, $teacherEmail)) {
            continue;
        }

        // 3) Find Google Meet activities in this section.
        $cms = $DB->get_records_sql("
            SELECT cm.id AS cmid, cm.instance, cm.availability
              FROM {course_modules} cm
              JOIN {modules} m ON m.id = cm.module
             WHERE cm.course = :courseid
               AND cm.section = :sectionid
               AND cm.deletioninprogress = 0
               AND m.name = 'googlemeet'
        ", ['courseid' => $courseid, 'sectionid' => $section->id]);

        if (!$cms) continue;

        $meets = [];
        foreach ($cms as $cm) {
            // 4) Collect student emails from the ACTIVITY availability.
            $studentEmails = $collect_all_emails($cm->availability ?? null);
            $students = [];

            if ($studentEmails) {
                list($in, $p) = $DB->get_in_or_equal($studentEmails, SQL_PARAMS_NAMED);
                // case-insensitive match in DB
                $lower = array_map('strtolower', $studentEmails);
                list($inLower, $paramsLower) = $DB->get_in_or_equal($lower, SQL_PARAMS_NAMED);
                // Fetch students (exclude deleted/suspended).
                $users = $DB->get_records_sql("
                    SELECT *
                    FROM {user}
                    WHERE LOWER(email) $inLower
                    AND deleted = 0
                    AND suspended = 0
                ", $paramsLower);

                if ($users) {
                    foreach ($users as $u) {
                        // Build profile image URL (100px)
                        $upic = new user_picture($u);
                        $upic->size = 100;
                        $profile_img_url = $upic->get_url($PAGE)->out(false);

                        $students[] = (object)[
                            'id'            => (int)$u->id,
                            'fullname'      => fullname($u),
                            'email'         => (string)$u->email,
                            'profileimgurl' => $profile_img_url,
                        ];
                    }
                }
            }

            // Get googlemeet instance (for name + meeting URL).
            $gm = $DB->get_record('googlemeet', ['id' => $cm->instance], '*', IGNORE_MISSING);
            if (!$gm) continue;

            // Meeting URL from common fields; fallback to activity view URL.
            $meetingurl = '';
            foreach (['meetingurl','meeting_url','meeturl','joinurl','join_url','url','link','meetinglink','meeting_link'] as $f) {
                if (isset($gm->$f) && !empty($gm->$f)) {
                    $meetingurl = (string)$gm->$f;
                    break;
                }
            }
            $viewurl = (new moodle_url('/mod/googlemeet/view.php', ['id' => $cm->cmid]))->out(false);

            // Get events for this Google Meet activity within date range
            $events = [];
            if ($start_timestamp !== null && $end_timestamp !== null) {
                $events = $DB->get_records_select(
                    'event',
                    "modulename = :mod
                     AND instance   = :instance
                     AND visible    = 1
                     AND timestart BETWEEN :starttime AND :endtime",
                    [
                        'mod'       => 'googlemeet',
                        'instance'  => $cm->instance,
                        'starttime' => $start_timestamp,
                        'endtime'   => $end_timestamp
                    ],
                    'timestart ASC',
                    'id,name,timestart,timeduration'
                );
            } else {
                // If no date range provided, get future events
                $now = time();
                $events = $DB->get_records_select(
                    'event',
                    "modulename = :mod
                     AND instance   = :instance
                     AND visible    = 1
                     AND (
                           timestart >= :now1
                        OR (:now2 >= timestart AND :now3 <= (timestart + 3600))
                     )",
                    [
                        'mod'      => 'googlemeet',
                        'instance' => $cm->instance,
                        'now1'     => $now,
                        'now2'     => $now,
                        'now3'     => $now
                    ],
                    'timestart ASC',
                    'id,name,timestart,timeduration'
                );
            }

            $meets[] = (object)[
                'cmid'       => (int)$cm->cmid,
                'instanceid' => (int)$cm->instance,
                'name'       => (string)($gm->name ?? ''),
                'meetingurl' => $meetingurl,
                'viewurl'    => $viewurl,
                'students'   => $students,
                'events'     => $events, // Include events in the result
            ];
        }

        if ($meets) {
            $result[] = (object)[
                'sectionid'   => (int)$section->id,
                'sectionnum'  => (int)$section->section,
                'sectionname' => (string)($section->name ?? ''),
                'meets'       => $meets,
            ];
        }
    }

    return $result;
}

function get_teacher_googlemeet_events_t($target_teacher_id, $start_date, $end_date, $limit = 1000) {
    global $DB;

    try {
        $start_timestamp = strtotime($start_date . ' 00:00:00');
        $end_timestamp = strtotime($end_date . ' 23:59:59');
        
        $isteacher = is_cohort_teacher_t($target_teacher_id);
        $all_events = [];

        if ($isteacher) {
            // Get teacher's cohorts
            $sql = "SELECT c.id, c.name, c.description, c.cohortmainteacher, c.visible, c.cohortguideteacher
                    FROM {cohort} c
                    WHERE (c.cohortmainteacher = :userid1 OR c.cohortguideteacher = :userid2) AND c.visible = 1";

            $cohorts = $DB->get_records_sql($sql, [
                'userid1' => $target_teacher_id,
                'userid2' => $target_teacher_id
            ]);
            
            $cohortData = process_cohorts_data_t($cohorts, true, $target_teacher_id);

            // Process cohort-based activities from course CR001
            $course = $DB->get_record('course', ['idnumber' => 'CR001'], '*');
            if ($course) {
                $sections = $DB->get_records('course_sections', ['course' => $course->id], 'section ASC');
                $allowed_sections = get_cohort_restricted_sections_t($sections, $cohortData, $isteacher, $cohorts, $target_teacher_id);

                if (!empty($allowed_sections)) {
                    $cohortCache = [];
                    
                    foreach ($allowed_sections as $section) {
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
                            
                            if (!check_role_access_t($section->role, $googleMeetActivity->name)) {
                                continue;
                            }

                            // Get Google Meet Events for this activity (Cohort-based)
                            $rows = get_googlemeet_events_t($googleMeetActivity->id, $target_teacher_id, $start_timestamp, $end_timestamp, $limit);
                            //print_r($rows);
                            if (!empty($rows)) {
                                foreach ($rows as $r) {
                                    $startTs = (int)$r->eventdate;

                                    // Duration from activity settings (fallback 60 min if invalid/missing)
                                    $startMins = ((int)$r->starthour) * 60 + (int)$r->startminute;
                                    $endMins   = ((int)$r->endhour)   * 60 + (int)$r->endminute;
                                    $durSecs   = max(60, ($endMins - $startMins) * 60);
                                    $meet_code   = $r->url;
                                    if ($durSecs <= 0) { $durSecs = 3600; }

                                    $endTs   = $startTs + $durSecs;

                                    // Labels
                                    $dateYmd      = userdate($startTs, '%Y-%m-%d');
                                    $dateLabel    = userdate($startTs, '%B %e');          // e.g., "October 12"
                                    $dayName      = userdate($startTs, '%A');             // e.g., "Sunday"
                                    $timeRangeLbl = userdate($startTs, '%I:%M %p').' - '.userdate($endTs, '%I:%M %p');

                                    // Class type from name
                                    $gmname   = (string)$r->gmname;
                                    $classType = (stripos($gmname, 'Main') !== false) ? 'Main Class'
                                              : ((stripos($gmname, 'Practice') !== false) ? 'Practice Class' : 'Group Class');

                                    // Cohort bits from name prefix (before first '-'), with cache
                                    $namePrefix = '';
                                    $parts = explode('-', $gmname);
                                    if (!empty($parts[0])) { $namePrefix = trim($parts[0]); }

                                    $badgeText = strtoupper(substr($namePrefix, 0, 4));
                                    $label     = $namePrefix;
                                    $color     = 'Green';

                                    if ($namePrefix !== '') {
                                        if (!array_key_exists($namePrefix, $cohortCache)) {
                                            $cohortCache[$namePrefix] = $DB->get_record('cohort', ['shortname' => $namePrefix], 'id,name,cohortcolor', IGNORE_MISSING);
                                        }
                                        if (!empty($cohortCache[$namePrefix])) {
                                            $label = $cohortCache[$namePrefix]->name ?? $label;
                                            if (!empty($cohortCache[$namePrefix]->cohortcolor)) {
                                                $color = $cohortCache[$namePrefix]->cohortcolor;
                                            }
                                        }
                                    }

                                    // Build activity URL (standard Moodle mod URL)
                                    $url = (new moodle_url('/mod/googlemeet/view.php', ['id' => $r->cmid]))->out(false);

                                    $all_events[] = [
                                        'date' => $dateYmd,
                                        'timestamp' => $startTs,
                                        'class_display' => [
                                            'date'       => $dateLabel,
                                            'day_time'   => $dayName.' at '.$timeRangeLbl,
                                            'short_text' => [
                                                'title' => $classType,
                                                'badge' => $badgeText,
                                                'label' => $label,
                                                'color' => $color,
                                            ],
                                            'url'   => $url,
                                            'type'  => 'group',
                                            'image' => '',
                                            'user'  => '',
                                            'activity_name' => $gmname,
                                            'event_id' => $r->eventid,
                                            'source' => 'cohort',
                                            'meet_code' => $meet_code
                                        ],
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            // Process 1-on-1 Google Meet Activities from Course 24
            $sections_1on1 = get_teacher_sections_googlemeets_and_students_course24_t($target_teacher_id, $start_timestamp, $end_timestamp);
             
            foreach ($sections_1on1 as $sec) {
                if (empty($sec->meets)) {
                    continue;
                }

                foreach ($sec->meets as $meet) {
                    $events = $meet->events ?? [];
                    
                    if (empty($events)) {
                        continue;
                    }

                    $students = $meet->students ?? [];
                    if (empty($students)) {
                        continue;
                    }

                    $meetUrl = !empty($meet->meetingurl) ? $meet->meetingurl : $meet->viewurl;

                    foreach ($events as $ev) {
                        $sessionStart = (int)$ev->timestart;
                        $duration     = (int)($ev->timeduration ?? 0);
                        $sessionEnd   = $sessionStart + ($duration > 0 ? $duration : 3600);
                        $meet_code    = $ev->url;
                        // Friendly labels in current user's timezone
                        $dateYmd        = userdate($sessionStart, '%Y-%m-%d');
                        $fullDayName    = userdate($sessionStart, '%A');
                        $displayDate    = userdate($sessionStart, '%B %e');
                        $formattedStart = userdate($sessionStart, '%l:%M %p');
                        $formattedEnd   = userdate($sessionEnd,   '%l:%M %p');
                        $formattedTime  = trim($formattedStart) . ' - ' . trim($formattedEnd);

                        $dt = new DateTime();
                        $dt->setTimestamp($sessionStart);
                        $dateLabel = ($dt->format('Y-m-d') === date('Y-m-d')) ? 'Today' : $dt->format('F j');

                        // One card per STUDENT for this event (1:1 display)
                        foreach ($students as $stu) {
                            $all_events[] = [
                                'date'     => $dateYmd,
                                'timestamp'     => $sessionStart,
                                'class_display' => [
                                    'date'       => $dateLabel,
                                    'day_time'   => $fullDayName . ' at ' . $formattedTime,
                                    'short_text' => [
                                        'title' => '1 on 1 Session',
                                        'badge' => $stu->profileimgurl,
                                        'label' => $stu->fullname,
                                        'color' => 'Blue',
                                    ],
                                    'url'   => $meetUrl,
                                    'type'  => 'group',
                                    'image' => '',
                                    'user'  => '',
                                    'activity_name' => $meet->name,
                                    'event_id' => $ev->id,
                                    'source' => '1on1',
                                    'meet_code' => $meetUrl
                                ],
                            ];
                        }
                    }
                }
            }
        }

        // Sort by timestamp and limit results
        usort($all_events, function($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });
        
        return array_slice($all_events, 0, $limit);

    } catch (Exception $e) {
        error_log("Error in get_teacher_googlemeet_events_t: " . $e->getMessage());
        return [];
    }
}

function display_googlemeet_events_table_tx($teacher_id, $start_date, $end_date, $limit = 1000)
{
    global $DB;

    $output = '';


    //$start_date = date('Y-m-d', $start_timestamp);
    //$end_date = date('Y-m-d', $end_timestamp);

    // Get paid session IDs within the date range
    $paid_sessions = $DB->get_records_sql("
        SELECT ps.session_id, ps.session_date
        FROM {local_teachertimecard_paid_sessions} ps
        JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
        WHERE p.teacherid = :teacherid 
        AND p.status = 'completed'
        AND ps.session_date BETWEEN :start_date AND :end_date
    ", [
        'teacherid' => $teacher_id,
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

    // Get Google Meet events using the existing function
    $events = get_teacher_googlemeet_events_t($teacher_id, $start_date, $end_date, $limit);
    
    if (!empty($events)) {
        echo "<p><strong>Total Combined Events Found:</strong> " . count($events) . "</p>";
        
        // Sort events by date in descending order
        usort($events, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 100%;'>";
        echo "<thead style='background: #e3f2fd;'>";
        echo "<tr>
                <th>Date</th>
                <th>Practice Classes</th>
                <th>Other Classes</th>
                <th>Actions</th>
              </tr>";
        echo "</thead><tbody>";
        
        // Group events by date and type
        $date_groups = [];
        foreach ($events as $event) {
            $date = $event['date'];
            $type = $event['class_display']['short_text']['title'];
            
            if (!isset($date_groups[$date])) {
                $date_groups[$date] = [
                    'practice' => [],
                    'other' => []
                ];
            }
            
            // Check if it's a Practice Class
            if (stripos($type, 'Practice') !== false) {
                $date_groups[$date]['practice'][] = $event;
            } else {
                $date_groups[$date]['other'][] = $event;
            }
        }
        
        // Display grouped events
        foreach ($date_groups as $date => $groups) {
            echo "<tr>";
            
            // Date column
            echo "<td style='background: #f9f9f9; font-weight: bold; vertical-align: top;'>";
            echo $date; // Y-m-d format
            echo "</td>";
            
            // Practice Classes column
            echo "<td style='vertical-align: top;'>";
            if (!empty($groups['practice'])) {
 
                foreach ($groups['practice'] as $event) {
                    
                    $display = $event['class_display'];
                    $source_color = $display['source'] == 'cohort' ? 'green' : 'blue';
                    
                    echo "<div style='border: 1px solid #ddd; padding: 8px; margin-bottom: 8px; border-radius: 4px;'>";
                    echo "<div style='margin-bottom: 4px;'><strong>{$display['activity_name']}</strong></div>";
                    echo "<div style='font-size: 12px; color: #666; margin-bottom: 2px;'>{$display['day_time']}</div>";
                    
                    // Cohort/Student info
                    echo "<div style='font-size: 12px; margin-bottom: 2px;'>";
                    if ($display['source'] == 'cohort') {
                        echo "<span style='background: {$display['short_text']['color']}; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;'>
                                {$display['short_text']['badge']}
                              </span>
                              {$display['short_text']['label']}";
                    } else {
                        echo "<img src='{$display['short_text']['badge']}' style='width: 25px; height: 25px; border-radius: 50%; vertical-align: middle; margin-right: 6px;'>
                              {$display['short_text']['label']}";
                    }
                    echo "</div>";
                    
                    echo "<div style='font-size: 11px; color: {$source_color}; margin-bottom: 4px;'><strong>" . strtoupper($display['source']) . "</strong></div>";
                    echo "<div style='font-size: 11px; color: #888;'>Event ID: {$display['event_id']}</div>";
                    echo "</div>";
                }
            } else {
                echo "<div style='color: #999; font-style: italic;'>No practice classes</div>";
            }
            echo "</td>";
            
            // Other Classes column
            echo "<td style='vertical-align: top;'>";
            if (!empty($groups['other'])) {
                foreach ($groups['other'] as $event) {
                    $display = $event['class_display'];
                    $source_color = $display['source'] == 'cohort' ? 'green' : 'blue';
                    
                    echo "<div style='border: 1px solid #ddd; padding: 8px; margin-bottom: 8px; border-radius: 4px;'>";
                    echo "<div style='margin-bottom: 4px;'><strong>{$display['activity_name']}</strong></div>";
                    echo "<div style='font-size: 12px; color: #666; margin-bottom: 2px;'>{$display['day_time']}</div>";
                    echo "<div style='font-size: 12px; color: #666; margin-bottom: 2px;'>Type: {$display['short_text']['title']}</div>";
                    
                    // Cohort/Student info
                    echo "<div style='font-size: 12px; margin-bottom: 2px;'>";
                    if ($display['source'] == 'cohort') {
                        echo "<span style='background: {$display['short_text']['color']}; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;'>
                                {$display['short_text']['badge']}
                              </span>
                              {$display['short_text']['label']}";
                    } else {
                        echo "<img src='{$display['short_text']['badge']}' style='width: 25px; height: 25px; border-radius: 50%; vertical-align: middle; margin-right: 6px;'>
                              {$display['short_text']['label']}";
                    }
                    echo "</div>";
                    
                    echo "<div style='font-size: 11px; color: {$source_color}; margin-bottom: 4px;'><strong>" . strtoupper($display['source']) . "</strong></div>";
                    echo "<div style='font-size: 11px; color: #888;'>Event ID: {$display['event_id']}</div>";
                    
                    // Join button for each event
                    echo "<div style='margin-top: 6px;'>";
                    echo "<a href='{$display['url']}' target='_blank' style='background: #4CAF50; color: white; padding: 4px 8px; text-decoration: none; border-radius: 3px; font-size: 11px;'>Join Class</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div style='color: #999; font-style: italic;'>No other classes</div>";
            }
            echo "</td>";
            
            // Actions column (general actions if needed)
            echo "<td style='vertical-align: top;'>";
            // You can add date-level actions here if needed
            echo "</td>";
            
            echo "</tr>";
        }
        echo "</tbody></table>";
        
    } else {
        echo "<p style='color: red;'>No Google Meet events found from any source</p>";
    }
}

function display_googlemeet_events_table_t($sessions,$teacher_id, $start_date, $end_date, $limit = 1000)
{
    global $DB;
    //print_r($sessions);
    $output = '';

    // Get paid session IDs within the date range
    $paid_sessions = $DB->get_records_sql("
        SELECT ps.session_id, ps.session_date
        FROM {local_teachertimecard_paid_sessions} ps
        JOIN {local_teachertimecard_payments} p ON ps.payment_id = p.id
        WHERE p.teacherid = :teacherid 
        AND p.status = 'completed'
        AND ps.session_date BETWEEN :start_date AND :end_date
    ", [
        'teacherid' => $teacher_id,
        'start_date' => $start_date,
        'end_date' => $end_date
    ]);

    // Create array of paid session IDs for quick lookup
    $paid_session_ids = array_column($paid_sessions, 'session_id');

    // Get Google Meet events using the existing function
    $events = get_teacher_googlemeet_events_t($teacher_id, $start_date, $end_date, $limit);
    
    if (empty($events)) {
        return "<p style='color: red;'>No Google Meet events found from any source</p>";
    }

    // Sort events by date in descending order (newest first)
    usort($events, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Group events by date only (no type grouping)
    $events_by_date = [];
    foreach ($events as $event) {
        $date = date("Y-m-d",strtotime($event['date']));
        if (!isset($events_by_date[$date])) {
            $events_by_date[$date] = [];
        }
        $events_by_date[$date][] = $event;
    }

    // Start building the table output
    // $output .= '
    // <table class="teacher-sessions-table">
    //     <thead>
    //         <tr>
    //             <th class="date">Date</th>
    //             <th class="main-cell">Practice Classes</th>
    //             <th class="practice-cell">Other Classes</th>
    //             <th class="taught">Taught</th>
    //             <th class="covered">Covered</th>
    //             <th class="missed">Missed</th>
    //             <th class="note">Note</th>
    //             <th class="status">Status</th>
    //         </tr>
    //     </thead>
    //     <tbody>';
    
    foreach ($events_by_date as $date => $date_events) {
        // Format the date
        //print_r($date_events);
        $day_name = date('D', strtotime($date));
        $month_day = date('M-j', strtotime($date));

        // Separate practice and other events
        $practice_events = [];
        $other_events = [];
        
        foreach ($date_events as $event) {
            $type = $event['class_display']['short_text']['title'];
            if (stripos($type, 'Practice') !== false) {
                $practice_events[] = $event;
            } else {
                $other_events[] = $event;
            }
        }

        // Generate practice session dots - ONE DOT PER EVENT
        $practice_dots = '';
        foreach ($practice_events as $index => $event) {
            
            $display = $event['class_display'];
            $prefix = get_session_prefix($display);
            $event_id = $display['event_id'] ?? 'event-' . $index;
            
            // Check if session is paid
            $is_paid = in_array($event_id, $paid_session_ids);
            $paid_indicator = $is_paid ? "<span class='paid-indicator full'></span>" : '';
            
            $tooltip_id = 'practice-' . $date . '-' . $event_id;
            $meeting_code = str_replace('https://meet.google.com/', '', $display['meet_code']);
            $meeting_code = strtoupper(str_replace('-', '',  $meeting_code));

            $session_exist = getSessionAggregatedData($sessions, $date, $meeting_code);

            

            //if (isSessionExists($sessions, $date, $meeting_code)
            if ($session_exist !== false) {
                //echo "Session exists!\n";
                $missed=" ";
                //print_r($session_exist);
                $session_duration = floor($session_exist['total_duration_seconds']/60);
                $session_start_at = date('h:i a',$session_exist['min_start_timestamp']);
                $session_end_at = date('h:i a',$session_exist['min_start_timestamp']+$session_exist['total_duration_seconds']);
            } else {
                //echo "Session not found\n";

                $missed="session-missed";
                 $session_duration = 0;
                $session_start_at  = "";
                $session_end__at   = "";
            }

            $practice_dots .=
                "<div class='session-dot-container' 
                      data-tooltip-id='{$tooltip_id}'>
                    <div class='session-dot {$missed}'>{$display['short_text']['badge']}{$paid_indicator}</div>
                </div>";

            // Create individual tooltip for EACH practice event
            
            $source_color = $display['source'] == 'cohort' ? 'green' : 'blue';


            
            $tooltip_content = "
                 
                <div class='tooltip-row'>
                    <span class='tooltip-time'>{$session_start_at}   {$session_end_at}   {$session_duration} mins</span>
                </div>";
            
            // Cohort/Student info
            if ($display['source'] == 'cohort') {
                $meeting_parts = explode('-', $display['activity_name']);
                $header = strtoupper($meeting_parts[0])." - ".strtoupper($meeting_parts[1]);
                 
            } else {
                $meeting_parts = explode(' ', $display['activity_name']); 
                $header = strtoupper($meeting_parts[0])." - ".strtoupper($meeting_parts[1]);
                
            }
            
             
            preg_match('/(\d{4}-\d{2}-\d{2})\s+\w+\s+at\s+(\d{1,2}:\d{2}\s+[AP]M)/', $date." ".$display['day_time'], $matches);
            $datetime_str = $matches[1] . ' ' . $matches[2]; // "2025-09-26 9:15 PM"
            $meeting_date_time = strtotime($datetime_str); 
            $recording = get_meeting_recording($event_id, strtotime($datetime_str));
            $output .= "
            <div class='session-tooltip alert-box-tooltip' id='{$tooltip_id}'>
                <div class='tooltip-header'>{$header}</div>
                <div class='tooltip-content'>
                    {$tooltip_content}
                </div>
                <div class='tooltip-foot'>
                    <div class='join-links-container'>
                        <a href='{$recording->webviewlink}' class='join-link' target='_blank'>
                            View Recording 
                        </a>
                    </div>
                </div>
                <div class='tooltip-close' onclick='closeTooltip(\"{$tooltip_id}\")'>×</div>
            </div>";
        }

        // Generate other classes dots - ONE DOT PER EVENT
        $other_dots = '';
        foreach ($other_events as $index => $event) {
            
            $display = $event['class_display'];
            $prefix = get_session_prefix($display);
            $event_id = $display['event_id'] ?? 'event-' . $index;
            
            // Check if session is paid
            $is_paid = in_array($event_id, $paid_session_ids);
            $paid_indicator = $is_paid ? "<span class='paid-indicator full'></span>" : '';
            
            $tooltip_id = 'other-' . $date . '-' . $event_id;
            $meeting_code = str_replace('https://meet.google.com/', '', $display['meet_code']);
            $meeting_code = strtoupper(str_replace('-', '',  $meeting_code));

            $session_exist = getSessionAggregatedData($sessions, $date, $meeting_code);

            

            //if (isSessionExists($sessions, $date, $meeting_code)
            if ($session_exist !== false) {
                //echo "Session exists!\n";
                $missed=" ";
                //print_r($session_exist);
                $session_duration = floor($session_exist['total_duration_seconds']/60);
                $session_start_at = date('h:i a',$session_exist['min_start_timestamp']);
                $session_end_at = date('h:i a',$session_exist['min_start_timestamp']+$session_exist['total_duration_seconds']);
            } else {
                //echo "Session not found\n";

                $missed="session-missed";
                 $session_duration = 0;
                $session_start_at  = "";
                $session_end__at   = "";
            }

            if ($display['source'] == '1on1') {
                
                $other_dots .=
                "<div class='session-dot-container' 
                      data-tooltip-id='{$tooltip_id}'>
                    <div class='session-dot {$missed}'><img src='{$display['short_text']['badge']}' style='width: 38px; height: 38px; border-radius: 50%; vertical-align: middle;'/>{$paid_indicator}</div>
                </div>";
            } else {
                $other_dots .=
                "<div class='session-dot-container' 
                      data-tooltip-id='{$tooltip_id}'>
                    <div class='session-dot {$missed}'>{$display['short_text']['badge']}{$paid_indicator}</div>
                </div>";
            }
            

            // Create individual tooltip for EACH other event
            //$header = $display['short_text']['title'] ?? 'Other Class';
            $source_color = $display['source'] == 'cohort' ? 'green' : 'blue';
            
            $tooltip_content = "                
                <div class='tooltip-row'>
                    <span class='tooltip-time'>{$session_start_at}   {$session_end_at}   {$session_duration} mins</span>
                </div>";
            preg_match('/(\d{4}-\d{2}-\d{2})\s+\w+\s+at\s+(\d{1,2}:\d{2}\s+[AP]M)/', $date." ".$display['day_time'], $matches);
            $datetime_str = $matches[1] . ' ' . $matches[2]; // "2025-09-26 9:15 PM"
            $meeting_date_time = strtotime($datetime_str); 
            
            // Cohort/Student info
            if ($display['source'] == 'cohort') {
                $meeting_parts = explode('-', $display['activity_name']);
                $header = strtoupper($meeting_parts[0])." - ".strtoupper($meeting_parts[1]);
                $recording = get_meeting_recording($event_id, strtotime($datetime_str)); 
            } else {
                $meeting_parts = explode(' ', $display['activity_name']); 
                $header = strtoupper($meeting_parts[0])." - ".strtoupper($meeting_parts[1]);
                $recording = get_meeting_recording_24($event_id, strtotime($datetime_str)); 
            }            
            
           
            $output .= "
            <div class='session-tooltip alert-box-tooltip' id='{$tooltip_id}'>
                <div class='tooltip-header'>{$header}</div>
                <div class='tooltip-content'>
                    {$tooltip_content}
                </div>
                <div class='tooltip-foot'>
                    <div class='join-links-container'>
                        <a href='{$recording->webviewlink}' class='join-link' target='_blank'>
                            View Recording
                        </a>
                    </div>
                </div>
                <div class='tooltip-close' onclick='closeTooltip(\"{$tooltip_id}\")'>×</div>
            </div>";
        }

        // Calculate hours
        $taught_hrs = calculate_taught_hours($date_events);
        $covered_hrs = 0; // Adapt based on your data
        $missed_hrs = 0;  // Adapt based on your data

        // Determine overall payment status for the day
        $all_paid = true;
        $some_paid = false;

        foreach ($date_events as $event) {
            $event_id = $event['class_display']['event_id'] ?? null;
            $is_paid = $event_id && in_array($event_id, $paid_session_ids);
            
            if ($is_paid) {
                $some_paid = true;
            } else {
                $all_paid = false;
            }
        }

        $status_class = '';
        $status_text = '';
        $status_icon = '';

        if ($all_paid && count($date_events) > 0) {
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

        $output .= '
        <tr>
            <td class="date">
                ' . $day_name . ' <br />
                ' . $month_day . '
            </td>
            
            <td class="practice-cell">
                <div class="session-dots">
                ' . $other_dots . '
                </div>
            </td>
            <td class="main-cell poppins">
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
                    <div class="edit-container" data-date="' . $date . '" data-teacherid="' . $teacher_id . '">
                        <img src="./assets/edit.svg" alt="" class="edit-icon" />
                    </div>
                </div>
                </div>
            </td>
        </tr>';
    }

    $output .= '</tbody></table>';

    // Add the same JavaScript and CSS from the first function
    $output .= get_tooltip_javascript();
    $output .= get_tooltip_css();

    return $output;
}

// Helper function to get session prefix
function get_session_prefix($display)
{
    $title = $display['short_text']['title'] ?? '';
    $words = explode(' ', $title);
    
    if (count($words) >= 2) {
        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    }
    
    return strtoupper(substr($title, 0, 2));
}

// Helper function to calculate taught hours
function calculate_taught_hours($events)
{
    $total_minutes = 0;
    
    // Calculate from all events
    foreach ($events as $event) {
        // You'll need to extract duration from your event data
        // This is a placeholder - adapt based on your actual data structure
        $total_minutes += 60; // Assuming 1 hour per session
    }
    
    return round($total_minutes / 60);
}

// Include the JavaScript and CSS from the first function
function get_tooltip_javascript()
{
    return '
    <script>
    (function($) {
        const GAP = 8; // space from the trigger
        const PAD = 8; // clamp inside viewport
        const DISPLAY_TIME = 2000; // 2 seconds display time

        let closeTimer = null;
        let currentTooltip = null;
        let currentDot = null;

        function place($dot, $tip) {
            const dotOffset = $dot.offset();
            const dotWidth = $dot.outerWidth();
            const dotHeight = $dot.outerHeight();
            const tipWidth = $tip.outerWidth();
            const tipHeight = $tip.outerHeight();
            
            const scrollTop = $(window).scrollTop();
            const scrollLeft = $(window).scrollLeft();
            const windowHeight = $(window).height();
            const windowWidth = $(window).width();

            // Default position: above the dot, centered
            let top = dotOffset.top - tipHeight - GAP;
            let left = dotOffset.left + (dotWidth / 2) - (tipWidth / 2);

            // Flip to below if not enough space above
            if (top < scrollTop + PAD) {
                top = dotOffset.top + dotHeight + GAP;
            }

            // Clamp horizontally within viewport
            left = Math.max(scrollLeft + PAD, Math.min(left, scrollLeft + windowWidth - tipWidth - PAD));
            
            // Clamp vertically within viewport
            if (top + tipHeight > scrollTop + windowHeight - PAD) {
                top = Math.max(scrollTop + PAD, scrollTop + windowHeight - tipHeight - PAD);
            }

            $tip.css({
                top: Math.round(top),
                left: Math.round(left)
            });
        }

        function openTooltip($dot) {
            const tooltipId = $dot.data("tooltip-id");
            const $tip = $("#" + tooltipId);
            if (!$tip.length) return;

            // Close current tooltip immediately if different
            if (currentTooltip && !currentTooltip.is($tip)) {
                closeCurrentTooltip();
            }

            $tip.css({
                display: "block",
                opacity: 0,
                visibility: "hidden"
            });

            // Position and show
            requestAnimationFrame(function() {
                place($dot, $tip);
                $tip.css({
                    visibility: "visible",
                    opacity: 1
                });
            });

            // Clear any existing timer
            clearTimeout(closeTimer);
            currentTooltip = $tip;
            currentDot = $dot;

            const onScrollResize = function() {
                if (currentTooltip && currentDot) {
                    requestAnimationFrame(function() {
                        place(currentDot, currentTooltip);
                    });
                }
            };

            $(window).on("scroll.sessiontip resize.sessiontip", onScrollResize);
            $dot.data("sessiontip-cleanup", function() {
                $(window).off("scroll.sessiontip resize.sessiontip", onScrollResize);
            });
        }

        function closeCurrentTooltip() {
            if (currentTooltip) {
                currentTooltip.css({
                    opacity: 0,
                    visibility: "hidden",
                    display: "none"
                });
                
                // Clean up event listeners
                if (currentDot) {
                    const cleanup = currentDot.data("sessiontip-cleanup");
                    if (cleanup) cleanup();
                    currentDot.removeData("sessiontip-cleanup");
                }
                
                currentTooltip = null;
                currentDot = null;
            }
            clearTimeout(closeTimer);
        }

        function startCloseTimer() {
            clearTimeout(closeTimer);
            closeTimer = setTimeout(function() {
                closeCurrentTooltip();
            }, DISPLAY_TIME);
        }

        function closeTooltip(id) {
            const $tip = $("#" + id);
            if ($tip.length) {
                $tip.css({
                    opacity: 0,
                    visibility: "hidden",
                    display: "none"
                });
                if (currentTooltip && currentTooltip.is($tip)) {
                    closeCurrentTooltip();
                }
            }
        }

        // Hover bindings
        $(document)
            .on("mouseenter", ".session-dot-container", function() {
                const $dot = $(this);
                openTooltip($dot);
            })
            .on("mouseleave", ".session-dot-container", function() {
                // Only start timer if not hovering over the tooltip
                if (!currentTooltip || !currentTooltip.is(":hover")) {
                    startCloseTimer();
                }
            })
            .on("mouseenter", ".session-tooltip", function() {
                // Cancel close timer when hovering tooltip
                clearTimeout(closeTimer);
            })
            .on("mouseleave", ".session-tooltip", function() {
                // Start close timer when leaving tooltip
                startCloseTimer();
            });

        // Reposition tooltips on window resize and scroll
        $(window).on("scroll.sessiontip resize.sessiontip", function() {
            if (currentTooltip && currentDot) {
                requestAnimationFrame(function() {
                    place(currentDot, currentTooltip);
                });
            }
        });

        // Global close function
        window.closeTooltip = closeTooltip;

    })(jQuery);
    </script>';
}

function get_tooltip_css()
{
    return '
    <style>
    .session-tooltip {
        position: fixed;
        background: white;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 12px;
        z-index: 10000;
        min-width: 250px;
        max-width: 300px;
        display: none;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        pointer-events: auto;
    }

    .session-tooltip::before {
        content: "";
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        border-width: 8px 8px 0;
        border-style: solid;
        border-color: white transparent transparent;
        filter: drop-shadow(0 2px 1px rgba(0, 0, 0, 0.1));
    }

    .tooltip-header {
        font-weight: bold;
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #333;
    }

    .tooltip-content {
        margin-bottom: 10px;
    }

    .tooltip-row {
        display: flex;
        flex-direction: column;
        padding: 4px 0;
        font-size: 12px;
        border-bottom: 1px solid #f5f5f5;
    }

    .tooltip-row:last-child {
        border-bottom: none;
    }

    .tooltip-time {
        color: #666;
    }

    .tooltip-activity {
        color: #333;
        font-weight: 500;
    }

    .tooltip-type {
        color: #888;
    }

    .tooltip-status {
        color: green;
        font-weight: bold;
    }

    .tooltip-foot {
        border-top: 1px solid #eee;
        padding-top: 8px;
    }

    .join-links-container {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .join-link {
        font-size: 11px;
        color: #007bff;
        text-decoration: none;
        padding: 3px 6px;
        border-radius: 3px;
        transition: background-color 0.2s;
        display: block;
        margin-bottom: 4px;
        text-align: center;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .join-link:hover {
        background-color: #007bff;
        color: white;
        text-decoration: none;
    }

    .paid-session {
        background-color: #f0fff0;
    }

    .tooltip-close {
        position: absolute;
        top: 6px;
        right: 8px;
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
        color: #999;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        z-index: 10001;
    }

    .tooltip-close:hover {
        background-color: #f5f5f5;
        color: #666;
    }

    .session-dot-container {
        display: inline-block;
        margin: 2px;
        position: relative;
    }

    .session-dot {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: bold;
        cursor: pointer;
        position: relative;
    }

    .practice-dot {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .other-dot {
        background-color: #f3e5f5;
        color: #7b1fa2;
    }

    .paid-indicator {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: green;
    }

    .paid-indicator.full {
        background: green;
    }

    .paid-indicator.partial {
        background: orange;
    }
    </style>';
}

function get_meeting_recording($googlemeetid, $meeting_date_time)
{
    global $DB;

    // Define the time window (30 minutes before and after meeting time)
    $time_window_start = $meeting_date_time - 1800;
    $time_window_end = $meeting_date_time + 1800;

    // Build the SQL query
    $sql = "SELECT r.* 
            FROM {googlemeet_events} e
            JOIN {googlemeet_recordings} r
              ON r.googlemeetid = e.googlemeetid
            WHERE e.id = :event_id
              AND r.createdtime > :time_start  
              AND r.visible = 1 
            ORDER BY r.createdtime ASC";

    // Execute the query with bound parameters
    $recordings = $DB->get_records_sql($sql, [
        'event_id' => $googlemeetid,
        'time_start' => $time_window_start 
    ], 0, 1); // Limit to 1 record

    return reset($recordings) ?: null; // Return the first record or null
}
function get_meeting_recording_24($googlemeetid, $meeting_date_time)
{
    global $DB;

    // Define the time window (30 minutes before and after meeting time)
    $time_window_start = $meeting_date_time - 1800;
    $time_window_end = $meeting_date_time + 1800;

    // Build the SQL query
    $sql = "SELECT r.* 
            FROM {event} e
            JOIN {googlemeet_recordings} r
              ON r.googlemeetid = e.instance
            WHERE e.id = :event_id
              AND r.createdtime > :time_start  
              AND r.visible = 1 
            ORDER BY r.createdtime ASC";

    // Execute the query with bound parameters
    $recordings = $DB->get_records_sql($sql, [
        'event_id' => $googlemeetid,
        'time_start' => $time_window_start 
    ], 0, 1); // Limit to 1 record

    return reset($recordings) ?: null; // Return the first record or null
}



function get_cohort_meet_activities_raw($teacherid, $startdate, $enddate)
{
    global $DB;

    $teacher_name = $DB->get_record_sql(
        "SELECT id, firstname 
        FROM {user} 
        WHERE id = ?",
        [$teacherid]
    );

    // 1. Get teacher's cohorts
    $cohorts_data = get_teacher_cohorts($teacherid);

    // 2. Convert date range
    $startdate_str = date('Y-m-d H:i:s', $startdate);
    $enddate_str = date('Y-m-d H:i:s', $enddate);

    // Initialize result arrays
    $all_sessions = [];

    // Process main cohorts
    if (!empty($cohorts_data['main_cohorts'])) {
        foreach ($cohorts_data['main_cohorts'] as $cohort) {
            $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period, r.webviewlink
                    FROM {google_meet_activities} a
                    JOIN {googlemeet} g ON 
                        LOWER(REPLACE(g.url, 'https://meeting.google.com/', '')) = 
                        LOWER(CONCAT(
                            SUBSTRING(a.meeting_code, 1, 3), '-',
                            SUBSTRING(a.meeting_code, 4, 4), '-',
                            SUBSTRING(a.meeting_code, 8, 3)
                        ))
                    JOIN {googlemeet_recordings} r ON r.googlemeetid = g.id    
                    WHERE (g.name LIKE :cohortpattern AND g.name LIKE '%Main%')
                        AND a.activity_time BETWEEN :startdate AND :enddate 
                        AND a.identifier = a.organizer_email
                    ORDER BY a.activity_time ASC";

            $params = [
                'cohortpattern' => $cohort->idnumber . '%',
                'startdate' => $startdate_str,
                'enddate' => $enddate_str
            ];

            $sessions = $DB->get_records_sql($sql, $params);
            $all_sessions = array_merge($all_sessions, $sessions);
        }
    }

    // Process 1:1 sessions
    $sql_1on1 = "SELECT a.*, g.name as meeting_type, g.days, g.period, r.webviewlink
                FROM {google_meet_activities} a
                JOIN {googlemeet} g ON 
                    LOWER(REPLACE(g.url, 'https://meeting.google.com/', '')) = 
                    LOWER(CONCAT(
                        SUBSTRING(a.meeting_code, 1, 3), '-',
                        SUBSTRING(a.meeting_code, 4, 4), '-',
                        SUBSTRING(a.meeting_code, 8, 3)
                    ))
                JOIN {googlemeet_recordings} r ON r.googlemeetid = g.id    
                WHERE (g.name LIKE '%1:1%' AND g.name LIKE :teacher_name)
                    AND a.activity_time BETWEEN :startdate AND :enddate 
                    AND a.identifier = a.organizer_email
                ORDER BY a.activity_time ASC";

    $params_1on1 = [
        'teacher_name' => '%' . $teacher_name->firstname,
        'startdate' => $startdate_str,
        'enddate' => $enddate_str
    ];

    $sessions_1on1 = $DB->get_records_sql($sql_1on1, $params_1on1);
    $all_sessions = array_merge($all_sessions, $sessions_1on1);

    // Process guide cohorts (practice sessions)
    if (!empty($cohorts_data['guide_cohorts'])) {
        foreach ($cohorts_data['guide_cohorts'] as $cohort) {
            $sql = "SELECT a.*, g.name as meeting_type, g.days, g.period, r.webviewlink
                    FROM {google_meet_activities} a
                    JOIN {googlemeet} g ON 
                        LOWER(REPLACE(g.url, 'https://meeting.google.com/', '')) = 
                        LOWER(CONCAT(
                            SUBSTRING(a.meeting_code, 1, 3), '-',
                            SUBSTRING(a.meeting_code, 4, 4), '-',
                            SUBSTRING(a.meeting_code, 8, 3)
                        ))
                    JOIN {googlemeet_recordings} r ON r.googlemeetid = g.id     
                    WHERE g.name LIKE :cohortpattern
                      AND g.name LIKE '%Practice%'
                      AND a.activity_time BETWEEN :startdate AND :enddate 
                      AND a.identifier = a.organizer_email
                    ORDER BY a.activity_time ASC";

            $params = [
                'cohortpattern' => $cohort->idnumber . '%',
                'startdate' => $startdate_str,
                'enddate' => $enddate_str
            ];

            $sessions = $DB->get_records_sql($sql, $params);
            $all_sessions = array_merge($all_sessions, $sessions);
        }
    }

    // Group by date and meeting_code
    $grouped_sessions = [];

    foreach ($all_sessions as $session) {
        $date = date('Y-m-d', strtotime($session->activity_time));
        $meeting_code = $session->meeting_code;
        
        $key = $date . '_' . $meeting_code;
        
        if (!isset($grouped_sessions[$key])) {
            $grouped_sessions[$key] = [
                'date' => $date,
                'meeting_code' => $meeting_code,
                'meeting_type' => $session->meeting_type,
                'days' => $session->days,
                'period' => $session->period,
                'webviewlink' => $session->webviewlink,
                'total_duration_seconds' => 0,
                'min_start_time' => $session->activity_time,
                'max_end_time' => $session->activity_time,
                'session_count' => 0,
                'sessions' => []
            ];
        }

        // Add session details
        $grouped_sessions[$key]['sessions'][] = [
            'activity_time' => $session->activity_time,
            'duration_seconds' => $session->duration_seconds,
            'identifier' => $session->identifier,
            'organizer_email' => $session->organizer_email
        ];

        // Update aggregates
        $grouped_sessions[$key]['total_duration_seconds'] += $session->duration_seconds;
        $grouped_sessions[$key]['session_count']++;
        
        // Update min start time
        if (strtotime($session->activity_time) < strtotime($grouped_sessions[$key]['min_start_time'])) {
            $grouped_sessions[$key]['min_start_time'] = $session->activity_time;
        }
        
        // Update max end time (activity_time + duration)
        $session_end_time = date('Y-m-d H:i:s', strtotime($session->activity_time) + $session->duration_seconds);
        if (strtotime($session_end_time) > strtotime($grouped_sessions[$key]['max_end_time'])) {
            $grouped_sessions[$key]['max_end_time'] = $session_end_time;
        }
    }
     
    // Convert to simple array and calculate additional fields
    $result = [];
    foreach ($grouped_sessions as $group) {
        $result[] = [
            'date' => $group['date'],
            'meeting_code' => $group['meeting_code'],
            'meeting_type' => $group['meeting_type'],
            'days' => $group['days'],
            'period' => $group['period'],
            'webviewlink' => $group['webviewlink'],
            'total_duration_seconds' => $group['total_duration_seconds'],
            'total_duration_hours' => round($group['total_duration_seconds'] / 3600, 2),
            'total_duration_minutes' => round($group['total_duration_seconds'] / 60, 2),
            'min_start_time' => $group['min_start_time'],
            'max_end_time' => $group['max_end_time'],
            'session_count' => $group['session_count'],
            'sessions' => $group['sessions']
        ];
    }

    // Sort by date and start time
    usort($result, function($a, $b) {
        $dateCompare = strcmp($a['date'], $b['date']);
        if ($dateCompare === 0) {
            return strcmp($a['min_start_time'], $b['min_start_time']);
        }
        return $dateCompare;
    });

    return $result;
}

function isSessionExistsx($sessions, $target_date, $target_meeting_code) {
    if (!isset($sessions['days'][$target_date])) {
        return false;
    }
    
    foreach ($sessions['days'][$target_date]['main_sessions'] as $session) {
        if ($session->meeting_code === $target_meeting_code) {
            return true;
        }
    }
    
    // Also check practice_sessions if needed
    foreach ($sessions['days'][$target_date]['practice_sessions'] as $session) {
        if ($session->meeting_code === $target_meeting_code) {
            return true;
        }
    }
    
    return false;
}
function getSessionAggregatedData($sessions, $target_date, $target_meeting_code) {
    if (!isset($sessions['days'][$target_date])) {
        return false;
    }
    
    $matchingSessions = [];
    $minStartTimestamp = PHP_INT_MAX;
    $totalDuration = 0;
    
    // Search in both session types
    $sessionTypes = ['main_sessions', 'practice_sessions'];
    
    foreach ($sessionTypes as $type) {
        if (isset($sessions['days'][$target_date][$type])) {
            foreach ($sessions['days'][$target_date][$type] as $session) {
                if ($session->meeting_code === $target_meeting_code) {
                    $matchingSessions[] = [
                        'session' => $session,
                        'type' => $type
                    ];
                    $minStartTimestamp = min($minStartTimestamp, $session->start_timestamp);
                    $totalDuration += $session->duration_seconds;
                }
            }
        }
    }
    
    if (empty($matchingSessions)) {
        return false;
    }
    
    return [
        'session_count' => count($matchingSessions),
        'min_start_timestamp' => $minStartTimestamp,
        'total_duration_seconds' => $totalDuration,
        'sessions' => $matchingSessions // All matching sessions with their types
    ];
}


function display_googlemeet_events_timeline_tx($sessions, $teacher_id, $start_timestamp, $end_timestamp, $limit = 1000) {
    global $DB;

    $output = '
    <table>
        <thead>
            <tr>
                <th class="date-header">' . get_string('date', 'local_teachertimecard') . '</th>
                <th class="timeline-header">
                    <div class="timeline-hours-container">';

    // Generate 24-hour headers starting from 9AM (9AM to 8AM next day)
    for ($h = 0; $h < 24; $h++) {
        $display_hour = ($h + 9) % 24; // Start from 9AM
        $hour_display = date('ga', mktime($display_hour, 0, 0));
        $output .= '<div class="hour-header">' . $hour_display . '</div>';
    }

    $output .= '
                    </div>
                </th>
                <th class="sticky-timeline-header">Status</th>
            </tr>
        </thead>
        <tbody id="timeline-body">';

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
        'teacherid' => $teacher_id,
        'start_date' => $start_date,
        'end_date' => $end_date
    ]);

    // Create array of paid session IDs for quick lookup
    $paid_session_ids = array_column($paid_sessions, 'session_id');

    // Get Google Meet events using the existing function
    $events = get_teacher_googlemeet_events_t($teacher_id, $start_date, $end_date, $limit);
    
    if (empty($events)) {
        $output .= '
        <tr>
            <td colspan="3" class="no-sessions-message">
                ' . get_string('nosessionsfound', 'local_teachertimecard') . '
            </td>
        </tr>';
        
        $output .= '</tbody></table>';
        return $output;
    }

    // Sort events by date in descending order (newest first)
    usort($events, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Group events by date
    $events_by_date = [];
    foreach ($events as $event) {
        $date = date("Y-m-d", strtotime($event['date']));
        if (!isset($events_by_date[$date])) {
            $events_by_date[$date] = [];
        }
        $events_by_date[$date][] = $event;
    }

    // Process each date
    foreach ($events_by_date as $date => $date_events) {
        // Format the date as "Mon<br>Oct-1"
        $day_name = date('D', strtotime($date));
        $month_day = date('M-j', strtotime($date));

        // Initialize hourly columns for 24 hours (starting from 9AM)
        $hourly_columns = array_fill(0, 24, '');
        $hourly_payment_status = array_fill(0, 24, ['paid_count' => 0, 'total_count' => 0]);

        // Process all events for this date
        foreach ($date_events as $event) {
            $display = $event['class_display'];
            $event_id = $display['event_id'] ?? uniqid();
            
            // Parse the scheduled time from day_time - FIXED VERSION
            $day_time = $display['day_time'] ?? '';
            if (empty($day_time)) {
                continue; // Skip if no day_time available
            }
            
            // Try to parse the time from day_time string
            $scheduled_time = false;
            
            // Method 1: Try parsing with regex (like your original code)
            preg_match('/(\d{1,2}:\d{2}\s+[AP]M)/i', $day_time, $time_matches);
            if (!empty($time_matches)) {
                $time_str = $time_matches[0];
                $datetime_str = $date . ' ' . $time_str;
                $scheduled_time = strtotime($datetime_str);
            }
            
            // Method 2: If regex fails, try direct strtotime on day_time
            if (!$scheduled_time) {
                $scheduled_time = strtotime($date . ' ' . $day_time);
            }
            
            // Method 3: If still no time, use a default time
            if (!$scheduled_time) {
                $scheduled_time = strtotime($date . ' 12:00 PM'); // Default to noon
            }

            // Get meeting code and check if session exists
            $meeting_code = str_replace('https://meet.google.com/', '', $display['meet_code']);
            $meeting_code = strtoupper(str_replace('-', '', $meeting_code));
            
            $session_data = getSessionAggregatedData($sessions, $date, $meeting_code);
            
            // Determine session type and styling
            $type = $display['class_display']['short_text']['title'] ?? '';
            $is_practice = stripos($type, 'Practice') !== false;
            $session_class = $is_practice ? 'practice-session' : 'main-session';
            
            // Get session prefix and check if it's 1on1 for image display
            if ($display['source'] == '1on1') {
                $prefix = "<img src='{$display['short_text']['badge']}' style='width: 58px; height: 58px; vertical-align: middle;'/>";
            } else {
                $prefix = $display['short_text']['badge'];
            }
            
            // Check if session is paid
            $is_paid = in_array($event_id, $paid_session_ids);
            $payment_indicator = $is_paid ? '<span class="paid-indicator-timeline full"></span>' : '';

            // Calculate timeline position - FIXED: Ensure we have valid timestamp
            $start_hour_original = (int)date('G', $scheduled_time);
            $start_minute = (int)date('i', $scheduled_time);
            
            // Convert hour to 9AM-based timeline (9AM = hour 0, 10AM = hour 1, etc.)
            $timeline_hour = ($start_hour_original + 15) % 24;

            // Calculate duration and position
            $session_duration = 0;
            $session_start_at = "";
            $session_end_at = "";
            
            if ($session_data !== false && isset($session_data['total_duration_seconds']) && isset($session_data['min_start_timestamp'])) {
                // Use actual session data if available
                $session_duration = floor($session_data['total_duration_seconds'] / 60);
                $actual_start_time = $session_data['min_start_timestamp'];
                $actual_hour = (int)date('G', $actual_start_time);
                $actual_minute = (int)date('i', $actual_start_time);
                $timeline_hour = ($actual_hour + 15) % 24;
                $position = round(($actual_minute / 60) * 100);
                $session_start_at = date('h:i a', $actual_start_time);
                $session_end_at = date('h:i a', $actual_start_time + $session_data['total_duration_seconds']);
            } else {
                // Use scheduled time with estimated duration
                $session_duration = 60; // Default 1 hour for scheduled sessions
                $position = round(($start_minute / 60) * 100);
                $session_start_at = date('h:i a', $scheduled_time);
                $session_end_at = date('h:i a', $scheduled_time + 3600); // +1 hour
            }

            $width = round(($session_duration / 60) * 100); // Width as percentage of hour

            // Update payment status for this hour
            if ($timeline_hour >= 0 && $timeline_hour <= 23) {
                $hourly_payment_status[$timeline_hour]['total_count']++;
                if ($is_paid) {
                    $hourly_payment_status[$timeline_hour]['paid_count']++;
                }
            }

            // Create tooltip ID and content
            $tooltip_id = 'timeline-' . $date . '-' . $event_id;
            $missed_class = ($session_data === false) ? 'session-missed' : '';

            // Add session to timeline (only if within 0-23 hour range)
            if ($timeline_hour >= 0 && $timeline_hour <= 23) {
                $hourly_columns[$timeline_hour] .= "
                    <div class='session-progress {$session_class} {$missed_class}' 
                         data-tooltip-id='{$tooltip_id}'
                         style='left: {$position}%; width: {$width}%' 
                         title='{$session_duration}min'>
                         {$prefix}{$payment_indicator}
                    </div>";
            }

            // Create tooltip content
            $tooltip_content = "
                <div class='tooltip-row'>
                    <span class='tooltip-time'>{$session_start_at}   {$session_end_at}   {$session_duration} mins</span>
                </div>";

            // Create header based on source
            if ($display['source'] == 'cohort') {
                $meeting_parts = explode('-', $display['activity_name']);
                $header = strtoupper($meeting_parts[0]) . " - " . strtoupper($meeting_parts[1]);
            } else {
                $meeting_parts = explode(' ', $display['activity_name']); 
                $header = strtoupper($meeting_parts[0]) . " - " . strtoupper($meeting_parts[1]);
            }

            // Get recording based on source
            preg_match('/(\d{4}-\d{2}-\d{2})\s+\w+\s+at\s+(\d{1,2}:\d{2}\s+[AP]M)/', $date . " " . $display['day_time'], $matches);
            $datetime_str = $matches[1] . ' ' . $matches[2];
            $meeting_date_time = strtotime($datetime_str);
            
            if ($display['source'] == 'cohort') {
                $recording = get_meeting_recording($event_id, $meeting_date_time);
            } else {
                $recording = get_meeting_recording_24($event_id, $meeting_date_time);
            }

            // Add tooltip HTML
            $output .= "
            <div class='session-tooltip alert-box-tooltip' id='{$tooltip_id}'>
                <div class='tooltip-header'>{$header}</div>
                <div class='tooltip-content'>
                    {$tooltip_content}
                </div>
                <div class='tooltip-foot'>
                    <div class='join-links-container'>
                        <a href='{$recording->webviewlink}' class='join-link' target='_blank'>
                            View Recording
                        </a>
                    </div>
                </div>
                <div class='tooltip-close' onclick='closeTooltip(\"{$tooltip_id}\")'>×</div>
            </div>";
        }

        // Determine overall payment status for the day
        $all_paid = true;
        $some_paid = false;
        $total_events = 0;

        foreach ($date_events as $event) {
            $event_id = $event['class_display']['event_id'] ?? null;
            $total_events++;
            
            if ($event_id && in_array($event_id, $paid_session_ids)) {
                $some_paid = true;
            } else {
                $all_paid = false;
            }
        }

        $status_class = '';
        $status_text = '';
        $status_icon = '';

        if ($all_paid && $total_events > 0) {
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

        // Build the timeline row
        $output .= '
        <tr>
            <td class="date-timeline">
                ' . $day_name . ' <br />
                ' . $month_day . '
            </td>
            <td class="timeline-content-cell">
                <div class="timeline-hours-scroll-container">
                    <div class="timeline-hours-container">';

        // Add hourly columns (0 to 23) with 9AM starting point
        for ($h = 0; $h < 24; $h++) {
            $content = $hourly_columns[$h] ?: '';
            $output .= '<div class="hour-cell">
                <div class="hour-content">
                    ' . $content . '
                </div>
            </div>';
        }

        $output .= '</div>
                </div>
            </td>
            <td class="sticky-timeline">
                <div class="status-container-timeline">
                    <div class="status-badge-timeline ' . $status_class . '">
                        ' . $status_icon . '
                        <p>' . $status_text . '</p>
                    </div>
                    <div class="edit-big-container-timeline">
                        <div class="edit-container" data-date="' . $date . '" data-teacherid="' . $teacher_id . '">
                            <img src="./assets/edit.svg" alt="" class="edit-icon" />
                        </div>
                    </div>
                </div>
            </td>
        </tr>';
    }

    $output .= '
        </tbody>
    </table>';

    // Add the same JavaScript and CSS from the first function
    $output .= get_tooltip_javascript();
    $output .= get_tooltip_css();

    return $output;
}


function display_googlemeet_events_timeline_t($sessions, $teacher_id, $start_timestamp, $end_timestamp, $limit = 1000) {
    global $DB;

    $output = '
    <table>
        <thead>
            <tr>
                <th class="date-header">' . get_string('date', 'local_teachertimecard') . '</th>
                <th class="timeline-header">
                    <div class="timeline-hours-container">';

    // Generate 24-hour headers starting from 9AM (9AM to 8AM next day)
    for ($h = 0; $h < 24; $h++) {
        $display_hour = ($h + 9) % 24; // Start from 9AM
        $hour_display = date('ga', mktime($display_hour, 0, 0));
        $output .= '<div class="hour-header">' . $hour_display . '</div>';
    }

    $output .= '
                    </div>
                </th>
                <th class="sticky-timeline-header">Status</th>
            </tr>
        </thead>
        <tbody id="timeline-body">';

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
        'teacherid' => $teacher_id,
        'start_date' => $start_date,
        'end_date' => $end_date
    ]);

    // Create array of paid session IDs for quick lookup
    $paid_session_ids = array_column($paid_sessions, 'session_id');

    // Get Google Meet events using the existing function
    $events = get_teacher_googlemeet_events_t($teacher_id, $start_date, $end_date, $limit);
    
    if (empty($events)) {
        $output .= '
        <tr>
            <td colspan="3" class="no-sessions-message">
                ' . get_string('nosessionsfound', 'local_teachertimecard') . '
            </td>
        </tr>';
        
        $output .= '</tbody></table>';
        return $output;
    }

    // Sort events by date in descending order (newest first)
    usort($events, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // Group events by date
    $events_by_date = [];
    foreach ($events as $event) {
        $date = date("Y-m-d", strtotime($event['date']));
        if (!isset($events_by_date[$date])) {
            $events_by_date[$date] = [];
        }
        $events_by_date[$date][] = $event;
    }

    // Process each date
    foreach ($events_by_date as $date => $date_events) {
        // Format the date as "Mon<br>Oct-1"
        $day_name = date('D', strtotime($date));
        $month_day = date('M-j', strtotime($date));

        // Initialize hourly columns for 24 hours (starting from 9AM)
        $hourly_columns = array_fill(0, 24, '');
        $hourly_payment_status = array_fill(0, 24, ['paid_count' => 0, 'total_count' => 0]);

        // Process all events for this date
        foreach ($date_events as $event) {
            $display = $event['class_display'];
            $event_id = $display['event_id'] ?? uniqid();
            
            // Parse the scheduled time from day_time - FIXED VERSION
            $day_time = $display['day_time'] ?? '';
            if (empty($day_time)) {
                continue; // Skip if no day_time available
            }
            
            // Try to parse the time from day_time string
            $scheduled_time = false;
            
            // Method 1: Try parsing with regex (like your original code)
            preg_match('/(\d{1,2}:\d{2}\s+[AP]M)/i', $day_time, $time_matches);
            if (!empty($time_matches)) {
                $time_str = $time_matches[0];
                $datetime_str = $date . ' ' . $time_str;
                $scheduled_time = strtotime($datetime_str);
            }
            
            // Method 2: If regex fails, try direct strtotime on day_time
            if (!$scheduled_time) {
                $scheduled_time = strtotime($date . ' ' . $day_time);
            }
            
            // Method 3: If still no time, use a default time
            if (!$scheduled_time) {
                $scheduled_time = strtotime($date . ' 12:00 PM'); // Default to noon
            }

            // Get meeting code and check if session exists
            $meeting_code = str_replace('https://meet.google.com/', '', $display['meet_code']);
            $meeting_code = strtoupper(str_replace('-', '', $meeting_code));
            
            $session_data = getSessionAggregatedData($sessions, $date, $meeting_code);
            
            // Determine session type and styling
            $type = $display['class_display']['short_text']['title'] ?? '';
            $is_practice = stripos($type, 'Practice') !== false;
            $session_class = $is_practice ? 'practice-session' : 'main-session';
            
            // Get session prefix and check if it's 1on1 for image display
            if ($display['source'] == '1on1') {
                $prefix = "<img src='{$display['short_text']['badge']}' style='width: 58px; height: 58px; vertical-align: middle;'/>";
            } else {
                $prefix = $display['short_text']['badge'];
            }
            
            // Check if session is paid
            $is_paid = in_array($event_id, $paid_session_ids);
            $payment_indicator = $is_paid ? '<span class="paid-indicator-timeline full"></span>' : '';

            // Calculate timeline position - FIXED: Ensure we have valid timestamp
            $start_hour_original = (int)date('G', $scheduled_time);
            $start_minute = (int)date('i', $scheduled_time);
            
            // Convert hour to 9AM-based timeline (9AM = hour 0, 10AM = hour 1, etc.)
            $timeline_hour = ($start_hour_original + 15) % 24;

            // Calculate duration and position
            $session_duration = 0;
            $session_start_at = "";
            $session_end_at = "";
            
            if ($session_data !== false && isset($session_data['total_duration_seconds']) && isset($session_data['min_start_timestamp'])) {
                // Use actual session data if available
                $session_duration = floor($session_data['total_duration_seconds'] / 60);
                $actual_start_time = $session_data['min_start_timestamp'];
                $actual_hour = (int)date('G', $actual_start_time);
                $actual_minute = (int)date('i', $actual_start_time);
                $timeline_hour = ($actual_hour + 15) % 24;
                $position = round(($actual_minute / 60) * 100);
                $session_start_at = date('h:i a', $actual_start_time);
                $session_end_at = date('h:i a', $actual_start_time + $session_data['total_duration_seconds']);
            } else {
                // Use scheduled time with estimated duration
                $session_duration = 60; // Default 1 hour for scheduled sessions
                $position = round(($start_minute / 60) * 100);
                $session_start_at = date('h:i a', $scheduled_time);
                $session_end_at = date('h:i a', $scheduled_time + 3600); // +1 hour
            }

            $width = round(($session_duration / 60) * 100); // Width as percentage of hour

            // Update payment status for this hour
            if ($timeline_hour >= 0 && $timeline_hour <= 23) {
                $hourly_payment_status[$timeline_hour]['total_count']++;
                if ($is_paid) {
                    $hourly_payment_status[$timeline_hour]['paid_count']++;
                }
            }

            // Create tooltip ID and content
            $tooltip_id = 'timeline-' . $date . '-' . $event_id;
            //$missed_class = ($session_data === false) ? 'session-missed' : '{$session_class}';
            $missed_class = ($session_data === false) ? 'session-missed' : "{$session_class}";
            //$session_classes = $missed_class ? 'session-missed' : " {$session_class}";
            // Add session to timeline (only if within 0-23 hour range)
            if ($timeline_hour >= 0 && $timeline_hour <= 23) {
                
                $hourly_columns[$timeline_hour] .= "
                    <div class='session-progress {$missed_class}  session-dot-containert' 
                         data-tooltip-id='{$tooltip_id}'
                         style='left: {$position}%; width: {$width}%' 
                         title='{$session_duration}min'>
                         {$prefix}{$payment_indicator}
                    </div>";
            }

            // Create tooltip content
            $tooltip_content = "
                <div class='tooltip-row'>
                    <span class='tooltip-time'>{$session_start_at}   {$session_end_at}   {$session_duration} mins</span>
                </div>";

            // Create header based on source
            if ($display['source'] == 'cohort') {
                $meeting_parts = explode('-', $display['activity_name']);
                $header = strtoupper($meeting_parts[0]) . " - " . strtoupper($meeting_parts[1]);
            } else {
                $meeting_parts = explode(' ', $display['activity_name']); 
                $header = strtoupper($meeting_parts[0]) . " - " . strtoupper($meeting_parts[1]);
            }

            // Get recording based on source
            preg_match('/(\d{4}-\d{2}-\d{2})\s+\w+\s+at\s+(\d{1,2}:\d{2}\s+[AP]M)/', $date . " " . $display['day_time'], $matches);
            $datetime_str = $matches[1] . ' ' . $matches[2];
            $meeting_date_time = strtotime($datetime_str);
            
            if ($display['source'] == 'cohort') {
                $recording = get_meeting_recording($event_id, $meeting_date_time);
            } else {
                $recording = get_meeting_recording_24($event_id, $meeting_date_time);
            }

            // Add tooltip HTML
            $output .= "
            <div class='session-tooltip alert-box-tooltip' id='{$tooltip_id}'>
                <div class='tooltip-header'>{$header}</div>
                <div class='tooltip-content'>
                    {$tooltip_content}
                </div>
                <div class='tooltip-foot'>
                    <div class='join-links-container'>
                        <a href='{$recording->webviewlink}' class='join-link' target='_blank'>
                            View Recording
                        </a>
                    </div>
                </div>
                <div class='tooltip-close' onclick='closeTooltip(\"{$tooltip_id}\")'>×</div>
            </div>";
        }

        // Determine overall payment status for the day
        $all_paid = true;
        $some_paid = false;
        $total_events = 0;

        foreach ($date_events as $event) {
            $event_id = $event['class_display']['event_id'] ?? null;
            $total_events++;
            
            if ($event_id && in_array($event_id, $paid_session_ids)) {
                $some_paid = true;
            } else {
                $all_paid = false;
            }
        }

        $status_class = '';
        $status_text = '';
        $status_icon = '';

        if ($all_paid && $total_events > 0) {
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

        // Build the timeline row
        $output .= '
        <tr>
            <td class="date-timeline">
                ' . $day_name . ' <br />
                ' . $month_day . '
            </td>
            <td class="timeline-content-cell">
                <div class="timeline-hours-scroll-container">
                    <div class="timeline-hours-container">';

        // Add hourly columns (0 to 23) with 9AM starting point
        for ($h = 0; $h < 24; $h++) {
            $content = $hourly_columns[$h] ?: '';
            $output .= '<div class="hour-cell">
                <div class="hour-content">
                    ' . $content . '
                </div>
            </div>';
        }

        $output .= '</div>
                </div>
            </td>
            <td class="sticky-timeline">
                <div class="status-container-timeline">
                    <div class="status-badge-timeline ' . $status_class . '">
                        ' . $status_icon . '
                        <p>' . $status_text . '</p>
                    </div>
                    <div class="edit-big-container-timeline">
                        <div class="edit-container" data-date="' . $date . '" data-teacherid="' . $teacher_id . '">
                            <img src="./assets/edit.svg" alt="" class="edit-icon" />
                        </div>
                    </div>
                </div>
            </td>
        </tr>';
    }

    $output .= '
        </tbody>
    </table>';

    // Add the JavaScript for tooltip functionality
    $output .= '
    <script>
    (function($) {
        const GAP = 8; // space from the trigger
        const PAD = 8; // clamp inside viewport
        const DISPLAY_TIME = 2000; // 2 seconds display time

        let closeTimer = null;
        let currentTooltip = null;
        let currentDot = null;

        function place($dot, $tip) {
            const dotOffset = $dot.offset();
            const dotWidth = $dot.outerWidth();
            const dotHeight = $dot.outerHeight();
            const tipWidth = $tip.outerWidth();
            const tipHeight = $tip.outerHeight();
            
            const scrollTop = $(window).scrollTop();
            const scrollLeft = $(window).scrollLeft();
            const windowHeight = $(window).height();
            const windowWidth = $(window).width();

            // Default position: above the dot, centered
            let top = dotOffset.top - tipHeight - GAP;
            let left = dotOffset.left + (dotWidth / 2) - (tipWidth / 2);

            // Flip to below if not enough space above
            if (top < scrollTop + PAD) {
                top = dotOffset.top + dotHeight + GAP;
            }

            // Clamp horizontally within viewport
            left = Math.max(scrollLeft + PAD, Math.min(left, scrollLeft + windowWidth - tipWidth - PAD));
            
            // Clamp vertically within viewport
            if (top + tipHeight > scrollTop + windowHeight - PAD) {
                top = Math.max(scrollTop + PAD, scrollTop + windowHeight - tipHeight - PAD);
            }

            $tip.css({
                top: Math.round(top),
                left: Math.round(left)
            });
        }

        function openTooltip($dot) {
            const tooltipId = $dot.data("tooltip-id");
            const $tip = $("#" + tooltipId);
            if (!$tip.length) return;

            // Close current tooltip immediately if different
            if (currentTooltip && !currentTooltip.is($tip)) {
                closeCurrentTooltip();
            }

            $tip.css({
                display: "block",
                opacity: 0,
                visibility: "hidden"
            });

            // Position and show
            requestAnimationFrame(function() {
                place($dot, $tip);
                $tip.css({
                    visibility: "visible",
                    opacity: 1
                });
            });

            // Clear any existing timer
            clearTimeout(closeTimer);
            currentTooltip = $tip;
            currentDot = $dot;

            const onScrollResize = function() {
                if (currentTooltip && currentDot) {
                    requestAnimationFrame(function() {
                        place(currentDot, currentTooltip);
                    });
                }
            };

            $(window).on("scroll.sessiontip resize.sessiontip", onScrollResize);
            $dot.data("sessiontip-cleanup", function() {
                $(window).off("scroll.sessiontip resize.sessiontip", onScrollResize);
            });
        }

        function closeCurrentTooltip() {
            if (currentTooltip) {
                currentTooltip.css({
                    opacity: 0,
                    visibility: "hidden",
                    display: "none"
                });
                
                // Clean up event listeners
                if (currentDot) {
                    const cleanup = currentDot.data("sessiontip-cleanup");
                    if (cleanup) cleanup();
                    currentDot.removeData("sessiontip-cleanup");
                }
                
                currentTooltip = null;
                currentDot = null;
            }
            clearTimeout(closeTimer);
        }

        function startCloseTimer() {
            clearTimeout(closeTimer);
            closeTimer = setTimeout(function() {
                closeCurrentTooltip();
            }, DISPLAY_TIME);
        }

        function closeTooltip(id) {
            const $tip = $("#" + id);
            if ($tip.length) {
                $tip.css({
                    opacity: 0,
                    visibility: "hidden",
                    display: "none"
                });
                if (currentTooltip && currentTooltip.is($tip)) {
                    closeCurrentTooltip();
                }
            }
        }

        // Hover bindings for timeline sessions
        $(document)
            .on("mouseenter", ".session-progress.session-dot-containert", function() {
                const $dot = $(this);
                openTooltip($dot);
            })
            .on("mouseleave", ".session-progress.session-dot-containert", function() {
                // Only start timer if not hovering over the tooltip
                if (!currentTooltip || !currentTooltip.is(":hover")) {
                    startCloseTimer();
                }
            })
            .on("mouseenter", ".session-tooltip", function() {
                // Cancel close timer when hovering tooltip
                clearTimeout(closeTimer);
            })
            .on("mouseleave", ".session-tooltip", function() {
                // Start close timer when leaving tooltip
                startCloseTimer();
            });

        // Reposition tooltips on window resize and scroll
        $(window).on("scroll.sessiontip resize.sessiontip", function() {
            if (currentTooltip && currentDot) {
                requestAnimationFrame(function() {
                    place(currentDot, currentTooltip);
                });
            }
        });

        // Global close function
        window.closeTooltip = closeTooltip;

    })(jQuery);
    </script>';

    // Add the same CSS from the first function
    $output .= get_tooltip_css();

    return $output;
}