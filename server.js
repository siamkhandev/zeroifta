const express = require('express');
const http = require('http'); // Use http instead of https
const app = express();
const server = http.createServer(app); // Create an HTTP server
const io = require('socket.io')(server, {
    cors: { origin: "*" }
});

// Array to hold driver data
let drivers = [];

io.on('connection', (socket) => {
    console.log('User connected');

    // Listen for location updates from the Android app
    socket.on('userLocation', (data) => {
        console.log(`Received location for user ${data.user_id}: ${data.lat}, ${data.lng}`);

        // Check if the driver already exists in the drivers array
        const driverIndex = drivers.findIndex(driver => driver.id === data.user_id);

        if (driverIndex !== -1) {
            // Update the existing driver's location
            drivers[driverIndex].lat = data.lat;
            drivers[driverIndex].lng = data.lng;
        } else {
            // Add new driver to the array if they don't exist
            drivers.push({
                id: data.user_id,
                lat: data.lat,
                lng: data.lng,
                name: data.driver_name // Assuming driver name is sent with location
            });
        }

        // Broadcast updated location to all connected clients
        io.emit('driverLocationUpdate', {
            driver_id: data.user_id,
            driver_name: data.driver_name,
            lat: data.lat,
            lng: data.lng
        });
    });

    socket.on('disconnect', () => {
        console.log('A user disconnected');
    });
});

// Start the server
server.listen(3000, () => {
    console.log('Socket.IO server is running on port 3000');
});