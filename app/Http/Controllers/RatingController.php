<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

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

        Rating::create(['rating' => $request->input('rating')]);

        return redirect()->route('rate.show')->with('success', 'Rating saved!');
    }
}
