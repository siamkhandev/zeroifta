<?php

namespace App\Http\Controllers;

use App\Models\DriverVehicle;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicle = DriverVehicle::with('vehicle')->where('driver_vehicles.driver_id',$request->driver_id)->first();
        if($vehicle){
            $vehicle->vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' .$vehicle->vehicle->vehicle_image;
            return response()->json(['status'=>200,'message'=>'vehicle found','data'=> $vehicle],200);
        }else{
            return response()->json(['status'=>404,'message'=>'vehicle not found','data'=> (object)[]],404);
        }
    }
    public function update(Request $request)
    {
        $vehicle = Vehicle::where('vehicle_number',$request->vehicle_number)->first();
        if($vehicle){
            $vehicle->odometer_reading = $request->odometer_reading;
            $vehicle->mpg = $request->mpg;
            $vehicle->fuel_tank_capacity = $request->fuel_tank_capacity;
            $vehicle->fuel_left = $request->fuel_left;
            $vehicle->save();
            return response()->json(['status'=>200,'message'=>'vehicle updated successfully','data'=> $vehicle],200);
        }else{
            return response()->json(['status'=>404,'message'=>'vehicle not found','data'=> (object)[]],404);
        }
    }
    public function allVehicles(Request $request)
    {
        $driverVehicles = DriverVehicle::where('driver_id',$request->driver_id)->get();
        $vehicles = Vehicle::whereIn('id', $driverVehicles->pluck('vehicle_id'))->get();
        if(count($vehicles) >0){
            foreach ($vehicles as $vehicle) {
                if (isset($vehicle->vehicle_image)) {
                    $vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $vehicle->vehicle_image;
                }
            }
            return response()->json(['status'=>200,'message'=>'vehicles found','data'=>$vehicles],200);
        }else{
            return response()->json(['status'=>404,'message'=>'vehicles not found','data'=>(object)[]],404);
        }


    }
    public function allTrips(Request $request)
    {
        // Eager load the related models to minimize the number of queries
        $trips = Trip::with(['driverVehicle.vehicle'])
            ->where('user_id', $request->driver_id)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($trips->isEmpty()) {
            return response()->json(['status' => 404, 'message' => 'trips not found', 'data' => (object)[]], 404);
        }

        // Prepare the data for Google Maps API requests
        $requests = [];
        foreach ($trips as $trip) {
            $pickup = $this->getAddressFromCoordinates($trip->start_lat, $trip->start_lng);
            $dropoff = $this->getAddressFromCoordinates($trip->end_lat, $trip->end_lng);
            $vehicle = $trip->driverVehicle->vehicle;

            // Check if vehicle image exists, update URL if necessary
            if (isset($vehicle->vehicle_image)) {
                $vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $vehicle->vehicle_image;
            }

            // Prepare request data for Google API
            $requests[] = [
                'start_lat' => $trip->start_lat,
                'start_lng' => $trip->start_lng,
                'end_lat' => $trip->end_lat,
                'end_lng' => $trip->end_lng,
                'vehicle' => $vehicle
            ];
        }

        // Call Google API in parallel (for optimization, parallel requests using Guzzle can be implemented here)
        $apiResponses = $this->getGoogleDirections($requests);

        // Process the API responses
        $geocodedTrips = $trips->map(function ($trip, $index) use ($apiResponses, $pickup, $dropoff, $vehicle) {
            $apiResponse = $apiResponses[$index] ?? null;

            if ($apiResponse && isset($apiResponse['distanceText'], $apiResponse['durationText'])) {
                // Format the distance and duration from the API response
                $distanceText = $apiResponse['distanceText'];
                $durationText = $apiResponse['durationText'];

                // Format distance (e.g., "100 miles")
                $distanceParts = explode(' ', $distanceText);
                $formattedDistance = $distanceParts[0] . ' miles'; // Ensuring it always returns distance in miles

                // Format duration (e.g., "2 hr 20 min")
                $durationParts = explode(' ', $durationText);
                $hours = $durationParts[0] ?? 0;
                $minutes = $durationParts[2] ?? 0;
                $formattedDuration = $hours . ' hr ' . $minutes . ' min'; // Formatting as "2 hr 20 min"
            } else {
                $formattedDistance = $formattedDuration = 'N/A';
            }

            return [
                'id' => $trip->id,
                'user_id' => $trip->user_id,
                'pickup' => $pickup,
                'dropoff' => $dropoff,
                'start_lat' => $trip->start_lat,
                'start_lng' => $trip->start_lng,
                'end_lat' => $trip->end_lat,
                'end_lng' => $trip->end_lng,
                'status' => $trip->status,
                'vehicle' => $vehicle,
                'distance' => $formattedDistance,
                'duration' => $formattedDuration,
                'created_at' => $trip->created_at,
                'updated_at' => $trip->updated_at,
            ];
        });

        return response()->json(['status' => 200, 'message' => 'trips found', 'data' => $geocodedTrips], 200);
    }

    private function getGoogleDirections($requests)
    {
        // Use Guzzle to make parallel requests to Google Directions API for each trip
        $client = new \GuzzleHttp\Client();
        $promises = [];

        foreach ($requests as $request) {
            $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$request['start_lat']},{$request['start_lng']}&destination={$request['end_lat']},{$request['end_lng']}&key=YOUR_GOOGLE_API_KEY";
            $promises[] = $client->getAsync($url);
        }

        // Wait for all requests to complete and return responses
        $responses = \GuzzleHttp\Promise\settle($promises)->wait();

        // Process and return API responses
        return array_map(function ($response) {
            if ($response['state'] === 'fulfilled') {
                $data = json_decode($response['value']->getBody()->getContents(), true);
                $route = $data['routes'][0] ?? [];
                return [
                    'distanceText' => $route['legs'][0]['distance']['text'] ?? 'N/A',
                    'durationText' => $route['legs'][0]['duration']['text'] ?? 'N/A',
                ];
            }
            return [
                'distanceText' => 'N/A',
                'durationText' => 'N/A',
            ];
        }, $responses);
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
}
