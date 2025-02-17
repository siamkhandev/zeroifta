<?php

namespace App\Http\Controllers;

use App\Models\CompanyDriver;
use App\Models\DriverVehicle;
use App\Models\FcmToken;
use App\Models\FuelStation;
use App\Models\Notification as ModelsNotification;
use App\Models\Trip;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

use App\Models\Tripstop;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class IFTAController extends Controller
{
    public function findCheapestFuelStops(Request $request)
    {
        $route = $request->route; // Assuming route data is passed in the request
        $currentGallons = $request->currentGallons;
        $reserveGallons = 45; // Example reserve
        $desiredAdditionalEndingGallons = 0; // Example desired ending gallons

        list($routeWithStops, $remainingGallons) = $this->stopsAlgorithm($route, $currentGallons, $reserveGallons, $desiredAdditionalEndingGallons);

        return response()->json([
            'routeWithStops' => $routeWithStops,
            'remainingGallons' => $remainingGallons
        ]);
    }

    private function stopsAlgorithm($route, $currentGallons, $reserveGallons, $desiredAdditionalEndingGallons)
{


    // Calculate the total fuel needed for the route
    $fuelNeeded = $this->gallonsOfFuel($route['miles'], $route['truckMPG']) + $reserveGallons + $desiredAdditionalEndingGallons;

    // If the current fuel is sufficient, no stop is needed
    if ($fuelNeeded <= $currentGallons) {
        return [[], $currentGallons - $fuelNeeded];
    } else {
        // If a fuel stop is necessary
        $fuelStop = $this->findCheapestFuelStop($route);
        $routeSegmentA = $this->createRouteSegment($route['start'], $fuelStop['location'], $route);

        // Calculate for the first segment
        $gallonsUsedSegmentA = $this->gallonsOfFuel($routeSegmentA['miles'], $routeSegmentA['truckMPG']);
        $remainingGallonsAfterSegmentA = $currentGallons - $gallonsUsedSegmentA;

        // Calculate the amount of fuel to buy
        $gallonsToBuy = min(
            $this->amountOfFuelNeeded($routeSegmentA['miles'], $routeSegmentA['truckMPG']) + $reserveGallons + $desiredAdditionalEndingGallons,
            $route['truckTankCapacity']
        ) - $remainingGallonsAfterSegmentA;

        $stopsData = [
            ['fuelStop' => $fuelStop, 'gallonsToBuy' => $gallonsToBuy]
        ];

        // Update the route for the next segment
        $remainingMiles = $route['miles'] - $routeSegmentA['miles'];



        if ($remainingMiles > 0) {
            $routeSegmentB = $this->createRouteSegment($fuelStop['location'], $route['destination'], [
                'miles' => $remainingMiles,
                'truckMPG' => $route['truckMPG'],
                'truckTankCapacity' => $route['truckTankCapacity'],
                'start' => $fuelStop['location'],
                'destination' => $route['destination']
            ]);

            $remainingGallonsAfterBuying = $gallonsToBuy + $remainingGallonsAfterSegmentA;

            // Recursive call for the remaining segment
            list($segBstopsData, $gallonsRemaining) = $this->stopsAlgorithm($routeSegmentB, $remainingGallonsAfterBuying, $reserveGallons, $desiredAdditionalEndingGallons);

            return [array_merge($stopsData, $segBstopsData), $gallonsRemaining];
        } else {
            // In case there are no remaining miles, return the current data
            return [$stopsData, $gallonsToBuy + $remainingGallonsAfterSegmentA];
        }
    }
}


    private function gallonsOfFuel($miles, $MPG)
    {
        return $miles / $MPG;
    }

    private function amountOfFuelNeeded($miles, $MPG)
    {
        return $this->gallonsOfFuel($miles, $MPG);
    }

    private function findCheapestFuelStop($route)
    {
        // Implement your logic to find the cheapest fuel stop along the route.
        // This is a placeholder for demonstration purposes.
        return [
            'location' => 'Some Fuel Station',
            //'pricePerGallon' => 3.50
        ];
    }

    private function createRouteSegment($start, $end, $route)
    {
        // Check if 'segments' key exists in the route array
        if (isset($route['segments'])) {
            // Find the segment of the route that starts at $start and ends at $end
            foreach ($route['segments'] as $segment) {
                if ($segment['start'] === $start && $segment['end'] === $end) {
                    return [
                        'start' => $segment['start'],
                        'end' => $segment['end'],
                        'miles' => $segment['miles'],
                        'truckMPG' => $segment['truckMPG'],
                        'truckTankCapacity' => $route['truckTankCapacity']
                    ];
                }
            }
        }

        // Fallback if the 'segments' key doesn't exist or the segment is not found
        return [
            'start' => $start,
            'end' => $end,
            'miles' => $route['miles'], // Using full route miles if segment not found
            'truckMPG' => $route['truckMPG'],
            'truckTankCapacity' => $route['truckTankCapacity']
        ];
    }

    public function findFuelStations(Request $request)
{
    $request->validate([
        'start_lat' => 'required|numeric',
        'start_lng' => 'required|numeric',
        'end_lat' => 'required|numeric',
        'end_lng' => 'required|numeric',
    ]);

    $startLat = $request->input('start_lat');
    $startLng = $request->input('start_lng');
    $endLat = $request->input('end_lat');
    $endLng = $request->input('end_lng');

    $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';

    // Step 1: Get the route
    $directionsUrl = "https://maps.googleapis.com/maps/api/directions/json?origin=$startLat,$startLng&destination=$endLat,$endLng&key=$apiKey";
    $directionsResponse = Http::get($directionsUrl);

    if ($directionsResponse->failed()) {
        return response()->json(['error' => 'Failed to fetch directions'], 500);
    }

    $directionsData = $directionsResponse->json();

    if (empty($directionsData['routes'])) {
        return response()->json(['error' => 'No route found for the given coordinates'], 404);
    }

    $steps = collect($directionsData['routes'][0]['legs'][0]['steps']);

    // Step 2: Extract waypoints
    $waypoints = $steps->map(fn($step) => [
        'lat' => $step['end_location']['lat'],
        'lng' => $step['end_location']['lng'],
    ]);

    // Step 3: Find truck stops along the waypoints
    $truckStops = collect();
    foreach ($waypoints as $point) {
        $lat = $point['lat'];
        $lng = $point['lng'];

        $placesUrl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=$lat,$lng&radius=5000&keyword=truck+stop&key=$apiKey";
        $placesResponse = Http::get($placesUrl);

        if ($placesResponse->failed()) {
            continue;
        }

        $placesData = $placesResponse->json();
        foreach ($placesData['results'] as $place) {
            $truckStops->push([
                'name' => $place['name'],
                'address' => $place['vicinity'],
                'lat' => $place['geometry']['location']['lat'],
                'lng' => $place['geometry']['location']['lng'],
                'place_id' => $place['place_id'],
            ]);
        }
    }

    // Remove duplicates by `place_id`
    $uniqueTruckStops = $truckStops->unique('place_id')->values();

    return response()->json(['truck_stops' => $uniqueTruckStops]);
}
    public function updateTrip(Request $request)
    {
        $validatedData =$request->validate([
            'trip_id' => 'required|exists:trips,id',
            'start_lat' => 'required',
            'start_lng' => 'required',
            'end_lat' => 'required',
            'end_lng' => 'required',
            'truck_mpg' => 'required',
            'fuel_tank_capacity' => 'required',
            'total_gallons_present' => 'required',
        ]);
        $startLat = $request->start_lat;
        $startLng = $request->start_lng;
        $endLat = $request->end_lat;
        $endLng = $request->end_lng;
        $truckMpg = $request->truck_mpg;
        $fuelTankCapacity = $request->fuel_tank_capacity;
        $currentFuel = $request->total_gallons_present;
        // Replace with your Google API key
        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
        $stops = Tripstop::where('trip_id', $request->trip_id)->get();
        if ($stops->isNotEmpty()) {
            $waypoints = $stops->map(fn($stop) => "{$stop->stop_lat},{$stop->stop_lng}")->implode('|');
        }
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";
        if (isset($waypoints)) {
            $url .= "&waypoints=optimize:true|{$waypoints}";
        }
        // Fetch data from Google Maps API
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            if($data['routes'] && $data['routes'][0]){
                if (!empty($data['routes'][0]['legs'])) {
                    $polylinePoints = [];

                    foreach ($data['routes'][0]['legs'] as $leg) {
                        if (!empty($leg['steps'])) {
                            foreach ($leg['steps'] as $step) {
                                if (isset($step['polyline']['points'])) {
                                    $polylinePoints[] = $step['polyline']['points'];
                                }
                            }
                        }
                    }

                    // Filter out any null values if necessary
                    $polylinePoints = array_filter($polylinePoints);
                }
                $route = $data['routes'][0];
                if($route){
                    $totalDistance = 0;
                    $totalDuration = 0;

                    foreach ($route['legs'] as $leg) {
                        $totalDistance += $leg['distance']['value']; // Distance in meters
                        $totalDuration += $leg['duration']['value']; // Duration in seconds
                    }

                    // Convert meters to miles
                    $totalDistanceMiles = round($totalDistance * 0.000621371, 2);

                    // Convert seconds to hours and minutes
                    $hours = floor($totalDuration / 3600);
                    $minutes = floor(($totalDuration % 3600) / 60);

                    // Format distance
                    $formattedDistance = $totalDistanceMiles . ' miles';

                    // Format duration
                    if ($hours > 0) {
                        $formattedDuration = "{$hours} hr {$minutes} min";
                    } else {
                        $formattedDuration = "{$minutes} min";
                    }
                }
                if (isset($data['routes'][0]['overview_polyline']['points'])) {
                    $encodedPolyline = $data['routes'][0]['overview_polyline']['points'];
                    $decodedPolyline = $this->decodePolyline($encodedPolyline);
                    $ftpData = $this->loadAndParseFTPData();
                    // Filter coordinates based on distance from start and end points
                    $finalFilteredPolyline = array_filter($decodedPolyline, function ($coordinate) use ($startLat, $startLng, $endLat, $endLng) {
                        // Ensure $coordinate is valid
                        if (isset($coordinate['lat'], $coordinate['lng'])) {
                            // Calculate distances from both start and end points
                            $distanceFromStart = $this->haversineDistanceFilter($startLat, $startLng, $coordinate['lat'], $coordinate['lng']);
                            $distanceFromEnd = $this->haversineDistanceFilter($endLat, $endLng, $coordinate['lat'], $coordinate['lng']);

                            // Keep coordinates if they are sufficiently far from both points
                            return $distanceFromStart > 9 && $distanceFromEnd > 9;
                        }
                        return false; // Skip invalid coordinates
                    });

                    // Reset array keys to ensure a clean array structure
                    $finalFilteredPolyline = array_values($finalFilteredPolyline);
                    $matchingRecords = $this->findMatchingRecords($finalFilteredPolyline, $ftpData);
                    $result = $this->findOptimalFuelStation($startLat, $startLng, $truckMpg, $currentFuel, $matchingRecords, $endLat, $endLng);
                    $trip = Trip::find($request->trip_id);

                    foreach ($result as  $value) {
                        $fuelStation = FuelStation::where('trip_id', $trip->id)->first();
                        $fuelStation->name = $value['fuel_station_name'];
                        $fuelStation->latitude = $value['ftp_lat'];
                        $fuelStation->longitude = $value['ftp_lng'];
                        $fuelStation->price = $value['price'];
                        $fuelStation->lastprice = $value['lastprice'];
                        $fuelStation->discount = $value['discount'];
                        $fuelStation->ifta_tax = $value['IFTA_tax'];
                        $fuelStation->is_optimal = $value['is_optimal'];
                        $fuelStation->address = $value['address'];
                        $fuelStation->gallons_to_buy = $value['gallons_to_buy'];
                        $fuelStation->trip_id = $trip->id;
                        $fuelStation->user_id = $trip->user_id;
                        $fuelStation->update();
                    }

                    $trip->distance = $formattedDistance;
                    $trip->duration = $formattedDuration;
                    $stops = Tripstop::where('trip_id', $trip->id)->get();
                    $driverVehicle = DriverVehicle::where('driver_id', $trip->user_id)->first();
                    if($driverVehicle){
                        $vehicle = Vehicle::where('id', $driverVehicle->vehicle_id)->first();
                        $vehicle->update([
                            'fuel_left'=> $currentFuel,
                            'reserve_fuel'=>$request->reserve_fuel,
                        ]);
                        if($vehicle && $vehicle->vehicle_image != null){
                            $vehicle->vehicle_image = url('/vehicles/'.$vehicle->vehicle_image);
                        }
                    }else{

                        $vehicle=null;
                    }


                    // Create a separate key for the polyline
                    $responseData = [
                        'trip_id' => $request->trip_id,
                        'trip' => $trip,
                        'fuel_stations' => $result, // Fuel stations with optimal station marked
                        'polyline' => $decodedPolyline,
                        'encoded_polyline'=>$encodedPolyline,
                        'polyline_paths' => $polylinePoints ?? [],
                        'stops' => $stops,
                        'vehicle' => $vehicle
                    ];
                    $findDriver = User::where('id', $trip->user_id)->first();
                    if($findDriver){

                     $findCompany = CompanyDriver::where('driver_id',$findDriver->id)->first();
                     if ($findCompany) {
                        $driverFcm = FcmToken::where('user_id', $findDriver->id)->pluck('token')->toArray();
                        $companyFcmTokens = FcmToken::where('user_id', $findCompany->company_id)
                        ->pluck('token')
                        ->toArray();

                        if (!empty($companyFcmTokens)) {
                            $factory = (new Factory)->withServiceAccount(storage_path('app/zeroifta.json'));
                            $messaging = $factory->createMessaging();

                            // Create the notification payload
                            $message = CloudMessage::new()
                                ->withNotification(Notification::create('Trip Updated', $findDriver->name . 'has updated a trip.'))
                                ->withData([
                                    'trip_id' => (string) $trip->id,  // Include trip ID for reference
                                    'driver_name' => $findDriver->name, // Driver's name
                                    'sound' => 'default',  // This triggers the sound
                                ]);

                            // Send notification to all FCM tokens of the company
                            $response = $messaging->sendMulticast($message, $companyFcmTokens);
                        }
                        if (!empty($driverFcm)) {
                            $factory = (new Factory)->withServiceAccount(storage_path('app/zeroifta.json'));
                            $messaging = $factory->createMessaging();

                            $message = CloudMessage::new()
                                ->withNotification(Notification::create('Trip Updated', 'Trip updated successfully'))
                                ->withData([
                                    'sound' => 'default', // This triggers the sound
                                ]);

                            $response = $messaging->sendMulticast($message, $driverFcm);
                            ModelsNotification::create([
                                'user_id' => $findCompany->company_id,
                                'title' => 'Trip Updated',
                                'body' => $findDriver->name . ' has updated a trip.',
                            ]);
                        }
                    }
                    }
                    return response()->json([
                        'status' => 200,
                        'message' => 'Fuel stations fetched successfully.',
                        'data' => $responseData,
                    ]);
                }

                return response()->json([
                    'status' => 404,
                    'message' => 'No route found.',
                    'data'=>(object)[]
                ], 404);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to fetch data from Google Maps API.',
                    'data'=>(object)[]
                ]);
            }

        }

        return response()->json([
            'status' => 500,
            'message' => 'Failed to fetch data from Google Maps API.',
            'data'=>(object)[]
        ]);
}
    public function getDecodedPolyline(Request $request, FcmService $firebaseService)
    {
        $validatedData =$request->validate([
            'user_id'   => 'required|exists:users,id',
            'start_lat' => 'required',
            'start_lng' => 'required',
            'end_lat' => 'required',
            'end_lng' => 'required',
            'truck_mpg' => 'required',
            'fuel_tank_capacity' => 'required',
            'total_gallons_present' => 'required',
            //'reserve_fuel'=>'required'
        ]);

        $findTrip = Trip::where('user_id', $validatedData['user_id'])->where('status', 'active')->first();

        if ($findTrip) {
            return response()->json(['status' => 422, 'message' => 'Trip already exists for this user', 'data' => $findTrip]);
        }
        $validatedData['status']='active';
        $vehicle_id = DriverVehicle::where('driver_id', $validatedData['user_id'])->first();
        if ($vehicle_id) {
            $validatedData['vehicle_id'] = $vehicle_id->vehicle_id;
        }
        $startLat = $request->start_lat;
        $startLng = $request->start_lng;
        $endLat = $request->end_lat;
        $endLng = $request->end_lng;
        $truckMpg = $request->truck_mpg;
        $fuelTankCapacity = $request->fuel_tank_capacity;
        $currentFuel = $request->total_gallons_present;
        // Replace with your Google API key
        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";

        // Fetch data from Google Maps API
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
           if($data['routes'] && $data['routes'][0]){
            if (!empty($data['routes'][0]['legs'][0]['steps'])) {
                $steps = $data['routes'][0]['legs'][0]['steps'];

                // Extract polyline points as an array of strings
                $polylinePoints = array_map(function ($step) {
                    return $step['polyline']['points'] ?? null;
                }, $steps);

                // Filter out any null values if necessary
                $polylinePoints = array_filter($polylinePoints);


            }

            $route = $data['routes'][0];

            $distanceText = isset($route['legs'][0]['distance']['text']) ? $route['legs'][0]['distance']['text'] : null;
            $durationText = isset($route['legs'][0]['duration']['text']) ? $route['legs'][0]['duration']['text'] : null;

            // Format distance (e.g., "100 miles")
            if ($distanceText) {
                $distanceParts = explode(' ', $distanceText);
                $formattedDistance = $distanceParts[0] . ' miles'; // Ensuring it always returns distance in miles
            }

            // Format duration (e.g., "2 hr 20 min")
            if ($durationText) {
                $durationParts = explode(' ', $durationText);
                $hours = isset($durationParts[0]) ? $durationParts[0] : 0;
                $minutes = isset($durationParts[2]) ? $durationParts[2] : 0;
                $formattedDuration = $hours . ' hr ' . $minutes . ' min'; // Formatting as "2 hr 20 min"

            }

            if (isset($data['routes'][0]['overview_polyline']['points'])) {
                $encodedPolyline = $data['routes'][0]['overview_polyline']['points'];
                $decodedPolyline = $this->decodePolyline($encodedPolyline);

                // Filter coordinates based on distance from start and end points
                $finalFilteredPolyline = array_filter($decodedPolyline, function ($coordinate) use ($startLat, $startLng, $endLat, $endLng) {
                    // Ensure $coordinate is valid
                    if (isset($coordinate['lat'], $coordinate['lng'])) {
                        // Calculate distances from both start and end points
                        $distanceFromStart = $this->haversineDistanceFilter($startLat, $startLng, $coordinate['lat'], $coordinate['lng']);
                        $distanceFromEnd = $this->haversineDistanceFilter($endLat, $endLng, $coordinate['lat'], $coordinate['lng']);

                        // Keep coordinates if they are sufficiently far from both points
                        return $distanceFromStart > 9 && $distanceFromEnd > 9;
                    }
                    return false; // Skip invalid coordinates
                });

                // Reset array keys to ensure a clean array structure
                $finalFilteredPolyline = array_values($finalFilteredPolyline);

                $ftpData = $this->loadAndParseFTPData();

                $matchingRecords = $this->findMatchingRecords($finalFilteredPolyline, $ftpData);
                $testFuelStations = [
                    ['ftp_lat' => 40.7128, 'ftp_lng' => -74.0060, 'price' => 3.60], // Station A
                    ['ftp_lat' => 40.7308, 'ftp_lng' => -73.9973, 'price' => 3.60], // Station B (Cheapest)
                    ['ftp_lat' => 40.7508, 'ftp_lng' => -73.9903, 'price' => 3.55], // Station C
                    ['ftp_lat' => 40.7708, 'ftp_lng' => -73.9800, 'price' => 3.45], // Station D
                    ['ftp_lat' => 40.7808, 'ftp_lng' => -73.9700, 'price' => 3.50], // Station E
                    ['ftp_lat' => 40.7908, 'ftp_lng' => -73.9600, 'price' => 3.48], // Station F
                    ['ftp_lat' => 40.8000, 'ftp_lng' => -73.9500, 'price' => 3.52], // Station G
                ];
                $startLat = 40.7000;
$startLng = -74.0100;
$mpg = 5; // Miles per gallon
$currentGallons = 5; // Current fuel in gallons
$destinationLat = 40.8500;
$destinationLng = -73.9000;
                $result = $this->findOptimalFuelStation($startLat, $startLng, $mpg, $currentGallons, $testFuelStations, $destinationLat, $destinationLng);
                dd($result);
               // $result = $this->findOptimalFuelStation($startLat, $startLng, $truckMpg, $currentFuel, $testFuelStations, $endLat, $endLng);

                $fuelStations = [];
                $trip = Trip::create($validatedData);
               foreach ($result as  $value) {
                    $fuelStations[] = [
                        'name' => $value['fuel_station_name'],
                        'latitude' => $value['ftp_lat'],
                        'longitude' => $value['ftp_lng'],
                        'price' => $value['price'],
                        'lastprice' => $value['lastprice'],
                        'discount' => $value['discount'],
                        'ifta_tax' => $value['IFTA_tax'],
                        'is_optimal' => $value['is_optimal'],
                        'address' => $value['address'],
                        'gallons_to_buy' => $value['gallons_to_buy'],
                        'trip_id' => $trip->id,
                        'user_id' => $validatedData['user_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
               }
               $findDriver = User::where('id', $trip->user_id)->first();
               if($findDriver){

                $findCompany = CompanyDriver::where('driver_id',$findDriver->id)->first();
                if ($findCompany) {
                    $driverFcm = FcmToken::where('user_id', $findDriver->id)->pluck('token')->toArray();
                    $companyFcmTokens = FcmToken::where('user_id', $findCompany->company_id)
                    ->pluck('token')
                    ->toArray();

                    if (!empty($companyFcmTokens)) {
                        $factory = (new Factory)->withServiceAccount(storage_path('app/zeroifta.json'));
                        $messaging = $factory->createMessaging();

                        // Create the notification payload
                        $message = CloudMessage::new()
                            ->withNotification(Notification::create('Trip Started', $findDriver->name.' has started a trip.'))
                            ->withData([
                                'trip_id' => (string) $trip->id,  // Include trip ID for reference
                                'driver_name' => $findDriver->name, // Driver's name
                                'sound' => 'default',  // This triggers the sound
                            ]);

                        // Send notification to all FCM tokens of the company
                        $response = $messaging->sendMulticast($message, $companyFcmTokens);
                    }
                    if (!empty($driverFcm)) {
                        $factory = (new Factory)->withServiceAccount(storage_path('app/zeroifta.json'));
                        $messaging = $factory->createMessaging();

                        $message = CloudMessage::new()
                            ->withNotification(Notification::create('Trip Started', 'Trip started successfully'))
                            ->withData([
                                'sound' => 'default', // This triggers the sound
                            ]);

                        $response = $messaging->sendMulticast($message, $driverFcm);
                        ModelsNotification::create([
                            'user_id' => $findCompany->company_id,
                            'title' => 'Trip Started',
                            'body' => $findDriver->name . ' has started a trip.',
                        ]);
                    }
                }

            }
               FuelStation::insert($fuelStations);
                $trip->distance = $formattedDistance;
                $trip->duration = $formattedDuration;
                $trip->user_id = (int)$trip->user_id;
                $vehicleFind = DriverVehicle::where('driver_id', $trip->user_id)->pluck('vehicle_id')->first();
                if($vehicleFind){
                    $vehicle = Vehicle::where('id', $vehicleFind)->first();
                    $vehicle->reserve_fuel = $request->reserve_fuel;
                    $vehicle->update();
                    if($vehicle && $vehicle->vehicle_image != null){
                        $vehicle->vehicle_image =url('/vehicles/'.$vehicle->vehicle_image);
                    }
                }else{
                    $vehicle = null;
                }

                $responseData = [
                    'trip_id'=>$trip->id,
                    'trip' => $trip,
                    'fuel_stations' => $result,
                    'polyline' => $decodedPolyline,
                    'encoded_polyline'=>$encodedPolyline,
                    'polyline_paths'=>$polylinePoints ?? [],
                    'stops'=>[],
                    'vehicle' => $vehicle
                ];

                return response()->json([
                    'status' => 200,
                    'message' => 'Fuel stations fetched successfully.',
                    'data' => $responseData,
                ]);
            }


           }else{
            return response()->json([
                'status' => 500,
                'message' => 'Failed to fetch data from Google Maps API.',
                'data'=>(object)[]
            ]);
           }

        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch polyline.',
        ], 500);
    }
    function haversineDistanceFilter($lat1, $lng1, $lat2, $lng2) {
        $earthRadius = 3958.8; // Earth radius in miles

        // Convert degrees to radians
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        // Haversine formula
        $dLat = $lat2 - $lat1;
        $dLng = $lng2 - $lng1;

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($lat1) * cos($lat2) *
             sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; // Distance in miles
    }

    // private function findOptimalFuelStation($startLat, $startLng, $mpg, $currentGallons, $fuelStations, $destinationLat, $destinationLng)
    // {
    //     $optimalStation = collect($fuelStations)->sortBy('price')->first();

    //     foreach ($fuelStations as &$station) {
    //         if (
    //             $station['ftp_lat'] == $optimalStation['ftp_lat'] &&
    //             $station['ftp_lng'] == $optimalStation['ftp_lng']
    //         ) {
    //             // Calculate distance from the optimal station to the destination
    //             $distanceToDestination = $this->haversineDistance(
    //                 $station['ftp_lat'],
    //                 $station['ftp_lng'],
    //                 $destinationLat,
    //                 $destinationLng
    //             );

    //             // Convert distance to miles and calculate gallons needed
    //             $distanceInMiles = $distanceToDestination / 1609.34; // Convert meters to miles
    //             $fuelRequired = $distanceInMiles / $mpg; // Fuel needed in gallons

    //             // Calculate gallons to buy
    //             $gallonsToBuy = max(0, $fuelRequired - $currentGallons);
    //             $station['gallons_to_buy'] = round($gallonsToBuy, 2);
    //             $station['is_optimal'] = true; // Mark as optimal
    //         } else {
    //             // Skip `gallons_to_buy` for non-optimal stations
    //             $station['gallons_to_buy'] = null;
    //             $station['is_optimal'] = false; // Mark as non-optimal
    //         }
    //     }

    //     return array_values($fuelStations); // Re-index for JSON response
    // }
    private function findOptimalFuelStation($startLat, $startLng, $mpg, $currentGallons, $fuelStations, $destinationLat, $destinationLng)
{
    $optimalStation = null;
    $stationsWithDetails = [];

    foreach ($fuelStations as &$station) {
        // Calculate distance from vehicle's current location
        $distanceFromVehicle = $this->haversineDistance(
            $startLat, $startLng, $station['ftp_lat'], $station['ftp_lng']
        );

        // Convert distance to miles and calculate gallons needed
        $distanceInMiles = $distanceFromVehicle / 1609.34; // Convert meters to miles
        $fuelRequired = $distanceInMiles / $mpg; // Fuel needed in gallons

        // Determine if the station is reachable with current fuel
        if ($fuelRequired <= $currentGallons) {
            // Find the most cost-effective station within reach
            if (!$optimalStation || ($station['price'] < $optimalStation['price'] && $fuelRequired <= $currentGallons)) {
                $optimalStation = $station;
            }
        }
    }

    foreach ($fuelStations as &$station) {
        $station['is_optimal'] = false;
        $station['gallons_to_buy'] = null;

        if ($optimalStation && $station['ftp_lat'] == $optimalStation['ftp_lat'] && $station['ftp_lng'] == $optimalStation['ftp_lng']) {
            $station['is_optimal'] = true;

            // If it's the cheapest station overall, refuel to complete the trip
            if ($station['price'] == min(array_column($fuelStations, 'price'))) {
                $distanceToDestination = $this->haversineDistance(
                    $station['ftp_lat'], $station['ftp_lng'], $destinationLat, $destinationLng
                );
                $distanceInMiles = $distanceToDestination / 1609.34;
                $station['gallons_to_buy'] = max(0, $distanceInMiles / $mpg - $currentGallons);
            } else {
                // Otherwise, refuel only enough to reach the next optimal station
                $nextOptimal = null;
                foreach ($fuelStations as $nextStation) {
                    $distanceToNext = $this->haversineDistance(
                        $station['ftp_lat'], $station['ftp_lng'], $nextStation['ftp_lat'], $nextStation['ftp_lng']
                    );
                    $nextDistanceInMiles = $distanceToNext / 1609.34;
                    $fuelNeededForNext = $nextDistanceInMiles / $mpg;

                    if ($nextStation['price'] < $station['price'] && $fuelNeededForNext <= $currentGallons) {
                        $nextOptimal = $nextStation;
                        break;
                    }
                }

                if ($nextOptimal) {
                    $station['gallons_to_buy'] = max(0, $nextDistanceInMiles / $mpg - $currentGallons);
                }
            }
        }
        $stationsWithDetails[] = $station;
    }

    return $stationsWithDetails; // Return all stations with optimal one highlighted
}
    private function decodePolyline($encoded)
    {
        $points = [];
        $index = 0;
        $len = strlen($encoded);
        $lat = 0;
        $lng = 0;

        while ($index < $len) {
            $b = 0;
            $shift = 0;
            $result = 0;

            do {
                $b = ord($encoded[$index++]) - 63;
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            } while ($b >= 0x20);

            $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));
            $lat += $dlat;

            $shift = 0;
            $result = 0;

            do {
                $b = ord($encoded[$index++]) - 63;
                $result |= ($b & 0x1f) << $shift;
                $shift += 5;
            } while ($b >= 0x20);

            $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
            $lng += $dlng;

            $points[] = [
                'lat' => number_format($lat * 1e-5, 5),
                'lng' => number_format($lng * 1e-5, 5),
            ];
        }

        return $points;
    }

    private function loadAndParseFTPData()
    {
        $filePath = 'EFSLLCpricing';

        // Connect to the FTP disk
        $ftpDisk = Storage::disk('ftp');
        if (!$ftpDisk->exists($filePath)) {
            throw new \Exception("FTP file not found.");
        }

        $fileContent = $ftpDisk->get($filePath);
        $rows = explode("\n", trim($fileContent));
        $parsedData = [];

        foreach ($rows as $line) {
            $row = explode('|', $line);

            if (isset($row[8], $row[9])) {
                $lat = number_format((float) trim($row[8]), 4);
                $lng = number_format((float) trim($row[9]), 4);
                $parsedData[$lat][$lng] = [
                    'fuel_station_name'=>$row[1] ?? 'N/A',
                    'lastprice' => $row[10] ?? 0.00,
                    'price' => $row[11] ?? 0.00,
                    'IFTA_tax'=> $row[18] ?? 0.00,
                    'address' => $row[3] ?? 'N/A',
                    'discount' => $row[12] ?? 0.00
                ];
            }
        }

        return $parsedData;
    }
    private function findMatchingRecords(array $decodedPolyline, array $ftpData)
    {
        $matchingRecords = [];
        $uniqueRecords = []; // To track unique lat,lng combinations

        // Iterate through decoded polyline points
        foreach ($decodedPolyline as $decoded) {
            $lat1 = $decoded['lat'];
            $lng1 = $decoded['lng'];

            // Compare with FTP data points
            foreach ($ftpData as $lat2 => $lngData) {
                foreach ($lngData as $lng2 => $data) {
                    $distance = $this->haversineDistance($lat1, $lng1, $lat2, $lng2);

                    // Check if within the defined proximity
                    if ($distance < 12000) { // Distance is less than 500 meters
                        // Create a unique key for each lat,lng pair
                        $uniqueKey = $lat2 . ',' . $lng2;

                        // Only add if this key hasn't been processed
                        if (!isset($uniqueRecords[$uniqueKey])) {
                            $matchingRecords[] = [
                                'fuel_station_name' => (string) $data['fuel_station_name'],
                                'ftp_lat' => (string) $lat2, // Ensure lat/lng are strings for consistency
                                'ftp_lng' => (string) $lng2,
                                'lastprice' => (float) $data['lastprice'], // Ensure numeric fields are cast properly
                                'price' => (float) $data['price'],
                                'discount' => isset($data['discount']) ? (float) $data['discount'] : 0.0,
                                'address' => isset($data['address']) ? (string) $data['address'] : 'N/A',
                                'IFTA_tax' => isset($data['IFTA_tax']) ? (float) $data['IFTA_tax'] : 0.0,
                            ];

                            // Mark this lat,lng pair as processed
                            $uniqueRecords[$uniqueKey] = true;
                        }
                    }
                }
            }
        }

        return array_values($matchingRecords); // Reindex the array for proper JSON formatting
    }

    private function haversineDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // Earth's radius in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lngDelta / 2) * sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Distance in meters
    }
}
