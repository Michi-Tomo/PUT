<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $booking = Booking::where('driver_id', Auth::user()->id)
        ->whereNull('is_accepted')
        ->orderBy('id', 'DESC')
        ->first();
        return view('bookings.decision', ['booking' => $booking]);
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
        // バリデーションを追加
        // $request->validate([
        //     'pickup' => 'required|string|max:255',
        //     'destination' => 'required|string|max:255',
        // ]);

        // 新しい予約を作成
        $booking = new Booking;
        $booking->user_id = auth()->id(); // 現在のログインユーザーIDを保存
        $booking->driver_id = 1; // ドライバーID (仮に1に設定。実際のアプリでは動的に設定する必要がある)
        $booking->pickup_location = $request->pickup_location;
        $booking->dropoff_location = $request->dropoff_location;
        $booking->taketime = $request->taketime;
        $booking->fare = $request->fare;
        $booking->save();

        // 結果表示画面にリダイレクト
        return redirect()->route('booking.show', $booking->id);
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
}
