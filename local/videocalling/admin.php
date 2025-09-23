<?php

/**
 * Local plugin "videocalling" - Lib file
 *
 * @package    local_videocalling
 * @copyright  2024 Deiker, Venezuela <deiker21004@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG, $DB, $PAGE, $USER;

require_once('../../config.php');
require_once($CFG->dirroot . '/local/videocalling/lib.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Admin videocalling');
$PAGE->set_url($CFG->wwwroot . '/local/videocalling/admin.php');
$PAGE->requires->css(new moodle_url('/local/videocalling/css/index.css?v=' . time()), true);
$apiUrl = new moodle_url('/local/videocalling/api/');

// Cargar CSS para estilo visual
$PAGE->requires->css(new moodle_url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swapc'), true);

require_login();

$full_name= $USER->firstname . ' ' . $USER->lastname;
echo $OUTPUT->header();
$selected = $DB->get_record('selectedappid', ['selected' => 1]);
$appId = $selected ? $selected->appid : null;
function esFinDeSemana() {
    $diaActual = date('N'); // 'N' devuelve 1 (lunes) a 7 (domingo)
    return ($diaActual == 4 || $diaActual == 7);
}


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


$timezone = $USER->timezone; // Obtener la zona horaria del usuario
if ($timezone == 99) {
    $timezone = date_default_timezone_get(); // Valor por defecto si no se ha configurado
}
$now = new DateTime('now', new DateTimeZone($timezone));
$from = $now;
$to = $now;


$currentTimestamp = intval($now->getTimestamp()); // ⏱️ timestamp actual en segundos
$isActive = false;

$sql = "SELECT *
        FROM {assignamentteachearforclass} a
        INNER JOIN {planificationclass} b ON b.id = a.idplanificaction
        WHERE b.startdate BETWEEN :startdate AND :enddate      
        AND a.iduserteacher = :teacherid
        "
        ;
$params = [
    'startdate' => (clone $now)->setTime(0, 0, 0)->getTimestamp(),
    'enddate' => (clone $now)->setTime(23, 59, 59)->getTimestamp(),
    'teacherid' => $USER->id,
];

$datateacher = $DB->get_records_sql($sql, $params);
if($datateacher && !$isActive){
    foreach($datateacher as $value) {
        $start = intval($value->startdate);
        $end = intval($value->finishdate);
        if ($start <= $currentTimestamp && $end >= $currentTimestamp) {
            // verificar por cohort
            $isActive = true;   
            break; // 🔁 rompe ambos foreach
        }
    }

}
// evaluar recurrentes
$sql = "SELECT *
        FROM {planificationclass} p
        INNER JOIN {assignamentteachearforclass} a ON p.id = a.idplanificaction
        LEFT JOIN {optionsrepeat} o ON p.id = o.idplanificaction
        WHERE p.recurrent = 1      
        AND a.iduserteacher = :teacherid
        "
        ;
$params = [
    'teacherid' => $USER->id,
];
$dataRepeatTeacher = $DB->get_records_sql($sql, $params);

if ($dataRepeatTeacher && !$isActive) {
    $currentDay = strtolower($now->format('l')); // e.g. "monday"
    $currentDate = $now->setTime(0, 0);
    $currentMinutes = intval($now->format('H')) * 60 + intval($now->format('i'));
    foreach ($dataRepeatTeacher as $value) {
        if (empty($value->type) || empty($value->repeatevery)) continue;

        $currentTime = new DateTimeImmutable('now', $now->getTimezone());
        $currentMinutes = intval($currentTime->format('H')) * 60 + intval($currentTime->format('i'));

        $startTime = (new DateTimeImmutable())->setTimestamp($value->startdate)->setTimezone($now->getTimezone());
        $finishTime = (new DateTimeImmutable())->setTimestamp($value->finishdate)->setTimezone($now->getTimezone());

        $startMinutes = intval($startTime->format('H')) * 60 + intval($startTime->format('i'));
        $endMinutes = intval($finishTime->format('H')) * 60 + intval($finishTime->format('i'));

        // echo "<strong>Evento ID {$value->id}</strong><br>";
        // echo "Hora actual: $currentMinutes min<br>";
        // echo "Inicio: $startMinutes min, Fin: $endMinutes min<br>";

        if ($currentMinutes < $startMinutes || $currentMinutes > $endMinutes) {
            // echo "⛔ Fuera del rango<br><br>";
            continue;
        }

        // echo "✅ Hora dentro del rango<br><br>";

        if ($value->type === 'week') {
            // Ej: $value->tuesday === "1"
            if (isset($value->$currentDay) && $value->$currentDay === "1") {
                // echo "Día actual ($currentDay) coincide con el evento<br>";
                $isActive = true;
                break;
            }
        }

        if ($value->type === 'day') {
            $repeatEvery = intval($value->repeatevery);
            $eventStartDate = (new DateTimeImmutable())->setTimestamp($value->startdate)->setTimezone($now->getTimezone())->setTime(0, 0);

            $diffDays = $eventStartDate->diff($currentDate)->days;

            if ($eventStartDate > $currentDate) continue;

            if ($diffDays % $repeatEvery === 0) {
                $isActive = true;
                break;
            }
        }
    }
}




if ($isActive) { ?>


<div id="screen-lobby" class="screen-transition">
        <h2>Buscando Lobby</h2>
    </div>
    <div id="screen-stream" class="screen-transition">
        <h2>Creando Lobby</h2>
    </div>
    <div class="ocultar" id="clock">
        <span id="min">00</span>:<span id="seg">00</span>
    </div>
    <div id="containerMain" class="containerPreview">
        <div id="stream-wrapper" class="card-preview serviceNotConnected">
            <div id="video-streams">
                <div id="stream-controls">
                    <button class="buttonOption" id="mic-btn"><i class="fa fa-microphone" aria-hidden="true"></i></button>
                    <!-- <button class="buttonOption" id="camera-btn"><i class="fa fa-video-camera" aria-hidden="true"></i></button> -->
                    <button class="buttonOption" style="background-color: red;" id="leave-btn"><i class="fa fa-phone" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
            
        <div class="controls card-preview"  id="device-selection">    
            <div class="container_options">
                <h1>Settings</h1>
                <div class="option-item">
                    <label for="audioSelect">Micrófono:</label>
                    <select class="buttonOption" id="audioSelect"></select> 
                </div>
                <div class="option-item">
                    <label for="videoSelect">Cámara:</label>
                    <select class="buttonOption" id="videoSelect"></select>
                </div>
                <button class="buttonOption" id="join-btn">Create Lobby</button>

            </div>
        </div>

        </div>
    </div>


    <script>
        const username = "Administrador";
        const apiUrlMoodle = <?php echo json_encode($apiUrl->out());?>;
        const APP_ID  = <?php echo json_encode($appId);?>;
        const myMoodleID  = <?php echo json_encode($USER->id);?>;


    </script>
    <script src="./js/AgoraRTC_N-4.23.1.js"></script>
    <script src="./js/admin.js?v=<?php echo time(); ?>"></script>
    <style>
        .serviceNotConnected{
            width: 30%;
        }
    </style>

<?php } else {?>

    <div class="serviceNotAvailable">
        <h1>¡Lo siento!</h1>
        <p>Servicio no disponible</p>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', async () => {
            document.querySelector(".rui-breadcrumbs").style.display = "none";
        });
    </script>
<?php
}
echo $OUTPUT->footer();

?>
 