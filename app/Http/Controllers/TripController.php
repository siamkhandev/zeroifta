<?php

namespace App\Http\Controllers;

use App\Models\DriverVehicle;
use App\Models\FuelStation;
use App\Models\Trip;
use App\Models\Tripstop;
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
        return Cache::remember('parsed_ftp_data', 3600, function () {
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
                    $parsedData[$lat][$lng] = ['price' => $row[11] ?? 0.00];
                }
            }

            return $parsedData;
        });
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

        return response()->json(['status' => 200, 'message' => 'Trip retrieved successfully', 'data' => $trip]);
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
            if (isset($data['routes'][0]['overview_polyline']['points'])) {
                $encodedPolyline = $data['routes'][0]['overview_polyline']['points'];
                $decodedPolyline = $this->decodePolyline($encodedPolyline);
            }
        }
        $stops = Tripstop::where('trip_id', $trip->id)->get();
        $driverVehicle = DriverVehicle::where('driver_id', $trip->user_id)->first();
        if($driverVehicle && $driverVehicle->vehicle_id != null){
            $vehicle = Vehicle::where('id', $driverVehicle->vehicle_id)->first();
            if($vehicle && $vehicle->vehicle_image != null){
                $vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $vehicle->vehicle_image;
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
                'fuel_stations' => $fuelStations,
                'polyline' => $decodedPolyline,
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
                $trip->vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $vehicle->vehicle_image;
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
       // dd($request->all());
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
            if (isset($data['routes'][0]['overview_polyline']['points'])) {
                $encodedPolyline = $data['routes'][0]['overview_polyline']['points'];
                $decodedPolyline = $this->decodePolyline($encodedPolyline);
            }
        }
        $vehiclefind = DriverVehicle::where('driver_id', $trip->user_id)->pluck('vehicle_id')->first();
        if($vehiclefind){
            $vehicle = Vehicle::where('id', $vehiclefind)->first();
            if($vehicle && $vehicle->vehicle_image != null){
                $vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $vehicle->vehicle_image;
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
                'fuel_stations' => $fuelStations,
                'polyline' => $decodedPolyline,
                'stops' => $stops,
                'vehicle' => $vehicle
            ];
            return response()->json(['status'=>200,'message'=>'stops added','data'=>$response],200);
        }else{
            return response()->json(['status'=>404,'message'=>'trip not found','data'=>[]],404);
        }

    }
}
