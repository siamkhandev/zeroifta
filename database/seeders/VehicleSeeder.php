<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicles')->insert([
            'driver_id' => 1,
            'vehicle_type' => 'truck',
            'vehicle_number' => 'LEH-010',
            'odometer_reading' => '1234',
            'mpg' => '1234',
            'fuel_tank_capacity' => '1234',
            'fuel_left' => '1234',
        ]);
    }
}
