<?php

/**
 * @package    local_attendance
 * @copyright  2024 Deiker, Venezuela <deiker21004@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function local_attendance_before_footer() {
    // Placeholder function
}

/**
 * Get Google Meet participants with caching
 * 
 * @param string $authToken Google API auth token
 * @param string $code Meeting code
 * @param string $startISO Start time in ISO format
 * @param string $endISO End time in ISO format
 * @return array Processed meeting data
 */
function getGoogleMeetParticipants($authToken, $code, $startISO, $endISO) {
    logToFile("Request for meeting $code between $startISO and $endISO");
    global $DB;
    
    // 1. First check if we have this data in our table
    $cachedData = getCachedMeetData($code, $startISO, $endISO);
    
    if ($cachedData !== false && !empty($cachedData['items'])) {
        logToFile("Returning cached data for meeting $code");
        return $cachedData;
    }
    
    // 2. If not in cache, fetch from API
    // logToFile("No cache found, fetching from API for meeting $code");
    // $apiData = getGoogleMeetParticipantsNow($authToken, $code, $startISO, $endISO);
    
    // if ($apiData === null || !isset($apiData['items']) || empty($apiData['items'])) {
    //     logToFile("No data received from API for meeting $code");
    //     return ['items' => []];
    // }
    
    // // 3. Process and save the API data
    //$processedData = processAndSaveMeetData($apiData);
    
    return ['items' => []];
}

/**
 * Get cached meeting data from database
 * 
 * @param string $code Meeting code
 * @param string $startISO Start time in ISO format
 * @param string $endISO End time in ISO format
 * @return array|bool Array of meeting data or false if not found
 */
function getCachedMeetData($code, $startISO, $endISO) {
    global $DB;
    
    $startTime = strtotime($startISO);
    $endTime = strtotime($endISO);
    
    $startDate = date('Y-m-d H:i:s', $startTime);
    $endDate = date('Y-m-d H:i:s', $endTime);
    
    $sql = "SELECT * FROM {google_meet_activities} 
            WHERE meeting_code = :code 
            AND activity_time >= :start 
            AND activity_time <= :end
            ORDER BY activity_time DESC";
    
    $params = [
        'code' => $code,
        'start' => $startDate,
        'end' => $endDate
    ];
    
    try {
        $records = $DB->get_records_sql($sql, $params);
        
        if (empty($records)) {
            logToFile("No cached data found for meeting $code between $startDate and $endDate");
            return false;
        }
        
        $result = ['items' => []];
        foreach ($records as $record) {
            $result['items'][] = convertDbRecordToApiFormat($record);
        }
        
        logToFile("Found " . count($result['items']) . " cached records for meeting $code");
        return $result;
    } catch (Exception $e) {
        logToFile("Error fetching cached data: " . $e->getMessage());
        return false;
    }
}

/**
 * Process API data and save to database
 * 
 * @param array $apiData Raw API response data
 * @return array Processed meeting data
 */
function processAndSaveMeetData($apiData) {
    global $DB;
    
    $processedItems = [];
    $transaction = $DB->start_delegated_transaction();
    
    try {
        foreach ($apiData['items'] as $item) {
            $record = new stdClass();
            
            // Map API fields to database columns
            $record->activity_id = $item['id']['time'] . '|' . $item['id']['uniqueQualifier'];
            $record->activity_time = date('Y-m-d H:i:s', strtotime($item['id']['time']));
            $record->unique_qualifier = $item['id']['uniqueQualifier'];
            $record->application_name = $item['id']['applicationName'];
            $record->customer_id = $item['id']['customerId'];
            $record->etag = $item['etag'];
            
            // Handle actor information
            $record->actor_type = strtolower($item['actor']['callerType']);
            if ($record->actor_type == 'user') {
                $record->actor_email = $item['actor']['email'] ?? null;
                $record->actor_profile_id = $item['actor']['profileId'] ?? null;
            } else {
                $record->actor_key = $item['actor']['key'] ?? null;
            }
            
            // Process event data
            $event = $item['events'][0];
            $record->event_type = $event['type'];
            $record->event_name = $event['name'];
            
            // Extract parameters
            $params = [];
            foreach ($event['parameters'] as $param) {
                $key = $param['name'];
                $params[$key] = $param['value'] ?? ($param['boolValue'] ?? ($param['intValue'] ?? null));
            }
            
            // Map parameters to database fields
            $record->meeting_code = $params['meeting_code'] ?? '';
            $record->conference_id = $params['conference_id'] ?? '';
            $record->organizer_email = $params['organizer_email'] ?? '';
            $record->calendar_event_id = $params['calendar_event_id'] ?? '';
            $record->is_external = $params['is_external'] ?? 0;
            $record->endpoint_id = $params['endpoint_id'] ?? '';
            $record->device_type = $params['device_type'] ?? '';
            $record->product_type = $params['product_type'] ?? '';
            $record->display_name = $params['display_name'] ?? '';
            $record->location_country = $params['location_country'] ?? null;
            $record->location_region = $params['location_region'] ?? null;
            $record->identifier = $params['identifier'] ?? null;
            $record->identifier_type = $params['identifier_type'] ?? null;
            $record->start_timestamp = $params['start_timestamp_seconds'] ?? 0;
            $record->duration_seconds = $params['duration_seconds'] ?? 0;
            $record->ip_address = $params['ip_address'] ?? null;
            
            // Network metrics
            $record->network_rtt_msec_mean = $params['network_rtt_msec_mean'] ?? null;
            $record->network_recv_jitter_msec_mean = $params['network_recv_jitter_msec_mean'] ?? null;
            $record->network_recv_jitter_msec_max = $params['network_recv_jitter_msec_max'] ?? null;
            $record->network_send_jitter_msec_mean = $params['network_send_jitter_msec_mean'] ?? null;
            $record->network_estimated_upload_kbps_mean = $params['network_estimated_upload_kbps_mean'] ?? null;
            $record->network_estimated_download_kbps_mean = $params['network_estimated_download_kbps_mean'] ?? null;
            
            // Audio/video metrics
            $record->audio_recv_seconds = $params['audio_recv_seconds'] ?? null;
            $record->audio_send_seconds = $params['audio_send_seconds'] ?? null;
            $record->video_recv_seconds = $params['video_recv_seconds'] ?? null;
            $record->video_send_seconds = $params['video_send_seconds'] ?? null;
            
            $record->timecreated = time();
            $record->timemodified = time();
            
            // Check if record exists
            if ($existing = $DB->get_record('google_meet_activities', ['activity_id' => $record->activity_id])) {
                $record->id = $existing->id;
                $DB->update_record('google_meet_activities', $record);
                logToFile("Updated existing record: " . $record->activity_id);
            } else {
                $DB->insert_record('google_meet_activities', $record);
                logToFile("Inserted new record: " . $record->activity_id);
            }
            
            $processedItems[] = $item;
        }
        
        $transaction->allow_commit();
        logToFile("Successfully processed and saved " . count($processedItems) . " records");
        return ['items' => $processedItems];
        
    } catch (Exception $e) {
        $transaction->rollback($e);
        logToFile("Error saving meet data: " . $e->getMessage());
        return ['items' => []];
    }
}

function getGoogleMeetParticipantsNow($authToken,  $startISO, $endISO) {
    
    // logToFile('User logged in');
    $url = "https://admin.googleapis.com/admin/reports/v1/activity/users/all/applications/meet?eventName=call_ended&startTime=".$startISO."&endTime=".$endISO;

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $authToken",
            "Content-Type: application/json",
        ],
    ]);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        echo "Error: " . curl_error($curl);
        return null;
    }
    logToFile($response);
    curl_close($curl);
    return json_decode($response, true);
    //getGoogleMeetDetailsWithCache($authToken, $code, $startISO, $endISO);
}

/**
 * Convert database record to API-like format
 * 
 * @param object $record Database record
 * @return array API format data
 */
function convertDbRecordToApiFormat($record) {
    $parameters = [
        ['name' => 'meeting_code', 'value' => $record->meeting_code],
        ['name' => 'conference_id', 'value' => $record->conference_id],
        ['name' => 'organizer_email', 'value' => $record->organizer_email],
        ['name' => 'calendar_event_id', 'value' => $record->calendar_event_id],
        ['name' => 'is_external', 'boolValue' => (bool)$record->is_external],
        ['name' => 'endpoint_id', 'value' => $record->endpoint_id],
        ['name' => 'device_type', 'value' => $record->device_type],
        ['name' => 'product_type', 'value' => $record->product_type],
        ['name' => 'display_name', 'value' => $record->display_name],
        ['name' => 'location_country', 'value' => $record->location_country],
        ['name' => 'location_region', 'value' => $record->location_region],
        ['name' => 'identifier', 'value' => $record->identifier],
        ['name' => 'identifier_type', 'value' => $record->identifier_type],
        ['name' => 'start_timestamp_seconds', 'intValue' => $record->start_timestamp],
        ['name' => 'duration_seconds', 'intValue' => $record->duration_seconds],
        ['name' => 'ip_address', 'value' => $record->ip_address],
        ['name' => 'network_rtt_msec_mean', 'intValue' => $record->network_rtt_msec_mean],
        ['name' => 'network_recv_jitter_msec_mean', 'intValue' => $record->network_recv_jitter_msec_mean],
        ['name' => 'audio_recv_seconds', 'intValue' => $record->audio_recv_seconds],
        ['name' => 'audio_send_seconds', 'intValue' => $record->audio_send_seconds],
        ['name' => 'video_recv_seconds', 'intValue' => $record->video_recv_seconds],
        ['name' => 'video_send_seconds', 'intValue' => $record->video_send_seconds],
    ];
    
    return [
        'id' => [
            'time' => date('c', strtotime($record->activity_time)),
            'uniqueQualifier' => $record->unique_qualifier,
            'applicationName' => $record->application_name,
            'customerId' => $record->customer_id
        ],
        'etag' => $record->etag,
        'actor' => array_filter([
            'callerType' => ucfirst($record->actor_type),
            'email' => $record->actor_type == 'user' ? $record->actor_email : null,
            'key' => $record->actor_type != 'user' ? $record->actor_key : null,
            'profileId' => $record->actor_type == 'user' ? $record->actor_profile_id : null
        ]),
        'events' => [
            [
                'type' => $record->event_type,
                'name' => $record->event_name,
                'parameters' => array_filter($parameters, function($param) {
                    return isset($param['value']) ? $param['value'] !== null : 
                           (isset($param['boolValue']) ? true : $param['intValue'] !== null);
                })
            ]
        ]
    ];
}

/**
 * Fetch Google Meet participants directly from API
 * 
 * @param string $authToken Google API auth token
 * @param string $code Meeting code
 * @param string $startISO Start time in ISO format
 * @param string $endISO End time in ISO format
 * @return array|null API response data or null on error
 */
// function getGoogleMeetParticipantsNow($authToken, $code, $startISO, $endISO) {
    
//     // logToFile('User logged in');
//     $url = "https://admin.googleapis.com/admin/reports/v1/activity/users/all/applications/meet?eventName=call_ended&filters=meeting_code==".$code."&startTime=".$startISO."&endTime=".$endISO;

//     $curl = curl_init();

//     curl_setopt_array($curl, [
//         CURLOPT_URL => $url,
//         CURLOPT_SSL_VERIFYPEER => false,
//         CURLOPT_SSL_VERIFYHOST => 0,
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_HTTPHEADER => [
//             "Authorization: Bearer $authToken",
//             "Content-Type: application/json",
//         ],
//     ]);

//     $response = curl_exec($curl);

//     if (curl_errno($curl)) {
//         echo "Error: " . curl_error($curl);
//         return null;
//     }
//     logToFile($response);
//     curl_close($curl);
//     return json_decode($response, true);
//     //getGoogleMeetDetailsWithCache($authToken, $code, $startISO, $endISO);
// }

/**
 * Log messages to a file
 * 
 * @param mixed $message Message to log
 * @param string $logFile Log file name
 * @param bool $includeTimestamp Whether to include timestamp
 * @return bool True on success, false on failure
 */
function logToFile($message, $logFile = 'logs.txt', $includeTimestamp = true) {
    $timestamp = $includeTimestamp ? '[' . date('Y-m-d H:i:s') . '] ' : '';
    
    if (is_array($message) || is_object($message)) {
        $message = print_r($message, true);
    }
    
    $logEntry = $timestamp . $message . PHP_EOL;
    
    try {
        $file = fopen($logFile, 'a');
        if ($file === false) {
            return false;
        }
        fwrite($file, $logEntry);
        fclose($file);
        return true;
    } catch (Exception $e) {
        error_log('Error writing to log file: ' . $e->getMessage());
        return false;
    }
}