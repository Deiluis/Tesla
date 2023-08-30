<div class="content-wrapper" id="ver-exposicion">
    <h2></h2>
    <div id="rooms"><button onClick="reloadRooms()">Recargar salas</button></div>
    <div id="controls"></div>
    <img id="play" style="display:none">
    <script>
        const socket = io("http://localhost:7777");
        const img = document.getElementById('play');
        const controls = document.querySelector('#controls');
        const salas = document.querySelector('#rooms');
        socket.on("connect_error", (error) => {
            document.querySelector('h2').innerHTML = "Error en conexión";
        });
        const room = {id: ''}
        function joinRoom(roomSelect){
            if (roomSelect < 1 && document.querySelector('#room').value === '') {
                return alert('Escribe el ID de una sala');
            }
            room.id = document.querySelector('#room').value || roomSelect.toString()
            controls.innerHTML = `
                <button onclick="quitRoom(this)" style="margin-bottom: 5px">Salir de la sala</button>
            `;
            salas.innerHTML = ``;
            controls.classList.add('emitir');
            return socket.emit('room', room);
        }
        function reloadRooms(){
            if(room.id){
                return;
            }
            return socket.emit('reloadRooms');
        }
        function quitRoom(){
            socket.emit('quitRoom', room);
            room.id = '';
            salas.innerHTML = `
                <button onClick="reloadRooms()">Recargar salas</button>
            `;
            controls.classList.remove('emitir');
            controls.innerHTML = `
                <input id="room" type="number">
                <button type="submit" onClick=joinRoom()>Entrar a la sala</button>
            `;
            img.src = '';
        }
        socket.on("connect", () => {
            controls.innerHTML = `
                <input id="room" type="number">
                <button type="submit" onClick=joinRoom()>Entrar a la sala</button>
            `;
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
