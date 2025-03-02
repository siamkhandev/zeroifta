<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Deviation Test</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Maps API -->
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&libraries=geometry&callback=initMap"></script>
    
    <!-- Socket.IO -->
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>

    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Driver Deviation Testing</h2>

    <div class="row">
        <div class="col-md-12">
            <div id="map"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <button class="btn btn-success w-100" onclick="simulateOnRoute()">Simulate On-Route</button>
        </div>
        <div class="col-md-6">
            <button class="btn btn-danger w-100" onclick="simulateOffRoute()">Simulate Off-Route</button>
        </div>
    </div>
</div>

<script>
    let map, polyline, driverMarker;
    const socket = io("https://ws.zeroifta.com");  // Replace with your Socket.IO server

    const startPoint = { lat: 34.019321, lng: -118.116076 };  // Los Angeles
    const endPoint = { lat: 39.740062, lng: -104.986160 };  // Denver

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: startPoint,
            zoom: 6,
        });

        // Draw route
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer({ map });

        directionsService.route({
            origin: startPoint,
            destination: endPoint,
            travelMode: google.maps.TravelMode.DRIVING
        }, (response, status) => {
            if (status === "OK") {
                directionsRenderer.setDirections(response);
                polyline = response.routes[0].overview_path;
            }
        });

        // Create Driver Marker
        driverMarker = new google.maps.Marker({
            position: startPoint,
            map,
            title: "Driver",
            icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
        });
    }

    function getDistance(lat1, lng1, lat2, lng2) {
        return google.maps.geometry.spherical.computeDistanceBetween(
            new google.maps.LatLng(lat1, lng1),
            new google.maps.LatLng(lat2, lng2)
        ) / 1609.34; // Convert meters to miles
    }

    function isDriverOffRoute(driverLat, driverLng) {
        return polyline.every(point => getDistance(driverLat, driverLng, point.lat(), point.lng()) > 10);
    }

    function updateDriverLocation(lat, lng) {
        driverMarker.setPosition(new google.maps.LatLng(lat, lng));
        map.setCenter({ lat, lng });

        if (isDriverOffRoute(lat, lng)) {
            console.log("Driver is off-route! Updating route...");
            socket.emit("new_route", { 
                new_start_lat: lat, 
                new_start_lng: lng, 
                end_lat: endPoint.lat, 
                end_lng: endPoint.lng 
            });
        } else {
            console.log("Driver is still on-route.");
        }
    }

    function simulateOnRoute() {
        updateDriverLocation(34.5, -117.0); // Move driver near the route
    }

    function simulateOffRoute() {
        updateDriverLocation(35.2, -120.0); // Move driver 10+ miles away
    }

    socket.on("route_updated", (data) => {
        alert("New Route Updated: " + JSON.stringify(data));
    });
</script>

</body>
</html>
