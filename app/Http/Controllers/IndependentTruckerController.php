<?php

namespace App\Http\Controllers;

use App\Models\CompanyDriver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndependentTruckerController extends Controller
{
    public function store(Request $request)
    {

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|numeric|max:20',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255',
            'driver_id' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'license_state' => 'required|string|max:255',
           'license_start_date' => 'required|date|before_or_equal:today',
        ]);
        $company = new User();
        $company->name=$request->name;
        $company->email=$request->email;
        $company->password=Hash::make($request->password);
        $company->role="company";
        $company->register_type = 'trucker';
        $company->phone=$request->phone;
        $company->save();
        
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
        $driver->role='driver';


        $driver->save();
        $companyDriver = new CompanyDriver();
        $companyDriver->driver_id =$driver->id;
        $companyDriver->company_id =$company->id;
        $companyDriver->save();
        return response()->json([
            'status'=>200,
            'message'=>'Independent trucker added',
            'data'=>$driver
        ]);
    }
}
