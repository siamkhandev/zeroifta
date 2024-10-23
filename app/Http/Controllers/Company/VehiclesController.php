<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Imports\VehiclesImport;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class VehiclesController extends Controller
{
    public function index()
    {
        $vehicles= Vehicle::where('company_id',Auth::id())->orderBy('id','desc')->get();
        return view('company.vehicles.index',get_defined_vars());
    }
    public function create()
    {
        return view('company.vehicles.add');
    }
    public function store(Request $request)

    {
        $data = $request->validate([
            'vehicle_type' => 'required',
            'vehicle_number' => 'required',
            'odometer_reading' => 'required',
            'mpg' => 'required',
            'image' => 'required',
            
        ]);
        $vehicle = new Vehicle();
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->odometer_reading	 = $request->odometer_reading;
        $vehicle->company_id = Auth::id();
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
        $data = $request->validate([
            'vehicle_type' => 'required',
            'vehicle_number' => 'required',
            'odometer_reading' => 'required',
            'mpg' => 'required',

            
        ]);
        $vehicle = Vehicle::find($id);
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_number = $request->vehicle_number;
        $vehicle->company_id = Auth::id();
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
    public function importForm()
    {
       return view('company.vehicles.import');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new VehiclesImport, $request->file('file'));

        return redirect('vehicles/all')->with('success', 'Vehicles imported successfully.');
    }
}
