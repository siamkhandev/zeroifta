@extends('layouts.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            @if(Session::has('success'))
                <div class="alert alert-success" style="color:white">{{ Session::get('success') }}</div>
            @endif
        </div>

        <div class="row">
            <!-- Users Column (4 Columns) -->
            <div class="col-md-4">
                <h4>Users</h4>
                <ul class="list-group">
                    @foreach($drivers as $driver)
                        <li class="list-group-item">
                            <h6>{{ $driver->driver->name }}</h6>

                            @if($driver->trips->isNotEmpty())
                                <a style="font-weight: bold; color: blue;" href="{{ route('driver.track', $driver->driver->id) }}">
                                    Track Location
                                </a>
                            @else
                                <p class="text-muted mt-2">No trip found</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Map Column (8 Columns) -->
            <div class="col-md-8">
                <h4>Fleet View</h4>
                <div id="map" style="width: 100%; height: 500px;">
                    <!-- Embed your map here (Google Maps, OpenStreetMap, etc.) -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Including Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&callback=initMap" async defer></script>

<script>
    let map;
    let driverMarkers = {}; // Store markers for each driver by driver ID

    function initMap() {
        // Initialize the map centered at a default location (USA)
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: { lat: 39.8283, lng: -98.5795 } // Center of USA
        });

        // Establish connection to Socket.IO server
        const socket = io('http://zeroifta.alnairtech.com:3000');

        // Listen for real-time driver location updates
        socket.on('driverLocationUpdate', function(data) {
            const driverId = data.driver_id;
            const driverLatLng = { lat: parseFloat(data.lat), lng: parseFloat(data.lng) };
            
            // Check if a marker for this driver already exists
            if (driverMarkers[driverId]) {
                // Update marker position
                driverMarkers[driverId].setPosition(driverLatLng);
            } else {
                // Create a new marker for the driver
                const marker = new google.maps.Marker({
                    position: driverLatLng,
                    map: map,
                    title: `Driver`,
                    icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                });

                // Store the marker by driver ID
                driverMarkers[driverId] = marker;
            }
        });
    }
</script>
@endsection
