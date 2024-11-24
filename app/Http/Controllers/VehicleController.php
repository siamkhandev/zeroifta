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
        if(count($trips) >0){
            return response()->json(['status'=>200,'message'=>'trips found','data'=>$trips],200);
        }else{
            return response()->json(['status'=>404,'message'=>'trips not found','data'=>(object)[]],404);
        }
    }
}
