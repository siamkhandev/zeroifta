const express = require('express');
const http = require('http'); // Use http instead of https
const app = express();
const server = http.createServer(app); // Create an HTTP server
const io = require('socket.io')(server, {
    cors: { origin: "*" }
});

io.on('connection', (socket) => {
    console.log('User connected');

    // Listen for the user location update
    socket.on('userLocation', (data) => {
        console.log(`Received location for user ${data.user_id}: ${data.lat}, ${data.lng}`);
        // Broadcast location to all clients (including admin panel)
        io.emit('locationUpdate', data);
    });

    socket.on('disconnect', () => {
        console.log('User disconnected');
    });
});

server.listen(3000, () => {
    console.log('Socket.IO server is running on port 3000');
});
