<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginSession extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'user_id',
        'login_time',
        'device',
        'device_name',
        'ip_address',
        'location',
        'status',
    ];

    protected $casts = [
        'login_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
