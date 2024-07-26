<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driverinfo;
use App\Models\Rating;
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

        $userLatestBooking = Booking::where('user_id', Auth::user()->id)
        ->orderBy('id', 'DESC')->first();
        $userPickupLocation = $userLatestBooking->pickup_location;
        $driverLocation = Driverinfo::where('user_id', $userLatestBooking->driver_id)
        ->pluck('driver_location')->first();
        
        $driver_info = Driverinfo::where('user_id', $userLatestBooking->driver_id)->first();
        // $driver_rating = Rating::where('driver_id', $userLatestBooking->driver_id)->get();
        
        return view('picks.refuse', [
            'pickup' => $userPickupLocation,
            'destination' => $driverLocation,
            'driver_info' => $driver_info,
            // 'driver_rating' => $driver_rating
        ]);
    }

    public function driving()
    {
        $users = User::find(Auth::user()->id);
        $userLatestBooking = Booking::where('user_id', Auth::user()->id)
        ->orderBy('id', 'DESC')->first();
        $userPickupLocation = $userLatestBooking->pickup_location;
        $driverLocation = Driverinfo::where('user_id', $userLatestBooking->driver_id)
        ->pluck('driver_location')->first();

        $driver_info = Driverinfo::where('user_id', $userLatestBooking->driver_id)->first();
        
        return view('picks.driving', [
            'driver_info' => $driver_info,
            'pickup' => $userPickupLocation,
            'destination' => $driverLocation,
        ]);
        }

        function index()
        {
            return view('history.index');
        }
    }

