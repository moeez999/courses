<?php
namespace mod_googlemeet\task;

use context_module;
use mod_googlemeet\client;

defined('MOODLE_INTERNAL') || die();

/**
 * Task to sync Google Meet recordings.
 */
class sync_recordings_task extends \core\task\scheduled_task {

    /**
     * Get the name of the task.
     *
     * @return string
     */
    public function get_name() {
        return get_string('syncrecordingstask', 'googlemeet');
    }

    /**
     * Execute the task.
     */
    public function execute() {
        global $DB, $CFG;

        // Acquire a lock to avoid overlapping executions
        $factory = \core\lock\lock_config::get_lock_factory('cron');
        $lock = $factory->get_lock('mod_googlemeet_sync_recordings', 900); // 15 min lock

        if (!$lock) {
            mtrace("❌ Could not acquire lock. Task already running.");
            return;
        }

        try {
            ini_set('max_execution_time', 0);
            set_time_limit(0);

            require_once($CFG->dirroot . '/mod/googlemeet/lib.php');
            require_once($CFG->dirroot . '/mod/googlemeet/locallib.php');

            $client = new \mod_googlemeet\client();

            if (!$client->check_login()) {
                mtrace('🔐 Google Meet client not logged in. Attempting login...');
                if (!$client->login()) {
                    mtrace('❌ Google Meet client login failed.');
                    return;
                }
                mtrace('✅ Login successful.');
            }

            //$googlemeets = $DB->get_records('googlemeet');
            
            global $DB;

// Define timestamps: last 24 hours
$now = time();
$from = $now - 86400; // 24 hours ago

// Step 1: Get recent Google Meet event data
$sql = "SELECT DISTINCT
               me.id,
               me.eventdate,
               me.duration,
               m.id AS googlemeetid,
               m.name AS googlemeetname,
               m.url,
               cm.id AS cmid,
               c.id AS courseid,
               c.fullname AS coursename
          FROM {googlemeet_events} me
    INNER JOIN {googlemeet} m ON m.id = me.googlemeetid
    INNER JOIN {course_modules} cm ON (cm.instance = m.id AND cm.visible = 1 AND cm.deletioninprogress = 0)
    INNER JOIN {course} c ON (c.id = cm.course AND c.visible = 1)
    INNER JOIN {modules} md ON (md.id = cm.module AND md.name = 'googlemeet')
         WHERE me.eventdate BETWEEN :from AND :to
           AND m.notify = 1";

$params = ['from' => $from, 'to' => $now];
$events = $DB->get_records_sql($sql, $params);

// Step 2: Extract googlemeetids
$googlemeetids = array_map(function($e) {
    return $e->googlemeetid;
}, $events);

// Remove duplicates
$googlemeetids = array_unique($googlemeetids);

// Step 3: Fetch full googlemeet records
$googlemeets = [];
if (!empty($googlemeetids)) {
    list($inSql, $inParams) = $DB->get_in_or_equal($googlemeetids, SQL_PARAMS_NAMED);
    $googlemeets = $DB->get_records_select('googlemeet', "id $inSql", $inParams);
}
            
//           $googlemeets = $DB->get_records_sql("
//     SELECT *
//     FROM {googlemeet}
//     WHERE lastsync IS NULL
//       OR lastsync < UNIX_TIMESTAMP(NOW() - INTERVAL 1 HOUR)
//     ORDER BY lastsync DESC
// ");
           // $googlemeets = $DB->get_records('googlemeet', ['id' => 68]);
            foreach ($googlemeets as $googlemeet) {
                mtrace("🔁 Syncing recordings for Google Meet ID: {$googlemeet->id}");
                $client->syncrecordings_new($googlemeet);
                sleep(1); // 🐢 Throttle if needed
            }

            mtrace("✅ All recordings synced successfully.");
        } catch (\Throwable $e) {
            mtrace("💥 Exception during sync: " . $e->getMessage());
            debugging("Google Meet sync task crashed: " . $e->getMessage(), DEBUG_DEVELOPER);
        } finally {
            $lock->release(); // ✅ Always release lock
            mtrace("🔓 Lock released.");
        }
    }
}