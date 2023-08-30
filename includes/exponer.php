<div class="content-wrapper" id="exposicion" style="padding: 0">
    <div id="controls"></div>
    <div id="emitir" style="display: none">
        <video id="video" style="width: 100%; height: 100%" autoplay="true"></video>
        <canvas id="preview" style="display:none"></canvas>
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
            document.querySelector('h2').innerHTML = "Error en conexión";
        });
        const room = {id: '', name: ''}
        function audioChange(e){
            streamConfig.audio = !streamConfig.audio;
            e.classList.toggle('active');
        }
        function joinRoom(){
            if (document.querySelector('#room').value === '') {
                return alert('Please type a room ID');
            }
            room.id = document.querySelector('#room').value
            room.name = document.querySelector('#roomName').value
            controls.innerHTML = `
                <button onclick="emitir(this)" style="margin-bottom: 5px">Emitir</button>
                <button onclick="stop(this)" style="margin-bottom: 5px; display: none;" id="stopEmit">Dejar de transmitir</button>
            `;
            controls.classList.add('emitir');
            document.querySelector('#emitir').style.display = `block`;
            return socket.emit('room', room);
        }

        function emitir(e){
            navigator.mediaDevices.getDisplayMedia(streamConfig).then((stream) => {video.srcObject = stream;e.nextElementSibling.style.display = "block";}).catch(() => {console.log('Error en emisión')})
            const intervalo = setInterval(() => {
                context.drawImage(video, 0, 0, context.width, context.height);
                socket.emit('stream', { stream: canvas.toDataURL('image/webp'), roomId: room.id});
            }, 1000)
        }
        function stop(e){
            e.style.display = "none";
            let tracks = video.srcObject.getTracks();
            tracks.forEach(track => track.stop());
            video.srcObject = null;
        }
        socket.on("connect", () => {
            controls.innerHTML = `
                <input id="room" type="number" placeholder="ID de la Sala">
                <input id="roomName" type="text" placeholder="Nombre">
                <button type="submit" onClick=joinRoom()>Crear sala</button>
                <button onClick="audioChange(this)">Audio</button>
            `;
        });
    </script>
</div>