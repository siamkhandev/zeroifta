<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyContactUs;
use App\Models\CompanyDriver;
use App\Models\DriverVehicle;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = User::whereRole('company')->orWhere('role','trucker')->orderBy('id','desc')->get();
        return view('admin.companies.index',get_defined_vars());
    }
    public function edit($id)
    {
        $company = User::find($id);
        return view('admin.companies.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'dot' => 'required|string|max:255',
            'mc' => 'required|string|max:255',

        ]);
        $company = User::find($id);
        $company->name=$request->name;
        $company->email=$request->email;
        $company->mc=$request->mc;
        $company->dot=$request->dot;
        $company->phone=$request->phone;
        $company->state=$request->state;
        $company->city=$request->city;
        $company->zip=$request->zip;
        $company->contact_person_name=$request->contact_person_name;
        $company->contact_person_email=$request->contact_person_email;
        $company->contact_person_phone=$request->contact_person_phone;
        $company->update();
        return redirect('companies')->withSuccess('Company Updated Successfully');
    }
    public function delete($id)
    {
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Perform deletion
            Vehicle::where('company_id', $id)->delete();
            DriverVehicle::where('company_id', $id)->delete();
            CompanyDriver::where('company_id', $id)->delete();
            User::whereId($id)->delete();

            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            DB::commit();
            return redirect()->back()->with('error', 'Company Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function changePassword(Request $request, $companyId)
    {
        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',  // password confirmation is automatically checked
        ]);
        $company = User::find($companyId);
        if (!$company) {
            return response()->json(['status' => 400, 'message' => 'Company not found']);
        }

        // Update password
        $company->password = Hash::make($request->password);
        $company->save();

        return response()->json(['status' => 200, 'message' => 'Password changed successfully']);

    }
}
