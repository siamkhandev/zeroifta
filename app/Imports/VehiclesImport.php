<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
class VehiclesImport implements ToModel, WithHeadingRow, OnEachRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(\Maatwebsite\Excel\Concerns\Row $row)
    {
        $row = $row->toArray(); // Convert row to array

        $valid = true;
        $message = [];

        // Validate required fields
        if (empty($row['vehicle_id']) || empty($row['vin']) || empty($row['fuel_type']) || empty($row['license_state']) || empty($row['license_number'])) {
            $valid = false;
            $message[] = 'Missing required fields.';
        }

        if ($valid) {
            // VIN Validation API Request
            $apiUrl = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVINValues/{$row['vin']}?format=json";
            $response = Http::get($apiUrl);

            // Check if the VIN is valid and the API responds with the expected data
            if ($response->successful() && isset($response->json()['Results'][0])) {
                $vehicleData = $response->json()['Results'][0];

                // Ensure valid vehicle information from API response
                if (isset($vehicleData['Make'], $vehicleData['Model'], $vehicleData['ModelYear'])) {
                    // Create a new vehicle model if all validations pass
                    Vehicle::create([
                        'vehicle_id' => $row['vehicle_id'],
                        'vin' => $row['vin'],
                        'fuel_type' => $row['fuel_type'],
                        'license_state' => $row['license_state'],
                        'license_plate_number' => $row['license_number'],
                        'odometer_reading' => $row['odometer_reading'],
                        'mpg' => $row['mpg'],
                        'fuel_tank_capacity' => $row['fuel_tank_capacity'],
                        'secondary_tank_capacity' => $row['secondary_fuel_tank_capacity'] ?? null,
                        'company_id' => Auth::id(),
                        'make' => $vehicleData['Make'],
                        'model' => $vehicleData['Model'],
                        'make_year' => $vehicleData['ModelYear'],
                    ]);
                    return true; // Record successfully created
                } else {
                    $message[] = 'Incomplete vehicle details from VIN API.';
                    Log::warning('Invalid vehicle data from VIN API', ['row' => $row, 'messages' => $message]);
                }
            } else {
                $message[] = 'Invalid or unreachable VIN API response.';
                Log::warning('VIN API error', ['row' => $row, 'messages' => $message]);
            }
        } else {
            Log::warning('Vehicle import failed due to validation errors:', ['row' => $row, 'messages' => $message]);
        }

        return false; // Validation failed, skip the record
    }
}
