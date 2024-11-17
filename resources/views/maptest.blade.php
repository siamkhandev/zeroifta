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
    .then(response => response.json())
    .then(data => {
        // Initialize the map
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: { lat: startLat, lng: startLng }, // You can dynamically adjust this
        });

        // Loop through the fetched data and add markers to the map
        data.forEach(record => {
            const { ftp_lat, ftp_lng, price } = record;

            // Add marker to map for each matching FTP record
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(ftp_lat), lng: parseFloat(ftp_lng) },
                map: map,
                title: `Price: $${price}`,
            });

            // Add an info window to display price when clicked
            const infoWindow = new google.maps.InfoWindow({
                content: `<strong>Fuel Price:</strong> $${price}`,
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        });
    })
    .catch(error => {
        console.error('Error fetching matching records:', error);
    });
</script>

</body>
</html>
