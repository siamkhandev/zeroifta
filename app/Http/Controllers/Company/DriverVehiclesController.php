<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyDriver;
use App\Models\DriverVehicle;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverVehiclesController extends Controller
{
    public function index()
    {
        $vehicles = DriverVehicle::with('driver','vehicle')->where('company_id',Auth::id())->get();
        return view('company.driver_vehicles.index',get_defined_vars());
    }
    public function create()
    {
        $drivers = CompanyDriver::with('driver')->where('company_id',Auth::id())->get();
        $vehicles = Vehicle::where('company_id',Auth::id())->get();
        //$check = DriverVehicle::whereIn('vehicle_id',$vehicles)->get();
        //$vehicles = Vehicle::where('company_id',Auth::id())->whereNotIn('id',$check->pluck('vehicle_id'))->get();
        return view('company.driver_vehicles.create',get_defined_vars());
    }
    public function store(Request $request)
{
    $data = $request->validate([
        'driver_id' => 'required',
        'vehicle_id' => 'required',
    ]);

    $checkVehicle = DriverVehicle::where('vehicle_id', $request->vehicle_id)->first();

    if ($checkVehicle) {
        $currentDriver = $checkVehicle->driver->name; // Assuming a relation `driver` exists in DriverVehicle
        return response()->json([
            'status' => 'already_assigned',
            'message' => "This vehicle is already assigned to driver {$currentDriver}. Do you want to reassign it?",
            'driver_vehicle_id' => $checkVehicle->id
        ]);
    }

    // Assign the vehicle if not already assigned
    $vehicle = new DriverVehicle();
    $vehicle->driver_id = $request->driver_id;
    $vehicle->vehicle_id = $request->vehicle_id;
    $vehicle->company_id = Auth::id();
    $vehicle->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Vehicle assigned successfully',
    ]);
}

public function reassign(Request $request)
{
   
    $data = $request->validate([
        'driver_vehicle_id' => 'required|exists:driver_vehicles,id',
        'driver_id' => 'required|exists:users,id',
    ]);

   
        $driverVehicle = DriverVehicle::find($data['driver_vehicle_id']);
        
        $driverVehicle->driver_id = $data['driver_id'];
        $driverVehicle->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Vehicle reassigned successfully.',
        ]);
    
}
public function checkDriverAssignment(Request $request)
{
    $driverId = $request->driver_id;
    $assignment = DriverVehicle::where('driver_id', $driverId)->first();

    if ($assignment) {
        $vehicle = Vehicle::find($assignment->vehicle_id);
        return response()->json([
            'assigned' => true,
            'message' => "Driver already has a vehicle assigned: {$vehicle->license_plate_number}. Do you want to reassign?"
        ]);
    }

    return response()->json(['assigned' => false]);
}

public function checkVehicleAssignment(Request $request)
{
    $vehicleId = $request->vehicle_id;
    $assignment = DriverVehicle::where('vehicle_id', $vehicleId)->first();

    if ($assignment) {
        $driver = Driver::find($assignment->driver_id);
        return response()->json([
            'assigned' => true,
            'message' => "Vehicle is already assigned to Driver: {$driver->name}. Do you want to reassign?"
        ]);
    }

    return response()->json(['assigned' => false]);
}
    public function edit($id)
    {
        $vehicle = DriverVehicle::find($id);

        $drivers = CompanyDriver::with('driver')->where('company_id',Auth::id())->get();
        $vehicles = Vehicle::where('company_id',Auth::id())->get();
        // $check = DriverVehicle::whereIn('vehicle_id',$vehicles)->get();
        // $vehicles = Vehicle::where('company_id',Auth::id())->whereNotIn('id',$check->pluck('vehicle_id'))->get();
        return view('company.driver_vehicles.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {


        // $check = DriverVehicle::where('driver_id',$request->driver_id)->where('vehicle_id',$request->vehicle_id)->first();
        // if(!$check){
            $vehicle = DriverVehicle::find($id);
            $vehicle->driver_id = $request->driver_id;
            $vehicle->vehicle_id = $request->vehicle_id;
            $vehicle->company_id = Auth::id();
            $vehicle->save();
              return redirect('driver/vehicles')->withSuccess('Vehicle assigned successfully');
        // }else{
        //     return redirect()->back()->withError('Vehicle already assigned');
        // }
    }
    public function destroy($id)
    {
        $vehicle = DriverVehicle::find($id);
        $vehicle->delete();
        return redirect('driver/vehicles')->withError('Vehicle unassigned successfully');
    }
}
