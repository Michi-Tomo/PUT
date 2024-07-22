<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MatchingsController extends Controller
{
    public function match(){
        return view('matchings.match');
    }
}
