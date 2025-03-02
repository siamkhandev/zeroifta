const express = require('express');
const http = require('http');
const axios = require('axios'); // To fetch trip details from Laravel API
const polyline = require('@mapbox/polyline'); // To decode polylines
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

    // Listen for location updates from the frontend
    socket.on('userLocation', async (data) => {
        console.log(`Received location for user ${data.user_id}: ${data.lat}, ${data.lng}`);

        // Store or update driver location
        const driverIndex = drivers.findIndex(driver => driver.id === data.user_id);
        if (driverIndex !== -1) {
            drivers[driverIndex].lat = data.lat;
            drivers[driverIndex].lng = data.lng;
        } else {
            drivers.push({ id: data.user_id, lat: data.lat, lng: data.lng });
        }

        // Fetch trip details from Laravel API
        try {
            const response = await axios.post('https://staging.zeroifta.com/api/check-active-trip', {
                trip_id: data.trip_id
            });
            const trip = response.data; // Expected to return {start_lat, start_lng, end_lat, end_lng}

            if (!trip) {
                console.log("Trip not found");
                return;
            }

            const { start_lat, start_lng, end_lat, end_lng } = trip;

            // Get polyline route using Google Directions API (or your own stored polyline)
            const polylineResponse = await axios.get(`https://maps.googleapis.com/maps/api/directions/json`, {
                params: {
                    origin: `${start_lat},${start_lng}`,
                    destination: `${end_lat},${end_lng}`,
                    key: "AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg"
                }
            });

            if (polylineResponse.data.routes.length === 0) {
                console.log("No route found");
                return;
            }

            const encodedPolyline = polylineResponse.data.routes[0].overview_polyline.points;
            const polylinePoints = polyline.decode(encodedPolyline); // Decode polyline into array of lat/lng pairs

            // Check if driver is within range of any polyline point
            const withinRange = isWithinRange(data.lat, data.lng, polylinePoints);

            if (!withinRange) {
                console.log(`Driver ${data.user_id} is off-route. Recalculating route...`);
                socket.emit("new_route", {
                    new_start_lat: data.lat,
                    new_start_lng: data.lng,
                    end_lat,
                    end_lng
                });
                try {
                    await axios.post('https://staging.zeroifta.com/api/trip/update', {
                        trip_id: data.trip_id,
                        start_lat: data.lat,
                        start_lng: data.lng,
                        end_lat: trip.end_lat,
                        end_lng: trip.end_lng,
                        truck_mpg: trip.truck_mpg,
                        fuel_tank_capacity: trip.fuel_tank_capacity,
                        total_gallons_present: trip.fuel_left,
                        reserve_fuel:trip.reserve_fuel,
                    });

                    console.log(`Trip ${data.trip_id} updated successfully!`);
                } catch (updateError) {
                    console.error("Failed to update trip start location:", updateError);
                }
            }
        } catch (error) {
            console.error("Error fetching trip data", error);
        }

        // Broadcast updated location to all connected clients
        io.emit('driverLocationUpdate', {
            driver_id: data.user_id,
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
