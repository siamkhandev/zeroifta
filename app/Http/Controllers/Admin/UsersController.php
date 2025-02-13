<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024',
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
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function changePasswordUpdate()
    {
        return view('change-password');
    }
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
        }
        try {
            $user = User::find(Auth::id());
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withInput()->withErrors(['current_password' => 'Current password does not match']);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->withSuccess('Password updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again.']);
        }
    }

    public function readDatFile()
    {
        // Define the path to the .dat file in the public folder
        $filePath = public_path('output.dat');

        // Check if the file exists
        if (!File::exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        // Read the file
        $contents = File::get($filePath);

        // Parse the file (Assuming each line is a record and fields are separated by commas)
        $lines = explode(PHP_EOL, $contents);

        foreach ($lines as $line) {

            $data = str_getcsv($line); // Adjust according to your file structure
            dd($data);
            if (count($data) > 1) { // To ensure non-empty lines
                // Insert data into the database
                DB::table('your_table')->insert([
                    'field1' => $data[0],
                    'field2' => $data[1],
                    // Add more fields as necessary
                ]);
            }
        }

        return back()->with('success', 'File read and data inserted successfully.');
    }
}
