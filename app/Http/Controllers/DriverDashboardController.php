<?php

namespace App\Http\Controllers;

use App\Models\CompanyContactUs;
use App\Models\CompanyDriver;
use App\Models\Contactus;
use App\Models\DriverVehicle;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverDashboardController extends Controller
{
    public function index(Request $request)
{
    $dashboardData = [];

    // Get the vehicle data
    $dashboardData['vehicle'] = DriverVehicle::with('vehicle')
        ->where('driver_id', $request->driver_id)
        ->first();

    // If the vehicle exists and has a vehicle image, update the image URL
    if ($dashboardData['vehicle'] && $dashboardData['vehicle']->vehicle) {
        $dashboardData['vehicle']->vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $dashboardData['vehicle']->vehicle->vehicle_image;
    }

    // Get all trips for the given driver
    $trips = Trip::where('user_id', $request->driver_id)->take(5)->orderBy('created_at', 'desc')->get();
    $tripData = []; // This will hold the formatted trip data

    foreach ($trips as $trip) {
        // Get the pickup and dropoff addresses using coordinates
        $pickup = $this->getAddressFromCoordinates($trip->start_lat, $trip->start_lng);
        $dropoff = $this->getAddressFromCoordinates($trip->end_lat, $trip->end_lng);

        // Add the formatted trip data to the array
        $tripData[] = [
            'id' => $trip->id,
            'user_id' => $trip->user_id,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'start_lat' => $trip->start_lat,
            'start_lng' => $trip->start_lng,
            'end_lat' => $trip->end_lat,
            'end_lng' => $trip->end_lng,
            'status' => $trip->status,
            'created_at' => $trip->created_at->format('d M'), // Format the date as requested
        ];
    }

    // Add the formatted trip data to the dashboard data
    $dashboardData['recentTrips'] = $tripData;

    // Return the response with the formatted data
    return response()->json([
        'status' => 200,
        'message' => 'Data Fetched',
        'data' => $dashboardData
    ], 200);
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
