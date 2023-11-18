const socket = io("https://192.168.0.2:7777");

const createRoomDiv = document.querySelector(".create-room");
const createRoomForm = document.querySelector(".create-room__form");

const videoShare = document.querySelector(".video-share");

const streamConfig = { video: {cursor: "always"}, audio: true }
const video = document.getElementById('video');
const canvas = document.getElementById('preview');

const context = canvas.getContext('2d');
canvas.width = 1600;
canvas.height = canvas.width * 0.5;
context.width = canvas.width;
context.height = canvas.height;

const emitButton = document.querySelector('.video-share__control-button--emit');
const audioButton = document.querySelector('.video-share__control-button--audio');
const quitButton = document.querySelector('.video-share__control-button--quit');

let emiting = false;
let emitingInterval;

socket.on("connect_error", (error) => {
    createRoomDiv.innerHTML = 
    `
        <div class="title title-room">
            <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
            </svg></div>
            <span>Exponer</span>
        </div>

        <h3>Error de conexión</h3>
        <p>Hubo un error en la conexión con el servicio de exposición, intenta recargar el sitio. Si el problema periste, comunicate con un EMATP para resolverlo.</p>
    `;

    //document.querySelector('.title-room').innerHTML = "Error en conexión";
});

const room = { id: '', name: '', size: 1, };

const audioChange = () => {
    streamConfig.audio = !streamConfig.audio;
    audioButton.classList.toggle('video-share__control-button--active');

    if (streamConfig.audio)
        audioButton.title = "No compartir sonido";
    else
        audioButton.title = "Compartir sonido";
};

const createRoom = (e) => {
    e.preventDefault();

    if (document.querySelector('#roomId').value === '') {
        return alert('Please type a room ID');
    }

    room.id = document.querySelector('#roomId').value;
    room.name = document.querySelector('#roomName').value;
    room.size = "1";

    createRoomDiv.style.display = "none";
    videoShare.style.display = "grid";

    document.querySelector(".video-share__info h3").innerHTML = room.name;
    document.querySelector(".video-share__info span").innerHTML = `Sala ${room.id}`;
    document.querySelector(".video-share__participants span").innerHTML = room.size;

    return socket.emit('createRoom', room);
};

const emit = () => {
    navigator.mediaDevices.getDisplayMedia(streamConfig)
    .then((stream) => {
        video.srcObject = stream;
        emitButton.classList.add("video-share__control-button--active");
        emitButton.title = "Dejar de exponer";
        emiting = true;
        //e.nextElementSibling.style.display = "block";
    })
    .catch(() => {
        console.log('Error en emisión');
        emiting = false;
    });

    emitingInterval = setInterval(() => {
        context.drawImage(video, 0, 0, context.width, context.height);
        socket.emit('stream', { stream: canvas.toDataURL('image/webp'), roomId: room.id});
    }, 150);
};

const stop = () => {
    //e.style.display = "none";
    let tracks = video.srcObject.getTracks();
    tracks.forEach(track => track.stop());
    video.srcObject = null;
    emitButton.classList.remove("video-share__control-button--active");
    emitButton.title = "Exponer";
    emiting = false;
    clearInterval(emitingInterval);
    socket.emit('stopStream', room);
};

const closeRoom = () => {
    if (emiting)
        stop();

    createRoomDiv.style.display = "block";
    videoShare.style.display = "none";

    return socket.emit('closeRoom', room);
};

socket.on("connect", () => {
    socket.on("newSize", (newSize) => {
        document.querySelector(".video-share__participants span").innerHTML = newSize;
        room.size = newSize;
    });
    
    socket.on('disconnect', () => closeRoom());
});

createRoomForm.addEventListener("submit", createRoom);

emitButton?.addEventListener("click", () => {
    if (emiting) 
        stop();
    else 
        emit();
});

audioButton?.addEventListener("click", audioChange);
quitButton.addEventListener("click", closeRoom);

