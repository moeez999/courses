<?php
namespace local_attendance\task;

defined('MOODLE_INTERNAL') || die();
//require_once(__DIR__.'/../meet/client.php'); 
class sync_meet_attendance extends \core\task\scheduled_task {
    
    public function get_name() {
        return get_string('syncmeetattendance', 'local_attendance');
    }

    public function execute() {
        global $CFG;

        // Define the return URL (where the user will be redirected after authentication)
        $returnurl = new \moodle_url('/mod/googlemeet/callback.php');
        $returnurl->param('callback', 'yes');
        $returnurl->param('sesskey', sesskey());
        
        // Define the scopes
        define('SCOPES', 'https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/admin.reports.audit.readonly https://www.googleapis.com/auth/admin.reports.usage.readonly');
        
        // Get the issuer object from the service
        $issuer = \core\oauth2\api::get_issuer(get_config('googlemeet', 'issuerid'));

        // Get the OAuth client
        $client = \core\oauth2\api::get_user_oauth_client(
            $issuer,
            $returnurl,
            SCOPES,
            true
        );

        if ($client->is_logged_in()) {
            $authToken = $client->get_accesstoken()->token;
            
            try {
                // Calculate time range (2 hours ago to 1 hour ago)
                // $endTime = new \DateTime('1 hour ago');
                // $startTime = clone $endTime;
                // $startTime->sub(new \DateInterval('PT1H')); // Subtract 1 hour
                
                // // Format as ISO 8601
                // $startISO = $startTime->format('Y-m-d\TH:i:s\Z');
                // $endISO = $endTime->format('Y-m-d\TH:i:s\Z');

                $endTime = new \DateTime(); // Current time
                $startTime = clone $endTime;
                $startTime->sub(new \DateInterval('P1M')); // Subtract 1 month

                // Format as ISO 8601
                $startISO = $startTime->format('Y-m-d\TH:i:s\Z');
                $endISO = $endTime->format('Y-m-d\TH:i:s\Z');
                
                mtrace("Fetching data between $startISO and $endISO");
                
                // Get data from Google API
                $apiData = $this->getGoogleMeetParticipants($authToken, $startISO, $endISO);
                
                if (!empty($apiData['items'])) {
                    // Process and save data
                    $result = $this->processAndSaveMeetData($apiData);
                    
                    // Update last sync time
                    set_config('last_sync_time', time(), 'local_attendance');
                    
                    mtrace("Processed " . count($result['items']) . " Meet activities");
                } else {
                    mtrace("No new Meet activities found");
                }
            } catch (\Exception $e) {
                mtrace('Error: '.$e->getMessage());
                throw $e;
            }
        }
    }

    protected function getGoogleMeetParticipants($authToken, $startISO, $endISO) {
        $url = "https://admin.googleapis.com/admin/reports/v1/activity/users/all/applications/meet";
        $url .= "?eventName=call_ended";
        $url .= "&startTime=" . urlencode($startISO);
        $url .= "&endTime=" . urlencode($endISO);
        
        $curl = new \curl();
        $curl->setHeader([
            "Authorization: Bearer $authToken",
            "Content-Type: application/json"
        ]);
        
        $response = $curl->get($url);
        
        if ($curl->get_errno()) {
            throw new \Exception("CURL Error: " . $curl->error);
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("JSON decode error: " . json_last_error_msg());
        }
        
        return $data;
    }
    
    public function processAndSaveMeetData($apiData) {
        global $DB;
        
        $processedItems = [];
        $transaction = $DB->start_delegated_transaction();
        
        try {
        foreach ($apiData['items'] as $item) {
            $record = new \stdClass();
            
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
                //logToFile("Updated existing record: " . $record->activity_id);
            } else {
                $DB->insert_record('google_meet_activities', $record);
                //logToFile("Inserted new record: " . $record->activity_id);
            }
            
            $processedItems[] = $item;
        }
        
        $transaction->allow_commit();
        //logToFile("Successfully processed and saved " . count($processedItems) . " records");
        return ['items' => $processedItems];
        
    } catch (Exception $e) {
        $transaction->rollback($e);
        //logToFile("Error saving meet data: " . $e->getMessage());
        return ['items' => []];
    }
    }
    
    protected function mapParametersToRecord($params, &$record) {
        // Meeting information
        $record->meeting_code = $params['meeting_code'] ?? '';
        $record->conference_id = $params['conference_id'] ?? '';
        $record->organizer_email = $params['organizer_email'] ?? '';
        $record->calendar_event_id = $params['calendar_event_id'] ?? '';
        
        // Participant details
        $record->is_external = $params['is_external'] ?? 0;
        $record->display_name = $params['display_name'] ?? '';
        $record->identifier = $params['identifier'] ?? null;
        $record->identifier_type = $params['identifier_type'] ?? null;
        
        // Technical details
        $record->device_type = $params['device_type'] ?? '';
        $record->product_type = $params['product_type'] ?? '';
        $record->ip_address = $params['ip_address'] ?? null;
        $record->location_country = $params['location_country'] ?? null;
        $record->location_region = $params['location_region'] ?? null;
        
        // Timing metrics
        $record->start_timestamp = $params['start_timestamp_seconds'] ?? 0;
        $record->duration_seconds = $params['duration_seconds'] ?? 0;
        
        // Network metrics
        $record->network_rtt_msec_mean = $params['network_rtt_msec_mean'] ?? null;
        $record->network_recv_jitter_msec_mean = $params['network_recv_jitter_msec_mean'] ?? null;
        $record->network_send_jitter_msec_mean = $params['network_send_jitter_msec_mean'] ?? null;
        
        // Media metrics
        $record->audio_recv_seconds = $params['audio_recv_seconds'] ?? null;
        $record->audio_send_seconds = $params['audio_send_seconds'] ?? null;
        $record->video_recv_seconds = $params['video_recv_seconds'] ?? null;
        $record->video_send_seconds = $params['video_send_seconds'] ?? null;
    }
}