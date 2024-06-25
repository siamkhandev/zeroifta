<?php

namespace App\Http\Controllers;

use App\Models\DriverVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicle = DriverVehicle::with('vehicle')->where('driver_vehicles.driver_id',$request->driver_id)->first();
        if($vehicle){
            $vehicle->vehicle->vehicle_image = 'http://54.164.54.21/vehicles/' .$vehicle->vehicle->vehicle_image;
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
    public function allVehicles()
    {
        $vehicles = Vehicle::all();
        if(count($vehicles) >0){
            foreach ($vehicles as $vehicle) {
                if (isset($vehicle->vehicle_image)) {
                    $vehicle->vehicle_image = 'http://54.164.54.21/vehicles/' . $vehicle->vehicle_image;
                }
            }
            return response()->json(['status'=>200,'message'=>'vehicles found','data'=>$vehicles],200);
        }else{
            return response()->json(['status'=>404,'message'=>'vehicles not found','data'=>[]],404);
        }
       

    }
}
