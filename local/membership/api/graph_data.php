<?php
require_once('../../../config.php');
require_login();

// Enable debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Validate permissions
$context = context_system::instance();

// Get parameters with defaults as timestamps
$start_timestamp = optional_param('startdate', strtotime('first day of this month 00:00:00'), PARAM_INT);
$end_timestamp = optional_param('enddate', strtotime('last day of this month 23:59:59'), PARAM_INT);

// Convert timestamps to YYYY-mm-dd format for database query
$start_date = date('Y-m-d', $start_timestamp);
$end_date = date('Y-m-d', $end_timestamp);

header('Content-Type: application/json');

try {
    // 1. Verify database connection
    if (!$DB->get_records_sql("SELECT 1")) {
        throw new Exception("Database connection test failed");
    }

    // 2. Calculate number of days in range
    $days = floor(($end_timestamp - $start_timestamp) / (60 * 60 * 24));
    
    // 3. Determine appropriate grouping
    $grouping = 'day';
    if ($days > 31) {
        $grouping = 'month';
    } elseif ($days > 7) {
        $grouping = 'week';
    }

    // 4. Initialize empty dataset
    $data = [
        'labels' => [],
        'activestudents' => [],
        'dropoutstudent' => [],
        'pausedstudents' => [],
        'declinedstudents' => [],
        'retention' => []
    ];

    // 5. Generate date labels and initialize buckets
    $current = $start_timestamp;
    $end = $end_timestamp;
    $date_buckets = [];
    
    while ($current <= $end) {
        if ($grouping === 'day') {
            $label = date('M j', $current);
            $bucket_key = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        } elseif ($grouping === 'week') {
            $week_end = strtotime('+6 days', $current);
            $label = date('M j', $current) . ' - ' . date('M j', $week_end);
            $bucket_key = date('Y-\WW', $current);
            $current = strtotime('+1 week', $current);
        } else {
            $label = date('M Y', $current);
            $bucket_key = date('Y-m', $current);
            $current = strtotime('+1 month', $current);
        }
        
        $data['labels'][] = $label;
        $date_buckets[$bucket_key] = [
            'active' => 0,
            'dropout' => 0,
            'paused' => 0,
            'declined' => 0
        ];
    }

    // 6. Get all relevant data - modified to work with Moodle's get_records_sql()
    $sql = "SELECT 
                CONCAT(status, '-', DATE(startdate)) as uniqueid,
                status,
                COUNT(*) as count,
                DATE(startdate) as day
            FROM {membership_patreon_subscriptions}
            WHERE startdate BETWEEN ? AND ?
            GROUP BY status, day
            ORDER BY day";
    
    $records = $DB->get_records_sql($sql, [$start_date, $end_date]);

    // 7. Process records and assign to buckets
    foreach ($records as $record) {
        $record_date = $record->day; // Already in YYYY-mm-dd format
        
        // Determine bucket key based on grouping
        if ($grouping === 'day') {
            $bucket_key = $record_date;
        } elseif ($grouping === 'week') {
            $timestamp = strtotime($record_date);
            $bucket_key = date('Y-\WW', $timestamp);
        } else {
            $bucket_key = substr($record_date, 0, 7); // Get YYYY-mm
        }

        if (isset($date_buckets[$bucket_key])) {
            switch ($record->status) {
                case 'active_patron':
                    $date_buckets[$bucket_key]['active'] += $record->count;
                    break;
                case 'former_patron':
                    $date_buckets[$bucket_key]['dropout'] += $record->count;
                    break;
                case 'unknown':
                    $date_buckets[$bucket_key]['paused'] += $record->count;
                    break;
                case 'declined_patron':
                    $date_buckets[$bucket_key]['declined'] += $record->count;
                    break;
            }
        }
    }

    // 8. Populate the response data
    foreach ($date_buckets as $bucket) {
        $data['activestudents'][] = $bucket['active'];
        $data['dropoutstudent'][] = $bucket['dropout'];
        $data['pausedstudents'][] = $bucket['paused'];
        $data['declinedstudents'][] = $bucket['declined'];
    }

    // 9. Calculate retention rates
    $previous_active = 0;
    foreach ($data['activestudents'] as $i => $current_active) {
        if ($i > 0 && $previous_active > 0) {
            $data['retention'][$i] = round(($current_active / $previous_active) * 100);
        } else {
            $data['retention'][$i] = 0;
        }
        $previous_active = $current_active;
    }

    // 10. Return successful response
    echo json_encode([
        'success' => true,
        'data' => $data,
        'stats' => [
            'total_active' => array_sum($data['activestudents']),
            'total_dropout' => array_sum($data['dropoutstudent']),
            'total_paused' => array_sum($data['pausedstudents']),
            'total_declined' => array_sum($data['declinedstudents']),
            'retention_rate' => end($data['retention']) ?: 0
        ]//,
        // 'debug' => [
        //     'input_timestamps' => [
        //         'start' => $start_timestamp,
        //         'end' => $end_timestamp
        //     ],
        //     'converted_dates' => [
        //         'start' => $start_date,
        //         'end' => $end_date
        //     ],
        //     'date_buckets' => $date_buckets,
        //     'records_count' => count($records),
        //     'grouping' => $grouping,
        //     'sql_query' => $sql,
        //     'sql_params' => [$start_date, $end_date]
        // ]
    ]);

} catch (Exception $e) {
    // Detailed error logging
    error_log("Graph Data Error: " . $e->getMessage());
    error_log("Backtrace: " . $e->getTraceAsString());
    
    // Return user-friendly error
    echo json_encode([
        'success' => false,
        'error' => 'Could not load graph data',
        'debug' => $e->getMessage() // Only include in development
    ]);
    http_response_code(500);
}