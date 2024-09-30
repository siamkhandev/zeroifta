@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <!-- Pills Navigation -->
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-live-tab" data-toggle="pill" href="#pills-live" role="tab" aria-controls="pills-live" aria-selected="true">Live</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-history-tab" data-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">History</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
            </li>
        </ul>

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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&callback=initMap" async defer></script>

    <script>
        let map, routePath, userMarker, startMarker, endMarker;
        const socket = io('http://zeroifta.alnairtech.com:3000');  // Socket.io server URL
        const userId = {{ $userId }};  // Pass the userId from blade

        function initMap() {
            // Initialize the map if the Live tab is active
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

        // Handle tab change
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            const target = $(e.target).attr("href");  // Get the tab's target id
            
            if (target === '#pills-live') {
                // Remove any old map element and reinitialize it when switching to Live tab
                $('#mapContainer').html('<div id="map" style="width: 100%; height: 500px;"></div>');
                initMap();
            } else {
                // Completely remove the map from the DOM when switching to History or Profile
                $('#mapContainer').empty();
            }
        });

        // Trigger map initialization on page load
        $(document).ready(function() {
            initMap();
        });
    </script>
@endsection
