let pingIntervalId = null;
let viewFeedback = null
let disconnectstream = null

let joinForLobby = null
let disconnectForLobby = null

let countdownInterval = null;
let alertFinishInterval = null;
let chatInterval;

let currentSeconds = 0;
let clockIniciado = false
let lastRoom = null;

let roomIsMeet = false
let totalUser = 0
let lastUserConnected = null;
let tempMoodleId = null
let lastTotalChats = 0
let userBlocks = null
let blockedResult = null
let api = 'https://api.latingles.com/'

document.addEventListener('DOMContentLoaded', async () => {
    document.getElementById('join-btn').style.display = 'none';
    const blockedFound = await fetch(`${apiUrlMoodle}blocked_user.php`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    blockedResult = await blockedFound.json();
    if(blockedResult.status === true) {
        // console.log('Usuario bloqueado, cerrando sesión...');
        document.getElementById('containerMain').innerHTML = '<h1 style="color:black" class="text-center">Usuario bloqueado</h1>';
        window.location.href = homeURL;
    }else{
        document.getElementById('join-btn').style.display = 'block';
    }
    const client = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });
    document.querySelector(".rui-breadcrumbs").style.display = "none";
    let localTracks = { audio: null, video: null };
    let remoteUsers = {};
    var salaId = null;
    const audioSelect = document.getElementById('audioSelect');
    const videoSelect = document.getElementById('videoSelect');
    // ID DEVICE  
    function getDeviceId() {
        return btoa(navigator.userAgent + navigator.deviceMemory + navigator.hardwareConcurrency);
    } 

    const responseBlocks = await fetch(`${apiUrlMoodle}banner_user.php`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    });
    userBlocks = await responseBlocks.json();
    
    // console.log('userBlocks', userBlocks);
    function toggleFeedback() {
        if ($('#exampleModal').hasClass('show')) {
          // Si ya está abierto, lo cerramos
          $('#exampleModal').modal('hide');
        } else {
          // Si está cerrado, lo abrimos
          $('#exampleModal').modal('show');
        }
    }

    let screens = document.querySelectorAll(".screen-transition");
    let screenLobby = document.getElementById("screen-lobby");
    let screenStream = document.getElementById("screen-stream");
    var userId = localStorage.getItem('userId') || getDeviceId();


    const changeDevice = async () => {
        const videoSource = videoSelect.value;
        const audioSource = audioSelect.value;
    
        // Detener y eliminar las pistas actuales
        if (localTracks.audio) {
            localTracks.audio.stop();
            localTracks.audio.close();
        }
        if (localTracks.video) {
            localTracks.video.stop();
            localTracks.video.close();
        }
    
        // Crear nuevas pistas de audio y video con los dispositivos seleccionados
        const tracks = await AgoraRTC.createMicrophoneAndCameraTracks(
            { microphoneId: audioSource },
            { cameraId: videoSource }
        );
    
        // Asignar las nuevas pistas a las variables globales
        localTracks.audio = tracks[0];
        localTracks.video = tracks[1];
    
        // Eliminar el contenedor de video previo si ya existe
        let existingPlayer = document.getElementById(`user-container-${userId}`);
        if (existingPlayer) {
            existingPlayer.remove();
        }
    
        // Crear un nuevo contenedor para el video
        let player = `<div class="video-container" id="user-container-${userId}">
                        <div class="video-player" id="user-${userId}"></div>
                      </div>`;
        document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);
    
        // Reproducir el video en la vista previa
        localTracks.video.play(`user-${userId}`);
    
        // Escuchar cambios en la selección de dispositivos
        audioSelect.addEventListener('change', changeDevice);
        videoSelect.addEventListener('change', changeDevice);
    };
    

    // 🔹 Función para cargar dispositivos de audio y video
    const loadDevices = async () => {
        const devices = await AgoraRTC.getDevices();
        const audioDevices = devices.filter(device => device.kind === 'audioinput');
        const videoDevices = devices.filter(device => device.kind === 'videoinput');

        audioSelect.innerHTML = audioDevices.map(device =>
            `<option value="${device.deviceId}">${device.label}</option>`
        ).join('');

        videoSelect.innerHTML = videoDevices.map(device =>
            `<option value="${device.deviceId}">${device.label}</option>`
        ).join('');

        
        // Iniciar previsualización con el primer dispositivo disponible
        
        const videoSource = videoSelect.value;
        const audioSource = audioSelect.value;

        const tracks = await AgoraRTC.createMicrophoneAndCameraTracks(
            { microphoneId: audioSource },
            { cameraId: videoSource }
        );

        localTracks.audio = tracks[0];
        localTracks.video = tracks[1];
        
        let player = `<div class="video-container" id="user-container-${userId}">
                        <div class="video-player" id="user-${userId}"></div>
                        <div class="video-username">Yo (${username})</div>
                    </div>`; 
        document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);
 
        localTracks.video.play(`user-${userId}`);

        
        // Escuchar cambios en la selección de dispositivos 

        audioSelect.addEventListener('change', changeDevice);
        videoSelect.addEventListener('change', changeDevice);
    };
    
    function startCountdown() {
        // Reiniciar el contador
        updateClockDisplay(currentSeconds);

        // Limpiar cualquier intervalo anterior
        clearInterval(countdownInterval);

        // Iniciar nuevo intervalo
        countdownInterval = setInterval(() => {
            currentSeconds--;
            updateClockDisplay(currentSeconds);

            if (currentSeconds <= 0) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
        }, 1000);
    }

    function stopCountdown() {
        clearInterval(countdownInterval);
        countdownInterval = null;
        currentSeconds = 0;
        updateClockDisplay(currentSeconds);
    }

    function updateClockDisplay(seconds) {
        const min = Math.floor(seconds / 60).toString().padStart(2, '0');
        const seg = (seconds % 60).toString().padStart(2, '0');
        document.getElementById("min").textContent = min;
        document.getElementById("seg").textContent = seg;
    }

    function changeScreen() {
        const container = document.querySelector("#containerMain");
    
        container.classList.toggle("containerPreview");
        container.classList.toggle("containerVideoCalling");
        
    }

    function InitClock(){
        const clock = document.querySelector("#clock");

        clock.classList.remove("ocultar");
        
        if (!clockIniciado) {
            clockIniciado = true
            startCountdown();
        }
        
        // Configurar desconexión
        disconnectstream = setTimeout(() => {
            // console.log('Desconectando después de 2 minutos');
            leaveAndRemoveLocalStream();
        }, 420000);
    
        // Configurar reconexión 10 segundos después de la desconexión
        // viewFeedback = setTimeout(() => {
        //     toggleFeedback()
        // }, 420000);
    }

    function finishClock(){

        const clock = document.querySelector("#clock");

        clock.classList.add("ocultar");
        
        if (clockIniciado) {
            clockIniciado = false
            stopCountdown();
        }
    }

    const joinAndDisplayLocalStream = async (salaId, token) => {

        client.on('user-published', handleUserJoined);
        client.on('user-left', handleUserLeft);

        await client.join(APP_ID, salaId, token, userId);


        await client.publish([localTracks.audio, localTracks.video]);
        
        screenLobby.classList.remove("screen-transition--active");
        screenStream.classList.remove("screen-transition--active");
        changeScreen()
    };

    // Cargar dispositivos al cargar la página
    await loadDevices();
 
    const joinStream = async () => {
        tempMoodleId = null
        document.getElementById('chat-btn').style.display = 'block';
        roomIsMeet = true
        // console.log('iniciado Sala');
        localStorage.setItem('userId', userId);
        screenStream.classList.add("screen-transition--active");
        const scorePro = Number(Datascore?.score_promedio ?? 0); // evita "NaN"
        const time = Date.now();
        const response = await fetch(`${api}unirse`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ userId, time, username, lastRoom, userBlocks, moodleID, scorePro, cohortAbre}),
        });
    
        const data = await response.json();
        salaId = data.salaId;
        currentSeconds = 420; // Reiniciar el contador al unirse a la sala
        await joinAndDisplayLocalStream(data.salaId, data.token);
        lastRoom = data.salaId;
        $('#label-search').removeClass('search-user--hide')
        document.getElementById('join-btn').style.display = 'none';
        document.getElementById('device-selection').style.display = 'none';
        document.getElementById('stream-controls').style.display = 'flex';
    
        // Limpiar cualquier temporizador anterior
        if (disconnectstream) {
            clearTimeout(disconnectstream);
        }
        if (viewFeedback) {
            clearTimeout(viewFeedback);
        }

    };
    
    const joinLobby = async () => {
        roomIsMeet = false
        document.getElementById('chat-btn').style.display = 'none';

        // console.log('Iniciado lobby');
        localStorage.setItem('userId', userId);
        screenLobby.classList.add("screen-transition--active");
        
        try {
            const time = Date.now();
            const response = await fetch(`${api}unirse/lobby`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ userId, time, username, moodleID }),
            });
            const data = await response.json();
            currentSeconds = 60; // Reiniciar el contador al unirse a la sala
            
            await joinAndDisplayLocalStream(data.salaId, data.token);
            document.getElementById('join-btn').style.display = 'none';
            document.getElementById('device-selection').style.display = 'none';
            document.getElementById('stream-controls').style.display = 'flex';
    
            // Limpiar cualquier temporizador anterior
            if (disconnectForLobby) {
                clearTimeout(disconnectForLobby);
            }
            if (joinForLobby) {
                clearTimeout(joinForLobby);
            }
    
            // Desconectar después de 2 minutos
            disconnectForLobby = setTimeout(() => {
                // console.log('Desconectando del lobby después de 2 minutos');
                leaveAndRemoveLocalStream();
            }, 59500); // 50 segundos
            joinForLobby = setTimeout(() => {
                // console.log('Conectando al stream después de 2 minutos y 10 segundos');
                joinStream();
            }, 60000); // 1 minutos 
    
        } catch (error) {
            // console.log('Fallo en el intento de unirse al lobby');
            
            // Si falla la conexión inicial, reconectar automáticamente
            joinStream();
        }
    
        // Enviar "ping" cada 30 segundos para mantener la sesión activa
        pingIntervalId = setInterval(() => {
            fetch(`${api}ping`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ salaId, userId })
            });
        }, 30000); // cada 30 segundos
    };
    
    const handleUserJoined = async (user, mediaType) => {
        remoteUsers[user.uid] = user;
        await client.subscribe(user, mediaType);
        const getName = await fetch(`${api}salas/username/${user.uid}`, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
        });
        const response = await getName.json(); 
        const dataName = response.username; 
        tempMoodleId = response.moodleID;

        let player = document.getElementById(`user-container-${user.uid}`);
        if (!player) {
            player = `<div class="video-container" id="user-container-${user.uid}">
                        <div class="video-player" id="user-${user.uid}"></div>
                        <div class="video-username" id='text-name-user-${user.uid}'>...</div>
                        </div>`;
            document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);
        }

        // Asegurar que el video del usuario remoto se reproduce
       
        if (mediaType === 'video') {
            const videoContainer = document.getElementById(`user-${user.uid}`);
            if (videoContainer) {
                user.videoTrack.play(`user-${user.uid}`);
                // console.log('Reproduciendo video de:', user.uid);
            } else {
                console.warn('No se encontró el contenedor para el video');
            }
        }
        
        const nameElement = document.getElementById(`text-name-user-${user.uid}`);
        if (nameElement && dataName) {
            nameElement.innerText = dataName;
        }
        chatInterval = setInterval(fetchAndRenderMessages, 5000);

        if(clockIniciado === false){
            InitClock()
            $('#label-search').addClass('search-user--hide')
            fetchAndRenderMessages();
            alertFinishInterval = setTimeout(() => {
                $('#label-alert-videocalling').removeClass('search-user--hide')
            }, 460000); // 7 minutos y 40 segundos

        }
        if(roomIsMeet === true){
            totalUser = 1
            lastUserConnected = user.uid !== userId ? user.uid : lastUserConnected;
           
            // console.log('lastUserConnected', lastUserConnected);
        }
        if (mediaType === 'audio') {
            await user.audioTrack.play();
        }
    };

    const handleUserLeft = async (user) => {
        delete remoteUsers[user.uid];
        const player = document.getElementById(`user-container-${user.uid}`);
        if (player) {
            player.remove();
        }
        if(roomIsMeet === true){
            leaveAndRemoveLocalStream()
        }
    };

    const toggleMic = async (e) => {
        if (localTracks.audio.muted) {
            await localTracks.audio.setMuted(false); 
            document.getElementById('mic-btn').style.backgroundColor ='#001275'
            e.target.style.backgroundColor = '#001275';
            document.getElementById('mic-btn').querySelector('i').classList.add('fa-microphone');
            document.getElementById('mic-btn').querySelector('i').classList.remove('fa-microphone-slash');

        } else {
            await localTracks.audio.setMuted(true); 
            e.target.style.backgroundColor = 'red';
            document.getElementById('mic-btn').style.backgroundColor ='red'
            document.getElementById('mic-btn').querySelector('i').classList.remove('fa-microphone');
            document.getElementById('mic-btn').querySelector('i').classList.add('fa-microphone-slash');
        }
    };

    const toggleCamera = async (e) => {
        if (localTracks.video.muted) {
            await localTracks.video.setMuted(false);
            document.getElementById('camera-btn').style.backgroundColor ='#001275'
        } else {
            await localTracks.video.setMuted(true);
            document.getElementById('camera-btn').style.backgroundColor ='red'
        }
    };


    // Función para eliminar todos los contenedores de video excepto el que coincide con mi userId
    const removeOtherUserContainers = () => {
        // Obtener todos los contenedores de video
        const allUserContainers = document.querySelectorAll('.video-container');

        allUserContainers.forEach(container => {
            // Verificar si el id del contenedor no coincide con el userId actual
            const userIdFromContainer = container.id.split('-')[2]; // extraer el userId del id del contenedor
            if (userIdFromContainer !== userId) {
                // Si no coincide, eliminar el contenedor
                container.remove();
            }
        });
    };


    const leaveAndRemoveLocalStream = async (click = false) => { 
        // document.getElementById("chat-messages").innerHTML = ''; // Limpiar mensajes anteriores
        document.getElementById('leave-btn').disabled = true;
        $('#label-search').addClass('search-user--hide')
        $('#label-alert-videocalling').addClass('search-user--hide')
        clearInterval(chatInterval);
        $('#chat-btn .badge-dot').hide();
        clearTimeout(alertFinishInterval);
        
        if (Swal.isVisible()) {
            Swal.close();
        }
        await client.leave();
        finishClock()
        if (pingIntervalId) {
            clearInterval(pingIntervalId);
            pingIntervalId = null;
        } 

        if(click === true){
            if (joinForLobby) {
                clearTimeout(joinForLobby);
                joinForLobby = null;
            }
        }

        if(click === true){
            if (viewFeedback) {
                clearTimeout(viewFeedback);
                viewFeedback = null;
            }
        }
        if (disconnectstream) {
            clearTimeout(disconnectstream);
            disconnectstream = null;
        }
        if (disconnectForLobby) {
            clearTimeout(disconnectForLobby);
            disconnectForLobby = null;
        }
        
        
        document.getElementById('join-btn').style.display = 'block';
        document.getElementById('stream-controls').style.display = 'none';
        document.getElementById('device-selection').style.display = 'block';
        // document.getElementById('video-streams').innerHTML = '';
        
        // elminar el videos container
        
        removeOtherUserContainers()
        
        const controlsDiv = document.createElement('div');
        controlsDiv.id = 'stream-controls';

        // Botón de micrófono
        const micBtn = document.createElement('button');
        micBtn.classList.add('buttonOption');
        micBtn.id = 'mic-btn';
        micBtn.innerHTML = '<i class="fa fa-microphone" aria-hidden="true"></i>';
        micBtn.addEventListener('click', toggleMic);

        // Botón de cámara
        // const camBtn = document.createElement('button');
        // camBtn.classList.add('buttonOption');
        // camBtn.id = 'camera-btn';
        // camBtn.innerHTML = '<i class="fa fa-video-camera" aria-hidden="true"></i>';
        // camBtn.addEventListener('click', toggleCamera);

        // Botón de salir
        const leaveBtn = document.createElement('button');
        leaveBtn.classList.add('buttonOption');
        leaveBtn.classList.add('buttonOption--phone');
        leaveBtn.id = 'leave-btn';
        leaveBtn.innerHTML = '<i class="fa fa-phone" aria-hidden="true"></i>';
        leaveBtn.addEventListener('click', leaveAndRemoveLocalStream);

        controlsDiv.appendChild(micBtn);
        // controlsDiv.appendChild(camBtn);
        controlsDiv.appendChild(leaveBtn);

        document.getElementById('video-streams').appendChild(controlsDiv);


        // Notificar al backend que el usuario ha salido
        await fetch(`${api}salir`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ salaId: salaId, userId: userId }),
        });
        salaId = null
        changeScreen()
        document.getElementById('leave-btn').disabled = false;
        // console.log('Desconectado de la sala 2');
        // console.log(roomIsMeet);
        
        if(roomIsMeet === true && totalUser == 1){
            // console.log('roomIsMeet');
            
            toggleFeedback()
            roomIsMeet = false
            totalUser = 0
        }
    };

    
    
    function sendChatMessage() {
        const input = document.getElementById("chat-input");
        const text = input.value.trim();
        if (!text) return;

        fetch(`${api}mensaje`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                salaId,
                moodleId: moodleID,
                mensaje: text
            })
        })
        .then(res => res.json())
        .then(() => {
            input.value = '';
            fetchAndRenderMessages(); // Refrescar al enviar
        });
    }



    function fetchAndRenderMessages() {
        // console.log(salaId);
        // console.log(moodleID);
        fetch(`${api}mensajes/${salaId}/${moodleID}`)
        .then(res => res.json())
        .then(data => {
            const chatContainer = document.getElementById("chat-messages");
            // console.log('total/mensajes', data.length);
            if(data.length != lastTotalChats){
                lastTotalChats = data.length
                $('#chat-btn .badge-dot').show();
            }
            if (!chatContainer) return;

            data.forEach(msg => {
                const msgDiv = document.createElement("div");
                msgDiv.className = "chat-message " + (msg.idMoodleUser == moodleID ? "me" : "other");
                msgDiv.innerHTML = `
                    <div class="chat-user">${msg.nombre}</div>
                    <div>${msg.mensaje}</div>
                `;
                chatContainer.appendChild(msgDiv);
            });

            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
    }


    function openChat() {
        Swal.fire({
            position: "top-end",
            showConfirmButton: false,
            showCloseButton: false,
            customClass: { popup: 'swal-chat-fullscreen' },
            html: `
            <div class="chat-container">
                <div class="chat-header">
                    <div>Chat de la Sala</div>
                    <button id='btn-close-swal' class="chat-close">&times;</button>
                </div>
                <div id="chat-messages" class="chat-messages"></div>
                <div class="chat-input-container">
                    <input id="chat-input" type="text" placeholder="Escribe un mensaje" class="chat-input">
                    <button id="chat-send-btn" class="chat-send">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </div>
            `,
            didOpen: () => {
                $('#chat-btn .badge-dot').hide();
                const sendBtn = document.getElementById('chat-send-btn');
                const input = document.getElementById('chat-input');
                const close = document.getElementById('btn-close-swal');
                fetchAndRenderMessages(); // Refrescar al enviar
                sendBtn.addEventListener('click', sendChatMessage);
                close.addEventListener('click', ()=>{
                    Swal.close();
                    // clearInterval(chatInterval);
                });

                input.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault(); // evita el comportamiento por defecto
                        sendChatMessage();
                    }
                });

                // fetchAndRenderMessages();
                // chatInterval = setInterval(fetchAndRenderMessages, 5000);
            },

            willClose: () => {
                // clearInterval(chatInterval);
            }
        });
    }


    // variables de los botones

    document.getElementById('join-btn').addEventListener('click', joinLobby);
    document.getElementById('leave-btn').addEventListener('click', () => leaveAndRemoveLocalStream(true));
    document.getElementById('mic-btn').addEventListener('click', toggleMic);
    document.getElementById('chat-btn').addEventListener('click', openChat);
    // document.getElementById('camera-btn').addEventListener('click', toggleCamera);
    
    const sendBtn = document.getElementById('send');
    const reconnectionBtn = document.getElementById('reconection');

    // Inicialmente desactivados
    sendBtn.disabled = true;
    reconnectionBtn.disabled = true;

    // Función para validar si ambas preguntas tienen selección
    function validateForm() {
        const inglesChecked = document.querySelectorAll('input[name="nivel_ingles"]:checked').length > 0;
        const conversacionChecked = document.querySelectorAll('input[name="conversacion"]:checked').length > 0;

        const formValid = inglesChecked && conversacionChecked;

        sendBtn.disabled = !formValid;
        reconnectionBtn.disabled = !formValid;
    }

    // Asigna el evento a todos los checkboxes
    document.querySelectorAll('input[name="nivel_ingles"], input[name="conversacion"]').forEach(el => {
        el.addEventListener('change', validateForm);
    });

    // Acción del botón "Enviar"
    sendBtn.addEventListener('click', function () {
        sendFeedback();
        toggleFeedback();
        sendBtn.disabled = true;
        reconnectionBtn.disabled = true;
    });

    // Acción del botón "Enviar y unirse"
    reconnectionBtn.addEventListener('click', function () {
        sendFeedback();
        joinStream();
        toggleFeedback();
        sendBtn.disabled = true;
        reconnectionBtn.disabled = true;
    });

   async function sendFeedback() {
        const ingles = document.querySelector('input[name="nivel_ingles"]:checked')?.value;
        const conversacion = document.querySelector('input[name="conversacion"]:checked')?.value;

        let score = 0;

        // Asignar puntaje según inglés
        if (ingles === "bueno") score += 2;
        else if (ingles === "regular") score += 1;
        else if (ingles === "malo") score -= 1;

        // Asignar puntaje según conversación
        if (conversacion === "interesante") score += 2;
        else if (conversacion === "neutral") score += 0;
        else if (conversacion === "mala") score -= 3;

        const payload = {
            nivel_ingles: ingles,
            conversacion: conversacion,
            userId: tempMoodleId,
            score: score
        };

        // console.log('Feedback enviado:', payload);

        // Si fue "mala", banea
        if (conversacion === 'mala') {
            fetch(`${apiUrlMoodle}banner_user.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => console.log("Usuario baneado:", data));
        }

        // Enviar el score al backend para que lo acumule
        fetch(`${apiUrlMoodle}score_feedback.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => console.log("Score actualizado:", data));

        // ✅ Resetear el formulario
        document.getElementById("feedbackForm").reset();

        try {
            const response = await fetch(`${apiUrlMoodle}score_feedback.php?userId=${myUserID}`);
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            Datascore = await response.json();
            // console.log('Score obtenido:', Datascore);
        } catch (error) {
            console.error('Error obteniendo score:', error);
        }
    }

    setInterval(async() => {
        const blockedVerify = await fetch(`${apiUrlMoodle}blocked_user.php`, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
        });
        blockedResult = await blockedVerify.json();
        if(blockedResult.status === true) {
            // console.log('Usuario bloqueado, cerrando sesión...');
            window.location.href = homeURL;
        }
    }, 5000); // 1 segundo de retraso para mostrar el botón de unirse y la selección de dispositivos
});
