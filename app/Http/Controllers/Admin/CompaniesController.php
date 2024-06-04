<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = User::whereRole('company')->orderBy('id','desc')->get();
        return view('admin.companies.index',get_defined_vars());
    }
    public function edit($id)
    {
        $company = User::find($id);
        return view('admin.companies.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {
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
        User::whereId($id)->delete();
        return redirect()->back()->withError('Company Deleted Successfully');
    }
}
