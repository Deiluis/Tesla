const { Console } = require('console');
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
    socket.join(room.id);
    if (!roomFind){
      return rooms.push({ id: room.id, name: room.name, size: 1})
    }
    roomFind.size = socket.adapter.rooms.get(room.id).size;
  })
  socket.on('reloadRooms', () => {
    for (let i = rooms.length - 1; i >= 0; i--) {
      let roomFind = socket.adapter.rooms.get(rooms[i].id) || { size: 0 };
      rooms[i].size = roomFind.size;
      if (rooms[i].size < 1) {
        rooms.splice(i, 1);
      }
    }
    socket.emit('reloadRooms', rooms)
  })
  socket.on('quitRoom', (room) => {
    socket.leave(room.id);
  })
  socket.on('stream', (video) => {
    socket.to(video.roomId).emit('stream', video.stream); //Emitir el evento a todos los sockets conectados a la sala
  })
})
server.listen(port, () => {
  console.log(`Express server listening on port ${port}`)
})