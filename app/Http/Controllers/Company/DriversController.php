<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Imports\DriversImport;
use App\Models\CompanyDriver;
use App\Models\DriverVehicle;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class DriversController extends Controller
{
    public function index()
    {
        $drivers= CompanyDriver::with('driver','company')->where('company_id',Auth::id())->latest()->get();
        return view('company.drivers.index',get_defined_vars());
    }
    public function create()
    {
        return view('company.drivers.add');
    }
    public function store(Request $request)

    {

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255',
            'driver_id' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'license_state' => 'required|string|max:255',
           'license_start_date' => 'required|date|before_or_equal:today',
           'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $driver = new User();
        $driver->first_name = $request->first_name;
        $driver->last_name = $request->last_name;
        $driver->name = $request->first_name.' '.$request->last_name;
        $driver->username = $request->username;
        $driver->driver_id = $request->driver_id;
        $driver->license_number = $request->license_number;
        $driver->license_state = $request->license_state;
        $driver->license_start_date = $request->license_start_date;
        $driver->email = $request->email;
        $driver->phone	 = $request->phone;
        $driver->password= Hash::make($request->password);
        if($request->hasFile('profile_picture')){
            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('drivers'), $imageName);
            $driver->driver_image= $imageName;
        }
        $driver->role='driver';


        $driver->save();
        $companyDriver = new CompanyDriver();
        $companyDriver->driver_id =$driver->id;
        $companyDriver->company_id =Auth::id();
        $companyDriver->save();
        return redirect('drivers/all')->withSuccess('Driver Added Successfully');
    }
    public function edit($id)
    {
        $driver = User::find($id);
        return view('company.drivers.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id.'|max:255',
            'phone' => 'required|string|max:20',
            'driver_id' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'license_state' => 'required|string|max:255',
            'license_start_date' => 'required|string|max:255',
            'username' => 'required|string|max:255',

        ]);
        $driver = User::find($id);
        $driver->first_name = $request->first_name;
        $driver->last_name = $request->last_name;
        $driver->username = $request->username;
        $driver->driver_id = $request->driver_id;
        $driver->license_number = $request->license_number;
        $driver->license_state = $request->license_state;
        $driver->license_start_date = $request->license_start_date;

        $driver->name = $request->first_name.' '.$request->last_name;
        $driver->email = $request->email;
        $driver->phone	 = $request->phone;
        if($request->hasFile('profile_picture')){
            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('drivers'), $imageName);
            $driver->driver_image= $imageName;
        }
        $driver->update();
        return redirect('drivers/all')->withSuccess('Driver Updated Successfully');
    }
    public function delete($id)
    {
        $driver = User::find($id);
        $findVehicle = CompanyDriver::where('driver_id',$id)->first();
        $findDVehicle = DriverVehicle::where('driver_id',$id)->first();
        if( $findVehicle){
            $findVehicle->delete();
        }
        if( $findDVehicle){
            $findDVehicle->delete();
        }
        $driver->delete();
        return redirect('drivers/all')->withError('Driver Deleted Successfully');
    }
    public function track($id)
    {
        $userName = User::find($id)->name;
        $trip = Trip::where('user_id', $id)->where('status', 'active')->latest()->first();
        $userId = $id;
        $geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/json";
        $startAddress = $this->getLocationFromCoordinates($trip->start_lat, $trip->start_lng);
        $endAddress = $this->getLocationFromCoordinates($trip->end_lat, $trip->end_lng);
        return view('company.drivers.track',get_defined_vars());
    }
    private function getLocationFromCoordinates($lat, $lng)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "$lat,$lng",
            'key' => 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg' // Your Google Maps API Key
        ]);

        $data = $response->json();

        // Check if the response contains results
        if (isset($data['results'][0])) {
            return $data['results'][0]['formatted_address'];
        } else {
            return 'Address not found';
        }
    }
    public function importForm()
    {
       return view('company.drivers.import');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        try{
            Excel::import(new DriversImport, $request->file('file'));
            return redirect('drivers/all')->with('success', 'Driver imported successfully.');
        }catch(\Exception $e){
            return redirect('drivers/all')->with('error', $e->getMessage());
        }



    }
}
