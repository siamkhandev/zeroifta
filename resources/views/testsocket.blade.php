<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socket.IO Test - Driver Location</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Driver Location Test</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="userId" class="form-label">Driver ID</label>
                    <input type="text" class="form-control" id="userId" value="22">
                </div>
                <div class="mb-3">
                    <label for="tripId" class="form-label">Trip ID</label>
                    <input type="text" class="form-control" id="tripId" value="125">
                </div>
                <div class="mb-3">
                    <label for="lat" class="form-label">Latitude</label>
                    <input type="text" class="form-control" id="lat" value="34.052235">
                </div>
                <div class="mb-3">
                    <label for="lng" class="form-label">Longitude</label>
                    <input type="text" class="form-control" id="lng" value="-118.243683">
                </div>
                <button id="sendLocation" class="btn btn-primary">Send Location</button>
            </div>
            <div class="col-md-6">
                <h3>Server Responses</h3>
                <ul id="responses" class="list-group"></ul>
            </div>
        </div>
        <div id="map"></div>
    </div>

    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&callback=initMap" async defer></script>

    <script>
        // Initialize Socket.IO connection
        const socket = io('https://ws.zeroifta.com');

        // Initialize Google Map
        let map;
        let driverMarker;
        let routePolyline;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 34.019321, lng: -118.116076 }, // Default to trip start location
                zoom: 10
            });

            // Add a marker for the driver
            driverMarker = new google.maps.Marker({
                position: { lat: 34.019321, lng: -118.116076 },
                map: map,
                title: 'Driver Location'
            });

            // Add a polyline for the route
            routePolyline = new google.maps.Polyline({
                path: [],
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2,
                map: map
            });
        }

        // Listen for server responses
        socket.on('driverLocationUpdate', (data) => {
            const responseItem = document.createElement('li');
            responseItem.className = 'list-group-item';
            responseItem.textContent = `Driver ${data.driver_id} updated to: ${data.lat}, ${data.lng}`;
            document.getElementById('responses').appendChild(responseItem);

            // Update driver marker on the map
            driverMarker.setPosition({ lat: data.lat, lng: data.lng });
            map.panTo({ lat: data.lat, lng: data.lng });
        });

        socket.on('new_route', (data) => {
            const responseItem = document.createElement('li');
            responseItem.className = 'list-group-item';
            responseItem.textContent = `New route calculated: Start (${data.new_start_lat}, ${data.new_start_lng}), End (${data.end_lat}, ${data.end_lng})`;
            document.getElementById('responses').appendChild(responseItem);

            // Update the polyline on the map
            const newRoutePath = [
                { lat: data.new_start_lat, lng: data.new_start_lng },
                { lat: data.end_lat, lng: data.end_lng }
            ];
            routePolyline.setPath(newRoutePath);
        });

        // Send location data to the server
        document.getElementById('sendLocation').addEventListener('click', () => {
            const userId = document.getElementById('userId').value;
            const tripId = document.getElementById('tripId').value;
            const lat = document.getElementById('lat').value;
            const lng = document.getElementById('lng').value;

            const data = {
                user_id: userId,
                trip_id: tripId,
                lat: parseFloat(lat),
                lng: parseFloat(lng)
            };

            socket.emit('userLocation', data);
            console.log('Location sent:', data);
        });
    </script>
</body>
</html>