<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedPlan extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function plan()
    {
        return $this->hasMany(Plan::class);
    }
    public function paymentMethod()
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
