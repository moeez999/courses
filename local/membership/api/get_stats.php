<?php
require_once('../../../config.php');
require_login();

// Validate permissions
$context = context_system::instance();
 

// Get parameters with defaults
$startdate = optional_param('startdate', strtotime('first day of this month 00:00:00'), PARAM_INT);
$enddate = optional_param('enddate', strtotime('last day of this month 23:59:59'), PARAM_INT);
$p = optional_param('p', 1, PARAM_INT);

// Calculate previous period for comparison
$periodDuration = $enddate - $startdate;
$prevStartdate = $startdate - $periodDuration;
$prevEnddate = $startdate;

try {
    // Get current period stats
    $currentStats = local_membership_get_stats($startdate, $enddate);
    
    // Get previous period stats for comparison
    $previousStats = local_membership_get_stats($prevStartdate, $prevEnddate);
    
    // Calculate trends for each metric
    $stats = [
        'activestudents' => [
            'value' => $currentStats['activestudents'],
            'trend' => calculate_trend($currentStats['activestudents'], $previousStats['activestudents']),
            'color' => '#28971f'
        ],
        'newstudents' => [
            'value' => $currentStats['newstudents'],
            'trend' => calculate_trend($currentStats['newstudents'], $previousStats['newstudents']),
            'color' => '#001cb1'
        ],
        'pausedstudents' => [
            'value' => $currentStats['pausedstudents'],
            'trend' => calculate_trend($currentStats['pausedstudents'], $previousStats['pausedstudents']),
            'color' => '#dd853e'
        ],
        'declinedstudents' => [
            'value' => $currentStats['declinedstudents'],
            'trend' => calculate_trend($currentStats['declinedstudents'], $previousStats['declinedstudents']),
            'color' => '#f86264'
        ],
        'dropoutstudent' => [
            'value' => $currentStats['dropoutstudent'],
            'trend' => calculate_trend($currentStats['dropoutstudent'], $previousStats['dropoutstudent']),
            'color' => '#9747ff'
        ],
        'retention' => [
            'value' => $currentStats['retention'],
            'trend' => calculate_trend(
                (float)str_replace('%', '', $currentStats['retention']), 
                (float)str_replace('%', '', $previousStats['retention'])
            ),
            'color' => '#464646'
        ]
    ];
    
    // Format the period for display
    $days = floor(($enddate - $startdate) / (60 * 60 * 24));
    $period = format_period($p,$prevStartdate,$prevEnddate);
    
    $response = [
        'success' => true,
        'stats' => $stats,
        'period' => $period
    ];

} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => $e->getMessage()
    ];
    http_response_code(500);
}

header('Content-Type: application/json');
echo json_encode($response);
exit;

/**
 * Get statistics from Patreon subscriptions
 */
/**
 * Get statistics from Patreon subscriptions
 */
function local_membership_get_stats($startdate, $enddate) {
    global $DB;
    
    $stats = [
        'activestudents' => 0,
        'newstudents' => 0,
        'pausedstudents' => 0,
        'declinedstudents' => 0,
        'dropoutstudent' => 0,
        'retention' => '0%'
    ];

    try {
        // Convert timestamps to database format
        $startdb = date('Y-m-d', $startdate);
        $enddb = date('Y-m-d', $enddate);

        // Active students (status = 'active_patron')
        $stats['activestudents'] = $DB->count_records_sql("
            SELECT COUNT(DISTINCT id) 
            FROM {membership_patreon_subscriptions} 
            WHERE status = 'active_patron' 
            AND startdate <= ? AND (enddate >= ? OR enddate IS NULL)",
            [$enddb, $startdb]);

        // New students (started in period)
        $stats['newstudents'] = $DB->count_records_sql("
            SELECT COUNT(DISTINCT id) 
            FROM {membership_patreon_subscriptions} 
            WHERE startdate BETWEEN ? AND ?",
            [$startdb, $enddb]);

        // Paused students (status = 'unknown')
        $stats['pausedstudents'] = $DB->count_records_sql("
            SELECT COUNT(DISTINCT id) 
            FROM {membership_patreon_subscriptions} 
            WHERE status = 'unknown' 
            AND startdate <= ? AND (enddate >= ? OR enddate IS NULL)",
            [$enddb, $startdb]);

        // Declined students (status = 'declined_patron')
        $stats['declinedstudents'] = $DB->count_records_sql("
            SELECT COUNT(DISTINCT id) 
            FROM {membership_patreon_subscriptions} 
            WHERE status = 'declined_patron' 
            AND startdate <= ? AND (enddate >= ? OR enddate IS NULL)",
            [$enddb, $startdb]);

        // Dropout students (ended in period with status = 'former_patron')
        $stats['dropoutstudent'] = $DB->count_records_sql("
            SELECT COUNT(DISTINCT id) 
            FROM {membership_patreon_subscriptions} 
            WHERE status = 'former_patron' 
            AND enddate BETWEEN ? AND ?",
            [$startdb, $enddb]);

        // Retention rate (active vs new)
        $stats['retention'] = $stats['newstudents'] > 0 
            ? round(($stats['activestudents'] / $stats['newstudents']) * 100) . '%' 
            : '0%';

    } catch (Exception $e) {
        debugging('Error in local_membership_get_stats: ' . $e->getMessage(), DEBUG_DEVELOPER);
        throw $e;
    }

    return $stats;
}

/**
 * Calculate trend between current and previous values
 */
function calculate_trend($current, $previous) {
    if ($previous == 0) {
        return 'neutral';
    }
    
    $change = (($current - $previous) / $previous) * 100;
    
    if ($change > 5) {
        return 'positive';
    } elseif ($change < -5) {
        return 'negative';
    } else {
        return 'neutral';
    }
}

/**
 * Format the period for display
 */
function format_period($days,$startdate,$enddate) {
    $startdb = date('Y-m-d', $startdate);
    $enddb = date('Y-m-d', $enddate);
    //echo "days".$days;
    if ($days == 1) {
        return 'today';
    } elseif ($days == 2) {
        return 'yesterday';
    } elseif ($days ==3) {
        return 'day before yesterday';
    } elseif ($days ==4) {
        return 'the previous months';
    } elseif ($days ==5) {
        return 'the previous 3 months';
    } elseif ($days ==6) {
        return 'the previous 6 months';
    } else {
        return 'between '.$startdb.' and '.$enddb;
    }
}