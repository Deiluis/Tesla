const express = require('express')
const app = express()
const server = require('http').createServer(app)
const port = process.env.PORT || 7777
const io = require("socket.io")(server, {
  cors: {
    origin: "*",
  }
});

io.on('connection', (socket) => {
  socket.on('room', (roomId) => {
    socket.join(roomId); //Une al socket a la sala
  })
  socket.on('stream', (video) => {
    socket.to(video.roomId).emit('stream', video.stream); //Emitir el evento a todos los sockets conectados a la sala
  })
})

server.listen(port, () => {
  console.log(`Express server listening on port ${port}`)
})