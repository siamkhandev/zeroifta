@extends('layouts.new_main')

@section('content')

<div class="dashbord-inner">
        <h3>{{__('messages.Tracking')}} {{ $userName }} {{__('messages.Location')}}</h3>
        <div class="row">
            <!-- Left Card with User and Trip Info -->
            <div class="col-md-4">
    <div class="card shadow-lg p-4 mb-4 bg-white rounded" style="margin-top: 20px;">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="text-primary">{{__('messages.Driver Name')}}</th>
                            <td>{{ $userName }}</td>
                        </tr>
                        <tr>
                            <th class="text-primary">{{__('messages.Trip Start Date')}}</th>
                            <td>{{ $trip->created_at }}</td>
                        </tr>
                        <tr>
                            <th class="text-primary">{{__('messages.Trip Starting Point')}}</th>
                            <td>{{ $startAddress }}</td>
                        </tr>
                        <tr>
                            <th class="text-primary">{{__('messages.Trip Ending Point')}}</th>
                            <td>{{ $endAddress }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Additional Cards or Content can go here -->
</div>

            <!-- Right Map Container -->
            <div class="col-md-8">
                <div id="mapContainer">
                    <div id="map" style="width: 100%; height: 500px;"></div>
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
const socket = io('https://ws.zeroifta.com');  // Socket.io server URL
const userId = {{ $userId }};  // Pass the userId from blade
let stopMarkers = []; // Global variable to store stop markers

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: { lat: 39.5501, lng: -105.7821 } // Default to Lahore
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

        const waypoints = trip.stops.map(stop => ({
            location: new google.maps.LatLng(parseFloat(stop.lat), parseFloat(stop.lng)),
            stopover: true
        }));

        drawRoute(start, end, waypoints); // Pass waypoints to drawRoute function

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



    let currentInfoWindow = null;

    $.get('/api/get-fuel-stations/' + userId, function(response) {
    if (response.status == 200) {
        response.data.forEach(station => {
            // Set circle color based on is_optimal value
            const circleColor = station.is_optimal ? "#14a832" : "#0000FF"; // Green if optimal, Blue if not

            const stationCircle = new google.maps.Circle({
                strokeColor: circleColor,  // Blue color if not optimal, Green if optimal
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: circleColor,    // Green fill if optimal, Blue fill if not
                fillOpacity: 0.4,
                map: map,
                center: { lat: parseFloat(station.latitude), lng: parseFloat(station.longitude) },
                radius: 5000  // Larger radius for better visibility
            });

            // Create the InfoWindow with a dynamic background color based on is_optimal
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="background-color: ${station.is_optimal ? '#14a832' : '#0000FF'}; color: white; padding: 10px 15px; border-radius: 5px; text-align: center; height: auto; max-height: 80px;">
                        <strong>${'$' + station.price + '/Gallon'}</strong>
                    </div>
                `,
                disableAutoPan: true // Prevent map from panning when opening the InfoWindow
            });

            google.maps.event.addListener(stationCircle, 'mouseover', function() {
                if (currentInfoWindow) {
                    currentInfoWindow.close();
                }
                infoWindow.setPosition(stationCircle.getCenter());
                infoWindow.open(map);
                currentInfoWindow = infoWindow;
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

function drawRoute(start, end, waypoints = []) {
    // Remove existing markers if any
    if (startMarker) startMarker.setMap(null);
    if (endMarker) endMarker.setMap(null);
    if (stopMarkers) stopMarkers.forEach(marker => marker.setMap(null));

    // Initialize an empty array to store stop markers
    stopMarkers = [];

    // Create markers for stops
    waypoints.forEach((waypoint, index) => {
        let stopMarker = new google.maps.Marker({
            position: waypoint.location,
            map: map,
            icon: '{{asset("assets/img/location-orange.png")}}', // Use a different icon for stops
            scaledSize: new google.maps.Size(30, 30)
        });

        stopMarkers.push(stopMarker);
    });

    // Create markers for start and end points
    startMarker = new google.maps.Marker({
        position: start,
        map: map,
        icon: '{{asset("assets/img/location-blue.png")}}',
        scaledSize: new google.maps.Size(40, 40)
    });

    endMarker = new google.maps.Marker({
        position: end,
        map: map,
        icon: '{{asset("assets/img/location-blue.png")}}',
        scaledSize: new google.maps.Size(40, 40)
    });

    // Initialize the Directions Service and Renderer
    const directionsService = new google.maps.DirectionsService();
    if (!routeRenderer) {
        routeRenderer = new google.maps.DirectionsRenderer();
        routeRenderer.setMap(map);
    }

    // Request route with waypoints
    directionsService.route({
        origin: start,
        destination: end,
        waypoints: waypoints, // Include waypoints
        optimizeWaypoints: true, // Optional: Optimizes route order
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

<!-- Additional Styles -->
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .user-info-card {
        background-color: #f7f7f7;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .user-info {
        margin-bottom: 15px;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
    }

    .user-info strong {
        color: #007bff;
    }

    .user-info span {
        color: #333;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }

    #mapContainer {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }
</style>
@endsection
