<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driverinfo extends Model
{
    use HasFactory;



    protected $fillable = [
        'age',
        'driver_image',
        'driver_license',
        'license_plate',
        'user_id',
    ];


    //ドライバーの評価を取得
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
}



