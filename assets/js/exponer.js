const socket = io("http://localhost:7777");

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

socket.on("connect_error", (error) => {
    document.querySelector('.title-room').innerHTML = "Error en conexión";
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

    const intervalo = setInterval(() => {
        context.drawImage(video, 0, 0, context.width, context.height);
        socket.emit('stream', { stream: canvas.toDataURL('image/webp'), roomId: room.id});
    }, 500);
};

const stop = () => {
    //e.style.display = "none";
    let tracks = video.srcObject.getTracks();
    tracks.forEach(track => track.stop());
    video.srcObject = null;
    emitButton.classList.remove("video-share__control-button--active");
    emitButton.title = "Exponer";
    emiting = false;
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

