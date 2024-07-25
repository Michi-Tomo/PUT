<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driverinfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PickController extends Controller
{

    public function register()
    {
        return view('driver');
    }
    

    public function driver()
    {
        return view('login');
    }


    public function search()
    {
        return view('picks.search');
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'pickup' => 'required',
            'destination' => 'required',
        ]);

        // データ処理（ここでは単純にリダイレクト）
        return redirect()->route('picks.result', [
            'pickup' => $request->input('pickup'),
            'destination' => $request->input('destination'),
        ]);
    }

    public function result(Request $request)
    {
        $pickup = $request->query('pickup');
        $destination = $request->query('destination');

        $drivers = User::where('is_driver', 1)->with('driverInfo')->get()->toArray();

        // dd(['drivers' => $drivers]);

        return view('picks.result', [
            'pickup' => $pickup,
            'destination' => $destination,
            'distance' => 0,  // Placeholder value
            'duration' => 0,  // Placeholder value
            'totalFare' => 0  // Placeholder value
        ]);
    }

    public function showRefuse()
    {
        $users = User::find(Auth::user()->id);
        $userLatestBooking = Booking::where('user_id', Auth::user()->id)
        ->orderBy('id', 'DESC')->first();
        $userPickupLocation = $userLatestBooking->pickup_location;
        $driverLocation = Driverinfo::where('user_id', $userLatestBooking->driver_id)
        ->pluck('driver_location')->first();
        
        return view('picks.refuse', [
            'users' => $users,
            'pickup' => $userPickupLocation,
            'destination' => $driverLocation,
        ]);
    }

    public function driving()
    {
        return view('picks.driving');
    }
}


