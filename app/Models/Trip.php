<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $guarded = [];

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
