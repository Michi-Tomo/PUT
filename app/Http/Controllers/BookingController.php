<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Driverinfo;
use App\Models\User;
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
        $booking = Booking::where('driver_id', Auth::user()->id)
        ->whereNull('is_accepted')
        ->orderBy('id', 'DESC')
        ->first();
        return view('bookings.decision', ['booking' => $booking]);
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
            return view('bookings.refuse', compact('users'));
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
        // バリデーションを追加
        // $request->validate([
        //     'pickup' => 'required|string|max:255',
        //     'destination' => 'required|string|max:255',
        // ]);

        $drivers = User::where('is_driver', 1)->with('driverInfo')->get()->toArray();

        $pickupResult = sqrt(
            (pow(floatval($request->lat), 2) + 
            pow(floatval($request->lon), 2))
        );

        $nearestDriverId = null;
        $nearestResult = null;
        foreach($drivers as $driver) {
            $currentResult = sqrt(
                (pow(floatval($driver['driver_info']['location_lat']), 2) + 
                pow(floatval($driver['driver_info']['location_lon']), 2))
            );
            $result = abs($pickupResult - $currentResult);

            if(is_null($nearestResult) || $result <= $nearestResult) {
                $nearestResult = $result;
                $nearestDriverId = $driver['id'];
            }
        }

        // 新しい予約を作成
        $booking = new Booking;
        $booking->user_id = auth()->id(); // 現在のログインユーザーIDを保存
        $booking->driver_id = $nearestDriverId; // ドライバーID (仮に1に設定。実際のアプリでは動的に設定する必要がある)
        $booking->pickup_location = $request->pickup_location;
        $booking->dropoff_location = $request->dropoff_location;
        $booking->taketime = $request->taketime;
        $booking->fare = $request->fare;
        $booking->pickup_lat = $request->lat;
        $booking->pickup_lon = $request->lon;
        $booking->save();

        // 結果表示画面にリダイレクト
        return redirect()->route('picks.refuse', $booking->id);
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