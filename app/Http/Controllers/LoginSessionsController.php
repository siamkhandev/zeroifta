<?php

namespace App\Http\Controllers;

use App\Models\LoginSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class LoginSessionsController extends Controller
{
    public function storeLoginSession(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'device' => 'required|string',
            'device_name' => 'required|string',
            'ip_address' => 'required|string',
            'location' => 'nullable|string',
        ]);

        // Generate session_id
        $sessionId = Str::uuid()->toString();

        // Create a new login session record
        $loginSession = LoginSession::create([
            'session_id' => $sessionId,
            'user_id' => $request->user_id,
            'login_time' => now(),
            'device' => $request->device,
            'device_name' => $request->device_name,
            'ip_address' => $request->ip_address,
            'location' => $request->location,
            'status' => 'active',
        ]);

        // Return response
        return response()->json([
            'status' => 200,
            'message' => 'Login session stored successfully.',
            'data' => $loginSession,
        ]);
    }
}
