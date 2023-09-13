const express = require('express')
const app = express()
const sql = require('mysql')
require('dotenv').config()
const conn = sql.createConnection({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER ||  "root",
  password: process.env.DB_PASS ||  "",
  database: process.env.DB_DATABASE ||  "tesla"
});
conn.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});
const server = require('http').createServer(app)
const port = process.env.PORT || 7777
const io = require("socket.io")(server, {
  cors: {
    origin: "*",
  }
});
const rooms = []
let allData = [];
app.post('/api/computers', function(req, res) {
  let data = '';
  req.on('data', chunk => {
    data += chunk;
  });
  req.on('end', () => {
    let pc = JSON.parse(data).host.split('-');
    let info = [`${pc[0]}`, `${pc[1]}`, `${data}`];
    allData.push(info);
    console.log(JSON.parse(data))
  });
  res.end('OK');
});
app.get('/api/computers', function(req, res){
  const json = [];
  allData.forEach((e) => {
    json.push(JSON.parse(e[2]));
  });
  conn.query("INSERT INTO computers (laboratory_id, pc, information) VALUES ?", [allData], function (err, res) {
    if (err) console.log('Hubo un error al subir los records', err);
  });
  allData = [];
  res.send(json);
})
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