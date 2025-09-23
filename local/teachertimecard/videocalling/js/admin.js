let pingIntervalId = null;
let joinRoom = null
let disconnectstream = null

let joinForLobby = null
let disconnectForLobby = null

let countdownInterval = null;
let currentSeconds = 0;

let api = 'https://api.latingles.com/'


document.addEventListener('DOMContentLoaded', async () => {
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
                        <div class="video-username">Yo</div>
                    </div>`;
        document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);
 
        localTracks.video.play(`user-${userId}`);

        
        // Escuchar cambios en la selección de dispositivos 

        audioSelect.addEventListener('change', changeDevice);
        videoSelect.addEventListener('change', changeDevice);
    };
    
    function startCountdown() {
        // Reiniciar el contador
        currentSeconds = 420;
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
        const clock = document.querySelector("#clock");
    
        container.classList.toggle("containerPreview");
        container.classList.toggle("containerVideoCalling");
        // clock.classList.toggle("ocultar");
    
        // if (!clock.classList.contains("ocultar")) {
        //     // Si se está mostrando el reloj, iniciar el contador
        //     startCountdown();
        // } else {
        //     // Si se está ocultando, detener el contador
        //     stopCountdown();
        // }
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
 
    
    
    const createLobby = async () => {
        $('#stream-wrapper').removeClass('serviceNotConnected');
        console.log('iniciado lobby')
        localStorage.setItem('userId', userId);
        console.log(userId);
        const time = Date.now();
        screenStream.classList.add("screen-transition--active");

        const response = await fetch(`${api}crear/lobby`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ userId, time, username }),
        });

        const data = await response.json();
        salaId = data.salaId;
        await joinAndDisplayLocalStream(data.salaId, data.token);
        pingIntervalId = setInterval(() => {
            fetch(`${api}ping`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ salaId, userId })
            });
        }, 30000); // cada 30 segundos
        document.getElementById('join-btn').style.display = 'none';
        document.getElementById('device-selection').style.display = 'none';
        document.getElementById('stream-controls').style.display = 'flex';
       
        // setTimeout(() => {
        //     console.log(' 10 segundos para conectar ');

        //     leaveAndRemoveLocalStream();
        // // }, 400000); 
        // }, 10000); // 6 minutos y 40 segundos
        
        // setTimeout(() => {
        //     console.log('conectando al stream');
        //     joinStream();
        // // }, 420000); // 7 minutos
        // }, 20000); // 7 minutos

        
    };
    
    const handleUserJoined = async (user, mediaType) => {
        remoteUsers[user.uid] = user;
        await client.subscribe(user, mediaType);
        let seconds = 60;
    
        const getName = await fetch(`${api}salas/username/${encodeURIComponent(user.uid)}`, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
        });
        
        const response = await getName.json(); 
        const dataName = response.username; 
    
        const getMoodleId = await fetch(`${api}salas/moodleid/${user.uid}`, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
        });
        const moodleIdUser = await getMoodleId.json(); 
        console.log('id Moodle Obtenido', moodleIdUser);
    
        let player = document.getElementById(`user-container-${user.uid}`);
        if (!player) {
            const popoverId = `popover-${user.uid}`;
            player = `
                <div class="video-container" id="user-container-${user.uid}">
                    <button 
                        class="report-btn" 
                        data-popover-id="${popoverId}">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                    </button>
                    <div class="custom-popover" id="${popoverId}">
                        <button class="ban-option" user-ban-id="${moodleIdUser.moodleID}" data-type="permanent">Ban permanente</button>
                        <button class="ban-option" user-ban-id="${moodleIdUser.moodleID}" data-type="daily">Ban diario</button>
                    </div>
                    <div class="video-player" id="user-${user.uid}"></div>
                    <div class="video-username" id='text-name-user-${user.uid}'>...</div>
                    <div class="video-clock" id="clock-${user.uid}">01:00</div>
                </div>`;
            
            document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);
    
            // Añadir evento de popover para este botón
            const userContainer = document.getElementById(`user-container-${user.uid}`);
            const reportBtn = userContainer.querySelector('.report-btn');

            const popover = document.getElementById(popoverId);
    
            reportBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                // Ocultar cualquier otro popover
                document.querySelectorAll('.custom-popover').forEach(p => {
                    if (p !== popover) p.style.display = 'none';
                });
    
                // Alternar el popover actual
                popover.style.display = (popover.style.display === 'block') ? 'none' : 'block';
            });
    
            // Manejar clics en opciones del popover
            popover.querySelectorAll('.ban-option').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const type = btn.getAttribute('data-type');
                    const userId = reportBtn.getAttribute('user-ban-id');
                    console.log(`Ban ${type} al usuario ${userId}`);
                    popover.style.display = 'none';
                    // Aquí puedes llamar a tu backend para aplicar el ban
                    
                    const userBanId = btn.getAttribute('user-ban-id');
                    const permanent = type === 'permanent';
                    try {
                        const response = await fetch(`${apiUrlMoodle}blocked_user.php`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({
                                userId: userBanId,
                                permanent: permanent
                            })
                        });
                
                        const result = await response.json();
                        if (result.status === 'success') {
                            console.log(`Ban ${type} aplicado a ${moodleIdUser}`);
                        } else {
                            console.error('Error al aplicar ban:', result.error);
                        }
                    } catch (error) {
                        console.error('Error en la solicitud:', error);
                    }
                
                    popover.style.display = 'none';
                });
            });

            
    
            // Cerrar popovers al hacer clic fuera
            document.addEventListener('click', (e) => {
                if (!popover.contains(e.target) && e.target !== reportBtn) {
                    popover.style.display = 'none';
                }
            });
        }
    
        if (mediaType === 'video') {
            const videoContainer = document.getElementById(`user-${user.uid}`);
            if (videoContainer) {
                user.videoTrack.play(`user-${user.uid}`);
                console.log('Reproduciendo video de:', user.uid);
            } else {
                console.warn('No se encontró el contenedor para el video');
            }
        }
    
        const nameElement = document.getElementById(`text-name-user-${user.uid}`);
        if (nameElement && dataName) {
            nameElement.innerText = dataName;
        }
    
        // Iniciar contador regresivo
        const clockElement = document.getElementById(`clock-${user.uid}`);
        if (clockElement) {
            clockElement.innerText = "01:00";
            const intervalId = setInterval(() => {
                const min = Math.floor(seconds / 60);
                const sec = seconds % 60;
                clockElement.innerText = `${min.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
                if (seconds <= 0) clearInterval(intervalId);
                seconds--;
            }, 1000);
        }
    
        if (mediaType === 'audio') {
            user.audioTrack.play();
        }
    };
    
    const handleUserLeft = async (user) => {
        delete remoteUsers[user.uid];
        const player = document.getElementById(`user-container-${user.uid}`);
        if (player) {
            player.remove();
        }
    };

    const toggleMic = async (e) => {
        if (localTracks.audio.muted) {
            await localTracks.audio.setMuted(false); 
            document.getElementById('mic-btn').style.backgroundColor ='#001275'

        } else {
            await localTracks.audio.setMuted(true); 
            e.target.style.backgroundColor = 'red';
            document.getElementById('mic-btn').style.backgroundColor ='red'
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
        $('#stream-wrapper').addClass('serviceNotConnected');
        await client.leave();
        if (pingIntervalId) {
            clearInterval(pingIntervalId);
            pingIntervalId = null;
        }
        if (joinForLobby) {
            clearTimeout(joinForLobby);
            joinForLobby = null;
        }
        if(click === true){
            if (joinRoom) {
                clearTimeout(joinRoom);
                joinRoom = null;
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
    };

    

    document.getElementById('join-btn').addEventListener('click', createLobby);
    document.getElementById('leave-btn').addEventListener('click', () => leaveAndRemoveLocalStream(true));
    document.getElementById('mic-btn').addEventListener('click', toggleMic);
    // document.getElementById('camera-btn').addEventListener('click', toggleCamera);
});
