<?php

namespace App\Http\Controllers;

use App\Models\FuelStation;
use App\Models\Trip;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
class TripController extends Controller
{
    

    public function store(Request $request)
    {
        // Step 1: Validate request data
        $validatedData = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'start_lat' => 'required|numeric',
            'start_lng' => 'required|numeric',
            'end_lat'   => 'required|numeric',
            'end_lng'   => 'required|numeric',
        ]);

        //Step 2: Check if a trip already exists for this user
        $findTrip = Trip::where('user_id', $validatedData['user_id'])->where('status', 'active')->first();
        if ($findTrip) {
            return response()->json(['status' => 422, 'message' => 'Trip already exists for this user', 'data' => (object)[]]);
        }
        $validatedData['status']='active';
        
    
        $trip = Trip::create($validatedData);
        
        // Step 4: Find and save gas stations along the route
        $gasStations = $this->findGasStations($validatedData['start_lat'], $validatedData['start_lng'], $validatedData['end_lat'], $validatedData['end_lng']);
       
        $ftpData = $this->loadAndParseFTPData();
       if($gasStations){
        foreach ($gasStations as $station) {
            $lat = number_format((float) $station['latitude'], 4);
            $lng = number_format((float) $station['longitude'], 4);

            $price = $ftpData[$lat][$lng]['price'] ?? 0.00;
            //$price = $ftpData[$station['latitude']][$station['longitude']]['price'] ?? 0.00;
            $fuelStation= FuelStation::create([
                'user_id'   => $validatedData['user_id'],
                'trip_id'   => $trip->id,
                'name'      => $station['name'],
                'latitude'  => $station['latitude'],
                'longitude' => $station['longitude'],
                'price'     => $price,
            ]);
            $storedStations[] = $fuelStation;
        }
       }
        

        return response()->json(['status' => 200, 'message' => 'Trip and gas stations stored successfully','data'    => [
            'trip'          => $trip,
            'gas_stations'  => $storedStations ?? [],
        ]]);
    }
    private function loadAndParseFTPData()
    {
        return Cache::remember('parsed_ftp_data', 3600, function () {
            $filePath = 'EFSLLCpricing';
    
            // Connect to the FTP disk
            $ftpDisk = Storage::disk('ftp');
            if (!$ftpDisk->exists($filePath)) {
                throw new \Exception("FTP file not found.");
            }
    
            $fileContent = $ftpDisk->get($filePath);
            $rows = explode("\n", trim($fileContent));
            $parsedData = [];
    
            foreach ($rows as $line) {
                $row = explode('|', $line);
                if (isset($row[8], $row[9])) {
                    $lat = number_format((float) trim($row[8]), 4);
                    $lng = number_format((float) trim($row[9]), 4);
                    $parsedData[$lat][$lng] = ['price' => $row[11] ?? 0.00];
                }
            }
    
            return $parsedData;
        });
    }
    private function findGasStations($startLat, $startLng, $endLat, $endLng)
    {
        $client = new Client();
        $radius = 2000; // Search radius of 500 meters
        $distance = $this->calculateDistance($startLat, $startLng, $endLat, $endLng);
        
        // Calculate the number of API requests dynamically based on route length
        $maxRequests = max(5, (int)($distance / 5)); // 1 request per 5 km, with a minimum of 5 requests
        $epsilon = 0.001; // Tolerance for RDP simplification (smaller values retain more points)

        $gasStations = [];

        // Generate initial route points
        $routePoints = $this->getRoutePoints($startLat, $startLng, $endLat, $endLng, 100); // Generate more points initially

        // Simplify route points using RDP
        $simplifiedPoints = $this->ramerDouglasPeucker($routePoints, $epsilon);

        // Limit checkpoints based on calculated maxRequests
        $checkpoints = array_slice($simplifiedPoints, 0, $maxRequests);

        // Google Places API URL
        $url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json';

        foreach ($checkpoints as $point) {
            $response = $client->get($url, [
                'query' => [
                    'location' => "{$point['lat']},{$point['lng']}",
                    'radius' => $radius,
                    'type' => 'gas_station',
                    'key' => 'AIzaSyBtQuABE7uPsvBnnkXtCNMt9BpG9hjeDIg'
                ]
            ]);
        
            $results = json_decode($response->getBody(), true)['results'];
            foreach ($results as $result) {
                $gasStations[] = [
                    'name' => $result['name'],
                    'latitude' => round($result['geometry']['location']['lat'], 4),
                    'longitude' => round($result['geometry']['location']['lng'], 4),
                ];
            }
        }

        // Remove duplicate stations
        $uniqueGasStations = collect($gasStations)->unique(function ($station) {
            return $station['name'] . $station['latitude'] . $station['longitude'];
        })->values()->all();

        return $uniqueGasStations;
    }

    private function getRoutePoints($startLat, $startLng, $endLat, $endLng, $numPoints)
    {
        $points = [];
        for ($i = 0; $i <= $numPoints; $i++) {
            $fraction = $i / $numPoints;
            $lat = $startLat + $fraction * ($endLat - $startLat);
            $lng = $startLng + $fraction * ($endLng - $startLng);
            $points[] = ['lat' => $lat, 'lng' => $lng];
        }
        return $points;
    }

    private function ramerDouglasPeucker($points, $epsilon)
    {
        if (count($points) < 3) {
            return $points;
        }

        // Find the point with the maximum distance
        $dmax = 0;
        $index = 0;
        $end = count($points) - 1;

        for ($i = 1; $i < $end; $i++) {
            $d = $this->perpendicularDistance($points[$i], $points[0], $points[$end]);
            if ($d > $dmax) {
                $index = $i;
                $dmax = $d;
            }
        }

        // If max distance is greater than epsilon, recursively simplify
        if ($dmax > $epsilon) {
            $recResults1 = $this->ramerDouglasPeucker(array_slice($points, 0, $index + 1), $epsilon);
            $recResults2 = $this->ramerDouglasPeucker(array_slice($points, $index, $end - $index + 1), $epsilon);

            return array_merge(array_slice($recResults1, 0, -1), $recResults2);
        } else {
            return [$points[0], $points[$end]];
        }
    }

    private function perpendicularDistance($point, $lineStart, $lineEnd)
    {
        $x0 = $point['lat'];
        $y0 = $point['lng'];
        $x1 = $lineStart['lat'];
        $y1 = $lineStart['lng'];
        $x2 = $lineEnd['lat'];
        $y2 = $lineEnd['lng'];

        $numerator = abs(($y2 - $y1) * $x0 - ($x2 - $x1) * $y0 + $x2 * $y1 - $y2 * $x1);
        $denominator = sqrt(pow($y2 - $y1, 2) + pow($x2 - $x1, 2));

        return $denominator == 0 ? 0 : $numerator / $denominator;
    }

    private function calculateDistance($startLat, $startLng, $endLat, $endLng)
    {
        $earthRadius = 6371; // Radius in kilometers

        $dLat = deg2rad($endLat - $startLat);
        $dLng = deg2rad($endLng - $startLng);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($startLat)) * cos(deg2rad($endLat)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Distance in kilometers
    }


    public function getTrip($user_id)
    {
        $trip = Trip::where('user_id', $user_id)->first();

        if (!$trip) {
            return response()->json(['status' =>404, 'message' => 'No trip found for this user', 'data' => (object)[]]);
        }

        return response()->json(['status' => 200, 'message' => 'Trip retrieved successfully', 'data' => $trip]);
    }
    public function deleteTrip(Request $request)
    {
        $trip = Trip::whereId($request->trip_id)->first();
        if (!$trip) {
            return response()->json(['status' => 404, 'message' => 'No trip found for this user', 'data' => (object)[]]);
        }
        $trip->delete();
        return response()->json(['status' => 200, 'message' => 'Trip deleted successfully', 'data' => (object)[]]);
    }
    public function completeTrip(Request $request){
        $trip = Trip::whereId($request->trip_id)->first();
        if (!$trip) {
            return response()->json(['status' => 404, 'message' => 'No trip found', 'data' => (object)[]]);
        }
        $trip->status = 'completed';
        $trip->save();
        return response()->json(['status' => 200, 'message' => 'Trip completed successfully', 'data' => (object)[]]);
    }
    function fetchFileDataAndMatchCoordinates($latitude, $longitude)
    {
        $filePath = 'EFSLLCpricing'; // The FTP file name

        // Connect to the FTP disk
        $ftpDisk = Storage::disk('ftp');
        
        // Check if the file exists
        if (!$ftpDisk->exists($filePath)) {
            return "File not found.";
        }
        
        // Get the file content
        $fileContent = $ftpDisk->get($filePath);

        // Convert content to an array by splitting lines
        $rows = explode("\n", trim($fileContent));

        // Loop through the lines to find matching coordinates
        foreach ($rows as $line) {
            $row = explode('|', $line); // Split by the pipe character
            
            // Check if the line contains latitude and longitude data
            // Assuming latitude is at index 8 and longitude is at index 9
            if (isset($row[8], $row[9]) && trim($row[8]) == $latitude && trim($row[9]) == $longitude) {
                return $row; // Return the matching row
            }
        }

        return "No matching coordinates found.";
    }
}
