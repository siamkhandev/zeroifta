<?php

namespace App\Http\Controllers;

use App\Models\DriverVehicle;
use App\Models\FuelStation;
use App\Models\Trip;
use App\Models\Tripstop;
use App\Models\Vehicle;
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
        if(!empty($stops)){
            $waypoints = $stops->map(function ($stop) {
                return "{$stop->stop_lat},{$stop->stop_lng}";
            })->implode('|');
        }
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";
        if ($waypoints) {
            $url .= "&waypoints=optimize:true|{$waypoints}";
        }
        // Fetch data from Google Maps API
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            if($data['routes'] && $data['routes'][0]){
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
                    $ftpData = $this->loadAndParseFTPData();

                    $matchingRecords = $this->findMatchingRecords($decodedPolyline, $ftpData);
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
                        'stops' => $stops,
                        'vehicle' => $vehicle
                    ];

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
    public function getDecodedPolyline(Request $request)
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
            $trip = Trip::create($validatedData);
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
                $ftpData = $this->loadAndParseFTPData();

                $matchingRecords = $this->findMatchingRecords($decodedPolyline, $ftpData);
                $result = $this->findOptimalFuelStation($startLat, $startLng, $truckMpg, $currentFuel, $matchingRecords, $endLat, $endLng);
                $fuelStations = [];
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
               FuelStation::insert($fuelStations);
                $trip->distance = $formattedDistance;
                $trip->duration = $formattedDuration;
                $trip->user_id = (int)$trip->user_id;
                $vehicleFind = DriverVehicle::where('driver_id', $trip->user_id)->pluck('vehicle_id')->first();
                if($vehicleFind){
                    $vehicle = Vehicle::where('id', $vehicleFind)->first();
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

        return array_values($fuelStations); // Re-index for JSON response
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

        // Iterate through decoded polyline points
        foreach ($decodedPolyline as $decoded) {
            $lat1 = $decoded['lat'];
            $lng1 = $decoded['lng'];

            // Compare with FTP data points
            foreach ($ftpData as $lat2 => $lngData) {
                foreach ($lngData as $lng2 => $data) {
                    $distance = $this->haversineDistance($lat1, $lng1, $lat2, $lng2);

                    // Check if within the defined proximity
                    if ($distance < 16093) { // Distance is less than 500 meters
                        $matchingRecords[] = [
                            'fuel_station_name'=>(string) $data['fuel_station_name'],
                            'ftp_lat' => (string) $lat2, // Ensure lat/lng are strings for consistency
                            'ftp_lng' => (string) $lng2,
                            'lastprice' => (float) $data['lastprice'], // Ensure numeric fields are cast properly
                            'price' => (float) $data['price'],
                            'discount' => isset($data['discount']) ? (float) $data['discount'] : 0.0,
                            'address' => isset($data['address']) ? (string) $data['address'] : 'N/A',
                            'IFTA_tax' => isset($data['IFTA_tax']) ? (float) $data['IFTA_tax'] : 0.0
                        ];
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
