<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        // 履歴データを取得するロジックをここに記述
        $user = Auth::user();
        if($user->is_driver == 1) {
            $histories = Booking::where('driver_id', $user->id)->get()->toArray();
        } else {
            $histories = Booking::where('user_id', $user->id)->get()->toArray();
        }

        return view('history.index', ['histories' => $histories]);
    }
}
