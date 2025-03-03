const express = require('express');
const http = require('http');
const axios = require('axios'); // For making API calls
const polyline = require('@mapbox/polyline'); // For decoding polylines
const app = express();
const server = http.createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*" }
});

// Array to hold driver data
let drivers = [];

// Function to calculate distance in miles using Haversine formula
function getDistance(lat1, lon1, lat2, lon2) {
    const R = 3958.8; // Radius of the Earth in miles
    const dLat = (lat2 - lat1) * (Math.PI / 180);
    const dLon = (lon2 - lon1) * (Math.PI / 180);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * (Math.PI / 180)) *
        Math.cos(lat2 * (Math.PI / 180)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

// Function to check if driver is within 10 miles of any polyline point
function isWithinRange(driverLat, driverLng, polylinePoints) {
    for (const [lat, lng] of polylinePoints) {
        const distance = getDistance(driverLat, driverLng, lat, lng);
        if (distance <= 10) {
            return true; // Driver is within range of at least one point
        }
    }
    return false; // Driver is too far from all polyline points
}

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
            });
        }

        // Broadcast updated location to all connected clients
        io.emit('driverLocationUpdate', {
            driver_id: data.user_id,
            lat: data.lat,
            lng: data.lng
        });
    });

    // New event to handle trip deviation check
    socket.on('checkTripDeviation', async (data) => {
        const { trip_id, user_id, lat, lng } = data;
        console.log(`Checking trip deviation for user ${user_id} on trip ${trip_id}`);

        try {
            // Fetch trip details from Laravel API
            const tripResponse = await axios.post('https://staging.zeroifta.com/api/check-active-trip', {
                trip_id: trip_id
            });

            const trip = tripResponse.data; // Expected to return {start_lat, start_lng, end_lat, end_lng}

            if (!trip) {
                console.log("Trip not found");
                return;
            }

            const { start_lat, start_lng, end_lat, end_lng } = trip.trip;

            // Get polyline route using Google Directions API
            const polylineResponse = await axios.get(`https://maps.googleapis.com/maps/api/directions/json`, {
                params: {
                    origin: `${start_lat},${start_lng}`,
                    destination: `${end_lat},${end_lng}`,
                    key: "AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg" // Replace with your Google Maps API key
                }
            });

            if (polylineResponse.data.routes.length === 0) {
                console.log("No route found");
                return;
            }

            // Decode the polyline into an array of coordinates
            const encodedPolyline = polylineResponse.data.routes[0].overview_polyline.points;
            const polylinePoints = polyline.decode(encodedPolyline);

            // Check if the driver is within 10 miles of any polyline point
            const withinRange = isWithinRange(lat, lng, polylinePoints);

            if (!withinRange) {
                console.log(`Driver ${user_id} is off-route. Recalculating route...`);

                // Emit event to frontend that the driver has deviated
                socket.emit('routeDeviation', {
                    user_id: user_id,
                    trip_id: trip_id,
                    message: "Driver has deviated from the route. Recalculating..."
                });

                // Call the update trip API to update the start location
                try {
                    const updateResponse = await axios.post('https://staging.zeroifta.com/api/trip/update', {
                        trip_id: trip_id,
                        start_lat: lat,
                        start_lng: lng,
                        end_lat: end_lat,
                        end_lng: end_lng,
                        truck_mpg: trip.trip.truck_mpg,
                        fuel_tank_capacity: trip.trip.fuel_tank_capacity,
                        total_gallons_present: trip.trip.fuel_left,
                        reserve_fuel: trip.trip.reserve_fuel,
                    });

                    console.log("Trip updated successfully:", updateResponse.data);
                } catch (updateError) {
                    console.error("Failed to update trip:", updateError.response ? updateError.response.data : updateError.message);
                }
            } else {
                console.log(`Driver ${user_id} is on route.`);
            }
        } catch (error) {
            console.error("Error checking trip deviation:", error.response ? error.response.data : error.message);
        }
    });

    socket.on('disconnect', () => {
        console.log('A user disconnected');
    });
});

// Start the server
server.listen(4000, () => {
    console.log('Socket.IO server is running on port 4000');
});
