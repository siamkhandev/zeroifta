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
                                <a style="font-weight: bold;
    color: blue;" href="{{route('driver.track',$driver->driver->id)}}">
                                    Track Location</a>
                            @else
                                <p class="text-muted mt-2">No trip found</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Map Column (8 Columns) -->
            <div class="col-md-8">
                <h4></h4>
                <div id="map" style="width: 100%; height: 500px;">
                    <!-- Embed your map here (Google Maps, OpenStreetMap, etc.) -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg&callback=initMap" async defer></script>
    <script>
    let map;
    let routePaths = [];

    function initMap() {
        // Initialize the map centered at a default location
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center: { lat: 31.5497, lng: 74.3436 } // Default to Lahore
        });

        // Pass all drivers and their trips data from backend to frontend
        const drivers = @json($drivers);

        // Iterate over each driver and their trips
        drivers.forEach(driver => {
            driver.trips.forEach(trip => {
                const startLatLng = { lat: parseFloat(trip.start_lat), lng: parseFloat(trip.start_lng) };
                const endLatLng = { lat: parseFloat(trip.end_lat), lng: parseFloat(trip.end_lng) };

                // Draw the polyline for the trip route
                const routePath = new google.maps.Polyline({
                    path: [startLatLng, endLatLng],
                    geodesic: true,
                    strokeColor: '#FF0000',
                    strokeOpacity: 1.0,
                    strokeWeight: 3,
                    map: map
                });

                // Add markers at the start and end points of the trip
                new google.maps.Marker({
                    position: startLatLng,
                    map: map,
                    title: 'Start',
                    icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png'
                });

                new google.maps.Marker({
                    position: endLatLng,
                    map: map,
                    title: 'End',
                    icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png'
                });

                // Store the routePath in case we need to manipulate it later
                routePaths.push(routePath);
            });
        });
    }
</script>
@endsection
