<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map with Markers</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&callback=initMap" async defer></script>
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
// Initialize the map
let map;

function initMap() {
    // Example coordinates (replace with actual start and end coordinates)
    const startLat = 33.798877;
    const startLng = -84.398553;
    const endLat = 39.7615548;
    const endLng = -104.774469;

    // Create the map centered around the start point
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: startLat, lng: startLng },
    });

    // Create the request data
    const requestData = {
        start_lat: startLat,
        start_lng: startLng,
        end_lat: endLat,
        end_lng: endLng,
        truck_mpg:8,
        fuel_tank_capacity:500,
        total_gallons_present:120,
    };

    // Fetch the matching records from your Laravel API
    fetch('/api/findgas', {
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
        if (data.status == 200) {
            // Check if 'data.data' is an array
            if (Array.isArray(data.data)) {
                const matchingRecords = data.data;

                // Loop through the matching records and add markers for FTP locations
                matchingRecords.forEach(record => {
                    const { ftp_lat, ftp_lng, price, distance, is_optimal } = record;

                    // Convert ftp_lat and ftp_lng to numbers using parseFloat
                    const lat = parseFloat(ftp_lat);
                    const lng = parseFloat(ftp_lng);

                    // Validate that lat and lng are valid numbers
                    if (!isNaN(lat) && !isNaN(lng)) {
                        // Define marker icon based on is_optimal
                        const icon = is_optimal
                            ? 'http://maps.google.com/mapfiles/ms/icons/green-dot.png' // Green for optimal
                            : 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'; // Red for non-optimal

                        // Create a marker for each matching FTP location
                        const marker = new google.maps.Marker({
                            position: { lat: lat, lng: lng },
                            map: map,  // This is the initialized map object
                            title: 'Fuel Station',
                            icon: icon // Set the icon for the marker
                        });

                        // Optional: Add an info window to display price and distance information
                        const infoWindow = new google.maps.InfoWindow({
                            content: `<b>Price: $${price}</b><br>Distance: ${distance ? distance.toFixed(2) : 'N/A'} meters<br>Optimal: ${is_optimal ? 'Yes' : 'No'}`
                        });

                        // Attach the info window to the marker
                        marker.addListener('click', function() {
                            infoWindow.open(map, marker);
                        });
                    } else {
                        console.error('Invalid coordinates for marker:', lat, lng);
                    }
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
}
</script>

</body>
</html>
