<?php

namespace App\Imports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
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
       
        return new Vehicle([
            'vehicle_type' => $row['vehicle_type'],
            'vehicle_number' => $row['vehicle_number'],
            'odometer_reading' => $row['odometer_reading'],
            'mpg' => $row['mpg'],
            'fuel_tank_capacity' => $row['fuel_tank_capacity'],
            'fuel_left' => $row['fuel_left'],
            'company_id' => Auth::id(),
        ]);
    }
}
