<div class="content-wrapper" id="ver-exposicion">
    <h2>Ver exposicion</h2>
    <img id="play">
</div>
<script type="text/javascript" src='http://181.45.18.185:7777/socket.io/socket.io.js'></script>
<script>
    const socket = io();
    const img = document.getElementById('play');
    socket.on('stream', (image) => {
        img.src = image;
    })
</script>