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
$PAGE->set_title('videocalling');
$PAGE->set_url($CFG->wwwroot . '/local/videocalling/index.php');
$PAGE->requires->css(new moodle_url('/local/videocalling/css/index.css?v=' . time()), true);
// jQuery
$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
// Popper (requerido por Bootstrap 4)
// Bootstrap JS
$PAGE->requires->js(new moodle_url('https://cdn.jsdelivr.net/npm/sweetalert2@11'), true);

// Cargar CSS para estilo visual
$PAGE->requires->js(new moodle_url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'), true);
$PAGE->requires->css(new moodle_url(url: 'https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swapc'), true);
$apiUrl = new moodle_url('/local/videocalling/api/');
$courseurl = new moodle_url('../../course/index.php');

require_login();
$full_name= $USER->firstname . ' ' . $USER->lastname;
echo $OUTPUT->header();
$selected = $DB->get_record('selectedappid', ['selected' => 1]);
$appId = $selected ? $selected->appid : null;
function esFinDeSemana() {
    $diaActual = date('N'); // 'N' devuelve 1 (lunes) a 7 (domingo)
    return ($diaActual == 4 || $diaActual == 7);
}
$timezone = $USER->timezone; // Obtener la zona horaria del usuario
if ($timezone == 99) {
    $timezone = date_default_timezone_get(); // Valor por defecto si no se ha configurado
}
$now = new DateTime('now', new DateTimeZone($timezone));
$from = $now;
$to = $now;

// Obtener cohortes del usuario actual
$cohortssql = "SELECT c.id, c.name, c.idnumber
               FROM {cohort_members} cm
               INNER JOIN {cohort} c ON cm.cohortid = c.id
               WHERE cm.userid = :userid";

$cohortparams = ['userid' => $USER->id];
$usercohorts = $DB->get_records_sql($cohortssql, $cohortparams);
if (!empty($usercohorts)) {
    $first = reset($usercohorts);   // primer elemento del array asociativo
    $cohortabre = $first->name; // "OH4-05022024-0052" en tu ejemplo
}
$sql = "SELECT 
            a.id AS a_id, 
            a.idplanificaction, 
            a.idcohort,
            b.id AS b_id, 
            b.startdate, 
            b.finishdate, 
            b.recurrent, 
            b.color
        FROM {assignamentcohortforclass} a
        INNER JOIN {planificationclass} b ON b.id = a.idplanificaction
        WHERE b.startdate BETWEEN :startdate AND :enddate";

$params = [
    'startdate' => (clone $now)->setTime(0, 0, 0)->getTimestamp(),
    'enddate' => (clone $now)->setTime(23, 59, 59)->getTimestamp(),
];
$data = $DB->get_records_sql($sql, $params);
$currentTimestamp = intval($now->getTimestamp()); // ⏱️ timestamp actual en segundos
$isActive = false;
foreach($data as $value) {
    $start = intval($value->startdate);
    $end = intval($value->finishdate);
    if ($start <= $currentTimestamp && $end >= $currentTimestamp) {
        // verificar por cohort
        foreach($usercohorts as $cohort) {
            if ($cohort->id == $value->idcohort) {
                $isActive = true;
                break 2; // 🔁 rompe ambos foreach
            }
        }
    }
}

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

// evaluar recurrentes para usuarios normales (no profesores)
$sql = "SELECT *
        FROM {planificationclass} p
        INNER JOIN {assignamentcohortforclass} a ON p.id = a.idplanificaction
        LEFT JOIN {optionsrepeat} o ON p.id = o.idplanificaction
        WHERE p.recurrent = 1";

$dataRepeatUser = $DB->get_records_sql($sql);

if ($dataRepeatUser && !$isActive) {
    $currentDay = strtolower($now->format('l')); // Ej: "monday"
    $currentDate = $now->setTime(0, 0);
    $currentMinutes = intval($now->format('H')) * 60 + intval($now->format('i'));

    foreach ($dataRepeatUser as $value) {
        if (empty($value->type) || empty($value->repeatevery)) continue;

        // Validar que el usuario pertenezca al cohort correspondiente
        $belongsToCohort = false;
        foreach ($usercohorts as $cohort) {
            if ($cohort->id == $value->idcohort) {
                $belongsToCohort = true;
                break;
            }
        }
        if (!$belongsToCohort) continue;

        $currentTime = new DateTimeImmutable('now', $now->getTimezone());
        $currentMinutes = intval($currentTime->format('H')) * 60 + intval($currentTime->format('i'));

        $startTime = (new DateTimeImmutable())->setTimestamp($value->startdate)->setTimezone($now->getTimezone());
        $finishTime = (new DateTimeImmutable())->setTimestamp($value->finishdate)->setTimezone($now->getTimezone());

        $startMinutes = intval($startTime->format('H')) * 60 + intval($startTime->format('i'));
        $endMinutes = intval($finishTime->format('H')) * 60 + intval($finishTime->format('i'));

        if ($currentMinutes < $startMinutes || $currentMinutes > $endMinutes) {
            continue;
        }

        if ($value->type === 'week') {
            if (isset($value->$currentDay) && $value->$currentDay === "1") {
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
   <div id="label-search" class="search-user search-user--hide">
        Gracias por tu paciencia <?php echo $USER->firstname;?>. Estamos buscando un compañero para que practiques tu inglés 😃
   </div>
   
   <div id="label-alert-videocalling" class="search-user search-user--hide">
        La llamada terminara en 10 segundos
   </div>
   <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Feedback de la Videollamada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="feedbackForm">
                <div class="form-group">
                    <label>¿Qué te pareció el nivel de inglés del otro usuario?</label>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="nivel_ingles" id="ingles_bueno" value="bueno">
                    <label class="form-check-label" for="ingles_bueno">Bueno</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="nivel_ingles" id="ingles_regular" value="regular">
                    <label class="form-check-label" for="ingles_regular">Regular</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="nivel_ingles" id="ingles_malo" value="malo">
                    <label class="form-check-label" for="ingles_malo">Malo</label>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>¿Qué te pareció la conversación?</label>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="conversacion" id="conversacion_interesante" value="interesante">
                    <label class="form-check-label" for="conversacion_interesante">Interesante</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="conversacion" id="conversacion_neutral" value="neutral">
                    <label class="form-check-label" for="conversacion_neutral">Neutral</label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="conversacion" id="conversacion_mala" value="mala">
                    <label class="form-check-label" for="conversacion_mala">Mala (No volver a hablar con esta persona)</label>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="send" data-dismiss="modal">Exit</button>
                <button type="button" class="btn btn-primary" id="reconection">Meet new partner</button>
            </div>
            </div>
        </div>
    </div>

    <div id="screen-lobby" class="screen-transition">
        <h2>Buscando Lobby</h2>
    </div>
    <div id="screen-stream" class="screen-transition">
        <h2>Conectando a la sala</h2>
    </div>
    <div class="ocultar" id="clock">
        <span id="min">00</span>:<span id="seg">00</span>
    </div>
    <div id="containerMain" class="containerPreview">
        <div id="stream-wrapper" class="card-preview">
            <ul id="data-preview">
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#059669" d="m10.6 13.8l-2.15-2.15q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7L9.9 15.9q.3.3.7.3t.7-.3l5.65-5.65q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275zM12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22"/></svg>
                    Stay face-to-face during coversation.
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#059669" d="m10.6 13.8l-2.15-2.15q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7L9.9 15.9q.3.3.7.3t.7-.3l5.65-5.65q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275zM12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22"/></svg>
                    Please sit down while using.
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#059669" d="m10.6 13.8l-2.15-2.15q-.275-.275-.7-.275t-.7.275t-.275.7t.275.7L9.9 15.9q.3.3.7.3t.7-.3l5.65-5.65q.275-.275.275-.7t-.275-.7t-.7-.275t-.7.275zM12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22"/></svg>
                    Only one face please.
                </li>
            </ul>
            <div id="video-streams">
                <div id="stream-controls">
                    <button class="buttonOption2" id="mic-btn"><i class="fa fa-microphone" aria-hidden="true"></i></button>
                    <button class="buttonOption2" id="chat-btn"><i class="fa fa-comments" aria-hidden="true"></i>
                        <span class="badge-dot"></span>
                    </button>
                    <button class="buttonOption2" style="background-color: red;" id="leave-btn"><i class="fa fa-phone" aria-hidden="true"></i></button>
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
                <button class="buttonOption2" id="join-btn">Join Stream</button>

            </div>
        </div>

        </div>
    </div>

    <script>
        const username = <?php echo json_encode($full_name);?>;
        const cohortAbre = <?php echo json_encode($cohortabre);?>;
        const myUserID = <?php echo json_encode($USER->id);?>;
        const apiUrlMoodle = <?php echo json_encode($apiUrl->out());?>;
        const homeURL = <?php echo json_encode($courseurl->out());?>;
        const moodleID  = <?php echo json_encode($USER->id);?>;
        const APP_ID  = <?php echo json_encode($appId);?>;
    </script>

    <script src="./js/AgoraRTC_N-4.23.1.js"></script>
    <script src="./js/index.js?v=<?php echo time(); ?>"></script>

   <script>
        let Datascore;
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                const response = await fetch(`${apiUrlMoodle}score_feedback.php?userId=${myUserID}`);
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                Datascore = await response.json();
                console.log('Score obtenido:', Datascore);
            } catch (error) {
                console.error('Error obteniendo score:', error);
                Datascore = {
                    status: "ok",
                    score_total: 0,
                    num_feedbacks: 0,
                    score_promedio: 0
                };
            }
            console.log('Datos del score:', Datascore);
        });
    </script>


<?php } else {?>

    <div class="serviceNotAvailable">
        <h1>Hola <?php echo $USER->firstname;?></h1>
        <p>En este momento no hay sesión de Peer Talk programada. ¡Gracias, nos vemos pronto! 😃</p>
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
 