<?php

namespace App\Http\Controllers;

use App\Models\Driverinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
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
}
