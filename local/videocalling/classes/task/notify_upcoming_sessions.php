<?php
namespace local_videocalling\task;

use DateTime; // ✅ Add this

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/accesslib.php');

class notify_upcoming_sessions extends \core\task\scheduled_task {

    public function get_name() {
        return 'Notify users before upcoming video call sessions';
    }

    public function execute() {
        global $DB;

        $now = time();
        $targetTime = $now + 5 * 60; // next 5 minutes

        $sessions = [];

        $records = $DB->get_records_sql("
            SELECT pc.*, op.*, pc.id as pcid
            FROM {planificationclass} pc
            LEFT JOIN {optionsrepeat} op ON op.idplanificaction = pc.id
        ");

        foreach ($records as $record) {
            $sessionStartTime = null;

            // Recurring Weekly
            if ($record->type === 'week') {
                $weekdayMap = [
                    'sunday' => 0, 'monday' => 1, 'tuesday' => 2,
                    'wednesday' => 3, 'thursday' => 4,
                    'friday' => 5, 'saturday' => 6
                ];

                foreach ($weekdayMap as $day => $num) {
                    if (!empty($record->$day)) {
                        $nextDate = new \DateTime();
                        $currentWeekday = (int)$nextDate->format('w');
                        $daysToAdd = ($num - $currentWeekday + 7) % 7;

                        $potentialDate = new \DateTime();
                        if ($daysToAdd > 0) {
                            $potentialDate->modify("+{$daysToAdd} days");
                        }
                        $potentialDateStr = $potentialDate->format('Y-m-d');
                        $startHour = date('H:i', $record->startdate);
                        $potentialStart = strtotime($potentialDateStr . ' ' . $startHour);

                        if ($potentialStart >= $now && $potentialStart <= $targetTime) {
                            $sessionStartTime = $potentialStart;
                            break;
                        }
                    }
                }
            }

            // Recurring Daily
            elseif ($record->type === 'day') {
                $repeatevery = (int)$record->repeatevery ?: 1;
                $repeatUntil = (int)$record->repeaton ?: PHP_INT_MAX;

                for ($i = 0; $i < 30; $i++) {
                    $candidateDate = strtotime("+$i days", $record->startdate);
                    $startHour = date('H:i', $record->startdate);
                    $candidateStart = strtotime(date('Y-m-d', $candidateDate) . ' ' . $startHour);

                    if ($candidateStart >= $now && $candidateStart <= $targetTime) {
                        if ($candidateStart <= $repeatUntil) {
                            $sessionStartTime = $candidateStart;
                            break;
                        }
                    }

                    if ($candidateStart > $targetTime + 60) break;
                }
            }

            // One-time session
            elseif (empty($record->type) && !empty($record->startdate)) {
                if ($record->startdate >= $now && $record->startdate <= $targetTime) {
                    $sessionStartTime = $record->startdate;
                }
            }

            if ($sessionStartTime !== null) {
                if(empty($record->id))
                {
                   $idd = $record->pcid;
                }else{
                  $idd = $record->idplanificaction; 
                }
               
                $sessions[] = [
                    'planid' => $idd,
                    'starttime' => $sessionStartTime
                ];
            }
        }

        // ✅ If no upcoming sessions
        if (empty($sessions)) {
            mtrace("ℹ️ No upcoming sessions in the next 5 Minutes.");
            error_log("ℹ️ No upcoming sessions in the next 5 Minutes.");
            return;
        }

        // ✅ Process each session
        foreach ($sessions as $session) {
            $planid = (int)$session['planid'];

            // Get cohort users
            $cohortids = $DB->get_fieldset_sql("
                SELECT idcohort
                FROM {assignamentcohortforclass}
                WHERE idplanificaction = :planid
            ", ['planid' => $planid]);

            $cohortuserids = [];
            foreach ($cohortids as $cohortid) {
                $members = $DB->get_records('cohort_members', ['cohortid' => (int)$cohortid], '', 'userid');
                foreach ($members as $m) {
                    $cohortuserids[] = $m->userid;
                }
            }
            
            // Get teacher(s)
            $teacheruserids = $DB->get_fieldset_select(
                'assignamentteachearforclass',
                'iduserteacher',
                'idplanificaction = ?',
                [$planid]
            );

            // Merge all recipients
            $userids = array_unique(array_merge($cohortuserids, $teacheruserids));

            if (empty($userids)) {
                mtrace("⚠️ No users found for session with planid {$planid}");
                error_log("⚠️ No users found for session with planid {$planid}");
                continue;
            }

            // Send email to each user
            foreach ($userids as $uid) {
               

                 // ✅ Idempotency check: already sent?
                $already = $DB->record_exists('local_videocalling_notices', [
                    'planid'    => $planid,
                    'starttime' => $session['starttime'],
                    'userid'    => $uid,
                ]);

                if ($already) {
                    mtrace("↩️ Skip duplicate: plan {$planid}, start {$session['starttime']}, user {$uid}");
                    continue;
                }
                
                
               // $this->notify_user($uid, $session);
               
                // Send
                $ok = $this->notify_user($uid, $session);

                // Mark only on success
               if ($ok) {
    try {
        $DB->insert_record('local_videocalling_notices', (object)[
            'planid'    => (int)$planid,
            'starttime' => (int)$session['starttime'],
            'userid'    => (int)$uid,
            'sentat'    => time(),
        ]);
    } catch (\dml_write_exception $e) {
        // Most likely unique-key race: someone inserted first. Safe to ignore.
        mtrace("ℹ️ Marker already exists (race): plan {$planid}, start {$session['starttime']}, user {$uid}");
    }
}
            }
        }
    }

   protected function notify_user($userid, $session) {
    global $DB;

    $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);
    $support = \core_user::get_support_user();

    // Subject (kept with emoji)
    $subject = "🎉Hora de Practicar tu Speaking con Peers🎉";

    // 12-hour time with AM/PM
    $starttime = date('g:i A', $session['starttime']);

    // Plain-text body (no HTML)
    $text =
        "Hi {$user->firstname} {$user->lastname}\n\n" .
        "You have a Quick Talk with Peers today at {$starttime} EST Time\n\n" .
        "Ingresa a tu cuenta con tu usuario: {$user->username}\n" .
        "Haciendo click en el botón de abajo 😃 Nos vemos pronto!\n\n" .
        "Join the Session: https://courses.latingles.com/local/videocalling\n\n" .
        "Presiona aquí para enviarnos un WhatsApp (todos los países): https://wa.me/17543644125\n" .
        "Llámanos al: +1 (754) 364-4125 (USA)\n\n" .
        "Latingles Academy\n" .
        "Hagamos el Inglés Fácil y Sencillo";

    // HTML body
    $html = "
        <p>Hi {$user->firstname} {$user->lastname}</p>

        <p>You have a Quick Talk with Peers today at <strong>{$starttime} EST Time</strong></p>

        <p>Ingresa a tu cuenta con tu usuario: <strong>{$user->username}</strong></p>
        <p>Haciendo click en el botón de abajo 😃 ¡Nos vemos pronto!</p>

        <p>
            <a href='https://courses.latingles.com/local/videocalling'
               style='display:inline-block;
                      padding:8px 17px;
                      font-size:11px;
                      font-weight:bold;
                      color:#ffffff;
                      background-color:#f8371e;
                      text-decoration:none;
                      border-radius:6px;
                      margin-top:10px;'>
                Join the Session
            </a>
        </p>

        <p>
            <a href='https://wa.me/17543644125' target='_blank' rel='noopener'
               style='color:#0b5ed7; text-decoration:underline;'>
               Presiona aquí para enviarnos un WhatsApp (todos los países)
            </a>
            <br>
            Llámanos al: +1 (754) 364-4125 (USA)
        </p>

        <p style='margin:16px 0 0 0;'><strong>Latingles Academy</strong><br>
        Hagamos el Inglés Fácil y Sencillo</p>
    ";
    

    $status = email_to_user($user, $support, $subject, $text, $html);

    if ($status) {
    mtrace("✅ Email sent to user ID {$user->id} ({$user->email}) at " . date('Y-m-d H:i:s', $session['starttime']));
    error_log("✅ Email sent to user ID {$user->id} ({$user->email})");
} else {
    mtrace("❌ Failed to send email to user ID {$user->id} ({$user->email})");
    error_log("❌ Failed to send email to user ID {$user->id} ({$user->email})");
}

return (bool)$status; // ✅ return so caller can mark as sent
}
}