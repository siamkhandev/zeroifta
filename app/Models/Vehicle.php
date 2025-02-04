<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function driverVehicle()
    {
        return $this->hasOne(DriverVehicle::class, 'vehicle_id');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
