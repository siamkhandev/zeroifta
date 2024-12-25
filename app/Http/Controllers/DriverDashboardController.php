<?php

namespace App\Http\Controllers;

use App\Models\CompanyContactUs;
use App\Models\CompanyDriver;
use App\Models\Contactus;
use App\Models\DriverVehicle;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DriverDashboardController extends Controller
{
    public function index(Request $request)
    {
        $start = microtime(true); // Measure execution time

        // Initialize dashboard data
        $dashboardData = [];

        // Fetch vehicle data
        $vehicle = DriverVehicle::with('vehicle:id,vehicle_image,vehicle_number,mpg,odometer_reading,fuel_left,fuel_tank_capacity,model,make,make_year,license_plate_number') // Select only required fields
            ->where('driver_id', $request->driver_id)
            ->first();

        if ($vehicle && $vehicle->vehicle) {
            $vehicle->vehicle->vehicle_image = url('vehicles/' . $vehicle->vehicle->vehicle_image);
        }
        //$dashboardData['vehicle'] = $vehicle;

        // Fetch the last 5 trips
        $trips = Trip::select('id', 'user_id', 'start_lat', 'start_lng', 'end_lat', 'end_lng', 'status', 'created_at')
            ->where('user_id', $request->driver_id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Cache addresses and routes
        $addresses = $this->batchGetAddressesFromCoordinates($trips->flatMap(function ($trip) {
            return [
                ['lat' => $trip->start_lat, 'lng' => $trip->start_lng],
                ['lat' => $trip->end_lat, 'lng' => $trip->end_lng],
            ];
        })->unique());

        $routes = $this->batchGetRoutesFromCoordinates($trips);

        // Map trips with pre-fetched data
        $tripData = $trips->map(function ($trip) use ($addresses, $routes) {
            $pickupKey = "{$trip->start_lat},{$trip->start_lng}";
            $dropoffKey = "{$trip->end_lat},{$trip->end_lng}";
            $routeKey = "$pickupKey-$dropoffKey";

            return [
                'id' => $trip->id,
                'start_lat'=>$trip->start_lat,
                'start_lng'=>$trip->start_lng,
                'end_lat'=>$trip->end_lat,
                'end_lng'=>$trip->end_lng,
                'user_id' => $trip->user_id,
                'pickup' => $addresses[$pickupKey] ?? 'Unknown Location',
                'dropoff' => $addresses[$dropoffKey] ?? 'Unknown Location',
                'distance' => $routes[$routeKey]['distance'] ?? null,
                'duration' => $routes[$routeKey]['duration'] ?? null,
                'status' => $trip->status,
                'created_at' => $trip->created_at->format('d M'),
            ];
        });

        $dashboardData['recentTrips'] = $tripData;

        // Return the response
        return response()->json([
            'status' => 200,
            'message' => 'Data Fetched',
            'data' => $dashboardData,
            'execution_time' => microtime(true) - $start // Optional: For debugging
        ]);
    }
    private function batchGetAddressesFromCoordinates($coordinates)
    {
        $cacheKey = 'addresses:' . md5(serialize($coordinates)); // Cache key for results
        $addresses = cache()->remember($cacheKey, 3600, function () use ($coordinates) {
            $results = [];
            foreach ($coordinates as $coordinate) {
                $lat = $coordinate['lat'];
                $lng = $coordinate['lng'];
                $results["$lat,$lng"] = $this->getAddressFromCoordinates($lat, $lng);
            }
            return $results;
        });

        return $addresses;
    }
    private function batchGetRoutesFromCoordinates($trips)
{
    $results = [];
    foreach ($trips as $trip) {
        $start = "{$trip->start_lat},{$trip->start_lng}";
        $end = "{$trip->end_lat},{$trip->end_lng}";
        $routeKey = "$start-$end";

        $results[$routeKey] = cache()->remember("route:$routeKey", 3600, function () use ($start, $end) {
            $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg';
            $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$start}&destination={$end}&key={$apiKey}";
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                $route = $data['routes'][0]['legs'][0] ?? null;

                return [
                    'distance' => $route['distance']['text'] ?? null,
                    'duration' => $route['duration']['text'] ?? null,
                ];
            }

            return ['distance' => null, 'duration' => null];
        });
    }

    return $results;
}
    public function contactus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id'=>'required|exists:users,id',
            'subject' => 'required',
            'message'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }
        //$findCompay = CompanyDriver::where('driver_id',$request->driver_id)->first();
        $contact = new CompanyContactUs();
        //$contact->driver_id = $request->driver_id;
        $contact->company_id = $request->driver_id;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return response()->json(['status'=>200,'message'=>'Request submitted successfully','data'=>$contact],200);
    }
    public function getAddressFromCoordinates($latitude, $longitude)
{
    $apiKey = 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg'; // Use config for the API key
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

    $response = file_get_contents($url);
    $response = json_decode($response, true);

    if (isset($response['results'][0]['address_components'])) {
        foreach ($response['results'][0]['address_components'] as $component) {
            if (in_array('administrative_area_level_1', $component['types'])) {
                return $component['long_name']; // State name
            }
        }
    }

    return 'Address not found';
}
}
