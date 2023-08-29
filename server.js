const express = require('express')
const app = express()
const server = require('http').createServer(app)
const port = process.env.PORT || 7777
const io = require("socket.io")(server, {
  cors: {
    origin: "*",
  }
});
const rooms = []
io.on('connection', (socket) => {
  socket.on('room', (room) => {
    let roomFind = rooms.find((e) => e.id === room.id);
    if (!roomFind){
      return rooms.push({ id: room.id, name: room.name, size: 1})
    }
    socket.join(room.id); //Une al socket a la sala
    roomFind.size = socket.adapter.rooms.get(room.id).size + 1;
  })
  socket.on('reloadRooms', () => {
    socket.emit('reloadRooms', rooms)
  })
  socket.on('stream', (video) => {
    socket.to(video.roomId).emit('stream', video.stream); //Emitir el evento a todos los sockets conectados a la sala
  })
})

server.listen(port, () => {
  console.log(`Express server listening on port ${port}`)
})