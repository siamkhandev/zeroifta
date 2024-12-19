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
                            $vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $vehicle->vehicle_image;
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
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'start_lat' => 'required',
        'start_lng' => 'required',
        'end_lat' => 'required',
        'end_lng' => 'required',
        'truck_mpg' => 'required',
        'fuel_tank_capacity' => 'required',
        'total_gallons_present' => 'required',
    ]);

    $activeTrip = Trip::where('user_id', $validatedData['user_id'])->where('status', 'active')->first();
    if ($activeTrip) {
        return response()->json(['status' => 422, 'message' => 'Trip already exists for this user', 'data' => $activeTrip]);
    }

    $validatedData['status'] = 'active';
    $vehicle = DriverVehicle::where('driver_id', $validatedData['user_id'])->first();
    if ($vehicle) {
        $validatedData['vehicle_id'] = $vehicle->vehicle_id;
    }

    $trip = Trip::create($validatedData);

    $googleMapsResponse = $this->fetchGoogleMapsData(
        $validatedData['start_lat'],
        $validatedData['start_lng'],
        $validatedData['end_lat'],
        $validatedData['end_lng']
    );

    if (!$googleMapsResponse['success']) {
        return response()->json(['status' => 500, 'message' => 'Failed to fetch data from Google Maps API.', 'data' => (object) []]);
    }

    $route = $googleMapsResponse['data']['routes'][0] ?? null;
    if (!$route) {
        return response()->json(['status' => 500, 'message' => 'No route data available.', 'data' => (object) []]);
    }

    $distanceText = $route['legs'][0]['distance']['text'] ?? null;
    $durationText = $route['legs'][0]['duration']['text'] ?? null;
    $encodedPolyline = $route['overview_polyline']['points'] ?? null;

    if ($encodedPolyline) {
        $decodedPolyline = $this->decodePolyline($encodedPolyline);
        $ftpData = $this->loadAndParseFTPData();
        $matchingRecords = $this->findMatchingRecords($decodedPolyline, $ftpData);

        $fuelStations = $this->findOptimalFuelStations(
            $validatedData['start_lat'],
            $validatedData['start_lng'],
            $validatedData['truck_mpg'],
            $validatedData['total_gallons_present'],
            $matchingRecords,
            $validatedData['end_lat'],
            $validatedData['end_lng']
        );

        $this->saveFuelStations($fuelStations, $trip->id, $validatedData['user_id']);

        $trip->update([
            'distance' => $this->formatDistance($distanceText),
            'duration' => $this->formatDuration($durationText),
        ]);

        $vehicleDetails = $this->getVehicleDetails($validatedData['user_id']);

        return response()->json([
            'status' => 200,
            'message' => 'Fuel stations fetched successfully.',
            'data' => [
                'trip_id' => $trip->id,
                'trip' => $trip,
                'fuel_stations' => $fuelStations,
                'polyline' => $decodedPolyline,
                'encoded_polyline' => $encodedPolyline,
                'stops' => [],
                'vehicle' => $vehicleDetails,
            ],
        ]);
    }

    return response()->json(['status' => 500, 'message' => 'Failed to decode polyline.', 'data' => (object) []]);
}

private function fetchGoogleMapsData($startLat, $startLng, $endLat, $endLng)
{
    $apiKey = "AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg";
    $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";

    $response = Http::get($url);
    if ($response->successful()) {
        return ['success' => true, 'data' => $response->json()];
    }

    return ['success' => false, 'data' => null];
}

private function saveFuelStations($fuelStations, $tripId, $userId)
{
    foreach ($fuelStations as $station) {
        FuelStation::create([
            'name' => $station['fuel_station_name'],
            'latitude' => $station['ftp_lat'],
            'longitude' => $station['ftp_lng'],
            'price' => $station['price'],
            'lastprice' => $station['lastprice'],
            'discount' => $station['discount'],
            'ifta_tax' => $station['IFTA_tax'],
            'is_optimal' => $station['is_optimal'],
            'address' => $station['address'],
            'gallons_to_buy' => $station['gallons_to_buy'],
            'trip_id' => $tripId,
            'user_id' => $userId,
        ]);
    }
}

private function formatDistance($distanceText)
{
    if (!$distanceText) return null;

    $distanceParts = explode(' ', $distanceText);
    return $distanceParts[0] . ' miles';
}

private function formatDuration($durationText)
{
    if (!$durationText) return null;

    $durationParts = explode(' ', $durationText);
    $hours = $durationParts[0] ?? 0;
    $minutes = $durationParts[2] ?? 0;

    return "$hours hr $minutes min";
}

private function getVehicleDetails($userId)
{
    $vehicleId = DriverVehicle::where('driver_id', $userId)->value('vehicle_id');
    if ($vehicleId) {
        $vehicle = Vehicle::find($vehicleId);
        if ($vehicle && $vehicle->vehicle_image) {
            $vehicle->vehicle_image = url("vehicles/{$vehicle->vehicle_image}");
        }
        return $vehicle;
    }

    return null;
}

}
