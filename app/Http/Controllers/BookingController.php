<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driverinfo;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showAccept()
    {
            return view('bookings.accept');
    }
    public function showDecision()
    {
            return view('bookings.decision');
    }
    public function showRefuse()
    {
            return view('bookings.refuse');
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