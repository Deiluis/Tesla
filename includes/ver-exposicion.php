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
        const room = {id: ''}
        function joinRoom(roomSelect){
            if (roomSelect < 1 && document.querySelector('#room').value === '') {
                return alert('Escribe el ID de una sala');
            }
            room.id = document.querySelector('#room').value || roomSelect.toString()
            controls.innerHTML = ``;
            rooms.innerHTML = ``;
            controls.style.display = `none`;
            return socket.emit('room', room);
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
                for (let e of rooms) {
                    salas.innerHTML += `
                        <div class="room">
                            <span> ${e.name} - ${e.size}/10</span>
                            <button type="submit" onClick=joinRoom(${e.id})>Entrar a la sala</button>
                        </div>
                    `;
                }
            });
        });
    </script>
</div>
