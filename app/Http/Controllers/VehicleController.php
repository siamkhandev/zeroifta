<?php

namespace App\Http\Controllers;

use App\Models\CompanyDriver;
use App\Models\DriverVehicle;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
    public function addVehicle(Request $request)
    {
        $data = $request->validate([
            'vehicle_type' => 'required',
            'vehicle_number' => 'required',
            'odometer_reading' => 'required',
            'mpg' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:1024',

        ]);
        $companyId = CompanyDriver::where('driver_id',Auth::id())->first();
        $vehicle = new Vehicle();
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->odometer_reading	 = $request->odometer_reading;
        $vehicle->company_id =  $companyId->company_id;
        $vehicle->mpg= $request->mpg;
        $vehicle->fuel_tank_capacity= $request->fuel_tank_capacity;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('vehicles'), $imageName);
            $vehicle->vehicle_image= $imageName;
        }
        $vehicle->save();
        return response()->json(['status'=>200,'message'=>'Vehcile Added Successfully','data'=>$vehicle],200);
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
            return response()->json(['status'=>404,'message'=>'vehicles not found','data'=>[]],404);
        }


    }
    public function allTrips(Request $request)
    {
        $trips = Trip::where('user_id', $request->driver_id)->orderBy('created_at', 'desc')->get();

        if ($trips->isEmpty()) {
            return response()->json(['status' => 404, 'message' => 'trips not found', 'data' => []], 404);
        }

        $geocodedTrips = $trips->map(function ($trip) {
            $pickup = $this->getAddressFromCoordinates($trip->start_lat, $trip->start_lng);
            $dropoff = $this->getAddressFromCoordinates($trip->end_lat, $trip->end_lng);
            $driverVehicle = DriverVehicle::where('driver_id', $trip->user_id)->pluck('vehicle_id')->first();
            $vehicle = Vehicle::where('id', $driverVehicle)->first();
            if(isset($vehicle->vehicle_image)){
                $vehicle->vehicle_image = 'http://zeroifta.alnairtech.com/vehicles/' . $vehicle->vehicle_image ?? null;

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
