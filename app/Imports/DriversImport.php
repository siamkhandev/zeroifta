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
        dd($row);
        $validator = Validator::make($row, [
            'email' => 'required|email|unique:users,email',
            'driver_id' => 'required|unique:users,driver_id',
            'username' => 'required|string|unique:users,username',
            //'password' => 'required|confirmed',
        ]);

        // Skip the row if validation fails
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        return new User([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'driver_id' => $row['driver_id'],
            'name' =>  $row['first_name'].' '.$row['last_name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'license_state' => $row['license_state'],
            'license_number' => $row['license_number'],
            'license_start_date' => $row['license_start_date'],
            'username' => $row['username'],
            'password' => Hash::make('password'),
            'role' => 'driver',
            'company_id' => Auth::id(),
        ]);
    }
}
