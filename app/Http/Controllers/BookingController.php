<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driverinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAccept()
    {
        $user = Auth::user();

        $user_type = Auth::user()->is_driver;
        

        if($user_type == 0) {
            //ユーザーページに飛ぶ
            return view('picks.search');
        } else if($user_type == 1) {
            //ドライバーぺージに飛ぶ！
            $users = Driverinfo::where('user_id', $user->id)->first();
            return view('bookings.accept', compact('users'));
        }
    }
    public function showDecision()
    {
            return view('bookings.decision');
    }
    public function showRefuse()
    {
        $user = Auth::user();

        $user_type = Auth::user()->is_driver;
        

        if($user_type == 0) {
            //ユーザーページに飛ぶ
            return view('picks.search');
        } else if($user_type == 1) {
            //ドライバーぺージに飛ぶ！
            $users = Driverinfo::where('user_id', $user->id)->first();
            return view('bookings.accept', compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function showAcceptPage($driverId)
{
    // ドライバーの情報をデータベースから取得
    $driver = Driverinfo::find($driverId);

    // 顔写真のパスを取得（例えば、'photo_path'というカラムに保存されていると仮定）
    $driver_image = $driver->driver_image;

    // 他の必要なデータも含めてビューに渡す
    return view('accept', ['driver' => $driver, 'driver_image' => $driver_image]);

}


}