@extends('layouts.new_main')

@section('content')
<div class="dashbord-inner">
    <div class="container mt-5">
        <div class="row">
            <!-- Left Card with User and Trip Info -->
            <div class="col-md-4">
                <div class="card shadow-sm p-3 mb-4 bg-white rounded">
                    <div class="card-body">
                        <h4 class="card-title">User Info</h4>
                        <p><strong>Name:</strong> {{ $userName }}</p>
                        <p><strong>Trip Start:</strong> {{ $trip->created_at }}</p>
                        <p><strong>Trip Starting point:</strong>Test</p>
                        <p><strong>Trip Ending point:</strong> Test</p>
                    </div>
                </div>

                <!-- More cards or content can go here -->

            </div>

            <!-- Right Map Container -->
            <div class="col-md-8">
                <div id="mapContainer">
                    <div id="map" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&callback=initMap" async defer></script>

<script>
let map, routeRenderer, userMarker, startMarker, endMarker;
const socket = io('http://zeroifta.alnairtech.com:3000');  // Socket.io server URL
const userId = {{ $userId }};  // Pass the userId from blade

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: { lat: 31.5497, lng: 74.3436 }  // Default to Lahore
    });

    routeRenderer = new google.maps.DirectionsRenderer({
        map: map,
        suppressMarkers: true // Prevents the default markers for start and end points
    });

    userMarker = new google.maps.Marker({
        map: map,
        icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
    });

    // Fetch trip data
    $.get('/api/user-trip/' + userId, function(response) {
        if (response.status == 200) {
            const trip = response.data;
            const start = { lat: parseFloat(trip.start_lat), lng: parseFloat(trip.start_lng) };
            const end = { lat: parseFloat(trip.end_lat), lng: parseFloat(trip.end_lng) };

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

    $.get('/api/get-fuel-stations/' + userId, function(response) {
        if (response.status == 200) {
            response.data.forEach(station => {
                // Create a smaller blue circle for each fuel station
                const stationCircle = new google.maps.Circle({
                    strokeColor: "#0000FF",  // Blue color
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#0000FF",  // Blue color fill
                    fillOpacity: 1,
                    map: map,
                    center: { lat: parseFloat(station.latitude), lng: parseFloat(station.longitude) },
                    radius: 100 // Radius in meters
                });

                // Create the InfoWindow with custom styling for blue background
                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="background-color: #0000FF; color: white; padding: 10px 15px; border-radius: 5px; text-align: center; height: auto; max-height: 80px;">
                            <strong>${station.name}</strong>
                        </div>
                    `,
                    disableAutoPan: true // To prevent map from panning when opening the InfoWindow
                });

                google.maps.event.addListener(stationCircle, 'mouseover', function() {
                    infoWindow.setPosition(stationCircle.getCenter());
                    infoWindow.open(map);

                    // Hide the default close button by targeting the class
                    const closeButton = document.querySelectorAll('.gm-ui-hover-effect');
                    closeButton.forEach(button => button.style.display = 'none');
                });

                google.maps.event.addListener(stationCircle, 'mouseout', function() {
                    infoWindow.close();
                });
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

    const directionsService = new google.maps.DirectionsService();
    directionsService.route({
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(result, status) {
        if (status === google.maps.DirectionsStatus.OK) {
            routeRenderer.setDirections(result);
        } else {
            console.error('Error fetching directions', result);
        }
    });
}

// Handle tab change
$('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    const target = $(e.target).attr("href");

    if (target === '#pills-live') {
        $('#mapContainer').html('<div id="map" style="width: 100%; height: 500px;"></div>');
        initMap();
    } else {
        $('#mapContainer').empty();
    }
});

// Trigger map initialization on page load
$(document).ready(function() {
    initMap();
});
</script>
@endsection
