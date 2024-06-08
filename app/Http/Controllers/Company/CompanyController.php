<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\CompanyContactUs;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function create()
    {
        return view('company.register');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required|string|max:20',
            'dot' => 'required|string|max:255',
            'mc' => 'required|string|max:255',
            'password'=>'required|min:8|confirmed'
        ]);
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
        $company->contact_person_name=$request->contact_name;
        $company->contact_person_email=$request->contact_email;
        $company->contact_person_phone=$request->contact_phone;
        $company->save();
        return redirect('login')->withSuccess('Account created successfully. Now you can login.');
       
    }

    public function contactus()
    {
        return view('company.contactus');
    }
    public function submitContactUs(Request $request)
    {
        $contact = new CompanyContactUs();
        $contact->subject = $request->subject;
        $contact->company_id = Auth::id();
        $contact->phone = $request->phone;
        $contact->description = $request->description;
        $contact->save();
        return redirect()->back()->withSuccess('Information Submitted Successfully');
    }
    public function showPlans()
    {
        $plans = Plan::get();
        $userPlan = Payment::where('company_id',Auth::id())->where('status','active')->first();
        return view('company.plans',get_defined_vars());
    }
   
}
