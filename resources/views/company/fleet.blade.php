@extends('layouts.new_main')

@section('content')

    <div class="dashbord-inner">
        <!-- Section 1 -->
        <div class="fleetV_main mb-4">
            <div class="Filters-main mb-3 mb-md-4">
                <div class="sec1-style">
                    <div class="tabele_filter">
                        <div class="tabFilt_left">
                            <!-- Tab 1 -->
                            <div class="sd2-filter">
                                <span class="d-sel">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>
                                            <span>Entity</span>
                                        </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </span>
                            </div>
                            <!-- Tab 2 -->
                            <div class="sd2-filter">
                                <span class="d-sel">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>
                                            <span>Duty Status</span>
                                        </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </span>
                            </div>
                            <!-- Tab 3 -->
                            <div class="sd2-filter">
                                <span class="d-sel">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>
                                            <span>Dispatch Status</span>
                                        </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </span>
                            </div>
                            <!-- Tab 3 -->
                            <div class="sd2-filter">
                                <span class="d-sel">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>
                                            <span>Vehicle With MIL On</span>
                                        </option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3">
                        <div class="buttons">
                            <a class="blueLine_btn clear-filter" href="#">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="24" viewBox="0 0 27 24" fill="none">
                                        <path
                                            d="M13.2123 20C10.7533 20 8.67056 19.225 6.96396 17.675C5.25735 16.125 4.40405 14.2333 4.40405 12C4.40405 9.76667 5.25735 7.875 6.96396 6.325C8.67056 4.775 10.7533 4 13.2123 4C14.4785 4 15.6896 4.2375 16.8457 4.7125C18.0018 5.1875 18.9927 5.86667 19.8185 6.75V4H22.0206V11H14.3134V9H18.9377C18.3505 8.06667 17.5476 7.33333 16.5292 6.8C15.5107 6.26667 14.4051 6 13.2123 6C11.3773 6 9.81747 6.58333 8.53293 7.75C7.24839 8.91667 6.60612 10.3333 6.60612 12C6.60612 13.6667 7.24839 15.0833 8.53293 16.25C9.81747 17.4167 11.3773 18 13.2123 18C14.6253 18 15.9007 17.6333 17.0384 16.9C18.1761 16.1667 18.9744 15.2 19.4332 14H21.7453C21.2315 15.7667 20.1855 17.2083 18.6074 18.325C17.0292 19.4417 15.2309 20 13.2123 20Z"
                                            fill="#092E75"
                                        />
                                    </svg>
                                </span>
                                <span>Clear Filter</span>
                            </a>
                            <a href="#" class="mainBtn status-btn">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M3 7L8 2L13 7L11.6 8.425L9 5.825L9 21L7 21L7 5.825L4.4 8.425L3 7ZM11 17L12.4 15.575L15 18.175L15 3L17 3L17 18.175L19.6 15.575L21 17L16 22L11 17Z"
                                            fill="white"
                                        />
                                    </svg>
                                </span>
                                <span>Status</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sec1-style">
                <div class="fleet-main">
                    <div class="fleet-inn">
                        <div class="sec1-style">
                            <div class="vehicle-list">
                                <div class="vehTabs-main">
                                @foreach($drivers as $driver)
                                    <div class="vh-tab mb-3">
                                        <div class="vh-tabIn">
                                            <div>
                                                <span>
                                                @if($driver->trips)
                                                <a  href="{{ route('driver.track', $driver->driver->id) }}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M13.0969 20C12.9555 19.9985 12.8182 19.9527 12.7042 19.869C12.5902 19.7853 12.5053 19.668 12.4615 19.5335L9.48686 10.5016L0.454929 7.53376C0.322093 7.48779 0.206891 7.40155 0.125354 7.28705C0.0438167 7.17254 0 7.03547 0 6.8949C0 6.75434 0.0438167 6.61726 0.125354 6.50276C0.206891 6.38826 0.322093 6.30202 0.454929 6.25604L19.0934 0.0364476C19.2131 -0.00452136 19.3419 -0.0110995 19.4651 0.0174604C19.5883 0.0460203 19.701 0.108572 19.7904 0.198008C19.8799 0.287444 19.9424 0.400176 19.971 0.52339C19.9996 0.646605 19.993 0.77536 19.952 0.895023L13.7324 19.5335C13.6886 19.668 13.6037 19.7853 13.4897 19.869C13.3757 19.9527 13.2383 19.9985 13.0969 20ZM2.81432 6.89153L10.2508 9.32528C10.3519 9.3583 10.4437 9.41469 10.5189 9.48986C10.5941 9.56504 10.6504 9.65689 10.6835 9.75795L13.1172 17.1944L18.2619 1.76712L2.81432 6.89153Z"
                                                            fill="#19A130"
                                                        />
                                                    </svg></a>
                                                    @endif
                                                </span>
                                                <span class="v-lov ps-2">88713</span>
                                            </div>
                                            <div>
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M12.7501 13.917L13.9167 12.7503L10.8334 9.66699V5.83366H9.16675V10.3337L12.7501 13.917ZM10.0001 18.3337C8.8473 18.3337 7.76397 18.1149 6.75008 17.6774C5.73619 17.2399 4.85425 16.6462 4.10425 15.8962C3.35425 15.1462 2.7605 14.2642 2.323 13.2503C1.8855 12.2364 1.66675 11.1531 1.66675 10.0003C1.66675 8.84755 1.8855 7.76421 2.323 6.75032C2.7605 5.73644 3.35425 4.85449 4.10425 4.10449C4.85425 3.35449 5.73619 2.76074 6.75008 2.32324C7.76397 1.88574 8.8473 1.66699 10.0001 1.66699C11.1529 1.66699 12.2362 1.88574 13.2501 2.32324C14.264 2.76074 15.1459 3.35449 15.8959 4.10449C16.6459 4.85449 17.2397 5.73644 17.6772 6.75032C18.1147 7.76421 18.3334 8.84755 18.3334 10.0003C18.3334 11.1531 18.1147 12.2364 17.6772 13.2503C17.2397 14.2642 16.6459 15.1462 15.8959 15.8962C15.1459 16.6462 14.264 17.2399 13.2501 17.6774C12.2362 18.1149 11.1529 18.3337 10.0001 18.3337ZM10.0001 16.667C11.8473 16.667 13.4202 16.0177 14.7188 14.7191C16.0174 13.4205 16.6667 11.8475 16.6667 10.0003C16.6667 8.1531 16.0174 6.58019 14.7188 5.28157C13.4202 3.98296 11.8473 3.33366 10.0001 3.33366C8.15286 3.33366 6.57994 3.98296 5.28133 5.28157C3.98272 6.58019 3.33341 8.1531 3.33341 10.0003C3.33341 11.8475 3.98272 13.4205 5.28133 14.7191C6.57994 16.0177 8.15286 16.667 10.0001 16.667Z"
                                                            fill="#979797"
                                                        />
                                                    </svg>
                                                </span>
                                                <span class="v-time ps-1">3hrs ago</span>
                                            </div>
                                        </div>
                                        <div class="pt-3">
                                            <h4>{{ $driver->driver->name }}</h4>
                                            @if($driver->trips)
                                <!-- <a style="font-weight: bold; color: blue;" href="{{ route('driver.track', $driver->driver->id) }}">
                                    Track Location
                                </a> -->
                            @else
                                <p class="text-muted mt-2">No trip found</p>
                            @endif
                                            <span id="status-{{ $driver->driver->id }}"
                                      class="status-circle"
                                      style="display:inline-block; width:10px; height:10px; background-color:yellow; border-radius:50%; margin-top: -35px;float:right"></span>
                                        </div>

                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="fleet-map">
                            <div class="mapouter">
                                <div class="gmap_canvas" id="map">

                                </div>
                            </div>
                        </div>
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
        // Initialize the map centered at Lahore, Pakistan
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: { lat: 39.5501, lng: -105.7821 } // Center at Lahore
        });

        // Establish connection to Socket.IO server
        const socket = io('http://zeroifta.alnairtech.com:3000');

        // Listen for real-time driver location updates
        socket.on('driverLocationUpdate', function(data) {
            const driverId = data.driver_id;
            const driverLatLng = { lat: parseFloat(data.lat), lng: parseFloat(data.lng) };

            // Update driver status to online (green circle)
            updateDriverStatus(driverId, 'green');

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

        // Listen for driver disconnection
        socket.on('driverDisconnected', function(data) {
            const driverId = data.driver_id;

            // Update driver status to offline (yellow circle)
            updateDriverStatus(driverId, 'yellow');

            // Check if a marker for this driver exists
            if (driverMarkers[driverId]) {
                // Remove the marker from the map
                driverMarkers[driverId].setMap(null);

                // Delete the marker from the driverMarkers object
                delete driverMarkers[driverId];
            }
        });
    }

    // Function to update the driver's status
    function updateDriverStatus(driverId, color) {
        const statusCircle = document.getElementById(`status-${driverId}`);
        if (statusCircle) {
            statusCircle.style.backgroundColor = color;
        }
    }
</script>
@endsection
