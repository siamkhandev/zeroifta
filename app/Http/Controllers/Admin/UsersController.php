<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function profile()
    {
        $profile = Auth::user();
        return view('profile',get_defined_vars());
    }
    public function profileUpdate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
            'dot' => 'required|string|max:255',
            'mc' => 'required|string|max:255',
            
        ]);
        $user = User::whereId(Auth::id())->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->dot = $request->dot;
        $user->mc = $request->mc;
        $user->city = $request->city;
        $user->state = $request->state;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $user->image= $imageName;
        }
        $user->update();
        return redirect()->back();
    }
    public function passwordUpdate(Request $request)
    {
       
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        try{
            $user = User::whereId(Auth::id())->first();
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withError('Current password does not match');
            }
            $user->password = Hash::make($request->password);
            $user->update();
            return redirect()->back()->withSuccess('Password updated successfully');
        }catch(Exception $e){
            dd($e->getMessage());
        }
       
    }
}
