<?php

/**
 * Local plugin "videocalling" - Lib file
 *
 * @package    local_videocalling
 * @copyright  2024 Deiker, Venezuela <deiker21004@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG, $DB, $PAGE, $USER, $OUTPUT;

require_once('../../config.php');
require_once($CFG->dirroot . '/local/videocalling/lib.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Panel de control');
$PAGE->set_url($CFG->wwwroot . '/local/videocalling/dashboard.php');
$PAGE->requires->css(new moodle_url('/local/videocalling/css/dashboard.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('/local/videocalling/css/modal.css?v=' . time()), true);
$PAGE->requires->css(new moodle_url('/local/videocalling/css/calendar.css?v=' . time()), true);
$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$PAGE->requires->js(new moodle_url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11'), true);
$PAGE->requires->css(new moodle_url(url: 'https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swapc'), true);
$apiUrl = new moodle_url('/local/videocalling/api/');
$selectPage = new moodle_url('/local/videocalling/selected.php');
$cohorts = $DB->get_records('cohort', null, 'name ASC');
$PAGE->requires->js(new moodle_url('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js'), true);
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/moment-timezone@0.5.43/builds/moment-timezone-with-data.min.js'), true);
$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$cohorts = $DB->get_records('cohort', null, 'name ASC');
$sql = "
    SELECT u.id, u.username, u.firstname, u.lastname, u.email
    FROM {user} u
    JOIN {cohort_members} cm ON u.id = cm.userid
    WHERE cm.cohortid = :cohortid AND u.deleted = 0
    ORDER BY u.lastname ASC, u.firstname ASC
";

$params = ['cohortid' => 93]; //change id teacher cohort

$users = $DB->get_records_sql($sql, $params);
$sql = "
    SELECT *
    FROM {cohort} c
    WHERE c.enabled = 1
";

// $params = ['cohortid' => 93]; //change id teacher cohort

$cohortsList = $DB->get_records_sql($sql);
require_login();

$full_name = $USER->firstname . ' ' . $USER->lastname;

function is_user_siteadmin($userid) {
    global $DB;
    $sql = "SELECT ra.id 
            FROM {role_assignments} ra 
            JOIN {role} r ON ra.roleid = r.id 
            WHERE ra.userid = :userid AND r.shortname = 'admin'";
    $params = array('userid' => $userid);
    $result = $DB->get_records_sql($sql, $params);
    return !empty($result);
}
$sql = "SELECT 
        p.id,p.startdate,p.finishdate,p.recurrent,p.color,
        o.idplanificaction,o.monday,o.tuesday, o.wednesday,o.sunday, 
        o.thursday, o.friday, o.saturday, o.never, o.repeaton, o.type, o.repeatafter, o.repeatevery FROM {planificationclass} p 
        LEFT JOIN {optionsrepeat} o 
        ON p.id = o.idplanificaction";
$dataplani = $DB->get_records_sql($sql);
if (!is_siteadmin($USER->id) && !has_capability('moodle/role:assign', context_system::instance())) {
    if (!is_user_siteadmin($USER->id)) {
        redirect(new moodle_url('/local/videocalling'), 'No tienes permisos de administrador del sitio.', null, \core\output\notification::NOTIFY_ERROR);
    }
}

// ========================
// POST: eliminar desbaneo
// ========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unban_id'])) {
    $unbanid = required_param('unban_id', PARAM_INT);
    $DB->delete_records('bannerusers', ['id' => $unbanid]);
    redirect(new moodle_url('/local/videocalling/dashboard.php'), 'Usuario desbaneado correctamente.', null, \core\output\notification::NOTIFY_SUCCESS);
}

// ==========================
// POST: activar/desactivar sitio
// ==========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_site'])) {
    $records = $DB->get_records('activevideocalling', null, 'id ASC', '*', 0, 1);
    $current = reset($records); 

    if ($current) {
        $current->active = $current->active ? 0 : 1;
        $DB->update_record('activevideocalling', $current);
    } else {
        $DB->insert_record('activevideocalling', ['active' => 1]);
    }

    redirect(new moodle_url('/local/videocalling/dashboard.php'), 'Estado del sitio actualizado.', null, \core\output\notification::NOTIFY_SUCCESS);
}


$records = $DB->get_records('activevideocalling', null, 'id ASC', '*', 0, 1);
$firstRecord = reset($records); 
$firstRecord = reset($records); 

$isActive = $firstRecord && $firstRecord->active;
$weekOptions = ["Day", "Week"]
// $weekOptions = ["Day", "Week",  "Month", "Never"]
?>
<script>
  let startTimeEvent = null
  let finishTimeEvent = null
  let activeRepeat = false
  let typeRepeat = null
  let repeatEveryCount = 1 
  let daysActive = {
    "mon":false,
    "tue":false,
    "wed":false,
    "thu":false,
    "fri":false,
    "sat":false,
    "sun":false
  }
  let repeat = {
    "active": activeRepeat,
    "repeatEvery": repeatEveryCount,
    "type": null,
    "weekDays":daysActive,
    "end":null,
  }
  let color = null;
  let idCohortsModal = [];
  let idTeachersModal = [];
//   console.log(repeat)
</script>
<div class="bg-modal-custom "></div>

<?php 
echo $OUTPUT->header(); 

$timezone = $USER->timezone;
if ($timezone == 99) {
    $timezone = date_default_timezone_get(); // Valor por defecto si no se ha configurado
}
// echo $timezone; // Valor por defecto si no se ha configurado
$sql = "SELECT *
        FROM {planificationclass} a";
$data = $DB->get_records_sql($sql);

require_once("calendar_admin_details_create_cohort.php");

?>
<a href="<?php echo ($selectPage->out());?>">
    <button class="btn btn-success">Cambiar APPID</button>
</a>

<div class="container mt-4">
    <form method="POST" class="mb-3">
        <input type="hidden" name="toggle_site" value="1">
        <?php if ($isActive): ?>
            <!-- <button type="submit" class="btn btn-danger">Desactivar Sitio</button> -->
        <?php else: ?>
            <!-- <button type="submit" class="btn btn-success">Activar Sitio</button> -->
        <?php endif; ?>
    </form>
</div>


<div id="my_lessons_tab_calendar" class="my_lessons_tab_content container">
    <div class="my_lessons_calendar_actions">
    <div class="my_lessons_calendar_nav">


        <button class="my_lessons_today_btn my_lessons_btn_outline" id="todayBtn">Today</button>
        <button class="my_lessons_nav_btn my_lessons_btn_outline"   id="prevWeek">
        <i class="fas fa-chevron-left"></i>
        </button>
        <button class="my_lessons_nav_btn my_lessons_btn_outline" id="nextWeek">
        <i class="fas fa-chevron-right"></i>
        </button>
    
        
        <div class="my_lessons_calendar_date">September 02–08, 2024</div>
    </div>
    <!-- <div class="my_lessons_calendar_legend">
         <button id="my_lessons_schedule_btn" class="my_lessons_btn_primary">
          + Schedule lesson <i class="fas fa-chevron-down"></i>
        </button>
    </div> -->
    </div>
    <table class="my_lessons_calendar_table">
    <thead>
        <tr>

        <th></th>
        <th class="calendar-day-header" data-index="0">Mon 2</th>
        <th class="calendar-day-header" data-index="1">Tue 3</th>
        <th class="calendar-day-header" data-index="2">Wed 4</th>
        <th class="calendar-day-header" data-index="3">Thu 5</th>
        <th class="calendar-day-header" data-index="4">Fri 6</th>
        <th class="calendar-day-header" data-index="5">Sat 7</th>
        <th class="calendar-day-header" data-index="6">Sun 8</th>

        </tr>
    </thead>
    <tbody>
        <!-- <td>
            <div class="my_lessons_calendar_event my_lessons_event_weekly my_lessons_calendar_event my_lessons_event_weekly">
            <img class="my_lessons_event_avatar"
                    src="https://randomuser.me/api/portraits/women/4.jpg"
                    alt="Mary Janes">
            <i class="fas fa-sync-alt my_lessons_event_icon"></i>
            <div class="my_lessons_event_time">07:00–08:00 AM</div>
            <div class="my_lessons_event_name">Mary Janes</div>
            </div>
        </td> -->
        <?php for ($i = 0; $i < 24; $i++): ?>
            <tr>
                <th><?php echo ($i < 10) ? 0 . $i : $i; ?>:00</th>
                <td data-day="monday" data-time="<?php echo ($i < 10) ? 0 . $i.':00' : $i.':00'; ?>" class="my_lessons_calendar_slot_empty"></td>
                <td data-day="tuesday" data-time="<?php echo ($i < 10) ? 0 . $i.':00' : $i.':00'; ?>" class="my_lessons_calendar_slot_empty"></td>
                <td data-day="wednesday" data-time="<?php echo ($i < 10) ? 0 . $i.':00' : $i.':00'; ?>" class="my_lessons_calendar_slot_empty"></td>
                <td data-day="thursday" data-time="<?php echo ($i < 10) ? 0 . $i.':00' : $i.':00'; ?>" class="my_lessons_calendar_slot_empty"></td>
                <td data-day="friday" data-time="<?php echo ($i < 10) ? 0 . $i.':00' : $i.':00'; ?>" class="my_lessons_calendar_slot_empty"></td>
                <td data-day="saturday" data-time="<?php echo ($i < 10) ? 0 . $i.':00' : $i.':00'; ?>" class="my_lessons_calendar_slot_empty"></td>
                <td data-day="sunday" data-time="<?php echo ($i < 10) ? 0 . $i.':00' : $i.':00'; ?>" class="my_lessons_calendar_slot_empty"></td>
            </tr>
        <?php endfor; ?>
    </tbody>
    </table>
</div>


<div class="container mt-4">
    <h2 class="table-title">Usuarios Baneados</h2>
    <table class="table table-striped table-bordered">
        <thead class="thead-blue">
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Fecha de Inicio</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $bannedusers = $DB->get_records('bannerusers');

            foreach ($bannedusers as $user) {
                echo '<tr>';
                echo '<td>' . $user->id . '</td>';
                echo '<td>' . $user->user_id . '</td>';
                echo '<td>' . date('Y-m-d H:i', strtotime($user->startdate)) . '</td>';
                echo '<td>
                        <form method="POST" onsubmit="return confirm(\'¿Estás seguro de desbanear este usuario?\');">
                            <input type="hidden" name="unban_id" value="' . $user->id . '">
                            <button type="submit" class="btn btn-danger btn-sm">Desbanear</button>
                        </form>
                      </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script>
        const apiUrlMoodle = <?php echo json_encode($apiUrl->out());?>;
        let dataplanification = <?php echo json_encode($dataplani);?>;
        let timeZone = <?php echo json_encode($timezone);?>;
        let teachersList = <?php echo json_encode($users);?>;
        let cohortList = <?php echo json_encode($cohortsList);?>;
</script>
<script src="./js/calendar.js?v=<?php echo time(); ?>"></script>

<?php echo $OUTPUT->footer(); ?>
