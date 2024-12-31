<?php

namespace App\Imports;

use App\Models\CompanyDriver;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
class DriversImport implements ToModel, WithHeadingRow,SkipsOnFailure
{
    use SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
{
    $licenseStartDate = is_numeric($row['license_start_date'])
        ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['license_start_date'])->format('Y-m-d')
        : $row['license_start_date'];

    // Initialize success and error counters
    $successCount = 0;
    $errorCount = 0;
    $errors = [];

    try {
        // Validate the row
        $validator = Validator::make($row, [
            'email' => 'required|email|unique:users,email',
            'driver_id' => 'required|unique:users,driver_id',
            'username' => 'required|string|unique:users,username',
        ]);

        if ($validator->fails()) {
            // Record the error
            $errors[] = [
                'row' => $row,
                'error' => $validator->errors()->first(),
            ];
            $errorCount++;
            return; // Skip this row
        }

        // Create the User record
        $drivers = new User([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'driver_id' => $row['driver_id'],
            'name' => $row['first_name'] . ' ' . $row['last_name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'license_state' => $row['license_state'],
            'license_number' => $row['license_number'],
            'license_start_date' => $licenseStartDate,
            'username' => $row['username'],
            'password' => Hash::make('password'),
            'role' => 'driver',
            'company_id' => Auth::id(),
        ]);

        $drivers->save(); // Save the user to generate an ID

        // Create the CompanyDriver record
        CompanyDriver::create([
            'company_id' => Auth::id(),
            'driver_id' => $drivers->id,
        ]);

        $successCount++;
    } catch (\Exception $e) {
        // Record the error
        $errors[] = [
            'row' => $row,
            'error' => $e->getMessage(),
        ];
        $errorCount++;
    }

    // Log errors (optional)
    foreach ($errors as $error) {
        Log::error('Import error', $error);
    }

    // Return success and error counts
    return [
        'successCount' => $successCount,
        'errorCount' => $errorCount,
        'errors' => $errors,
    ];
}
}
