<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PickController extends Controller
{
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
        
        return view('picks.result', [
            'pickup' => $pickup,
            'destination' => $destination,
            'distance' => 0,  // Placeholder value
            'duration' => 0,  // Placeholder value
            'totalFare' => 0  // Placeholder value
        ]);
    }
}

