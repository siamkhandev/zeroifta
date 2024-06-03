<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
       
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('dashboard');
        }else{
            return redirect()->back()->withError('Invalid Credentials');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
