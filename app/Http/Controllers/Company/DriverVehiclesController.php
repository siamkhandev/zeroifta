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
        $checkVehicle = DriverVehicle::where('vehicle_id',$request->vehicle_id)->first();
        if($checkVehicle){
            return redirect()->back()->withError('This vehicle is already assigned. Please select another vehicle or remove this vehicle from the driver.');
        }
        $check = DriverVehicle::where('driver_id',$request->driver_id)->where('vehicle_id',$request->vehicle_id)->first();
        if(!$check){
            $vehicle = new DriverVehicle();
            $vehicle->driver_id = $request->driver_id;
            $vehicle->vehicle_id = $request->vehicle_id;
            $vehicle->company_id = Auth::id();
            $vehicle->save();
              return redirect('driver/vehicles')->withSuccess('Vehicle assigned successfully');
        }else{
            return redirect()->back()->withError('Vehicle already assigned');
        }

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
