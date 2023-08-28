<div class="content-wrapper" id="exposicion">
    <div id="controls"></div>
    <div id="emitir" style="display: none">
        <video id="video" style="width: 100%; height: 100%" autoplay="true"></video>
        <canvas id="preview" style="display:none"></canvas>
        <button onclick="emitir()" style="margin-bottom: 5px">Emitir</button>
    </div>
    <script>
        const socket = io("http://localhost:7777");
        const controls = document.querySelector('#controls');
        const streamConfig = { video: {cursor: "always"}, audio: false }
        const video = document.getElementById('video');
        const canvas = document.getElementById('preview');
        const context = canvas.getContext('2d');
        canvas.width = 1600;
        canvas.height = canvas.width * 0.5;
        context.width = canvas.width;
        context.height = canvas.height;

        socket.on("connect_error", (error) => {
            document.querySelector('h2').innerHTML = "Error en conexion";
        });
        let roomId;
        function audioChange(e){
            streamConfig.audio = !streamConfig.audio;
            e.classList.toggle('active');
        }
        function joinRoom(){
            if (document.querySelector('#room').value === '') {
                return alert('Please type a room ID');
            }
            roomId = document.querySelector('#room').value
            controls.innerHTML += ``;
            controls.style.display = `none`;
            document.querySelector('#emitir').style.display = `block`;
            return socket.emit('room', roomId);
        }

        function loadCam(stream) {
            video.srcObject = stream
        }

        function emitir(){
            navigator.mediaDevices.getDisplayMedia(streamConfig).then(loadCam).catch(() => {
                console.log('errors with the media device')
            })
            const intervalo = setInterval(() => {
                context.drawImage(video, 0, 0, context.width, context.height);
                socket.emit('stream', { stream: canvas.toDataURL('image/webp'), roomId});
            }, 1000)
        }
        socket.on("connect", () => {
            controls.innerHTML = `
                <input id="room" type="number">
                <button type="submit" onClick=joinRoom()>Crear sala</button>
                <button onClick="audioChange(this)">Audio</button>
            `;
        });

    </script>
</div>