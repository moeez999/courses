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

$PAGE->requires->js(new moodle_url('https://cdn.tailwindcss.com'), true);
$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$PAGE->set_url($CFG->wwwroot . '/local/videocalling/observer.php');
$PAGE->requires->css(new moodle_url('/local/videocalling/css/observer.css?v=' . time()), true);
$apiUrl = new moodle_url('/local/videocalling/api/');
$dashboardurl = new moodle_url('./dashboard.php');

$selected = $DB->get_record('selectedappid', ['selected' => 1]);
$appId = $selected ? $selected->appid : null;

// Cargar CSS para estilo visual (mantengo tu carga de fuentes)
$PAGE->requires->css(new moodle_url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap'), true);

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

require_login();
if (!is_siteadmin($USER->id) && !has_capability('moodle/role:assign', context_system::instance())) {
    if (!is_user_siteadmin($USER->id)) {
        redirect(new moodle_url('/local/videocalling'), 'No tienes permisos de administrador del sitio.', null, \core\output\notification::NOTIFY_ERROR);
    }
}

$full_name= $USER->firstname . ' ' . $USER->lastname;


$timezone = $USER->timezone;
if ($timezone == 99) {
    $timezone = date_default_timezone_get();
}

$now = new DateTime('now', new DateTimeZone($timezone));
$tz = new DateTimeZone($timezone);
$utc = new DateTimeZone('UTC');

$todayLocal = new DateTimeImmutable('today', $tz);
$startOfDayUtc = $todayLocal->setTimezone($utc)->getTimestamp();
$endOfDayUtc = $todayLocal->setTime(23, 59, 59)->setTimezone($utc)->getTimestamp();

$currentTimestamp = intval($now->getTimestamp());
$currentDay = strtolower($now->format('l')); // monday, tuesday...
$currentDate = (clone $now)->setTime(0, 0);
$currentMinutes = intval($now->format('H')) * 60 + intval($now->format('i'));

$activeClasses = [];

// ===============================
// CLASES NORMALES
// ===============================
$sql = "SELECT id, startdate, finishdate, recurrent 
        FROM {planificationclass}
        WHERE finishdate >= :start_of_day_utc
          AND startdate <= :end_of_day_utc";
$params = [
    'start_of_day_utc' => $startOfDayUtc,
    'end_of_day_utc'   => $endOfDayUtc,
];
$data = $DB->get_records_sql($sql, $params);

$sql = "
    SELECT u.id, u.username, u.firstname, u.lastname, u.email
    FROM {user} u
    JOIN {cohort_members} cm ON u.id = cm.userid
    WHERE cm.cohortid = :cohortid AND u.deleted = 0
    ORDER BY u.lastname ASC, u.firstname ASC
";

$params = ['cohortid' => 93]; //change id teacher cohort

$teacherList = $DB->get_records_sql($sql, $params);
foreach ($data as $value) {
    $start = intval($value->startdate);
    $end   = intval($value->finishdate);

    if ($start <= $currentTimestamp && $end >= $currentTimestamp && empty($value->recurrent)) {
        $activeClasses[] = [
            'id' => $value->id,
            'label' => "Peer talk #{$value->id}"
        ];
    }
}

// ===============================
// CLASES RECURRENTES (UNIFICADO)
// ===============================
$sql = "SELECT p.*, o.*
        FROM {planificationclass} p
        LEFT JOIN {optionsrepeat} o ON p.id = o.idplanificaction
        WHERE p.recurrent = 1";
$dataRepeat = $DB->get_records_sql($sql);

foreach ($dataRepeat as $value) {
    if (empty($value->type) || empty($value->repeatevery)) {
        continue;
    }

    // Horas reales de inicio/fin proyectadas a hoy
    $startTime = (new DateTimeImmutable())->setTimestamp($value->startdate)->setTimezone($tz);
    $endTime   = (new DateTimeImmutable())->setTimestamp($value->finishdate)->setTimezone($tz);

    $startMinutes = intval($startTime->format('H')) * 60 + intval($startTime->format('i'));
    $endMinutes   = intval($endTime->format('H')) * 60 + intval($endTime->format('i'));
    $currentMinutes = intval($now->format('H')) * 60 + intval($now->format('i'));

    // Validar rango horario (fin exclusivo)
    if ($currentMinutes < $startMinutes || $currentMinutes >= $endMinutes) {
        continue;
    }

    // ==================
    // Recurrentes semanales
    // ==================
    if ($value->type === 'week') {
        if (isset($value->$currentDay) && (int)$value->$currentDay === 1) {
            $activeClasses[$value->id] = [
                'id'    => $value->id,
                'idplanificaction' =>$value->idplanificaction,
                'label' => "Peer Talk #{$value->idplanificaction}",
                'start' => $startTime->format('H:i'),
                'end'   => $endTime->format('H:i')
            ];
        }
    }

    // ==================
    // Recurrentes diarios
    // ==================
    if ($value->type === 'day') {
        $repeatEvery = intval($value->repeatevery);

        $eventStartDate = (new DateTimeImmutable())
            ->setTimestamp($value->startdate)
            ->setTimezone($tz)
            ->setTime(0, 0);

        // Saltar si aún no empieza
        if ($eventStartDate > $currentDate) {
            continue;
        }

        $diffDays = $eventStartDate->diff($currentDate)->days;

        if ($diffDays % $repeatEvery === 0) {
            $activeClasses[$value->id] = [
                'id'    => $value->id,
                'idplanificaction' =>$value->idplanificaction,
                'label' => "Peer Talk #{$value->idplanificaction}",
                'start' => $startTime->format('H:i'),
                'end'   => $endTime->format('H:i')
            ];
        }
    }
}



$PAGE->set_title("View Sessions");
?>
<style>
/* ======= Estilos rápidos, respetando tu referencia ======= */

:root{
  --primary: #001cb1;
  --primary-dark:#001275;
  --text:#141414;
  --danger:#e11d48;
  --success:#10b981;
  --radius: 20px;
  --shadow: 0 10px 25px rgba(0,0,0,.08);
  --bg: #ffffff;
}

#roomsList .list-group-item{
  border: 1px solid #e5e7eb;
  border-radius: 16px;
  margin-bottom: 12px;
  box-shadow: var(--shadow);
}

.table thead th{
  font-family: "Poppins", sans-serif;
  font-weight: 600;
  border-bottom-color: #f1f5f9;
}

.table td, .table th{
  vertical-align: middle;
}

.btn{
  border-radius: var(--radius);
  font-family: "Poppins", sans-serif;
  font-weight: 600;
  letter-spacing: .2px;
  border: 2px solid transparent;
  transition: .2s ease;
}
.btn-success{
  background: var(--primary);
  border-color: var(--primary);
}
.btn-success:hover{ background: var(--primary-dark); border-color: var(--primary-dark); }
.btn-danger{
  background: #111827;
  border-color: #111827;
}
.btn-danger:hover{ background: #374151; border-color: #374151; }

#localVideoContainer { 
  position: relative; 
  background:#000; 
  border-radius: 16px; 
  overflow: hidden; 
  box-shadow: var(--shadow);
  padding: 0;
  /* ====== NUEVO: grid para múltiples cámaras ====== */
  display: flex;
  gap: 12px;
  align-content: start;
  padding: 12px;
}
@media (max-width: 768px) {
  #localVideoContainer {
    flex-direction: column;
  }
}
/* new css */

  :root{
    --peer_talk_events_border:#E4E7EE;
    --peer_talk_events_text:#121117;
    --peer_talk_events_muted:#9CA3AF;
    --peer_talk_events_accent:#ff3b1f;               /* red accent for card border/dot */
    --peer_talk_events_join_start:#ff5a2f;           /* join gradient */
    --peer_talk_events_join_end:#ff2a10;
  }
  body{ font-family:'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
  .peer_talk_events_shadow{ box-shadow:0 8px 32px rgba(18,17,23,.15), 0 16px 48px rgba(18,17,23,.12); }
  .peer_talk_events_box{ border:1px solid var(--peer_talk_events_border); }
  .peer_talk_events_chip{ border:1px solid var(--peer_talk_events_border); border-radius:9999px; padding:.375rem .75rem; }
  .peer_talk_events_badge{ width:28px; height:28px; border-radius:9999px; display:inline-flex; align-items:center; justify-content:center; font-weight:600; font-size:.75rem; }
  .peer_talk_events_checkbox{ width:24px; height:24px; border:2px solid #CBD5E1; border-radius:.5rem; display:inline-flex; align-items:center; justify-content:center; background:#fff; cursor:pointer; }
  .peer_talk_events_checkbox.checked{ background:#111827; border-color:#111827; }
  .peer_talk_events_checkbox.checked:after{ content:""; width:10px; height:10px; background:#fff; border-radius:.25rem; }
  .peer_talk_events_noscrollbar{ scrollbar-width:none; -ms-overflow-style:none; }
  .peer_talk_events_noscrollbar::-webkit-scrollbar{ width:0; height:0; }
  .peer_talk_events_caret{ transition:transform .18s ease; }
  .peer_talk_events_caret--open{ transform:rotate(180deg); }

  /* ===== Room card styles (exact snapshot) ===== */
  .peer_talk_events_roomcard{ border:1.5px solid var(--peer_talk_events_accent); border-radius:18px; }
  .peer_talk_events_timerpill{
    border:1px solid #E5E7EB; background:#fff; border-radius:9999px;
    padding:2px 8px; font-size:12px; display:inline-flex; align-items:center; gap:6px;
  }
  .peer_talk_events_reddot{ width:8px; height:8px; background:var(--peer_talk_events_accent); border-radius:9999px; display:inline-block; }

  .peer_talk_events_joinbtn{
    background:linear-gradient(180deg, var(--peer_talk_events_join_start), var(--peer_talk_events_join_end));
    color:#fff;
    border:2px solid #000;          /* ⬅ black border */
    border-radius:9999px;
    font-weight:700;
    width:95px; height:36px;
    box-shadow: inset 0 1px 0 rgba(255,255,255,.35);
  }
  .peer_talk_events_watchbtn{
    background:#fff;
    color:#111;
    border:2px solid #000;          /* ⬅ black border */
    border-radius:9999px;
    font-weight:700;
    width:95px; height:36px;
  }

  /* Compact table-like spacing inside card */
  .peer_talk_events_rowline{ height:1px; background:#E5E7EB; }
  
  /* === NEW: “Peer Talk 1” pill (top-left of card) === */
  .peer_talk_events_peertalkpill{
    display:inline-flex; align-items:center; justify-content:center;
    height:28px; padding:0 12px; border-radius:9999px;
    background:#FDE9E5;             /* soft peach like snapshot */
    color:var(--peer_talk_events_text);
    font-weight:600; font-size:13px; line-height:1;
  }
#localVideoContainer { 
  position: relative; 
  background:#000; 
  border-radius: 16px; 
  overflow: hidden; 
  box-shadow: var(--shadow);

  /* ====== NUEVO: grid para múltiples cámaras ====== */
  display: flex;
  gap: 12px;
  align-content: start;
  padding: 12px;
}
#localVideoContainer video {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  object-fit: cover;
  background: #000;
  z-index: 1; /* NUEVO: los mosaicos remotos van por encima */
}

/* Controles de cámara */
.cam-controls {
  position: absolute; left: 0rem; bottom: 1em; z-index: 5;
  display: flex; gap: .5rem;
  width: 100%;
  padding: 0px 5px;
}

#stream-controls{
  justify-content: center;
  align-items: center;
  display:flex;
  width: 100%;
  gap: .5rem;
  background: white;
  padding: .5rem;
  border-radius: 999px;
  backdrop-filter: blur(8px);
}
.buttonOption2{
  background-color: var(--primary);
  color: #fff;
  border:none;
  padding: 10px 14px;
  border-radius: 999px;
  cursor: pointer;
}
.buttonOption2:hover{ background-color: var(--primary-dark); }
.buttonOption2:disabled{ opacity:.5; cursor:not-allowed; }

/* Badges en video */
.video-container {
  position: relative;
  border: 2px solid rgba(255,255,255,.08);
  background-color: #203A49;
  border-radius: 12px;
  overflow: hidden;
  height: 100%;
  /* ====== NUEVO: tamaño visible para cada cámara ====== */
  aspect-ratio: 16 / 9;
  min-height: 180px;
  width: 100%;
}
.video-player{
  height: 100%;
  width: 100%;
  object-fit: cover;
  display: block; /* NUEVO: evita colapsos de altura */
}
.video-username, .video-clock {
  position: absolute;
  left: 6px; bottom: 6px;
  background-color: rgba(0, 0, 0, 0.72);
  color: #fff;
  padding: 2px 8px;
  font-size: 12px;
  border-radius: 6px;
}
.video-clock{
  left:auto; right:6px; top:6px; bottom:auto;
  color:#2f74ff;
}

/* Hints y notificaciones */
.autoplay-hint {
  position: absolute; left: 50%; bottom: 1rem; transform: translateX(-50%);
  z-index: 10; background: rgba(0,0,0,.7); color: #fff; padding: .5rem .75rem;
  border-radius: .75rem; display: none; align-items: center; gap: .5rem;
  box-shadow: var(--shadow);
}
.autoplay-hint button { white-space: nowrap; }

.toast-stack{
  position: fixed;
  right: 16px;
  bottom: 16px;
  display: grid;
  gap: 10px;
  z-index: 2000;
}
.toast{
  min-width: 260px;
  max-width: 360px;
  background: #111827;
  color: #fff;
  border-radius: 14px;
  box-shadow: var(--shadow);
  padding: 10px 14px;
  font-family: "Poppins", sans-serif;
  display: flex; align-items: center; gap: 10px;
}
.toast.success{ background: #065f46; }
.toast.error{ background: #7f1d1d; }
.toast.info{ background: #1f2937; }

/* Scroll en listado */
.col-5[style*="overflow-y:scroll"]{
  scrollbar-width: thin;
  scrollbar-color: #94a3b8 #e2e8f0;
}
.cam-controls {
  position: absolute;
  bottom: 1.5rem;
  left: 0;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 10;
}

/* === Botón de expandir (a la izquierda, fijo) === */
.split-toggle-btn {
  position: absolute;
  left: 1rem;
  top: 0;
  bottom: 0;
  margin: auto 0;
  z-index: 20;
  background: #fff;
  color: #111;
  border: 1.5px solid #ccc;
  border-radius: 12px;
  width: 48px;
  height: 48px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.2s ease;
}

.split-toggle-btn:hover {
  background: #f9fafb;
  transform: scale(1.05);
}

/* === Barra de controles central === */
#stream-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1.5rem;
  padding: 0.8rem 1.5rem;
  background: linear-gradient(90deg, #f9fafb, #fff);
  border-radius: 9999px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  backdrop-filter: blur(8px);
  width: 100%;
  margin: 0 auto;
}

/* === Botones individuales === */
.call-btn {
  background: #fff;
  border: 1.5px solid #d1d5db;
  border-radius: 12px;
  width: 52px;
  height: 52px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  color: #111;
  cursor: pointer;
  transition: all 0.2s ease;
}

.call-btn:hover {
  background: #f3f4f6;
  transform: translateY(-2px);
}

/* === Botón rojo central === */
.call-btn.leave {
  background: #ef4444;
  color: white;
  border: none;
  width: 56px;
  height: 56px;
  font-size: 20px;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
}

.call-btn.leave:hover {
  background: #dc2626;
  transform: scale(1.05);
}

.call-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  box-shadow: none;
}

/* === Responsive === */
@media (max-width: 640px) {
  #stream-controls {
    gap: 1rem;
    padding: 0.5rem 1rem;
  }

  .call-btn {
    width: 44px;
    height: 44px;
    font-size: 16px;
  }

  .split-toggle-btn {
    width: 40px;
    height: 40px;
    left: 0.5rem;
  }
}



</style>

<?php
echo $OUTPUT->header();
?>
<div class="row"  id="splitRow"  style="height: 80vh;">
  <div id="leftCol"  class="col-5 " style="height: 100%; overflow-y:scroll;">
    
      <h2 class="text-[18px] font-semibold mb-3">Speaking events</h2>

      <!-- FIELD + CALENDAR ICON (outside) -->
      <div class="flex items-center gap-2">
        <!-- input/select -->
        <div class="relative flex-1">
          <button id="peer_talk_events_field"
                  type="button"
                  class="peer_talk_events_box w-full h-[48px] rounded-xl px-4 pr-12 text-left flex items-center justify-between hover:bg-slate-50 focus:outline-none" style="border:2px solid black;">
            <span id="peer_talk_events_field_label" class="text-slate-500">Select Speaking events</span>
            <svg id="peer_talk_events_caret" class="peer_talk_events_caret w-5 h-5 text-slate-700 absolute right-3"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M6 9l6 6 6-6"/>
            </svg>
          </button>
          
          <!-- DROPDOWN PANEL -->
          <div id="peer_talk_events_panel"
               class="hidden absolute z-50 mt-2 w-full bg-white rounded-xl peer_talk_events_box peer_talk_events_shadow">
            <!-- <div class="flex items-center justify-between px-5 py-3 border-b border-slate-100">
              <div class="font-semibold text-[16px]">Events</div>
              <button id="peer_talk_events_close" class="w-9 h-9 rounded-lg hover:bg-slate-100 grid place-items-center" aria-label="Close">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
              </button>
            </div> -->

            <!-- list body -->
            <div class="max-h-[420px] overflow-auto peer_talk_events_noscrollbar p-2">
              <!-- <ul id="peer_talk_events_list" class="flex flex-col gap-2"> -->

                <!-- <li class="peer_talk_events_item peer_talk_events_box rounded-xl">
                  <button type="button" class="peer_talk_events_row w-full px-4 py-3 flex items-center justify-between rounded-xl">
                    <span class="font-semibold">Peer talk 1</span>
                    <span class="peer_talk_events_checkbox" data-name="Peer talk 1" role="checkbox" aria-checked="false"></span>
                  </button>
                  <div class="peer_talk_events_expand px-4 pb-4 hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div>
                        <div class="text-slate-800 font-semibold mb-2">Attending Cohorts</div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><span class="peer_talk_events_badge bg-lime-100 text-lime-800">FL1</span><span>Florida 1</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><span class="peer_talk_events_badge bg-purple-100 text-purple-800">TX1</span><span>Texas 1</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><span class="peer_talk_events_badge bg-emerald-100 text-emerald-800">FL3</span><span>Florida 3</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip"><span class="peer_talk_events_badge bg-lime-100 text-lime-800">FL2</span><span>Florida 2</span></div>
                      </div>
                      <div>
                        <div class="text-slate-800 font-semibold mb-2">Attending Teachers</div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=11"><span>jackson</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=12"><span>Hawkins</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip mb-2"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=13"><span>Warren</span></div>
                        <div class="flex items-center gap-3 peer_talk_events_chip"><img class="w-7 h-7 rounded-full object-cover" src="https://i.pravatar.cc/48?img=14"><span>Fox</span></div>
                      </div>
                    </div>
                  </div>
                </li> -->

              <!-- </ul> -->
               <?php 
                echo '<ul id="peer_talk_events_list" class="flex flex-col gap-2">';
                foreach ($activeClasses as $class) {
                    $label = htmlspecialchars($class['label']);
                    if(isset($class["idplanificaction"])){
                      $idEventItem=$class["idplanificaction"];
                      $type='recurrent';
                    }else{
                      $idEventItem=$class["id"];
                      $type='normal';

                    }
                    echo '
                    <li class="peer_talk_events_item peer_talk_events_box rounded-xl">
                      <button data-event="'.$idEventItem.'" data-type-event="'.$type.'" type="button" class="peer_talk_events_row w-full px-4 py-3 flex items-center justify-between rounded-xl">
                        <span class="font-semibold">'. $label .'</span>
                        <span data-event="'.$idEventItem.'" data-type-event="'.$type.'" class="peer_talk_events_checkbox button_filter_events" data-name="'. $label .'" role="checkbox" aria-checked="false"></span>
                      </button>
                      
                      <div class="peer_talk_events_expand container_participants px-4 pb-4 hidden" data-event-participants="'.$idEventItem.'">
                        
                      
                      </div>
                    </li>';
                }
                echo '</ul>';
               ?>
            </div>
          </div>
        </div>

        <!-- Calendar OUTSIDE -->
        <a href="<?php echo $dashboardurl->out();?>"><button type="button" class="peer_talk_events_box w-10 h-10 rounded-lg grid place-items-center hover:bg-slate-50" aria-label="Calendar">
          <svg class="w-5 h-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
          </svg>
        </button></a>
      </div>

      <!-- ===== Room card (AFTER DROPDOWN) ===== -->
      <div id='containerItems'>
        
      </div>
      <!-- ===== /Room card ===== -->

  </div>

  <div id="localVideoContainer" class="col-7" style="background-color:black;height: 100%;">
    <!-- Banner de autoplay -->
    <div id="autoplayHint" class="autoplay-hint">
      El navegador bloqueó el audio.
      <button id="btnEnableAudio" class="btn btn-sm btn-success">Habilitar audio</button>
    </div>

    <div class="cam-controls">
      <!-- Botón flotante expandir -->
      <button id="splitToggle" class="split-toggle-btn" title="Cambiar vista">
        <i class="fa fa-step-backward"></i>
      </button>

      <!-- CONTROLES DE STREAM (centrados) -->
      <div id="stream-controls">
        <button id="mic-btn" class="call-btn" title="Mic on/off">
          <i class="fa fa-microphone"></i>
        </button>
        <button id="leave-btn" class="call-btn leave" title="Salir" disabled>
          <i class="fa fa-phone"></i>
        </button>
        <button id="chat-btn" class="call-btn" title="Chat">
          <i class="fa fa-comment"></i>
        </button>
      </div>
    </div>

  </div>
</div>


<!-- Contenedor de toasts -->
<div class="toast-stack" id="toastStack"></div>

<script src="./js/AgoraRTC_N-4.23.1.js"></script>

<script>
/** ============================ Helpers UI ============================ */
function notify(message, type='info', timeout=3000){
  const stack = document.getElementById('toastStack');
  if(!stack) return;
  const el = document.createElement('div');
  el.className = `toast ${type}`;
  el.textContent = message;
  stack.appendChild(el);
  setTimeout(()=>{ el.style.opacity = '0'; el.style.transform='translateY(10px)'; }, timeout-300);
  setTimeout(()=>{ stack.removeChild(el); }, timeout);
}
function q(id){ return document.getElementById(id); }

/** ============================ Config inicial ============================ */
let api = 'https://api.latingles.com/';
const APP_ID  = <?php echo json_encode($appId);?>;

function getDeviceId() {
  return btoa(navigator.userAgent + (navigator.deviceMemory||'') + (navigator.hardwareConcurrency||''));
} 
var userId = localStorage.getItem('userId') || getDeviceId();
localStorage.setItem('userId', userId);

// Identidad del admin desde Moodle
const myUserID   = <?php echo json_encode($USER->id);?>;
const myUsername = <?php echo json_encode($full_name);?>;

let pingIntervalId = null;
let viewFeedback = null;
let disconnectstream = null;

let joinForLobby = null;
let disconnectForLobby = null;

let countdownInterval = null;
let alertFinishInterval = null;
let chatInterval;

let currentSeconds = 0;
let clockIniciado = false;
let lastRoom = null;

let roomIsMeet = false;
let totalUser = 0;
let lastUserConnected = null;
let tempMoodleId = null;
let lastTotalChats = 0;
let userBlocks = null;
let __roomsListBound = false;

let joined = false

let blockedResult = null;

let remoteUsers = {};
const client = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });

// Estado local (tracks de Agora)
let localTracks = { audio: null, video: null };
let isJoined = false;

/* ====== NUEVO: evita doble join/watch simultáneo ====== */
let isJoining = false;

/* ====== NUEVO: rol actual (join | watch) para intercalar correctamente ====== */
let currentRole = null;
let showEventWithId = null
// Ref de preview para que NO se pierda al salir
window.previewVideoEl = null;
window.previewStream = null;

/** ============================ Overlay preview ============================ */
function hidePreviewOverlay() {
  if (window.previewVideoEl) {
    window.previewVideoEl.style.display = 'none';
  }
}
function showPreviewOverlay() {
  if (window.previewVideoEl) {
    window.previewVideoEl.style.display = '';
  } else {
    startCameraPreview();
  }
}

/** ============================ Autoplay hint ============================ */
function showAutoplayHint() {
  const hint = q('autoplayHint');
  if (hint) hint.style.display = 'flex';
}
function hideAutoplayHint() {
  const hint = q('autoplayHint');
  if (hint) hint.style.display = 'none';
}
async function enableAllRemoteAudio() {
  hideAutoplayHint();
  const users = Object.values(remoteUsers);
  for (const u of users) {
    try { if (u.audioTrack) await u.audioTrack.play(); } catch(e) {}
  }
}
document.addEventListener('click', (ev) => {
  if (ev.target && ev.target.id === 'btnEnableAudio') {
    enableAllRemoteAudio();
  }
});
AgoraRTC.onAutoplayFailed = () => { showAutoplayHint(); };

/** ============================ Suscripciones remotas ============================ */
async function subscribeExistingRemoteUsers() {
  const list = client.remoteUsers || [];
  for (const u of list) {
    try {
      remoteUsers[u.uid] = u;
      if (u.hasVideo && u.videoTrack) {
        ensureRemoteContainer(u.uid);
        u.videoTrack.play(`user-${u.uid}`);
      }
      if (u.hasAudio && u.audioTrack) {
        try { await u.audioTrack.play(); } catch(e){ showAutoplayHint(); }
      }
      paintUsername(u.uid);
    } catch(e){}
  }
}


function ensureRemoteContainer(uid){
  let player = document.getElementById(`user-container-${uid}`);
  if (!player) {
    const tpl = `
      <div class="video-container" id="user-container-${uid}">
        <div class="video-player" id="user-${uid}"></div>
        <div class="video-username" id="text-name-user-${uid}">...</div>
      </div>`;
    document.getElementById('localVideoContainer').insertAdjacentHTML('beforeend', tpl);
    const el = document.getElementById(`user-container-${uid}`);
    if (el) { 
      el.style.position = 'relative'; 
      el.style.zIndex = '3';
      el.style.aspectRatio = '16 / 9';
      el.style.minHeight = '180px';
      el.style.width = '100%';
    }
  }
}

/* ====== NUEVO: contenedor para la cámara local cuando eres participante ====== */
function ensureLocalContainer(){
  let player = document.getElementById('user-container-local');
  if (!player) {
    const tpl = `
      <div class="video-container" id="user-container-local">
        <div class="video-player" id="user-local"></div>
        <div class="video-username" id="text-name-user-local"><?php echo htmlspecialchars($full_name, ENT_QUOTES); ?> (Tú)</div>
      </div>`;
    document.getElementById('localVideoContainer').insertAdjacentHTML('afterbegin', tpl);
    const el = document.getElementById('user-container-local');
    if (el) {
      el.style.position = 'relative';
      el.style.zIndex = '3';
      el.style.aspectRatio = '16 / 9';
      el.style.minHeight = '180px';
      el.style.width = '100%';
    }
  }
}
function removeLocalContainer(){
  const el = document.getElementById('user-container-local');
  if (el) el.remove();
}

async function paintUsername(uid){
  try {
    const resp = await fetch(`${api}salas/username/${encodeURIComponent(uid)}`);
    const json = await resp.json();
    const name = json?.username ?? `User ${uid}`;
    const el = document.getElementById(`text-name-user-${uid}`);
    if (el) el.textContent = name;
  } catch(e){}
}

/** ============================ Eventos de Agora ============================ */
const handleUserJoined = async (user, mediaType) => {
  remoteUsers[user.uid] = user;
  await client.subscribe(user, mediaType);

  ensureRemoteContainer(user.uid);

  if (mediaType === 'video' && user.videoTrack) {
    user.videoTrack.play(`user-${user.uid}`);
  }
  if (mediaType === 'audio' && user.audioTrack) {
    try { await user.audioTrack.play(); } catch(e){ showAutoplayHint(); }
  }

  await paintUsername(user.uid);

  if (roomIsMeet === true){
    totalUser = 1;
    lastUserConnected = user.uid !== userId ? user.uid : lastUserConnected;
  }
};

const handleUserLeft = async (user) => {
  delete remoteUsers[user.uid];
  const player = document.getElementById(`user-container-${user.uid}`);
  if (player) player.remove();

  if (roomIsMeet === true){
    // si se quedó solo, salir
    leaveAndCleanup(false);
  }
};

const handleUserUnpublished = (user, mediaType) => {
  if (mediaType === 'video') {
    const el = document.getElementById(`user-container-${user.uid}`);
    if (el) el.remove();
  }
};

/** ============================ Join / Publish ============================ */
async function joinAndDisplayLocalStream(salaId, token, shouldPublish = false) {
   await fetch(`${api}salir`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ salaId: lastRoom, userId: userId }),
  });
  // listeners solo 1 vez por safety
  client.off('user-published', handleUserJoined);
  client.off('user-left', handleUserLeft);
  client.off('user-unpublished', handleUserUnpublished);
  client.on('user-published', handleUserJoined);
  client.on('user-left', handleUserLeft);
  client.on('user-unpublished', handleUserUnpublished);

  await client.join(APP_ID, salaId, token, userId);
  lastRoom = salaId;
  isJoined = true;

  // oculta simplemente el preview (NO lo detengo, así no se pierde al salir)
  hidePreviewOverlay();

  await subscribeExistingRemoteUsers();

  if (shouldPublish) {
    if (!localTracks.audio || !localTracks.video) {
      const [micTrack, camTrack] = await AgoraRTC.createMicrophoneAndCameraTracks();
      localTracks.audio = micTrack;
      localTracks.video = camTrack;
    }
    await client.publish([localTracks.audio, localTracks.video]);

    /* ====== NUEVO: mostrar tu cámara en un mosaico local ====== */
    ensureLocalContainer();
    if (localTracks.video) {
      localTracks.video.play('user-local');
    }

    // estado visual mic
    updateMicButtonUI(!localTracks.audio.muted);
  }

  // ping
  clearInterval(pingIntervalId);
  pingIntervalId = setInterval(() => {
    fetch(`${api}ping`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ salaId, userId })
    });
  }, 30000);

  q('leave-btn').disabled = false;
  notify(shouldPublish ? 'Conectado como PARTICIPANTE' : 'Conectado como OBSERVADOR', 'success');
}

/** ============================ Leave / Cleanup ============================ */
async function leaveAndCleanup(showToast = true){
  try{
    // Detener publicación local si existiera
    if (localTracks.video) { localTracks.video.stop(); await localTracks.video.close(); localTracks.video = null; }
    if (localTracks.audio) { await localTracks.audio.setMuted(true); localTracks.audio.stop(); await localTracks.audio.close(); localTracks.audio = null; }

    // Quitar mosaico local
    removeLocalContainer();
    lastRoom = null

    // Desuscribir eventos y salir
    client.off('user-published', handleUserJoined);
    client.off('user-left', handleUserLeft);
    client.off('user-unpublished', handleUserUnpublished);

    // Eliminar elementos remotos
    Object.keys(remoteUsers).forEach(uid=>{
      const el = document.getElementById(`user-container-${uid}`);
      if (el) el.remove();
    });
    remoteUsers = {};

    if (isJoined){
      await client.leave();
      isJoined = false;
    }

    // Limpiar timers
    clearInterval(pingIntervalId);
    pingIntervalId = null;

    // Reanudar la previsualización local visible
    showPreviewOverlay();

    // UI
    q('leave-btn').disabled = true;
    updateMicButtonUI(false);

    if (showToast) notify('Has salido de la sala', 'info');
  } catch(e){
    notify('No fue posible salir completamente. Reintenta.', 'error');
    console.error(e);
  } finally {
    joined = false;
    currentRole = null; // NUEVO: limpiar rol actual al salir
  }
  
}

/** ============================ Mic UI ============================ */
function updateMicButtonUI(isOn){
  const micBtn = q('mic-btn');
  const icon = micBtn?.querySelector('i');
  if (!micBtn || !icon) return;
  if (isOn){
    micBtn.style.backgroundColor = 'white';
    icon.classList.add('fa-microphone');
    icon.classList.remove('fa-microphone-slash');
  } else {
    micBtn.style.backgroundColor = 'red';
    icon.classList.remove('fa-microphone');
    icon.classList.add('fa-microphone-slash');
  }
}

/** ============================ Render listado de salas ============================ */
function escapeHtml(s) {
  if (!s && s !== 0) return '';
  return String(s)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}
// Abrevia "Latingles Teachers Cohort" -> "LTC"
function abbrevCohort(name) {
  if (!name) return '—';
  return name
    .split(/\s+/)
    .filter(w => w.length)
    .map(w => w[0])
    .join('')
    .toUpperCase();
}
  /** ============================ Token helper ============================ */
  async function fetchRoomToken(roomId, role = 'watch') {
    // Ajusta la URL/shape según tu API. Manejamos varias posibles respuestas.
    const resp = await fetch(`${api}token`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ salaId: roomId, userId, role, asAdmin: true })
    });

    if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
    const data = await resp.json();

    // Acepta {token}, {data:{token}}, o {ok:true, token:'...'}
    const token =
      data?.token ??
      data?.data?.token ??
      (data?.ok ? data?.token : null);

    if (!token) throw new Error('Token no recibido del servidor.');
    return token;
  }

  /** ============================ Acciones admin: Watch / Join ============================ */
  async function watchRoomAsAdmin(roomId) {
    try {
      const token = await fetchRoomToken(roomId, 'watch');
      currentRole = 'watch';
      joined = true;
      roomIsMeet = false; // como observador no forzamos auto-salida al quedar solo
      await joinAndDisplayLocalStream(roomId, token, /* shouldPublish */ false);
    } catch (e) {
      console.error(e);
      notify('No fue posible ver la sala (watch).', 'error');
      throw e;
    }
  }

  async function joinRoomAsAdmin(roomId) {
    try {
      const token = await fetchRoomToken(roomId, 'join');
      currentRole = 'join';
      joined = true;
      roomIsMeet = true; // si eres participante, puedes querer lógica especial
      await joinAndDisplayLocalStream(roomId, token, /* shouldPublish */ true);
    } catch (e) {
      console.error(e);
      notify('No fue posible unirse a la sala (join).', 'error');
      throw e;
    }
  }


function filterEvent(){
  if (showEventWithId == null){
    $('.peer_talk_events_roomcard').each(function(index){
      $('#peer_talk_events_field_label').text('Select Spearking events')
      $(this).show() 
    })
    return
  }
  $('#peer_talk_events_field_label').text(`Peer Talk ${showEventWithId}`)

  $('.peer_talk_events_roomcard').each(function(index){
    $(this).attr('data-event') != showEventWithId ? $(this).hide() : null 
  })
}
async function renderRooms(data) {
  const container = document.getElementById('containerItems');
  if (!container) return;

  container.innerHTML = '';
  // Si no hay salas, estado vacío elegante
  if (!data || Object.keys(data).length === 0) {
    container.innerHTML = `
      <div class="peer_talk_events_roomcard mt-6 bg-white">
        <div class="px-4 lg:px-5 py-6 text-center text-slate-500">
          No hay salas activas por ahora.
        </div>
      </div>
    `;
    return;
  }

  // Util para avatar fallback
  const fallbackAvatar = (i) => `https://placehold.co/40x40?text=${i ?? 'U'}`;
  
  for (const [roomId, room] of Object.entries(data)) {
    let i = 1
    const usuarios = (room.usuarios || [])
      .map(k => room.usuariosInfo?.[k])
      .filter(Boolean);

    // Header: nombre de la sala (o "Peer talk")
    const eventId = room.eventId; 
    const roomLabel = escapeHtml(`Peer talk ${eventId}`);
    // Construye filas de participantes
    const rowsHtml = (usuarios.length ? usuarios : [null]).map((u, idx) => {
      const username = u ? escapeHtml(u.username || 'Usuario') : '—';
      const cohortAbbr = u ? escapeHtml(abbrevCohort(u.cohort)) : '—';
      const level = u ? escapeHtml(u.level || '—') : '—';
      const img = u?.avatar ? escapeHtml(u.avatar) : fallbackAvatar(idx + 1);

      return `
        <div class="grid grid-cols-9 items-center py-1">
          <div class="col-span-5 flex items-center gap-3">
            <img class="w-6 h-6 rounded-full object-cover" src="${img}" alt="${username}">
            <div class="text-[12px]">${username}</div>
          </div>
          <div class="hidden sm:block col-span-2">${cohortAbbr}</div>
          <div class="hidden sm:block col-span-2">${level}</div>
        </div>
        ${idx < (usuarios.length ? usuarios.length : 1) - 1 ? '<div class="peer_talk_events_rowline"></div>' : ''}
      `;
    }).join('');

    // Card completa (mismo layout que tu ejemplo)
    const card = document.createElement('div');
    card.className = 'peer_talk_events_roomcard mt-6 bg-white';
    card.setAttribute('data-event', eventId);
    card.innerHTML = `
      <!-- header -->
      <div class="px-4 lg:px-5 pt-3">
        <div class="grid grid-cols-12 items-center">
          <div class="col-span-6 sm:col-span-5 flex items-center gap-3">
            <div class="text-[13px] font-semibold" style="background-color:#ffdad4;padding:5px 10px ;border-radius:10px">${roomLabel}</div>
            <span class="peer_talk_events_timerpill" aria-hidden="true" style="display:none;">
              <span class="peer_talk_events_reddot"></span>
              <span>00:00</span>
            </span>
          </div>
          <div class="hidden sm:block sm:col-span-2 text-[12px] text-[color:var(--peer_talk_events_muted)]">Cohort</div>
          <div class="hidden sm:block sm:col-span-2 text-[12px] text-[color:var(--peer_talk_events_muted)]">Level</div>
          <div class="hidden sm:block sm:col-span-3"></div>
        </div>
      </div>

      <!-- body rows + actions column -->
      <div class="px-4 lg:px-5 pb-3">
        <div class="grid grid-cols-12 items-center">
          <!-- left block (two rows) -->
          <div class="col-span-9">
            ${rowsHtml}
          </div>

          <!-- actions column (vertical buttons) -->
          <div class="col-span-3 flex flex-col items-end justify-center gap-3">
            <button
              class="peer_talk_events_joinbtn"
              data-room="${escapeHtml(roomId)}"
              aria-label="Join room ${roomLabel}">
              Join
            </button>
            <button
              class="peer_talk_events_watchbtn"
              data-room="${escapeHtml(roomId)}"
              aria-label="Watch room ${roomLabel}">
              Watch
            </button>
          </div>
        </div>
      </div>
    `;

    container.appendChild(card);
    filterEvent()
  }

  // ===== Event delegation: join / watch (solo 1 vez) =====
  if (!__roomsListBound) {
    __roomsListBound = true;
    container.addEventListener('click', async (ev) => {
      const btn = ev.target.closest('.btn-watch, .btn-join, .peer_talk_events_watchbtn, .peer_talk_events_joinbtn');
      if (!btn) return;

      if (btn.disabled) return;
      if (isJoining) return; // evita doble click mientras cambia

      const targetRole = (btn.classList.contains('btn-watch') || btn.classList.contains('peer_talk_events_watchbtn')) ? 'watch' : 'join';
      const targetRoomId = btn.dataset.room;

      btn.disabled = true;
      isJoining = true;

      try {
        // Si ya estás dentro…
        if (joined) {
          // 1) mismo rol y misma sala => salir
          if (currentRole === targetRole && lastRoom === targetRoomId) {
            await leaveAndCleanup(true);
            return;
          }
          // 2) sala distinta o rol distinto => sal sin toast y cambia
          await leaveAndCleanup(false);
        }

        // Entra según el rol elegido
        if (targetRole === 'watch') {
          await watchRoomAsAdmin(targetRoomId);
        } else {
          await joinRoomAsAdmin(targetRoomId);
        }
      } catch (e) {
        console.error(e);
        notify('No fue posible cambiar de sala/rol.', 'error');
      } finally {
        btn.disabled = false;
        isJoining = false;
      }
    });
  }
}

/** ============================ API Salas ============================ */
function getRooms() {
  fetch(`${api}salas`)
    .then(res => res.json())
    .then(data => { renderRooms(data); })
    .catch(err => {
      console.error('Error cargando salas:', err);
      notify('No se pudieron cargar las salas', 'error');
    });
}
async function joinRoomAsAdmin(roomId) {
  // joined se establece solo cuando el flujo tenga éxito
  try {
    const res = await fetch(`${api}admin/participar`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        salaId: String(roomId),
        adminId: String(myUserID),
        username: myUsername,
        uid : userId
      })
    });
    const data = await res.json();
    if (!res.ok) {
      console.error('join error:', data);
      notify(data?.message || 'No se pudo unir como participante.', 'error');
      return;
    }
    await joinAndDisplayLocalStream(data.salaId, data.token, true);
    joined = true;
    currentRole = 'join'; // NUEVO
    q('leave-btn').disabled = false;
  } catch (err) {
    console.error(err);
    notify('Error al unirse como participante.', 'error');
  }
}
async function watchRoomAsAdmin(roomId) {
  try {
    const res = await fetch(`${api}admin/observar`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        salaId: String(roomId),
        adminId: String(myUserID),
        username: myUsername,
        uid : userId
      })
    });
    const data = await res.json();
    if (!res.ok) {
      console.error('watch error:', data);
      notify(data?.message || 'No se pudo unir como observador.', 'error');
      return;
    }
    await joinAndDisplayLocalStream(data.salaId, data.token, false);
    joined = true;
    currentRole = 'watch'; // NUEVO
    q('leave-btn').disabled = false;
  } catch (err) {
    console.error(err);
    notify('Error al unirse como observador.', 'error');
  }
}

/** ============================ Preview de Cámara (fuera de la sala) ============================ */
async function startCameraPreview() {
  const container = document.getElementById('localVideoContainer');
  if (!container) return;

  // Reusar si existe
  if (!window.previewVideoEl) {
    const videoEl = document.createElement('video');
    videoEl.autoplay = true;
    videoEl.muted = true;
    videoEl.playsInline = true;
    videoEl.style.position = 'absolute';
    videoEl.style.inset = '0';
    videoEl.style.width = '100%';
    videoEl.style.height = '100%';
    videoEl.style.objectFit = 'cover';
    container.appendChild(videoEl);
    window.previewVideoEl = videoEl;
  }

  try {
    // Si ya hay stream y tracks activos, solo muestro
    if (window.previewStream && window.previewStream.getTracks().some(t=>t.readyState==='live')) {
      window.previewVideoEl.srcObject = window.previewStream;
      window.previewVideoEl.style.display = '';
      return;
    }
    const constraints = {
      audio: false,
      video: { width: { ideal: 1280 }, height: { ideal: 720 }, facingMode: 'user' }
    };
    const localStream = await navigator.mediaDevices.getUserMedia(constraints);
    window.previewStream = localStream;
    window.previewVideoEl.srcObject = localStream;
    window.previewVideoEl.style.display = '';
  } catch (err) {
    console.error('No se pudo iniciar la cámara:', err);
    notify('No se pudo acceder a la cámara. Revisa permisos y HTTPS.', 'error');
  }
}
function stopCameraPreview(){
  try {
    if (window.previewStream) {
      window.previewStream.getTracks().forEach(t => t.stop());
    }
  } catch(e){}
}

/** ============================ DOM Ready ============================ */
document.addEventListener("DOMContentLoaded", () => {
  const apiUrlMoodle = <?php echo json_encode($apiUrl->out());?>;
  const teacherList = <?php echo json_encode($teacherList);?>;
  console.log('deiker',teacherList)
  // Cargar lista de salas y refrescar
  getRooms();
  setInterval(() => getRooms(), 5000);
(function(){
  const row = document.getElementById('splitRow');
  const btn = document.getElementById('splitToggle');

  btn.addEventListener('click', () => {
    row.classList.toggle('expand-right');
    row.classList.remove('expand-left');
  });
})();

  // --- Cache súper simple ---
const participantsCache = {};

// --- Carga y pinta (una sola vez por eventId) ---
async function loadParticipants(eventId, container, apiUrlMoodle) {
  if (participantsCache[eventId]) return; // ya cargado

  container.innerHTML = '<div class="px-1 py-2 text-sm text-slate-500">Cargando…</div>';

  const okjson = async (res, name) => {
    if (!res.ok) throw new Error(`${name}: ${res.status}`);
    return res.json();
  };

  try {
    const [cohorts, teachers] = await Promise.all([
      fetch(`${apiUrlMoodle}getcohorts.php?idplanificaction=${encodeURIComponent(eventId)}`, { headers: { 'Content-Type': 'application/json' } }).then(r => okjson(r, 'cohorts')),
      fetch(`${apiUrlMoodle}getteachers.php?idplanificaction=${encodeURIComponent(eventId)}`, { headers: { 'Content-Type': 'application/json' } }).then(r => okjson(r, 'teachers')),
    ]);
    console.log(teachers)
    container.innerHTML = renderParticipantsSimple(cohorts, teachers);
    container.dataset.loaded = '1';
    participantsCache[eventId] = true;
  } catch (err) {
    console.error(err);
    container.innerHTML = `<div class="px-1 py-2 text-sm text-red-600">No se pudo cargar (${String(err.message)})</div>`;
  }
}

// --- Render mínimo (usa teacherList y sin fotos) ---
function renderParticipantsSimple(cohortsRaw, teachersRaw) {
  const toArray = v => Array.isArray(v) ? v : Object.values(v || {});

  // Cohorts igual que antes
  const cohorts = toArray(cohortsRaw).map(c => {
    const name = (c.name || c.fullname || c.cohortname || 'Cohorte').toString();
    const code = (c.shortname || c.idnumber || name.slice(0,3).toUpperCase()).toString();
    return { name, code };
  });

  // Teachers: mapea iduserteacher -> teacherList[id].firstname/lastname
  const teachers = toArray(teachersRaw).map(t => {
    const tid = String(t.iduserteacher || t.userid || t.user_id || t.id || '');
    const u = teacherList && teacherList[tid] ? teacherList[tid] : null;
    const firstname = (u && u.firstname) ? String(u.firstname) : '';
    const lastname  = (u && u.lastname)  ? String(u.lastname)  : '';
    const fullname  = (firstname || lastname) ? `${firstname} ${lastname}`.trim() : `Docente ${tid || ''}`.trim();
    const initials  = getInitials(firstname, lastname);
    return { fullname, initials };
  });

  const cohortsHTML = cohorts.length
    ? cohorts.map(c => `
        <div class="flex items-center gap-3 peer_talk_events_chip mb-2">
          <span class="peer_talk_events_badge bg-lime-100 text-lime-800">${escapeHtml(c.code)}</span>
          <span>${escapeHtml(c.name)}</span>
        </div>`).join('')
    : `<div class="text-slate-500 text-sm">Sin cohorts.</div>`;

  const teachersHTML = teachers.length
    ? teachers.map(t => `
        <div class="flex items-center gap-3 peer_talk_events_chip mb-2">
          <div class="w-7 h-7 rounded-full bg-slate-200 flex items-center justify-center text-xs font-semibold uppercase">
            ${escapeHtml(t.initials)}
          </div>
          <span>${escapeHtml(t.fullname)}</span>
        </div>`).join('')
    : `<div class="text-slate-500 text-sm">Sin teachers.</div>`;

  return `
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div>
        <div class="text-slate-800 font-semibold mb-2">Attending Cohorts</div>
        ${cohortsHTML}
      </div>
      <div>
        <div class="text-slate-800 font-semibold mb-2">Attending Teachers</div>
        ${teachersHTML}
      </div>
    </div>`;
}

// --- Helper de iniciales ---
function getInitials(firstname, lastname) {
  const f = (firstname || '').trim();
  const l = (lastname  || '').trim();
  const a = f ? f[0] : '';
  // Si el apellido tiene espacios (p.ej. "Ruiz Duran"), toma la primera letra del primer token
  const ltok = l.split(/\s+/).filter(Boolean);
  const b = ltok.length ? ltok[0][0] : '';
  const initials = (a + b).toUpperCase();
  return initials || (f || l ? (f || l)[0].toUpperCase() : '?');
}

// --- Helpers pequeñitos ---
function avatarFromUser(id){ const n = Math.abs(Number(id)) % 70 || 10; return `https://i.pravatar.cc/48?img=${n}`; }
function escapeHtml(v){ return String(v).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'","&#39;"); }


  
  $('.button_filter_events').each(function(index){

    $(this).click(function(){
      if(showEventWithId == $(this).attr('data-event')){
        showEventWithId = null
      }else{
        showEventWithId = $(this).attr('data-event')
      }
      filterEvent()
    })
  })

  // Inicio preview
  
  startCameraPreview();

  const peer_talk_events_state = { open:false };

  function peer_talk_events_openPanel() {
    peer_talk_events_state.open = true;
    $('#peer_talk_events_panel').removeClass('hidden');
    $('#peer_talk_events_caret').addClass('peer_talk_events_caret--open');
  }
  function peer_talk_events_closePanel() {
    peer_talk_events_state.open = false;
    $('#peer_talk_events_panel').addClass('hidden');
    $('#peer_talk_events_caret').removeClass('peer_talk_events_caret--open');
  }

  $(function(){
    // Toggle dropdown
    $('#peer_talk_events_field').on('click', function(e){
      e.stopPropagation();
      peer_talk_events_state.open ? peer_talk_events_closePanel() : peer_talk_events_openPanel();
    });
    $('#peer_talk_events_close').on('click', function(e){
      e.stopPropagation(); peer_talk_events_closePanel();
    });
    $(document).on('click', function(){ if(peer_talk_events_state.open) peer_talk_events_closePanel(); });
    $('#peer_talk_events_panel').on('click', function(e){ e.stopPropagation(); });

    // Expand/collapse rows
    $('.peer_talk_events_row').on('click', function(e){
      if($(e.target).closest('.peer_talk_events_checkbox').length) return;
      const $item = $(this).closest('.peer_talk_events_item');
      const $expand = $item.find('.peer_talk_events_expand');
      $('.peer_talk_events_expand').not($expand).addClass('hidden');
      $expand.toggleClass('hidden');

      // ---> AÑADIDO: cargar solo la primera vez cuando se abre
      if (!$expand.hasClass('hidden') && !$expand.data('loaded')) {
        const eventId = $(this).data('event');
        loadParticipants(String(eventId), $expand.get(0), apiUrlMoodle);
      }
    });


    // Checkbox toggle only
    $('.peer_talk_events_checkbox').on('click', function(e){
      e.stopPropagation();
      const $cb = $(this);
      $('.peer_talk_events_checkbox').not($cb).removeClass('checked').attr('aria-checked','false');
      $cb.toggleClass('checked');
      $cb.attr('aria-checked', $cb.hasClass('checked') ? 'true' : 'false');
    });

    // Default expand first
    // $('.peer_talk_events_item').first().find('.peer_talk_events_expand').removeClass('hidden');
  });
  // Botones
  const micBtn = q('mic-btn');
  const leaveBtn = q('leave-btn');

  micBtn.addEventListener('click', async (e) => {
    try {
      // Si aún no hay track local (p.e. en modo observador), créalo pero SIN publicar
      if (!localTracks.audio) {
        const [micTrack] = await AgoraRTC.createMicrophoneAndCameraTracks({ encoderConfig: "speech_standard" }, false);
        localTracks.audio = micTrack;
        await localTracks.audio.setMuted(false);
      } else {
        const willMute = !localTracks.audio.muted ? true : false;
        await localTracks.audio.setMuted(willMute);
      }
      updateMicButtonUI(!localTracks.audio.muted);
    } catch (err) {
      console.error('No se pudo alternar el micrófono', err);
      notify('No se pudo alternar el micrófono', 'error');
    }
  });

  leaveBtn.addEventListener('click', async () => {
    await leaveAndCleanup(true);
  });

  // Cleanup al cerrar pestaña
  window.addEventListener('beforeunload', () => {
    try { stopCameraPreview(); } catch(e){}
    try { if (isJoined) client.leave(); } catch(e){}
  });
});
</script>

<?php echo $OUTPUT->footer();
?>
