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
.then(response => response.json()) // Parse the JSON response
            .then(data => {
                // Ensure the response status is OK
                if (data.status === 200) {
                    // Check if 'data.data' is an array
                    if (Array.isArray(data.data)) {
                        const matchingRecords = data.data;

                        // Loop through the matching records and add markers for FTP locations
                        matchingRecords.forEach(record => {
                            const { ftp_lat, ftp_lng, price, distance } = record;

                            // Create a marker for each matching FTP location
                            const marker = new google.maps.Marker({
                                position: { lat: ftp_lat, lng: ftp_lng },
                                map: map,
                                title: 'Fuel Station'
                            });

                            // Optional: Add an info window to display price and distance information
                            const infoWindow = new google.maps.InfoWindow({
                                content: `<b>Price: $${price}</b><br>Distance: ${distance.toFixed(2)} meters`
                            });

                            // Attach the info window to the marker
                            marker.addListener('click', function() {
                                infoWindow.open(map, marker);
                            });
                        });
                    } else {
                        console.error('The data field is not an array:', data.data);
                    }
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
