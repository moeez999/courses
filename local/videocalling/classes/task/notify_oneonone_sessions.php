<?php
namespace local_videocalling\task;

defined('MOODLE_INTERNAL') || die();

use core\task\scheduled_task;
use moodle_url;

require_once($CFG->libdir.'/accesslib.php');

class notify_oneonone_sessions extends scheduled_task {
    private const WINDOW_SECONDS = 300; // 5 minutes

    public function get_name() {
        return 'Notify 1:1 Google Meet sessions (5 minutes before, once per user per event)';
    }

    public function execute() {
        global $DB;

        $now      = time();
        $winFrom  = $now;
        $winTo    = $now + self::WINDOW_SECONDS;

        // Google Meet module id
        $gmModId = (int)$DB->get_field('modules', 'id', ['name' => 'googlemeet'], IGNORE_MISSING);
        if (!$gmModId) { mtrace('⚠️ googlemeet module not installed.'); return; }

        // All googlemeet CMs in course 24 that have availability rules (we need the student email rule)
        $cms = $DB->get_records_sql("
            SELECT cm.id, cm.instance, cm.availability, cs.name AS sectionname
              FROM {course_modules} cm
              JOIN {course_sections} cs ON cs.id = cm.section
             WHERE cs.course = :course
               AND cm.module = :mod
               AND cm.deletioninprogress = 0
               AND cm.availability IS NOT NULL
        ", ['course' => 24, 'mod' => $gmModId]);

        if (!$cms) { mtrace('ℹ️ No 1:1 googlemeet activities found.'); return; }

        foreach ($cms as $cm) {
            // Student (from availability: profile rule on email)
            $student = $this->availability_extract_user($cm->availability);
            if (!$student) { continue; }

            // Meet info
            // inside execute(), when you fetch the meet:
             $gm = $DB->get_record('googlemeet', ['id' => (int)$cm->instance], 'id,name,url', MUST_EXIST);
            if (!$gm) { continue; }

            // this is the ONLY join link we’ll use for the email button
            $joinurl = trim((string)$gm->url);

            // Teacher (from meet name patterns you’re using)
            $teacher = $this->extract_teacher_from_name($gm->name);

            // Events starting in the next 5 minutes (no “ongoing” logic here—strictly before start)
            $events = $DB->get_records_select(
                'event',
                "modulename = :mod AND instance = :inst AND visible = 1 AND timestart >= :from AND timestart <= :to",
                ['mod' => 'googlemeet', 'inst' => (int)$cm->instance, 'from' => $winFrom, 'to' => $winTo],
                'timestart ASC',
                'id,name,timestart'
            );
            if (!$events) { continue; }

            foreach ($events as $ev) {
                // Recipients: the specific student + the specific teacher (when resolvable)
                $recipients = [$student->id];
                if (!empty($teacher) && !empty($teacher->id)) {
                    $recipients[] = (int)$teacher->id;
                }
                $recipients = array_values(array_unique(array_map('intval', $recipients)));

                foreach ($recipients as $uid) {
                    // Idempotency: once per user per event
                    if ($DB->record_exists('local_oneonone_notices', ['eventid' => (int)$ev->id, 'userid' => $uid])) {
                        mtrace("↩️ Skip duplicate: event {$ev->id}, user {$uid}.");
                        continue;
                    }

                    if ($this->notify_user($uid, (int)$ev->timestart, $joinurl)) {
                        try {
                            $DB->insert_record('local_oneonone_notices', (object)[
                                'eventid' => (int)$ev->id,
                                'userid'  => $uid,
                                'sentat'  => time(),
                            ]);
                        } catch (\dml_write_exception $e) {
                            mtrace("ℹ️ Marker race: event {$ev->id}, user {$uid} already marked.");
                        }
                    }
                }
            }
        }
    }

    /**
     * Traverse availability JSON to find a profile rule on sf=email and return the user by that email.
     */
    private function availability_extract_user(?string $availabilityjson): ?\stdClass {
        global $DB;
        if (empty($availabilityjson)) return null;

        $tree = json_decode($availabilityjson, true);
        if (!is_array($tree)) return null;

        $stack = [$tree];
        while ($node = array_pop($stack)) {
            if (is_array($node) && !empty($node['type']) && $node['type'] === 'profile') {
                $isEmailField = isset($node['sf']) && $node['sf'] === 'email';
                if ($isEmailField) {
                    $val = isset($node['v']) ? trim(mb_strtolower($node['v'])) : '';
                    if ($val !== '') {
                        $u = $DB->get_record_sql("
                            SELECT id, firstname, lastname, email, username
                              FROM {user}
                             WHERE deleted = 0 AND suspended = 0 AND LOWER(email) = ?
                        ", [$val]);
                        if ($u) return $u;
                    }
                }
            }
            if (!empty($node['c']) && is_array($node['c'])) {
                foreach ($node['c'] as $child) if (is_array($child)) $stack[] = $child;
            }
        }
        return null;
    }

    /**
     * Try to resolve the teacher from meet name.
     * Examples expected from your codebase:
     *   "1:1 Sandra Ayala with Teacher Jessica Smith"
     *   "... Teacher Jessica Smith"
     */
    private function extract_teacher_from_name(string $name): ?\stdClass {
        global $DB;

        $candidate = '';
        // Preferred: "... with Teacher <Name>"
        if (preg_match('/\bwith\s+Teacher\s+(.+)\s*$/ui', $name, $m)) {
            $candidate = trim($m[1]);
        }
        // Fallback: "Teacher <Name>" at end
        elseif (preg_match('/\bTeacher\b[[:space:]:\-–—]*(.+)\s*$/ui', $name, $m)) {
            $candidate = trim($m[1]);
        }

        if ($candidate === '') return null;

        // Normalize inner whitespace
        $candidate = preg_replace('/\s+/', ' ', $candidate);

        // Try full-name first (firstname + lastname match, order-insensitive)
        if (strpos($candidate, ' ') !== false) {
            [$p1, $p2] = array_map('mb_strtolower', explode(' ', $candidate, 2));
            $u = $DB->get_record_sql("
                SELECT id, firstname, lastname, email, username
                  FROM {user}
                 WHERE deleted = 0 AND suspended = 0
                   AND (
                        (LOWER(firstname) = ? AND LOWER(lastname) = ?) OR
                        (LOWER(firstname) = ? AND LOWER(lastname) = ?)
                   )
              ORDER BY lastaccess DESC, id DESC
                 LIMIT 1
            ", [$p1,$p2,$p2,$p1]);
            if ($u) return $u;
        }

        // Single token or ambiguous → unique match on firstname OR lastname
        $tok = mb_strtolower($candidate);
        $matches = $DB->get_records_sql("
            SELECT id, firstname, lastname, email, username
              FROM {user}
             WHERE deleted = 0 AND suspended = 0
               AND (LOWER(firstname) = ? OR LOWER(lastname) = ?)
          ORDER BY lastaccess DESC, id DESC
        ", [$tok, $tok], 0, 2);

        if (count($matches) === 1) {
            return reset($matches);
        }

        return null;
    }

    /**
     * Send email to user for a specific event time and meet view URL.
     */
    private function notify_user(int $userid, int $timestart, string $joinurl): bool {
    global $DB;

    $user = $DB->get_record('user', ['id' => $userid, 'deleted' => 0, 'suspended' => 0], '*', IGNORE_MISSING);
    if (!$user || empty($user->email)) return false;

    $support = \core_user::get_support_user();
    $start12 = date('g:i A', $timestart);

    $subject = "🔔 1:1 session in 5 minutes";

    // plain text
    $text =
        "Hi {$user->firstname} {$user->lastname}\n\n" .
        "Your 1:1 session starts at {$start12} (in ~5 minutes).\n\n" .
        "Join class: {$joinurl}\n\n" .
        "Usuario: {$user->username}\n" .
        "WhatsApp: https://wa.me/17543644125\n" .
        "Tel: +1 (754) 364-4125 (USA)\n\n" .
        "Latingles Academy\n" .
        "Hagamos el Inglés Fácil y Sencillo";

    // html (JOIN CLASS button points to googlemeet.url)
    $html = "
        <p>Hi {$user->firstname} {$user->lastname},</p>
        <p>Your <strong>1:1 session</strong> starts at <strong>{$start12}</strong> (in ~5 minutes).</p>
        <p>
            <a href=\"{$joinurl}\"
               style=\"display:inline-block;padding:10px 18px;font-size:13px;font-weight:700;
                      color:#ffffff;background-color:#28a745;text-decoration:none;border-radius:8px\">
                Join class
            </a>
        </p>
        <p>Usuario: <strong>{$user->username}</strong></p>
        <p>
            <a href=\"https://wa.me/17543644125\" target=\"_blank\" rel=\"noopener\">
                WhatsApp (todos los países)
            </a><br>
            Tel: +1 (754) 364-4125 (USA)
        </p>
        <p><strong>Latingles Academy</strong><br>Hagamos el Inglés Fácil y Sencillo</p>
    ";

    $ok = email_to_user($user, $support, $subject, $text, $html);
    mtrace(($ok ? '✅' : '❌') . " Email to {$user->id} ({$user->email}) for " . date('Y-m-d H:i:s', $timestart));
    return (bool)$ok;
}
}