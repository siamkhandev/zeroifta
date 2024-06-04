<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index()
    {
        $vehicles= Vehicle::orderBy('id','desc')->get();
        return view('company.vehicles.index',get_defined_vars());
    }
    public function create()
    {
        return view('company.vehicles.add');
    }
    public function store(Request $request)

    {
        $vehicle = new Vehicle();
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->odometer_reading	 = $request->odometer_reading;
        $vehicle->mpg= $request->mpg;
        $vehicle->fuel_tank_capacity= $request->fuel_tank_capacity;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('vehicles'), $imageName);
            $vehicle->vehicle_image= $imageName;
        }
        $vehicle->save();
        return redirect('vehicles/all')->withSuccess('Vehicle Added Successfully');
    }
    public function edit($id)
    {
        $vehicle = Vehicle::find($id);
        return view('company.vehicles.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->odometer_reading	 = $request->odometer_reading;
        $vehicle->mpg= $request->mpg;
        $vehicle->fuel_tank_capacity= $request->fuel_tank_capacity;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('vehicles'), $imageName);
            $vehicle->vehicle_image= $imageName;
        }
        $vehicle->update();
        return redirect('vehicles/all')->withSuccess('vehicle Updated Successfully');
    }
    public function delete($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->delete();
        return redirect('vehicles/all')->withError('vehicle Deleted Successfully');
    }
}
