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

// Connection TCP received data
//var net = require('net');
//
//var HOST = '192.168.250.2';
//var PORT = 2001;
//
//var client = new net.Socket();
//client.connect(PORT, HOST, function () {
//   console.log('CONNECTED : ' + HOST + ' : ' + PORT);
//   // Write a message to the socket as soon as the client is connected, the server will receive it as message from the client
//   client.write('I am Cahya Satya');
//});
//// Add a 'data' event handler for the client socket
//// data is what the server sent to this socket
//client.on('data', function (data) {
//    console.log('Data : ' + data);
//    // Close the client socket completely
//    client.destroy();
//});
//
//// Add a 'close' event handler for the client socket
//client.on('close', function() {
//  console.log('Connection closed');
//});

// server start
http.listen(port, function(){
	console.log("Node server listening on port " + port);
});