var express = require('express'),
app = express(),
http = require('http').Server(app),
io = require('socket.io')(http),
port = 3000;

app.get('/', function(req, res){
	res.send("<h1>It works!</h1>");
});

io.on('connection', function(socket){
	console.log('new client connected');
	socket.on('disconnet', function(){
		console.log('a client disconnect');	
	})
	socket.on('notif',function(msg){
		console.log('message: '+msg.name);
		io.emit('notif', {name: msg.name});
	})
        socket.on('gagal', function(){
            console.log('message: gagal input data');
            io.emit('gagal');
        })
});
// Arduino to CMD
//const SerialPort = require('serialport');
//const Readline = SerialPort.parsers.Readline;
//const usbport = new SerialPort('COM4');
//const parser = usbport.pipe(new Readline());
//parser.on('data', function(data){
//    console.log('data : '+data.kode);
//    io.emit('data', {data: data});
//})

// server start
http.listen(port, function(){
	console.log("Node server listening on port " + port);
});