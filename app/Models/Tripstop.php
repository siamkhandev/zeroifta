<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tripstop extends Model
{
    use HasFactory;
    protected $fillable = ['trip_id', 'stop_name', 'stop_lat', 'stop_lng'];
}
