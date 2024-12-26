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
        'new_driver_id' => 'required|exists:drivers,id',
        'vehicle_id' => 'required|exists:vehicles,id',
    ]);

    // Remove current assignment
    $currentAssignment = DriverVehicle::find($request->driver_vehicle_id);
    if ($currentAssignment) {
        $currentAssignment->delete();
    }

    // Assign the vehicle to the new driver
    DriverVehicle::create([
        'driver_id' => $request->new_driver_id,
        'vehicle_id' => $request->vehicle_id,
        'company_id' => Auth::id(),
    ]);

    return redirect()->route('driver_vehicles')->with('success', 'Vehicle reassigned successfully.');
}
public function checkAssignment(Request $request)
{
    $vehicleId = $request->vehicle_id;
    $currentAssignment = DriverVehicle::where('vehicle_id', $vehicleId)->first();

    if ($currentAssignment) {
        $currentDriver = $currentAssignment->driver->name; // Assuming driver relation exists
        return response()->json([
            'assigned' => true,
            'current_driver' => $currentDriver,
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
