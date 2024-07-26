<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['rating', 'user_id', 'driver_id' ];

//ドライバーの評価取得
    public function driver()
    {
        return $this->belongsTo(Driverinfo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}






