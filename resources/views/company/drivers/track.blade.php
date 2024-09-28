<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track User Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Tracking Location for User ID: {{ $userId }}</h1>
        <div id="map"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&callback=initMap" async defer></script>
    <script>
        let map, routePath, userMarker, startMarker, endMarker;
        const socket = io('http://zeroifta.alnairtech.com:3000');  // Socket.io server URL
        const userId = {{ $userId }};  // Pass the userId from blade

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: { lat: 31.5497, lng: 74.3436 }  // Default to Lahore
            });

            routePath = new google.maps.Polyline({
                path: [],
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 3
            });
            routePath.setMap(map);

            userMarker = new google.maps.Marker({
                map: map,
                icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            });

            // Fetch trip data
            $.get('/api/user-trip/' + userId, function(response) {
                if (response.status === 'success') {
                    const trip = response.data;
                    const start = new google.maps.LatLng(parseFloat(trip.start_lat), parseFloat(trip.start_lng));
                    const end = new google.maps.LatLng(parseFloat(trip.end_lat), parseFloat(trip.end_lng));

                    drawRoute(start, end);

                    socket.on('locationUpdate', function(data) {
                        const { user_id, lat, lng } = data;
                        if (user_id === userId) {
                            const currentLocation = new google.maps.LatLng(lat, lng);
                            userMarker.setPosition(currentLocation);
                            map.setCenter(currentLocation);
                        }
                    });
                } else {
                    alert(response.message);
                }
            });
        }

        function drawRoute(start, end) {
            if (startMarker) startMarker.setMap(null);
            if (endMarker) endMarker.setMap(null);

            startMarker = new google.maps.Marker({
                position: start,
                map: map,
                label: "Start"
            });

            endMarker = new google.maps.Marker({
                position: end,
                map: map,
                label: "End"
            });

            routePath.setPath([start, end]);

            const bounds = new google.maps.LatLngBounds();
            bounds.extend(start);
            bounds.extend(end);
            map.fitBounds(bounds);
        }
    </script>
</body>
</html>
