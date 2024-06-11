<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['contact_id', 'message', 'sender','is_read'];

    public function contact()
    {
        return $this->belongsTo(CompanyContactUs::class, 'contact_id');
    }
}
