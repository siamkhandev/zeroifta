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
    protected $successCount = 0;
    protected $errorCount = 0;
    protected $errors = [];

    public function model(array $row)
    {
        $licenseStartDate = is_numeric($row['license_start_date'])
            ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['license_start_date'])->format('Y-m-d')
            : $row['license_start_date'];

        try {
            // Validate the row
            $validator = Validator::make([
                'email' => $row['email'],
                'driver_id' => $row['driver_id'],
                'username' => $row['username'],
                'license_number' => $row['license_number'],
                'license_start_date' => $licenseStartDate,
            ], [
                'email' => 'required|email|unique:users,email',
                'driver_id' => 'required|unique:users,driver_id',
                'username' => 'required|string|unique:users,username',
                'license_number' => 'required|string|unique:users,license_number',
                'license_start_date' => 'required|date|before_or_equal:today',
            ]);

            if ($validator->fails()) {
                // Record the error
                $this->errors[] = [
                    'row' => $row,
                    'error' => $validator->errors()->first(),
                ];
                $this->errorCount++;
                return null; // Skip this row
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

            $this->successCount++;
        } catch (\Exception $e) {
            // Record the error
            $this->errors[] = [
                'row' => $row,
                'error' => $e->getMessage(),
            ];
            $this->errorCount++;
        }
    }

    // Method to get results
    public function getResults()
    {
        return [
            'successCount' => $this->successCount,
            'errorCount' => $this->errorCount,
            'errors' => $this->errors,
        ];
    }
}

