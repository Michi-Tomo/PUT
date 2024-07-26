<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function show()
    {
        return view('rates.rating');
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user_id = Auth::user()->id;
        $user_latest_booking = Booking::where('user_id', $user_id)->orderBy('id', 'DESC')->first();
        $driver_id = $user_latest_booking->driver_id;

        Rating::create([
            'rating' => $request->input('rating'),
            'user_id' => $user_id,
            'driver_id' => $driver_id,
        ]);

        return redirect()->route('rate.show')->with('success', 'Rating saved!');
    }
}
