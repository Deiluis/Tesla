<div class="content-wrapper" id="ver-exposicion">
    <div id="rooms"><button onClick="reloadRooms()">Recargar salas</button></div>
    <div id="controls"></div>
    <img id="play" style="display:none">
    <script>
        const socket = io("http://localhost:7777");
        const controls = document.querySelector('#controls');
        const salas = document.querySelector('#rooms');
        socket.on("connect_error", (error) => {
            document.querySelector('h2').innerHTML = "Error en conexion";
        });
        let roomId;
        function joinRoom(room){
            if (room < 1 && document.querySelector('#room').value === '') {
                return alert('Escribe el ID de una sala');
            }
            roomId = document.querySelector('#room').value || room.toString()
            controls.innerHTML = ``;
            rooms.innerHTML = ``;
            controls.style.display = `none`;
            return socket.emit('room', roomId);
        }
        function reloadRooms(){
            return socket.emit('reloadRooms');
        }
        socket.on("connect", () => {
            controls.innerHTML = `
                <input id="room" type="number">
                <button type="submit" onClick=joinRoom()>Entrar a la sala</button>
            `;
            const img = document.getElementById('play');
            img.style.display = 'block';
            socket.on("stream", (image) => {
                img.src = image;
            })
            socket.on("reloadRooms", (rooms) => {
                salas.innerHTML = `<button onClick="reloadRooms()">Recargar salas</button>`;
                for (let value of rooms) {
                    salas.innerHTML += `
                        <div class="room">
                            <span> ${value.room} - ${value.users}/10</span>
                            <button type="submit" onClick=joinRoom(${value.room})>Entrar a la sala</button>
                        </div>
                    `;
                }
            });
        });
    </script>
</div>
