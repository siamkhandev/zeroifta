<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'end_lat'   => 'required|numeric',
            'end_lng'   => 'required|numeric',
        ]);

        // Store the trip details
        Trip::create($validatedData);

        return response()->json(['status' => 'success', 'message' => 'Trip coordinates stored successfully']);
    }
    public function getTrip($user_id)
    {
        $trip = Trip::where('user_id', $user_id)->first();

        if (!$trip) {
            return response()->json(['status' => 'error', 'message' => 'No trip found for this user']);
        }

        return response()->json(['status' => 'success', 'data' => $trip]);
    }
}
