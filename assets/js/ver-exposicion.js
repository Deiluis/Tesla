// Se conecta al websocket.
const socket = io('https://192.168.0.10:7777');

const screenImg = document.querySelector('#screenImg');
const roomsDiv = document.querySelector('#rooms');
const reloadButton = document.querySelector('.join-room__reload-button');

const quitButton = document.querySelector('.video-share__control-button--quit');

const joinRoomForm = document.querySelector(".join-room__form");
const joinRoomDiv = document.querySelector(".join-room");

const videoShare = document.querySelector(".video-share");

socket.on("connect_error", (error) => {
    joinRoomDiv.innerHTML = 
    `
        <div class="title title-room">
            <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
            </svg></div>
            <span>Exponer</span>
        </div>

        <h3>Error de conexión</h3>
        <p>Hubo un error en la conexión con el servicio de exposición, intenta recargar el sitio o avísarle a tu profesor para poder resolverlo.</p>
    `;
});

let room = { id: '', name: '', size: 1, };

const joinRoom = (roomId) => {

    room.id = roomId.toString();
    socket.emit('joinRoom', room);

    // Analiza si se pudo unir correctamente.
    socket.on("joinStatus", (joined, roomFind, message) => {
        if (joined) {
            joinRoomDiv.style.display = "none";
            videoShare.style.display = "grid";
            
            room = roomFind;

            document.querySelector(".video-share__info h3").innerHTML = room.name;
            document.querySelector(".video-share__info span").innerHTML = `Sala ${room.id}`;
            document.querySelector(".video-share__participants span").innerHTML = `${room.size}`;
        } else {
            console.log(message);
        }
    });
};

const reloadRooms = () => {
    if(room.id){
        return;
    }
    return socket.emit('reloadRooms');
};

const quitRoom = () => {
    joinRoomDiv.style.display = "block";
    videoShare.style.display = "none";

    socket.emit('quitRoom', room);

    room.id = '';
    screenImg.src = '';
};

socket.on("connect", () => {

    screenImg.style.display = 'block';

    socket.on("createRoom", (room) => {
        console.log(room);
    });

    socket.on("closeRoom", () => {
        quitRoom();
        reloadRooms();
    });

    socket.on("stream", (image) => {
        screenImg.src = image;
    });

    socket.on('stopStream', () => {
        screenImg.src = "";
    });

    socket.on("reloadRooms", (rooms) => {

        if (rooms.length > 0) {

            roomsDiv.innerHTML = "";

            for (let room of rooms) {

                roomsDiv.innerHTML += `
                    <div class="room" onClick=joinRoom(${room.id})>
                        <h4>${room.name}</h4>
                        <span>
                            ID: ${room.id} | ${room.size}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                            </svg>
                        </span>
                    </div>
                `;
            }

        } else {
            roomsDiv.innerHTML = '<h4>No hay salas disponibles.</h4>';
        }
    });

});

joinRoomForm.addEventListener("submit", (e) => {
    e.preventDefault();

    if (document.querySelector('#roomId').value === '') {
        return alert('Escribe el ID de una sala');
    }
    const roomId = document.querySelector('#roomId').value;

    joinRoom(roomId);
});
quitButton.addEventListener("click", quitRoom);
reloadButton.addEventListener("click", reloadRooms);