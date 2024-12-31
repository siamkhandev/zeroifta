<?php

namespace App\Imports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehiclesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $createdCount;
    protected $failedCount;
    protected $failedRecords;
    public function __construct(&$createdCount, &$failedCount, &$failedRecords)
    {
        $this->createdCount = &$createdCount;
        $this->failedCount = &$failedCount;
        $this->failedRecords = &$failedRecords;
    }
    public function model(array $row)
    {
        $row = array_map('trim', $row);  // Clean up extra spaces if any

        // Track success and failure
        $valid = true;
        $message = [];
        $response = null; // Initialize response to null
        $requiredFields = [
            'vehicle_id', 'vin',  'fuel_type',
            'license_state', 'license_number', 'odometer_reading', 'mpg'
        ];
        foreach ($requiredFields as $field) {
            if (empty($row[$field])) {
                $valid = false;
                $message[] = "The {$field} field is required.";
            }
        }
        if ($valid) {
            $existingVehicle = Vehicle::where('vehicle_id', $row['vehicle_id'])
                                      ->orWhere('vin', $row['vin'])
                                      ->orWhere('license_plate_number', $row['license_number'])
                                      ->first();
            if ($existingVehicle) {
                $valid = false;
                $message[] = 'Duplicate vehicle_id, VIN, or license plate number detected.';
            }
        }


        // VIN Validation API Request
        if ($valid) {
            $apiUrl = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVINValues/{$row['vin']}?format=json";
            $response = Http::get($apiUrl);  // This defines the $response variable
        }

        // Check if the VIN is valid
        if ($valid && (!$response || !$response->successful() || !isset($response->json()['Results'][0]))) {
            $valid = false;
            $message[] = 'Invalid VIN.';
        }


        // Extract vehicle data if VIN is valid
        $vehicleData = $valid ? $response->json()['Results'][0] ?? null : null;

        // Ensure valid vehicle information from API response
        if ($valid && ($vehicleData === null || empty($vehicleData['Make']) || empty($vehicleData['Model']) || empty($vehicleData['ModelYear']))) {
            $valid = false;
            $message[] = 'Incomplete vehicle details from VIN API.';
        }

        // If the row is valid, create the vehicle record
        if ($valid) {
            return new Vehicle([
                'vehicle_id' => $row['vehicle_id'],
                'vin' => $row['vin'],
                'fuel_type' => $row['fuel_type'],
                'license' => $row['license_state'],
                'license_plate_number' => $row['license_number'],
                'odometer_reading' => $row['odometer_reading'] ?? null,
                'mpg' => $row['mpg'] ?? null,
                'fuel_tank_capacity' => $row['fuel_tank_capacity'] ?? null,
                'secondary_tank_capacity' => $row['secondary_fuel_tank_capacity'] ?? null,
                'company_id' => auth()->id(),
                'make' => $vehicleData['Make'],
                'model' => $vehicleData['Model'],
                'make_year' => $vehicleData['ModelYear'],
            ]);
            $this->createdCount++;
        } else {
            // Log failure message with row data for debugging
            \Log::warning('Vehicle import failed due to validation errors:', [
                'row' => $row,
                'messages' => $message
            ]);
            $this->failedCount++;
            $this->failedRecords[] = ['row' => $row, 'messages' => $message];
            return null;  // Skip the invalid row
        }
    }
}
