@extends('layouts.new_main')

@section('content')
<div class="dashbord-inner">
    <div class="container mt-5">
        <!-- Pills Navigation -->
        <!-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-live-tab" data-toggle="pill" href="#pills-live" role="tab" aria-controls="pills-live" aria-selected="true">Live</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-history-tab" data-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">History</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
            </li>
        </ul> -->

        <!-- Pills Content -->
        <div class="tab-content" id="pills-tabContent">
            <!-- Live Tab Content -->
            <div class="tab-pane fade show active" id="pills-live" role="tabpanel" aria-labelledby="pills-live-tab">
                <div id="mapContainer">
                    <div id="map" style="width: 100%; height: 500px;"></div>
                </div>
            </div>

            <!-- History Tab Content -->
            <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
                <h4>History coming soon.</h4>
            </div>

            <!-- Profile Tab Content -->
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h4>Profile coming soon.</h4>
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
                fillOpacity: 0.35,
                map: map,
                center: { lat: parseFloat(station.latitude), lng: parseFloat(station.longitude) },
                radius: 100 // Decrease radius to make the circle smaller (in meters)
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `<strong>${station.name}</strong>`
            });

            // Add event listeners for mouseover and mouseout to show and hide info window
            google.maps.event.addListener(stationCircle, 'mouseover', function() {
                infoWindow.setPosition(stationCircle.getCenter());
                infoWindow.open(map);
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
