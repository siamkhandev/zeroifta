<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $validator = Validator::make($row, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed', // Laravel's 'confirmed' rule checks if 'password' and 'password_confirmation' match
        ]);

        // Skip the row if validation fails
        if ($validator->fails()) {
            return null; // Skipping invalid rows
        }
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'dot' => $row['dot'],
            'mc' => $row['mc'],
            'password' => Hash::make($row['password']),
            'role' => 'driver',
            'company_id' => Auth::id(),
        ]);
    }
}
