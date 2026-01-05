<?php
namespace local_customplugin\task;

defined('MOODLE_INTERNAL') || die();

class sync_gm_event_status extends \core\task\scheduled_task {

    public function get_name() {
        // You can add lang string later; for now a hard-coded name is okay.
        // return get_string('task_sync_gm_event_status', 'local_customplugin', null, true)
        //     ?: 'Sync Google Meet event statuses';

             global $DB;

        // 1) Get googlemeet module id.
        $mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
        if (!$mod) {
            mtrace('local_customplugin: googlemeet module not found, skipping.');
            return;
        }

        // 2) Find all googlemeet_events that don't have any status row yet.
        $sql = "
            SELECT
                ge.id            AS eventid,
                ge.googlemeetid  AS googlemeetid,
                gm.course        AS courseid,
                cm.id            AS cmid
            FROM {googlemeet_events} ge
            JOIN {googlemeet} gm
                 ON gm.id = ge.googlemeetid
            JOIN {course_modules} cm
                 ON cm.instance = gm.id
            JOIN {modules} m
                 ON m.id = cm.module
                AND m.id = :modid
            LEFT JOIN {local_gm_event_status} s
                 ON s.eventid = ge.id
            WHERE s.id IS NULL
        ";

        $params = ['modid' => $mod->id];
        $events = $DB->get_records_sql($sql, $params);

        if (!$events) {
            mtrace('local_customplugin: no new googlemeet_events without status.');
            return;
        }

        $now = time();
        $count = 0;

        foreach ($events as $e) {
            $rec = new \stdClass();
            $rec->googlemeetid = (int)$e->googlemeetid;
            $rec->eventid      = (int)$e->eventid;
            $rec->courseid     = (int)$e->courseid;
            $rec->cmid         = (int)$e->cmid;
            $rec->statuscode   = 'scheduled';   // default initial status
            $rec->isactive     = 1;
            $rec->detailsjson  = null;
            $rec->timecreated  = $now;
            $rec->timemodified = $now;
            $rec->createdby    = 0;

            $DB->insert_record('local_gm_event_status', $rec);
            $count++;
        }

        mtrace("local_customplugin: inserted {$count} default event statuses.");
    }

    public function execute() {
        global $DB;

        // 1) Get googlemeet module id.
        $mod = $DB->get_record('modules', ['name' => 'googlemeet'], 'id', IGNORE_MISSING);
        if (!$mod) {
            mtrace('local_customplugin: googlemeet module not found, skipping.');
            return;
        }

        // 2) Find all googlemeet_events that don't have any status row yet.
        $sql = "
            SELECT
                ge.id            AS eventid,
                ge.googlemeetid  AS googlemeetid,
                gm.course        AS courseid,
                cm.id            AS cmid
            FROM {googlemeet_events} ge
            JOIN {googlemeet} gm
                 ON gm.id = ge.googlemeetid
            JOIN {course_modules} cm
                 ON cm.instance = gm.id
            JOIN {modules} m
                 ON m.id = cm.module
                AND m.id = :modid
            LEFT JOIN {local_gm_event_status} s
                 ON s.eventid = ge.id
            WHERE s.id IS NULL
        ";

        $params = ['modid' => $mod->id];
        $events = $DB->get_records_sql($sql, $params);

        if (!$events) {
            mtrace('local_customplugin: no new googlemeet_events without status.');
            return;
        }

        $now = time();
        $count = 0;

        foreach ($events as $e) {
            $rec = new \stdClass();
            $rec->googlemeetid = (int)$e->googlemeetid;
            $rec->eventid      = (int)$e->eventid;
            $rec->courseid     = (int)$e->courseid;
            $rec->cmid         = (int)$e->cmid;
            $rec->statuscode   = 'scheduled';   // default initial status
            $rec->isactive     = 1;
            $rec->detailsjson  = null;
            $rec->timecreated  = $now;
            $rec->timemodified = $now;
            $rec->createdby    = 0;

            $DB->insert_record('local_gm_event_status', $rec);
            $count++;
        }

        mtrace("local_customplugin: inserted {$count} default event statuses.");
    }
}