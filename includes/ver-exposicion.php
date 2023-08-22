<div class="content-wrapper" id="ver-exposicion">
    <!-- <h2>Ver exposición</h2> -->
    <img id="play">
    <script>
        const socket = io("http://localhost:7777");
        const img = document.getElementById('play');
        socket.on('stream', (image) => {
            img.src = image;
        })
    </script>
</div>
