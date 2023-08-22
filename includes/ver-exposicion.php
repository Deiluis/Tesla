<div class="content-wrapper" id="ver-exposicion">
    <h2></h2>
    <div id="controls"></div>
    <img id="play" style="display:none">
    <script>
        const socket = io("http://localhost:7777");
        const controls = document.querySelector('#controls');
        socket.on("connect_error", (error) => {
            document.querySelector('h2').innerHTML = "Error en conexion";
        });
        let roomId;
        function joinRoom(){
            if (document.querySelector('#room').value === '') {
                return alert('Please type a room ID');
            }
            roomId = document.querySelector('#room').value
            controls.innerHTML = ``;
            controls.style.display = `none`;
            return socket.emit('room', roomId);
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
        });
    </script>
</div>
