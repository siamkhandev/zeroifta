@extends('layouts.new_main')

@section('content')

<div class="dashbord-inner">
        <h3>Tracking {{ $userName }} Location</h3>
        <div class="row">
            <!-- Left Card with User and Trip Info -->
            <div class="col-md-4">
    <div class="card shadow-lg p-4 mb-4 bg-white rounded" style="margin-top: 20px;">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th class="text-primary">Driver Name</th>
                            <td>{{ $userName }}</td>
                        </tr>
                        <tr>
                            <th class="text-primary">Trip Start Date</th>
                            <td>{{ $trip->created_at }}</td>
                        </tr>
                        <tr>
                            <th class="text-primary">Trip Starting Point</th>
                            <td>{{ $startAddress }}</td>
                        </tr>
                        <tr>
                            <th class="text-primary">Trip Ending Point</th>
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

    let currentInfoWindow = null;

$.get('/api/get-fuel-stations/' + userId, function(response) {
    if (response.status == 200) {
        response.data.forEach(station => {
            console.log(`Lat: ${station.latitude}, Lng: ${station.longitude}`);

            const stationCircle = new google.maps.Circle({
                strokeColor: "#0000FF",  // Blue color
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#0000FF",  // Blue color fill
                    fillOpacity: 1,
                map: map,
                center: { lat: parseFloat(station.latitude), lng: parseFloat(station.longitude) },
                radius: 5000  // Larger radius for better visibility
            });

            // Create the InfoWindow with custom styling for red background
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="background-color: #FF0000; color: white; padding: 10px 15px; border-radius: 5px; text-align: center; height: auto; max-height: 80px;">
                        <strong>${station.name}</strong>
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

function drawRoute(start, end) {
    if (startMarker) startMarker.setMap(null);
    if (endMarker) endMarker.setMap(null);

    startMarker = new google.maps.Marker({
        position: start,
        map: map,
        icon: '{{asset("assets/img/location-blue.png")}}',
        url: '{{asset("assets/img/location-blue.png")}}',  // Path to the custom icon
        scaledSize: new google.maps.Size(40, 40),  // Resize the icon if necessary
        anchor: new google.maps.Point(20, 40)
    });

    endMarker = new google.maps.Marker({
        position: end,
        map: map,
        icon: '{{asset("assets/img/location-green.png")}}',
        url: '{{asset("assets/img/location-green.png")}}',  // Path to the custom icon
        scaledSize: new google.maps.Size(40, 40),  // Resize the icon if necessary
        anchor: new google.maps.Point(20, 40)
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
