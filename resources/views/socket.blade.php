<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Location Simulation (Lahore to Islamabad)</title>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
</head>
<body>
    <h1>User Location Simulation (ID: 1)</h1>

    <script>
        const socket = io('https://zeroifta.alnairtech.com');  // Socket.io server address

        // Coordinates for the simulation (from Lahore to Islamabad)
        const locations = [
            { lat: 31.5497, lng: 74.3436 },  // Lahore
            { lat: 31.7131, lng: 73.9783 },  // Near Sheikhupura
            { lat: 32.1614, lng: 74.1898 },  // Near Gujranwala
            { lat: 32.4110, lng: 74.1344 },  // Near Wazirabad
            { lat: 32.4964, lng: 74.5434 },  // Near Sialkot
            { lat: 32.0800, lng: 75.0126 },  // Near Narowal
            { lat: 31.3185, lng: 72.3210 },  // Near Jhang
            { lat: 31.5204, lng: 74.3587 },  // Near Faisalabad
            { lat: 33.6938, lng: 73.0652 },  // Near Islamabad
            { lat: 33.6844, lng: 73.0479 }   // Islamabad
        ];

        let index = 0;

        // Function to send location update to the Socket.io server
        function sendLocation() {
            if (index < locations.length) {
                const currentLocation = locations[index];
                socket.emit('userLocation', {
                    user_id: 13,  // User ID 1
                    lat: currentLocation.lat,
                    lng: currentLocation.lng
                });
                console.log(`Sent location: ${currentLocation.lat}, ${currentLocation.lng}`);
                index++;
            } else {
                console.log("Simulation complete");
                clearInterval(simulation);  // Stop the simulation
            }
        }

        // Simulate sending location every 3 seconds
        const simulation = setInterval(sendLocation, 3000);
    </script>
</body>
</html>
