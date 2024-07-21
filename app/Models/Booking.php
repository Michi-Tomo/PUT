<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'driver_id',
            'pickup_location',
            'dropoff_location',
            'taketime',
            'fare',
            'is_accepted',
    ];
}
