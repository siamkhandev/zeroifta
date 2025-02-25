<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewPasswordController extends Controller
{
    public function create(Request $request)
    {
        $token = $request->route('token');
        $email = $request->query('email');

        // Validate token and email
        $resetRequest = DB::table('password_reset_tokens')->where('token', $token)->where('email', $email)->first();

        if (!$resetRequest || Carbon::parse($resetRequest->created_at)->addMinutes(60)->isPast()) {
            return redirect()->route('password.request')->withErrors(['email' => 'This password reset link is invalid or has expired.']);
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if token and email match
        $resetRequest = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$resetRequest) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Update the password
        $user = \App\Models\User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the reset request
        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset successfully!');
    }
}
