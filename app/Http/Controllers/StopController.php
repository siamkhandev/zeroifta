<?php

namespace App\Http\Controllers;

use App\Models\DriverVehicle;
use App\Models\FuelStation;
use App\Models\Trip;
use App\Models\Tripstop;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class StopController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['stops'] = array_map(function ($stop) {
            return [
                'stop_name' => $stop["'stop_name'"] ?? null,
                'stop_lat' => $stop["'stop_lat'"] ?? null,
                'stop_lng' => $stop["'stop_lng'"] ?? null,
            ];
        }, $data['stops'] ?? []);

        // Validate the cleaned data
        $validator = Validator::make($data, [
            'trip_id' => 'required|exists:trips,id',
            'stops' => 'required|array',
            'stops.*.stop_lat' => 'required|numeric',
            'stops.*.stop_lng' => 'required|numeric',
            'stops.*.stop_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors()->first(),
                'data' => (object) [],
            ]);
        }

        // Save stops
        $stopsData = array_map(function ($stop) use ($request) {
            return [
                'trip_id' => $request->trip_id,
                'stop_name' => $stop['stop_name'] ?? null,
                'stop_lat' => $stop['stop_lat'],
                'stop_lng' => $stop['stop_lng'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $request->stops);

        Tripstop::insert($stopsData);
        $trip = Trip::whereId($request->trip_id)->first();
        $fuelStations = FuelStation::where('trip_id', $request->trip_id)->get()
    ->map(function ($station) {
        // Convert the station to an array, keeping all attributes
        $data = $station->toArray();

        // Add the new keys
        $data['ftp_lat'] = $data['latitude'];
        $data['ftp_lng'] = $data['longitude'];
        $data['fuel_station_name'] = $data['name'];
        $data['IFTA_tax'] = floatval(preg_replace('/[^0-9.-]/', '', $station->ifta_tax));
        $data['lastprice'] = floatval(preg_replace('/[^0-9.-]/', '', $station->lastprice));
        $data['price'] = floatval(preg_replace('/[^0-9.-]/', '', $station->price));
        $data['discount'] = $data['discount'] ? (double)$data['discount'] : 0;
        $data['gallons_to_buy'] = $data['gallons_to_buy'] ? (double)$data['gallons_to_buy'] :null;
        $data['is_optimal'] = $data['is_optimal'] ? (bool)$data['is_optimal'] : false;
        // Optionally remove the old keys if not needed
        unset($data['latitude'], $data['longitude'],$data['ifta_tax'],$data['name']);

        return $data;
    });
        $startLat = $trip->start_lat;
        $startLng = $trip->start_lng;
        $endLat = $trip->end_lat;
        $endLng = $trip->end_lng;
        $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$startLat},{$startLng}&destination={$endLat},{$endLng}&key={$apiKey}";
        $response = Http::get($url);
        if ($response->successful()) {
            $data = $response->json();
            $route = $data['routes'][0];

            $distanceText = isset($route['legs'][0]['distance']['text']) ? $route['legs'][0]['distance']['text'] : null;
            $durationText = isset($route['legs'][0]['duration']['text']) ? $route['legs'][0]['duration']['text'] : null;

            // Format distance (e.g., "100 miles")
            if ($distanceText) {
                $distanceParts = explode(' ', $distanceText);
                $formattedDistance = $distanceParts[0] . ' miles'; // Ensuring it always returns distance in miles
            }

            // Format duration (e.g., "2 hr 20 min")
            if ($durationText) {
                $durationParts = explode(' ', $durationText);
                $hours = isset($durationParts[0]) ? $durationParts[0] : 0;
                $minutes = isset($durationParts[2]) ? $durationParts[2] : 0;
                $formattedDuration = $hours . ' hr ' . $minutes . ' min'; // Formatting as "2 hr 20 min"

            }
            if (isset($data['routes'][0]['overview_polyline']['points'])) {
                $encodedPolyline = $data['routes'][0]['overview_polyline']['points'];
                $decodedPolyline = $this->decodePolyline($encodedPolyline);
            }
        }
        $vehicle = DriverVehicle::where('driver_id', $trip->user_id)->pluck('vehicle_id')->first();
        $vehicle = Vehicle::where('id', $vehicle)->first();
        if($trip){
            $trip->distance = $formattedDistance;
            $trip->duration = $formattedDuration;
            $trip->user_id = (int)$trip->user_id;
            $response = [
                'trip_id' => $trip->id,
                'trip' => $trip,
                'fuel_stations' => $fuelStations,
                'polyline' => $decodedPolyline,
                'stops' => $request->stops,
                'vehicle' => $vehicle
            ];
            return response()->json(['status'=>200,'message'=>'trip found','data'=>$response],200);
        }else{
            return response()->json(['status'=>404,'message'=>'trip not found','data'=>[]],404);
        }

    }

}
