<?php

namespace App\Imports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class VehiclesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Track success and failure
        $valid = true;
        $message = [];

        // Validate required fields
        if (empty($row['vehicle_id']) || empty($row['vin']) || empty($row['fuel_type']) || empty($row['license_state']) || empty($row['license_number'])) {
            $valid = false;
            $message[] = 'Missing required fields.';
        }

        // VIN Validation API Request
        $apiUrl = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVINValues/{$row['vin']}?format=json";
        $response = Http::get($apiUrl);

        // Check if the VIN is valid
        if (!$response->successful() || !isset($response->json()['Results'][0])) {
            $valid = false;
            $message[] = 'Invalid VIN.';
        }

        $vehicleData = $response->json()['Results'][0];

        // Ensure valid vehicle information from API response
        if (empty($vehicleData['Make']) || empty($vehicleData['Model']) || empty($vehicleData['ModelYear'])) {
            $valid = false;
            $message[] = 'Incomplete vehicle details from VIN API.';
        }

        if ($valid) {
            // Create a new vehicle model if all validations pass
            return new Vehicle([
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
        } else {
            // Log failure message with row data for debugging
            Log::warning('Vehicle import failed due to validation errors:', [
                'row' => $row,
                'messages' => $message
            ]);

            return null;  // Skip this row if validation failed
        }
    }
}
