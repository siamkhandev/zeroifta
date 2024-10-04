<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Location Simulation</title>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
</head>
<body>
    <h1>User Location Simulation (Driver ID: 13 & 14)</h1>

    <script>
        const socket = io('http://localhost:3000');  // Socket.io server address

        // Coordinates for driver 13 (Lahore to Islamabad)
        const driver13Locations = [
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

        // Coordinates for driver 14 (Islamabad to Lahore)
        const driver14Locations = [
            { lat: 33.6844, lng: 73.0479 },  // Islamabad
            { lat: 33.6938, lng: 73.0652 },  // Near Islamabad
            { lat: 31.5204, lng: 74.3587 },  // Near Faisalabad
            { lat: 31.3185, lng: 72.3210 },  // Near Jhang
            { lat: 32.0800, lng: 75.0126 },  // Near Narowal
            { lat: 32.4964, lng: 74.5434 },  // Near Sialkot
            { lat: 32.4110, lng: 74.1344 },  // Near Wazirabad
            { lat: 32.1614, lng: 74.1898 },  // Near Gujranwala
            { lat: 31.7131, lng: 73.9783 },  // Near Sheikhupura
            { lat: 31.5497, lng: 74.3436 }   // Lahore
        ];

        let index13 = 0;
        let index14 = 0;

        // Function to send location update for driver 13
        function sendDriver13Location() {
            if (index13 < driver13Locations.length) {
                const currentLocation = driver13Locations[index13];
                socket.emit('userLocation', {
                    user_id: 13,  // Driver ID 13
                    lat: currentLocation.lat,
                    lng: currentLocation.lng
                });
                console.log(`Driver 13 sent location: ${currentLocation.lat}, ${currentLocation.lng}`);
                index13++;
            }
        }

        // Function to send location update for driver 14
        function sendDriver14Location() {
            if (index14 < driver14Locations.length) {
                const currentLocation = driver14Locations[index14];
                socket.emit('userLocation', {
                    user_id: 14,  // Driver ID 14
                    lat: currentLocation.lat,
                    lng: currentLocation.lng
                });
                console.log(`Driver 14 sent location: ${currentLocation.lat}, ${currentLocation.lng}`);
                index14++;
            }
        }

        // Simulate sending locations every 3 seconds for each driver
        const simulation = setInterval(() => {
            sendDriver13Location();
            sendDriver14Location();
            if (index13 >= driver13Locations.length && index14 >= driver14Locations.length) {
                console.log("Simulation complete");
                clearInterval(simulation);  // Stop the simulation when both are done
            }
        }, 3000);
    </script>
</body>
</html>
