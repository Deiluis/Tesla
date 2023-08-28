const express = require('express')
const app = express()
const server = require('http').createServer(app)
const io = require("socket.io")(server, {
  cors: {
    origin: "*",
  }
});
app.set("view engine", "hbs");
app.set("views", __dirname + "\\views");
app.use('/', express.static('public'))
app.get('/profesor', function(req, res, next) {
  res.render('profesor');
});
io.on('connection', (socket) => {
  socket.on('room', (roomId) => {
    socket.join(roomId); //Une al socket a la sala
  })
  socket.on('stream', (video) => {
    socket.to(video.roomId).emit('stream', video.stream); //Emitir el evento a todos los sockets conectados
  })
})

// INICIO DEL SERVIDOR =================================================================
const port = process.env.PORT || 7777
server.listen(port, () => {
  console.log(`Express server listening on port ${port}`)
})