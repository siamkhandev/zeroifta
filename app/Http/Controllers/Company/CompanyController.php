<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function create()
    {
        return view('company.register');
    }
    public function store(Request $request)
    {
        
        $company = new User();
        $company->name=$request->name;
        $company->email=$request->email;
        $company->password=Hash::make($request->password);
        $company->role="company";
        $company->mc=$request->mc;
        $company->dot=$request->dot;
        $company->phone=$request->phone;
        
        $company->state=$request->state;
        $company->city=$request->city;
        $company->zip=$request->zip;
        $company->contact_person_name=$request->contact_person_name;
        $company->contact_person_email=$request->contact_person_email;
        $company->contact_person_phone=$request->contact_person_phone;
        $company->save();
        return redirect('login')->withSuccess('Account created successfully. Now you can login.');
       
    }
}
