<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'start_lat', 'start_lng', 'end_lat', 'end_lng','status','vehicle_id','updated_start_lat','updated_start_lng','updated_end_lat','updated_end_lng',
    ];

    public function driverVehicle()
    {
        return $this->hasOne(DriverVehicle::class, 'driver_id', 'user_id');
        // Or use 'driver_id' if that is the foreign key that relates the Trip to DriverVehicle.
    }
    public function stops()
    {
        return $this->hasMany(Tripstop::class);
    }
}
