<?php

namespace App\Http\Controllers;

use App\Models\FuelStation;
use App\Models\Trip;
use Illuminate\Http\Request;

class FuelStationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'trip_id' => 'required|exists:trips,id',
            'stations' => 'required|array',
            'stations.*.name' => 'required',
            'stations.*.latitude' => 'required|numeric|between:-90,90',
            'stations.*.longitude' => 'required|numeric|between:-180,180',
        ]);

        // Store each fuel station
        foreach ($validated['stations'] as $station) {
            FuelStation::create([
                'user_id' => $validated['user_id'],
                'trip_id' => $validated['trip_id'],
                'name' => $station['name'],
                'latitude' => $station['latitude'],
                'longitude' => $station['longitude'],
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Fuel stations saved successfully','data' => (object)[]]);
    }
    public function getFuelStations($user_id)
    {
        $trip = Trip::where('user_id', $user_id)->where('status', 'active')->first();
        $fuelStations = FuelStation::where('user_id', $user_id)->where('trip_id', $trip->id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'Fuel stations retrieved successfully',
            'data' => $fuelStations
        ]);
    }
}
