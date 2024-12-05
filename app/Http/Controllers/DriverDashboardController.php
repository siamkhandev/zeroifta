<?php

namespace App\Http\Controllers;

use App\Models\CompanyContactUs;
use App\Models\CompanyDriver;
use App\Models\Contactus;
use App\Models\DriverVehicle;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DriverDashboardController extends Controller
{
//     public function index(Request $request)
// {
//     $dashboardData = [];

//     // Get the vehicle data
//     $dashboardData['vehicle'] = DriverVehicle::with('vehicle')
//         ->where('driver_id', $request->driver_id)
//         ->first();

//     // If the vehicle exists and has a vehicle image, update the image URL
//     if ($dashboardData['vehicle'] && $dashboardData['vehicle']->vehicle) {
//         $dashboardData['vehicle']->vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $dashboardData['vehicle']->vehicle->vehicle_image;
//     }

//     // Get all trips for the given driver
//     $trips = Trip::where('user_id', $request->driver_id)->take(5)->orderBy('created_at', 'desc')->get();
//     $tripData = []; // This will hold the formatted trip data

//     foreach ($trips as $trip) {
//         // Get the pickup and dropoff addresses using coordinates
//         $pickup = $this->getAddressFromCoordinates($trip->start_lat, $trip->start_lng);
//         $dropoff = $this->getAddressFromCoordinates($trip->end_lat, $trip->end_lng);
//         $startLat = $trip->start_lat;
//         $startLng = $trip->start_lng;
//         $endLat = $trip->end_lat;
//         $endLng = $trip->end_lng;
//         $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
//         $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";
//         $response = Http::get($url);
//         if ($response->successful()) {
//             $data = $response->json();
//             $route = $data['routes'][0];

//             $distanceText = isset($route['legs'][0]['distance']['text']) ? $route['legs'][0]['distance']['text'] : null;
//             $durationText = isset($route['legs'][0]['duration']['text']) ? $route['legs'][0]['duration']['text'] : null;

//             // Format distance (e.g., "100 miles")
//             if ($distanceText) {
//                 $distanceParts = explode(' ', $distanceText);
//                 $formattedDistance = $distanceParts[0] . ' miles'; // Ensuring it always returns distance in miles
//             }

//             // Format duration (e.g., "2 hr 20 min")
//             if ($durationText) {
//                 $durationParts = explode(' ', $durationText);
//                 $hours = isset($durationParts[0]) ? $durationParts[0] : 0;
//                 $minutes = isset($durationParts[2]) ? $durationParts[2] : 0;
//                 $formattedDuration = $hours . ' hr ' . $minutes . ' min'; // Formatting as "2 hr 20 min"

//             }
//         }
//         // Add the formatted trip data to the array
//         $tripData[] = [
//             'id' => $trip->id,
//             'user_id' => $trip->user_id,
//             'pickup' => $pickup,
//             'dropoff' => $dropoff,
//             'start_lat' => $trip->start_lat,
//             'start_lng' => $trip->start_lng,
//             'end_lat' => $trip->end_lat,
//             'end_lng' => $trip->end_lng,
//             'distance' => $formattedDistance ?? null,
//             'duration' => $formattedDuration ?? null,
//             'status' => $trip->status,
//             'created_at' => $trip->created_at->format('d M'), // Format the date as requested
//         ];
//     }

//     // Add the formatted trip data to the dashboard data
//     $dashboardData['recentTrips'] = $tripData;

//     // Return the response with the formatted data
//     return response()->json([
//         'status' => 200,
//         'message' => 'Data Fetched',
//         'data' => $dashboardData
//     ], 200);
// }
public function index(Request $request)
{
    // Initialize dashboard data
    $dashboardData = [];

    // Fetch vehicle data with nested vehicle object
    $vehicle = DriverVehicle::with('vehicle')
        ->where('driver_id', $request->driver_id)
        ->first();

    if ($vehicle && $vehicle->vehicle) {
        $vehicle->vehicle->vehicle_image = url('vehicles/' . $vehicle->vehicle->vehicle_image);
    }
    $dashboardData['vehicle'] = $vehicle;

    // Fetch the last 5 trips for the driver
    $trips = Trip::where('user_id', $request->driver_id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    $tripData = $trips->map(function ($trip) {
        $pickup = $this->getAddressFromCoordinates($trip->start_lat, $trip->start_lng);
        $dropoff = $this->getAddressFromCoordinates($trip->end_lat, $trip->end_lng);

        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg'; // Use env for API key
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$trip->start_lat},{$trip->start_lng}&destination={$trip->end_lat},{$trip->end_lng}&key={$apiKey}";
        $response = Http::get($url);

        $distance = $duration = null;
        if ($response->successful()) {
            $data = $response->json();
            $route = $data['routes'][0] ?? null;

            if ($route) {
                $distance = $route['legs'][0]['distance']['text'] ?? null;
                $duration = $route['legs'][0]['duration']['text'] ?? null;

                // Ensure distance in miles
                if ($distance) {
                    $distanceParts = explode(' ', $distance);
                    $distance = $distanceParts[0] . ' miles';
                }

                // Ensure duration in "hr min" format
                if ($duration) {
                    $durationParts = explode(' ', $duration);
                    $hours = $durationParts[0] ?? 0;
                    $minutes = $durationParts[2] ?? 0;
                    $duration = "{$hours} hr {$minutes} min";
                }
            }
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
            'distance' => $distance,
            'duration' => $duration,
            'status' => $trip->status,
            'created_at' => $trip->created_at->format('d M'),
        ];
    });

    $dashboardData['recentTrips'] = $tripData;

    // Return the response
    return response()->json([
        'status' => 200,
        'message' => 'Data Fetched',
        'data' => $dashboardData,
    ]);
}

    public function contactus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id'=>'required|exists:users,id',
            'subject' => 'required',
            'message'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }
        //$findCompay = CompanyDriver::where('driver_id',$request->driver_id)->first();
        $contact = new CompanyContactUs();
        //$contact->driver_id = $request->driver_id;
        $contact->company_id = $request->driver_id;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return response()->json(['status'=>200,'message'=>'Request submitted successfully','data'=>$contact],200);
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
