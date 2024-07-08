<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyContactUs;
use App\Models\CompanyDriver;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->role=='admin')
        {
            $data = User::where('role','company')->take(10)->latest()->get();
        }else{
            $data = CompanyDriver::with('driver','company')->where('company_id',Auth::id())->take(10)->latest()->get();
        }
        return view('admin.index',get_defined_vars());
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
            
        ]);
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/');
        }else{
            return redirect()->back()->withInput()->withErrors(['email' => 'Invalid Credentials']);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
    public function contactUsForms()
    {
        $forms = CompanyContactUs::with('company')->orderBy('company_contact_us.id','desc')->get();
        
        return view('admin.contactus.index',get_defined_vars());
    }
    public function readForm($id)
    {
        $form = CompanyContactUs::with('company')->find($id);
      
        return view('admin.contactus.read',get_defined_vars());
    }
    public function deleteForm($id)
    {
        $form = CompanyContactUs::find($id);
        $form->delete();
        return redirect('contactus/all')->withError('Record Deleted Successfully');
    }
}
