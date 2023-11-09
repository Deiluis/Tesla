const express = require('express');
const app = express();
const sql = require('mysql');
require('dotenv').config();

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

let rooms = []
let allData = [];

app.use(express.static('public'));

app.route('/api/computers')
  .get(function(req, res){
    const json = [];
    allData.forEach((e) => {
      json.push(JSON.parse(e[2]));
    });
    conn.query("INSERT INTO notifications (laboratory_id, computer, information) VALUES ?", [allData], function (err, res) {
      if (err) console.log('Hubo un error al subir los records', err);
    });
    allData = [];
    res.send(json);
  })
  .post(function(req, res) {
    let data = '';
    req.on('data', chunk => {
      data += chunk;
    });
    req.on('end', () => {
      let pc = JSON.parse(data).host.split('-');
      let info = [`${pc[0]}`, `${parseInt(pc[1].replace('PC', ''))}`, `${data}`];
      allData.push(info);
      console.log(JSON.parse(data))
    });
    res.end('OK');
  });

// Funciones de socket.io para exponer.
io.on('connection', (socket) => {

	socket.on('createRoom', (room) => {
		let roomFind = rooms.find((e) => e.id === room.id);
		
		if (roomFind) {
			return `Ya existe una sala con el ID ${room.id}`;
		} else {
			socket.join(room.id);
			return rooms.push({ id: room.id, name: room.name, size: 1});
		}
	})

	// Unirse a una sala.
	socket.on('joinRoom', (room) => {
		let roomFind = rooms.find((e) => e.id === room.id);
		let joined = false;
		let message = "";

		// Analiza si la room solicitada existe.
		if (roomFind) {
			socket.join(room.id);
			joined = true;
			roomFind.size = socket.adapter.rooms.get(room.id).size;
			socket.to(room.id).emit('newSize', roomFind.size);
		} else {
			joined = false;
			message = `No existe una sala con el ID ${room.id}`
		}

		socket.emit("joinStatus", joined, roomFind, message);
	});

	// Recargar salas.
	socket.on('reloadRooms', () => {
		for (let i = rooms.length - 1; i >= 0; i--) {
			let roomFind = socket.adapter.rooms.get(rooms[i].id) || { size: 0 };
			rooms[i].size = roomFind.size;
			if (rooms[i].size < 1) {
				rooms.splice(i, 1);
			}
		}
		socket.emit('reloadRooms', rooms);
	});

	// Salir de una sala.
	socket.on('quitRoom', (room) => {
		socket.leave(room.id);

		let roomSize = socket.adapter.rooms.get(room.id)?.size;
		socket.to(room.id).emit('newSize', roomSize);
	});

	// Cierra la sala y la elimina del array.
	socket.on('closeRoom', (room) => {
		let roomFind = rooms.find((e) => e.id === room.id);
		
		if (roomFind) {
			// Saca a todos de la sala.
			socket.leave(room.id);
			socket.to(room.id).emit("closeRoom");

			// Busca el indice de la sala en el array de salas, y la elimina.
			let roomIndex = rooms.findIndex((e) => e.id === room.id);
			rooms[roomIndex] = null;

			// Filtra las salas nulas para solo dejar las válidas.
			rooms = rooms.filter(room => room != null);
		}
	});

	//Emitir el evento a todos los sockets conectados a la sala.
	socket.on('stream', (video) => {
		socket.to(video.roomId).emit('stream', video.stream);
	});

});

server.listen(port, () => {
  	console.log(`Express server listening on port ${port}`)
});