<?php

namespace App\Http\Controllers;

use App\Models\CompanyDriver;
use App\Models\DriverVehicle;
use App\Models\FcmToken;
use App\Models\FuelStation;
use App\Models\Notification as ModelsNotification;
use App\Models\Trip;
use App\Models\Tripstop;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\User;
use App\Models\Vehicle;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{


    public function store(Request $request)
    {

        // Step 1: Validate request data
        $validatedData = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'end_lat'   => 'required|numeric',
            'end_lng'   => 'required|numeric',
        ]);

        //Step 2: Check if a trip already exists for this user
        $findTrip = Trip::where('user_id', $validatedData['user_id'])->where('status', 'active')->first();
        if ($findTrip) {
            return response()->json(['status' => 422, 'message' => 'Trip already exists for this user', 'data' => (object)[]]);
        }
        $validatedData['status']='active';


        $trip = Trip::create($validatedData);

        // Step 4: Find and save gas stations along the route
        $gasStations = $this->findGasStations($validatedData['start_lat'], $validatedData['start_lng'], $validatedData['end_lat'], $validatedData['end_lng']);

        $ftpData = $this->loadAndParseFTPData();

       if($gasStations){
        foreach ($gasStations as $station) {
            $lat = number_format((float) $station['latitude'], 4);
            $lng = number_format((float) $station['longitude'], 4);

            //if (isset($ftpData[$lat][$lng])) {
                $price = $ftpData[$lat][$lng]['price'] ?? 0.00;

                // Save the valid gas station
                $fuelStation = FuelStation::create([
                    'user_id'   => $validatedData['user_id'],
                    'trip_id'   => $trip->id,
                    'name'      => $station['name'],
                    'latitude'  => $station['latitude'],
                    'longitude' => $station['longitude'],
                    'price'     => $price,
                ]);
                $storedStations[] = $fuelStation;
            //}

        }
       }


        return response()->json(['status' => 200, 'message' => 'Trip and gas stations stored successfully','data'    => [
            'trip'          => $trip,
            'gas_stations'  => $storedStations ?? [],
        ]]);
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
    private function findGasStations($startLat, $startLng, $endLat, $endLng)
    {
        $client = new Client();
        $radius = 5000; // Search radius of 1000 meters
        $distance = $this->calculateDistance($startLat, $startLng, $endLat, $endLng);

        // Calculate the number of API requests dynamically based on route length
        $maxRequests = max(5, (int)($distance / 5)); // 1 request per 5 km, with a minimum of 5 requests
        $epsilon = 0.001; // Tolerance for RDP simplification (smaller values retain more points)

        $gasStations = [];

        // Generate initial route points (more points for better accuracy)
        $routePoints = $this->getRoutePoints($startLat, $startLng, $endLat, $endLng, 100); // Increase number of points

        // Simplify route points using RDP (optional, but helps to reduce unnecessary points)
        $simplifiedPoints = $this->ramerDouglasPeucker($routePoints, $epsilon);

        // Limit checkpoints based on calculated maxRequests
        $checkpoints = array_slice($simplifiedPoints, 0, $maxRequests);

        // Google Places API URL
        $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json';

        // Loop through each checkpoint and find gas stations
        foreach ($checkpoints  as $point) {
            $response = $client->get($url, [
                'query' => [
                    'location' => "{$point['lat']},{$point['lng']}",
                    'radius' => $radius,
                    'type' => 'gas_station',
                    'key' => 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg'
                ]
            ]);

            $results = json_decode($response->getBody(), true)['results'];
            foreach ($results as $result) {
                $gasStations[] = [
                    'name' => $result['name'],
                    'latitude' => preg_replace('/^(\d+\.\d{4}).*$/', '$1', number_format($result['geometry']['location']['lat'], 10, '.', '')),
                    'longitude' => preg_replace('/^(\-?\d+\.\d{4}).*$/', '$1', number_format($result['geometry']['location']['lng'], 10, '.', '')),
                ];
            }
        }

        // Remove duplicate stations (same station with the same latitude/longitude)
        $uniqueGasStations = collect($gasStations)->unique(function ($station) {
            return $station['name'] . $station['latitude'] . $station['longitude'];
        })->values()->all();

        return $uniqueGasStations;
    }

    private function getRoutePoints($startLat, $startLng, $endLat, $endLng, $numPoints)
    {
        $points = [];
        for ($i = 0; $i <= $numPoints; $i++) {
            $fraction = $i / $numPoints;
            $lat = $startLat + $fraction * ($endLat - $startLat);
            $lng = $startLng + $fraction * ($endLng - $startLng);
            $points[] = ['lat' => $lat, 'lng' => $lng];
        }
        return $points;
    }

    private function ramerDouglasPeucker($points, $epsilon)
    {
        if (count($points) < 3) {
            return $points;
        }

        // Find the point with the maximum distance
        $dmax = 0;
        $index = 0;
        $end = count($points) - 1;

        for ($i = 1; $i < $end; $i++) {
            $d = $this->perpendicularDistance($points[$i], $points[0], $points[$end]);
            if ($d > $dmax) {
                $index = $i;
                $dmax = $d;
            }
        }

        // If max distance is greater than epsilon, recursively simplify
        if ($dmax > $epsilon) {
            $recResults1 = $this->ramerDouglasPeucker(array_slice($points, 0, $index + 1), $epsilon);
            $recResults2 = $this->ramerDouglasPeucker(array_slice($points, $index, $end - $index + 1), $epsilon);

            return array_merge(array_slice($recResults1, 0, -1), $recResults2);
        } else {
            return [$points[0], $points[$end]];
        }
    }

    private function perpendicularDistance($point, $lineStart, $lineEnd)
    {
        $x0 = $point['lat'];
        $y0 = $point['lng'];
        $x1 = $lineStart['lat'];
        $y1 = $lineStart['lng'];
        $x2 = $lineEnd['lat'];
        $y2 = $lineEnd['lng'];

        $numerator = abs(($y2 - $y1) * $x0 - ($x2 - $x1) * $y0 + $x2 * $y1 - $y2 * $x1);
        $denominator = sqrt(pow($y2 - $y1, 2) + pow($x2 - $x1, 2));

        return $denominator == 0 ? 0 : $numerator / $denominator;
    }

    private function calculateDistance($startLat, $startLng, $endLat, $endLng)
    {
        $earthRadius = 6371; // Radius in kilometers

        $dLat = deg2rad($endLat - $startLat);
        $dLng = deg2rad($endLng - $startLng);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($startLat)) * cos(deg2rad($endLat)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Distance in kilometers
    }


    public function getTrip($user_id)
    {
        $trip = Trip::where('user_id', $user_id)->where('status', 'active')->orderBy('created_at', 'desc')->first();

        if (!$trip) {
            return response()->json(['status' =>404, 'message' => 'No trip found for this user', 'data' => (object)[]]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Trip retrieved successfully',
            'data' => [
                'id' => $trip->id,
                'start_lat' => $trip->start_lat,
                'start_lng' => $trip->start_lng,
                'end_lat' => $trip->end_lat,
                'end_lng' => $trip->end_lng,
                'stops' => $trip->stops->map(function ($stop) {
                    return [
                        'lat' => $stop->stop_lat,
                        'lng' => $stop->stop_lng,
                    ];
                }),
            ]
        ]);
        // return response()->json(['status' => 200, 'message' => 'Trip retrieved successfully', 'data' => $trip]);
    }
    public function deleteTrip(Request $request)
    {
        $trip = Trip::whereId($request->trip_id)->first();
        if (!$trip) {
            return response()->json(['status' => 404, 'message' => 'No trip found for this user', 'data' => (object)[]]);
        }
        $trip->delete();
        return response()->json(['status' => 200, 'message' => 'Trip deleted successfully', 'data' => (object)[]]);
    }
    public function completeTrip(Request $request){
        $trip = Trip::whereId($request->trip_id)->first();
        if (!$trip) {
            return response()->json(['status' => 404, 'message' => 'No trip found', 'data' => (object)[]]);
        }

        $trip->status = $request->status;
        $trip->save();
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
                    if($request->status == "completed"){
                        $message = CloudMessage::new()
                        ->withNotification(Notification::create('Trip Completed', $findDriver->name . 'has completed a trip.'))
                        ->withData([
                            'trip_id' => (string) $trip->id,  // Include trip ID for reference
                            'driver_name' => $findDriver->name, // Driver's name
                            'sound' => 'default',  // This triggers the sound
                        ]);
                    }else{
                        $message = CloudMessage::new()
                        ->withNotification(Notification::create('Trip Cancelled', $findDriver->name . 'has cancelled a trip.'))
                        ->withData([
                            'trip_id' => (string) $trip->id,  // Include trip ID for reference
                            'driver_name' => $findDriver->name, // Driver's name
                            'sound' => 'default',  // This triggers the sound
                        ]);
                    }
                    // Create the notification payload
                    

                    // Send notification to all FCM tokens of the company
                    $response = $messaging->sendMulticast($message, $companyFcmTokens);
                }
                if (!empty($driverFcm)) {
                    $factory = (new Factory)->withServiceAccount(storage_path('app/zeroifta.json'));
                    $messaging = $factory->createMessaging();
                    if($request->status == "completed"){
                        $message = CloudMessage::new()
                            ->withNotification(Notification::create('Trip Completed', 'Trip completed successfully'))
                            ->withData([
                                'sound' => 'default', // This triggers the sound
                            ]);
                            $response = $messaging->sendMulticast($message, $driverFcm);
                            ModelsNotification::create([
                                'user_id' => $findCompany->company_id,
                                'title' => 'Trip Completed',
                                'body' => $findDriver->name . ' has completed a trip.',
                            ]);
                    }else{
                        $message = CloudMessage::new()
                            ->withNotification(Notification::create('Trip Cancelled', 'Trip cancelled successfully'))
                            ->withData([
                                'sound' => 'default', // This triggers the sound
                            ]);
                            $response = $messaging->sendMulticast($message, $driverFcm);
                            ModelsNotification::create([
                                'user_id' => $findCompany->company_id,
                                'title' => 'Trip Cancelled',
                                'body' => $findDriver->name . ' has cancelled a trip.',
                            ]);
                    }
                    
                }
            }
        }
        return response()->json(['status' => 200, 'message' => 'Trip status updated successfully', 'data' => (object)[]]);
    }
    function fetchFileDataAndMatchCoordinates($latitude, $longitude)
    {
        $filePath = 'EFSLLCpricing'; // The FTP file name

        // Connect to the FTP disk
        $ftpDisk = Storage::disk('ftp');

        // Check if the file exists
        if (!$ftpDisk->exists($filePath)) {
            return "File not found.";
        }

        // Get the file content
        $fileContent = $ftpDisk->get($filePath);

        // Convert content to an array by splitting lines
        $rows = explode("\n", trim($fileContent));

        // Loop through the lines to find matching coordinates
        foreach ($rows as $line) {
            $row = explode('|', $line); // Split by the pipe character

            // Check if the line contains latitude and longitude data
            // Assuming latitude is at index 8 and longitude is at index 9
            if (isset($row[8], $row[9]) && trim($row[8]) == $latitude && trim($row[9]) == $longitude) {
                return $row; // Return the matching row
            }
        }

        return "No matching coordinates found.";
    }
    public function getActiveTrip(Request $request){
        $trip = Trip::whereId($request->trip_id)->first();
        $fuelStations = FuelStation::where('trip_id', $request->trip_id)->get()
        ->map(function ($station) {
        // Convert the station to an array, keeping all attributes
        $data = $station->toArray();

        // Add the new keys
        $data['ftp_lat'] = $data['latitude'];
        $data['ftp_lng'] = $data['longitude'];
        $data['fuel_station_name'] = $data['name'];
        $data['IFTA_tax'] = floatval(preg_replace('/[^0-9.-]/', '', $station->ifta_tax));
        $data['lastprice'] = floatval(preg_replace('/[^0-9.-]/', '', $station->lastprice));
        $data['price'] = floatval(preg_replace('/[^0-9.-]/', '', $station->price));
        $data['discount'] = $data['discount'] ? (double)$data['discount'] : 0;
        $data['gallons_to_buy'] = $data['gallons_to_buy'] ? (double)$data['gallons_to_buy'] :null;
        $data['is_optimal'] = $data['is_optimal'] ? (bool)$data['is_optimal'] : false;
        // Optionally remove the old keys if not needed
        unset($data['latitude'], $data['longitude'],$data['ifta_tax'],$data['name']);

        return $data;
    });
        $startLat = $trip->start_lat;
        $startLng = $trip->start_lng;
        $endLat = $trip->end_lat;
        $endLng = $trip->end_lng;

        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
        $stops = Tripstop::where('trip_id', $trip->id)->get();
        if ($stops->isNotEmpty()) {
            $waypoints = $stops->map(fn($stop) => "{$stop->stop_lat},{$stop->stop_lng}")->implode('|');
        }

        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";
        if (isset($waypoints)) {
            $url .= "&waypoints=optimize:true|{$waypoints}";
        }

        $response = Http::get($url);
        if ($response->successful()) {
            $data = $response->json();
            if($data['routes'] && $data['routes'][0]){
                $route = $data['routes'][0];
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
                if ($route) {
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
                    $currentTrip = Trip::where('id', $trip->id)->first();
                    $vehicle_id = DriverVehicle::where('driver_id', $currentTrip->user_id)->first();
                    if($vehicle_id){
                        $findVehicle = Vehicle::where('id', $vehicle_id->vehicle_id)->first();
                        $truckMpg = $findVehicle->mpg;
                        $currentFuel = $findVehicle->fuel_left;
                        $result = $this->findOptimalFuelStation($startLat, $startLng, $truckMpg, $currentFuel, $matchingRecords, $endLat, $endLng);
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
                    }else{
                        return response()->json(['status'=>404,'message'=>'trip not found','data'=>(object)[]],404);
                    }

                }
            }
        }
        $stops = Tripstop::where('trip_id', $trip->id)->get();
        $driverVehicle = DriverVehicle::where('driver_id', $trip->user_id)->first();
        if($driverVehicle && $driverVehicle->vehicle_id != null){
            $vehicle = Vehicle::where('id', $driverVehicle->vehicle_id)->first();
            if($vehicle && $vehicle->vehicle_image != null){
                $vehicle->vehicle_image = url('/vehicles/' . $vehicle->vehicle_image);
            }
        }else{
            $vehicle = null;
        }

        unset($trip->vehicle_id);
        if($trip){
            $trip->distance = $formattedDistance;
            $trip->duration = $formattedDuration;
            $trip->user_id = (int)$trip->user_id;
            $response = [
                'trip_id' => $trip->id,
                'trip' => $trip,
                'fuel_stations' => $result,
                'polyline' => $decodedPolyline,
                'encoded_polyline'=>$encodedPolyline,
                'polyline_paths'=>$polylinePoints,
                'stops' => $stops,
                'vehicle' => $vehicle
            ];
            return response()->json(['status'=>200,'message'=>'trip found','data'=>$response],200);
        }else{
            return response()->json(['status'=>404,'message'=>'trip not found','data'=>(object)[]],404);
        }
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
    public function tripDetail(Request $request)
    {
        $trip = Trip::where('id', $request->trip_id)->first();
        if($trip){
            $driverVehicle = DriverVehicle::where('driver_id', $trip->user_id)->pluck('vehicle_id')->first();
            $vehicle = Vehicle::where('id', $driverVehicle)->first();

            $pickupState = $this->getAddressFromCoordinates($trip->start_lat, $trip->start_lng);
            $dropoffState = $this->getAddressFromCoordinates($trip->end_lat, $trip->end_lng);
            $pickup = $this->getPickupFromCoordinates($trip->start_lat, $trip->start_lng);
            $dropoff = $this->getPickupFromCoordinates($trip->end_lat, $trip->end_lng);
            $trip->pickup = $pickup;
            $trip->dropoff = $dropoff;
            $trip->pickupState = $pickupState;
            $trip->dropoffState = $dropoffState;
            $trip->vehicle = $vehicle;
            if($trip->vehicle && $trip->vehicle->vehicle_image){
                $trip->vehicle->vehicle_image = url('/vehicles/' . $vehicle->vehicle_image);
            }
            $startLat = $trip->start_lat;
            $startLng = $trip->start_lng;
            $endLat = $trip->end_lat;
            $endLng = $trip->end_lng;
            $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";
        $response = Http::get($url);
        if ($response->successful()) {
            $data = $response->json();
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
        }
            $trip->distance = $formattedDistance;
            $trip->duration = $formattedDuration;
            return response()->json(['status'=>200,'message'=>'trip found','data'=>$trip],200);
        }else{
            return response()->json(['status'=>404,'message'=>'trip not found','data'=>(object)[]],404);
        }
    }

    private function getAddressFromCoordinates($latitude, $longitude)
    {
        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg'; // Add your API key in .env
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

        $response = file_get_contents($url);
        $response = json_decode($response, true);

        if (isset($response['results'][0]['address_components'])) {
            foreach ($response['results'][0]['address_components'] as $component) {
                if (in_array('administrative_area_level_1', $component['types'])) {
                    return $component['long_name']; // State name
                }
            }
        }

        return 'Address not found';
    }
    private function getPickupFromCoordinates($latitude, $longitude)
    {
        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg'; // Add your API key in .env
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

        $response = file_get_contents($url);
        $response = json_decode($response, true);

        if (isset($response['results'][0]['formatted_address'])) {
            return $response['results'][0]['formatted_address'];
        }

        return 'Address not found';
    }
    public function storeStop(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'trip_id' => 'required|exists:trips,id',
            'stops' => 'required|array',
            'stops.*.stop_lat' => 'required|string',
            'stops.*.stop_lng' => 'required|string',
            'stops.*.stop_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
                'data' => (object) [],
            ]);
        }

        // Save stops
        $stopsData = array_map(function ($stop) use ($request) {
            return [
                'trip_id' => $request->trip_id,
                'stop_name' => $stop['stop_name'] ?? null,
                'stop_lat' => $stop['stop_lat'],
                'stop_lng' => $stop['stop_lng'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $request->stops);

        Tripstop::insert($stopsData);
        $trip = Trip::whereId($request->trip_id)->first();
        $fuelStations = FuelStation::where('trip_id', $request->trip_id)->get()
            ->map(function ($station) {
                // Convert the station to an array, keeping all attributes
                $data = $station->toArray();

                // Add the new keys
                $data['ftp_lat'] = $data['latitude'];
                $data['ftp_lng'] = $data['longitude'];
                $data['fuel_station_name'] = $data['name'];
                $data['IFTA_tax'] = floatval(preg_replace('/[^0-9.-]/', '', $station->ifta_tax));
                $data['lastprice'] = floatval(preg_replace('/[^0-9.-]/', '', $station->lastprice));
                $data['price'] = floatval(preg_replace('/[^0-9.-]/', '', $station->price));
                $data['discount'] = $data['discount'] ? (double)$data['discount'] : 0;
                $data['gallons_to_buy'] = $data['gallons_to_buy'] ? (double)$data['gallons_to_buy'] :null;
                $data['is_optimal'] = $data['is_optimal'] ? (bool)$data['is_optimal'] : false;
                // Optionally remove the old keys if not needed
                unset($data['latitude'], $data['longitude'],$data['ifta_tax'],$data['name']);
            return $data;
        });
        unset($trip->vehicle_id);
        $startLat = $trip->start_lat;
        $startLng = $trip->start_lng;
        $endLat = $trip->end_lat;
        $endLng = $trip->end_lng;
        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
        $waypoints = '';
        $stops = Tripstop::where('trip_id', $trip->id)->get();
        if ($stops->isNotEmpty()) {
            $waypoints = $stops->map(fn($stop) => "{$stop->stop_lat},{$stop->stop_lng}")->implode('|');
        }
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";
        if ($waypoints) {
            $url .= "&waypoints=optimize:true|{$waypoints}";
        }
        $response = Http::get($url);
        if ($response->successful()) {
            $data = $response->json();
            if($data['routes'] && $data['routes'][0]){
                if (!empty($data['routes'][0]['legs'])) {
                    $polylinePoints = [];

                    foreach ($data['routes'][0]['legs'] as $leg) {
                        foreach ($leg['steps'] as $step) {
                            $polylinePoints[] = $step['polyline']['points'] ?? null;
                        }
                    }

                    $polylinePoints = array_filter($polylinePoints);
                   // $completePolyline = implode('', $polylinePoints);
                }
                $route = $data['routes'][0] ?? null;
                if ($route) {
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
                    $currentTrip = Trip::where('id', $trip->id)->first();
                    $vehicle_id = DriverVehicle::where('driver_id', $currentTrip->user_id)->first();

                    $findVehicle = Vehicle::where('id', $vehicle_id->vehicle_id)->first();
                    $truckMpg = $findVehicle->mpg;
                    $currentFuel = $findVehicle->fuel_left;
                    $fuelStations = [];
                    $result = $this->findOptimalFuelStation($startLat, $startLng, $truckMpg, $currentFuel, $matchingRecords, $endLat, $endLng);
                    FuelStation::where('trip_id', $trip->id)->delete();
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
                            'user_id' => $trip->user_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                   }
                }
                FuelStation::insert($fuelStations);

            }
        }

        $vehiclefind = DriverVehicle::where('driver_id', $trip->user_id)->pluck('vehicle_id')->first();
        if($vehiclefind){
            $vehicle = Vehicle::where('id', $vehiclefind)->first();
            if($vehicle && $vehicle->vehicle_image != null){
                $vehicle->vehicle_image = url('/vehicles/' . $vehicle->vehicle_image);
            }
        }else{
            $vehicle =null;

        }


        if($trip){
            $trip->distance = $formattedDistance;
            $trip->duration = $formattedDuration;
            $trip->user_id = (int)$trip->user_id;
            $stops = Tripstop::where('trip_id', $trip->id)->get();
            $response = [
                'trip_id' => $trip->id,
                'trip' => $trip,
                'fuel_stations' => $result,
                'polyline' => $decodedPolyline,
                'encoded_polyline'=>$encodedPolyline,
                'polyline_paths' => $polylinePoints ?? [],
                'stops' => $stops,
                'vehicle' => $vehicle
            ];
            return response()->json(['status'=>200,'message'=>'stops added','data'=>$response],200);
        }else{
            return response()->json(['status'=>404,'message'=>'trip not found','data'=>[]],404);
        }

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
    private function findOptimalFuelStation($startLat, $startLng, $mpg, $currentGallons, $fuelStations, $destinationLat, $destinationLng)
    {
        $optimalStation = collect($fuelStations)->sortBy('price')->first();

        foreach ($fuelStations as &$station) {
            if (
                $station['ftp_lat'] == $optimalStation['ftp_lat'] &&
                $station['ftp_lng'] == $optimalStation['ftp_lng']
            ) {
                // Calculate distance from the optimal station to the destination
                $distanceToDestination = $this->haversineDistance(
                    $station['ftp_lat'],
                    $station['ftp_lng'],
                    $destinationLat,
                    $destinationLng
                );

                // Convert distance to miles and calculate gallons needed
                $distanceInMiles = $distanceToDestination / 1609.34; // Convert meters to miles
                $fuelRequired = $distanceInMiles / $mpg; // Fuel needed in gallons

                // Calculate gallons to buy
                $gallonsToBuy = max(0, $fuelRequired - $currentGallons);
                $station['gallons_to_buy'] = round($gallonsToBuy, 2);
                $station['is_optimal'] = true; // Mark as optimal
            } else {
                // Skip `gallons_to_buy` for non-optimal stations
                $station['gallons_to_buy'] = null;
                $station['is_optimal'] = false; // Mark as non-optimal
            }
        }
        return array_values($fuelStations);
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
