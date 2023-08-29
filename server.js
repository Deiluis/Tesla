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
  socket.on('room', (roomId) => {
    socket.join(roomId); //Une al socket a la sala
    let room = rooms.find((e) => e.room === roomId);
    if (!room){
      return rooms.push({ room: roomId, users: socket.adapter.rooms.get(roomId).size})
    }
    room.users = socket.adapter.rooms.get(roomId).size;
  })
  socket.on('reloadRooms', () => {
    console.log(rooms);
    socket.emit('reloadRooms', rooms)
  })
  socket.on('stream', (video) => {
    socket.to(video.roomId).emit('stream', video.stream); //Emitir el evento a todos los sockets conectados a la sala
  })
})

server.listen(port, () => {
  console.log(`Express server listening on port ${port}`)
})