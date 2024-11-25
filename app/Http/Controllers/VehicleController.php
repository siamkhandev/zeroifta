<?php

namespace App\Http\Controllers;

use App\Models\DriverVehicle;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;

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
        $trips = Trip::where('user_id', $request->driver_id)->get();

        if ($trips->isEmpty()) {
            return response()->json(['status' => 404, 'message' => 'trips not found', 'data' => (object)[]], 404);
        }

        $geocodedTrips = $trips->map(function ($trip) {
            $pickup = $this->getAddressFromCoordinates($trip->start_lat, $trip->start_lng);
            $dropoff = $this->getAddressFromCoordinates($trip->end_lat, $trip->end_lng);

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

        if (isset($response['results'][0]['formatted_address'])) {
            return $response['results'][0]['formatted_address'];
        }

        return 'Address not found';
    }
}
