<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyDriver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class DriversController extends Controller
{
    public function index()
    {
        $drivers= CompanyDriver::with('driver','company')->get();
        return view('company.drivers.index',get_defined_vars());
    }
    public function create()
    {
        return view('company.drivers.add');
    }
    public function store(Request $request)

    {
        $driver = new User();
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->phone	 = $request->phone;
        $driver->password= Hash::make($request->password);
        $driver->dot=$request->dot;
        $driver->role='driver';
        $driver->mc=$request->mc;
        $driver->save();
        $companyDriver = new CompanyDriver();
        $companyDriver->driver_id =$driver->id;
        $companyDriver->company_id =Auth::id();
        $companyDriver->save();
        return redirect('drivers')->withSuccess('Driver Added Successfully');
    }
    public function edit($id)
    {
        $driver = User::find($id);
        return view('company.drivers.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {
        $driver = User::find($id);
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->phone	 = $request->phone;
        $driver->dot=$request->dot;
        $driver->mc=$request->mc;
        $driver->update();
        return redirect('drivers')->withSuccess('Driver Updated Successfully');
    }
    public function delete($id)
    {
        $driver = User::find($id);
        CompanyDriver::where('driver_id',$id)->delete();
        $driver->delete();
        return redirect('drivers')->withError('Driver Deleted Successfully');
    }
}
