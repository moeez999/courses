<?php
namespace mod_googlemeet\task;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/googlemeet/locallib.php');

class notify_event extends \core\task\scheduled_task {

    public function get_name() {
        return get_string('notifytask', 'mod_googlemeet');
    }

    public function execute() {
        global $DB;

        // 🔒 Get lock
        $factory = \core\lock\lock_config::get_lock_factory('cron');
        $lock = $factory->get_lock('mod_googlemeet_notify_event', 900); // 15 minutes

        if (!$lock) {
            mtrace("❌ Could not acquire lock for notify_event task.");
            return;
        }

        try {
            ini_set('max_execution_time', 0);
            set_time_limit(0);

            $events = googlemeet_get_future_events();

            if ($events) {
                foreach ($events as $event) {
                    mtrace("🔔 Processing event ID: {$event->id}");

                    // Fetch module ID for 'googlemeet'
                    $moduleid = $DB->get_field_sql("SELECT id FROM {modules} WHERE name = :modulename", ['modulename' => 'googlemeet']);

                    // Get section and availability
                    $sectionid = $DB->get_field('course_modules', 'section', ['id' => $event->cmid]);
                    $availability = $DB->get_field('course_sections', 'availability', ['id' => $sectionid]);

                    // Extract cohort IDs
                    $cohortIds = [];
                    if ($availability) {
                        $availabilityData = json_decode($availability, true);
                        if (isset($availabilityData['c']) && is_array($availabilityData['c'])) {
                            foreach ($availabilityData['c'] as $condition) {
                                if (isset($condition['type'], $condition['id']) && $condition['type'] === 'cohort') {
                                    $cohortIds[] = $condition['id'];
                                }
                            }
                        }
                    }

                    // Collect users from all cohorts
                    $allUsers = [];
                    foreach ($cohortIds as $cohortId) {
                        $users = googlemeet_get_users_by_cohort($cohortId);
                        $allUsers = array_merge($allUsers, $users);
                    }
                    $skipthreshold = time() - 600; // 600 seconds = 10 minutes

                    foreach ($allUsers as $user) {
                        
                         // Check if a notification was sent in the last 10 minutes
                            $alreadySent = $DB->record_exists_select('googlemeet_notify_done',
                                'userid = :userid AND eventid = :eventid AND timesent >= :recent',
                                [
                                    'userid' => $user->id,
                                    'eventid' => $event->id,
                                    'recent' => $skipthreshold
                                ]
                            );
                        
                            if ($alreadySent) {
                                mtrace("⏭ Notification already sent to user {$user->id} for event {$event->id} in the last 10 minutes. Skipping.");
                                continue;
                            }
    
    
                        mtrace("📧 Sending notification to: {$user->id}");
                        googlemeet_send_notification($user, $event);
                        googlemeet_notify_done($user->id, $event->id);
                    }
                }
            }

            googlemeet_remove_notify_done_from_old_events();
            mtrace("✅ Notifications completed.");
        } catch (\Throwable $e) {
            mtrace("💥 Error in notify_event task: " . $e->getMessage());
            debugging("notify_event task error: " . $e->getMessage(), DEBUG_DEVELOPER);
        } finally {
            $lock->release();
            mtrace("🔓 Lock released for notify_event task.");
        }
    }
}