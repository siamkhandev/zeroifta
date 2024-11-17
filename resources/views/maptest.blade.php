<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map with Markers</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg"></script>
    <style>
        #map {
            height: 100vh;
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

<!-- Add Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>

<h3>Fuel Stations on Route</h3>
<div id="map"></div>

<script>
// Define the API URL (use the correct route for your Laravel API)
const apiUrl = '/api/findgas'; // Change to your API route

// Example coordinates (replace with actual start and end coordinates)
const startLat = 33.798877;
const startLng = -84.398553;
const endLat = 39.7615548;
const endLng = -104.774469;

// Create the request data
const requestData = {
    start_lat: startLat,
    start_lng: startLng,
    end_lat: endLat,
    end_lng: endLng,
};

// Fetch the matching records from your Laravel API
fetch(apiUrl, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    body: JSON.stringify(requestData),
})
.then(response => response.json()) // Parse the JSON response
.then(data => {
    if (data.status === 200) {
        // Handle the matching records in the response
        const matchingRecords = data.data;

        // Example of initializing the map (assuming you've set up the map already)
        const map = L.map('map').setView([startLat, startLng], 13); // Adjust zoom level as needed

        // Add a tile layer (this is just an example; you can use your own provider)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Loop through the matching records and add markers for FTP locations
        matchingRecords.forEach(record => {
            const { ftp_lat, ftp_lng, price, distance } = record;

            // Create a marker for each matching FTP location
            const marker = L.marker([ftp_lat, ftp_lng]).addTo(map);

            // Optional: Add a popup with price and distance information
            marker.bindPopup(`
                <b>Price: $${price}</b><br>
                Distance: ${distance.toFixed(2)} meters
            `);
        });
    } else {
        console.error('Error fetching data:', data.message);
    }
})
.catch(error => {
    console.error('Error:', error);
});
</script>

</body>
</html>
