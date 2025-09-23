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
$PAGE->requires->js(new moodle_url('https://code.jquery.com/jquery-3.6.0.min.js'), true);
$PAGE->set_url($CFG->wwwroot . '/local/videocalling/observer.php');
$PAGE->requires->css(new moodle_url('/local/videocalling/css/observer.css?v=' . time()), true);
$apiUrl = new moodle_url('/local/videocalling/api/');

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

  /* ====== NUEVO: grid para múltiples cámaras ====== */
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
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
  position: absolute; left: 1rem; bottom: 1rem; z-index: 5;
  display: flex; gap: .5rem;
}

#stream-controls{
  display:flex;
  gap: .5rem;
  background: rgba(0,0,0,.35);
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
</style>

<?php
echo $OUTPUT->header();
?>
<div class="row" style="height: 80vh;">
  <div class="col-5" style="height: 100%; overflow-y:scroll;">
    <ul id="roomsList" class="list-group"></ul>
  </div>

  <div id="localVideoContainer" class="col-7" style="background-color:black;height: 100%;">
    <!-- Banner de autoplay -->
    <div id="autoplayHint" class="autoplay-hint">
      El navegador bloqueó el audio.
      <button id="btnEnableAudio" class="btn btn-sm btn-success">Habilitar audio</button>
    </div>

    <!-- Controles -->
    <div class="cam-controls">
      <div id="stream-controls">
        <button class="buttonOption2" id="mic-btn" title="Mic on/off"><i class="fa fa-microphone" aria-hidden="true"></i></button>
        <button class="buttonOption2" style="background-color: red;" id="leave-btn" disabled title="Salir"><i class="fa fa-phone" aria-hidden="true"></i></button>
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

let blockedResult = null;

let remoteUsers = {};
const client = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });

// Estado local (tracks de Agora)
let localTracks = { audio: null, video: null };
let isJoined = false;

// Ref de preview para que NO se pierda al salir
window.previewVideoEl = null;
window.previewStream = null;

/** ============================ Overlay preview ============================ */
function hidePreviewOverlay() {
  // No paramos la cámara de preview aquí; solo ocultamos si fuera necesario
  if (window.previewVideoEl) {
    window.previewVideoEl.style.display = 'none';
  }
}
function showPreviewOverlay() {
  if (window.previewVideoEl) {
    window.previewVideoEl.style.display = '';
  } else {
    // si por alguna razón se limpió, la restauro
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

      /* ====== NUEVO refuerzo inline: garantiza tamaño visible ====== */
      el.style.aspectRatio = '16 / 9';
      el.style.minHeight = '180px';
      el.style.width = '100%';
    }
  }
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
  // listeners solo 1 vez por safety
  client.off('user-published', handleUserJoined);
  client.off('user-left', handleUserLeft);
  client.off('user-unpublished', handleUserUnpublished);
  client.on('user-published', handleUserJoined);
  client.on('user-left', handleUserLeft);
  client.on('user-unpublished', handleUserUnpublished);

  await client.join(APP_ID, salaId, token, userId);
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
  }
}

/** ============================ Mic UI ============================ */
function updateMicButtonUI(isOn){
  const micBtn = q('mic-btn');
  const icon = micBtn?.querySelector('i');
  if (!micBtn || !icon) return;
  if (isOn){
    micBtn.style.backgroundColor = '#001275';
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
function renderRooms(data) {
  const list = document.getElementById('roomsList');
  if (!list) return;
  list.innerHTML = '';

  for (const [roomId, room] of Object.entries(data)) {
    const usuarios = (room.usuarios || [])
      .map(k => room.usuariosInfo?.[k])
      .filter(Boolean);

    const totalRows = Math.max(usuarios.length, 1);

    let rowsHtml = '';
    if (usuarios.length === 0) {
      rowsHtml = `
        <tr>
          <td><img src="https://placehold.co/40x40" class="img-user me-2" alt="">—</td>
          <td>—</td>
          <td>—</td>
          <td class="text-nowrap" rowspan="1">
            <button class="btn btn-sm btn-danger me-1 btn-watch" data-room="${escapeHtml(roomId)}">Watch</button>
            <button class="btn btn-sm btn-success btn-join" data-room="${escapeHtml(roomId)}">Join</button>
          </td>
        </tr>
      `;
    } else {
      rowsHtml = usuarios.map((u, idx) => {
        const username = escapeHtml(u.username || 'Usuario');
        const cohortAbbr = escapeHtml(abbrevCohort(u.cohort));
        const level = escapeHtml(u.level || '—');
        const border = idx === 0 ? ' style="border-bottom: none;"' : '';

        return `
          <tr${border}>
            <td><img src="https://placehold.co/40x40" class="img-user me-2" alt="">${username}</td>
            <td>${cohortAbbr}</td>
            <td>${level}</td>
            ${idx === 0 ? `
              <td class="text-nowrap" rowspan="${totalRows}">
                <button class="btn btn-sm btn-danger me-1 btn-watch" data-room="${escapeHtml(roomId)}">Watch</button>
                <button class="btn btn-sm btn-success btn-join" data-room="${escapeHtml(roomId)}">Join</button>
              </td>
            ` : ''}
          </tr>
        `;
      }).join('');
    }

    const li = document.createElement('li');
    li.className = 'list-group-item';
    li.innerHTML = `
      <table class="table align-middle">
        <thead>
          <tr>
            <th><span style="font-size:1.3em;">•</span> Participants</th>
            <th>Cohort</th>
            <th>Levels</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          ${rowsHtml}
        </tbody>
      </table>
    `;
    list.appendChild(li);
  }

  // Delegación: solo la enganchamos una vez
  const roomsListEl = document.getElementById('roomsList');
  if (roomsListEl && !__roomsListBound) {
    __roomsListBound = true;
    roomsListEl.addEventListener('click', async (ev) => {
      const btn = ev.target.closest('.btn-watch, .btn-join');
      if (!btn) return;

      if (btn.disabled) return;
      btn.disabled = true;

      try {
        if (btn.classList.contains('btn-watch')) {
          const roomId = btn.dataset.room;
          if (roomId) await watchRoomAsAdmin(roomId);
          return;
        }
        if (btn.classList.contains('btn-join')) {
          const roomId = btn.dataset.room;
          if (roomId) await joinRoomAsAdmin(roomId);
          return;
        }
      } finally {
        btn.disabled = false;
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
  q('leave-btn').disabled = false;
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
  } catch (err) {
    console.error(err);
    notify('Error al unirse como participante.', 'error');
  }
}
async function watchRoomAsAdmin(roomId) {
  q('leave-btn').disabled = false;
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
  // Cargar lista de salas y refrescar
  getRooms();
  setInterval(() => getRooms(), 5000);

  // Inicio preview
  startCameraPreview();

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
