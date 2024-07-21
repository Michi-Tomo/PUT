<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show the profile page
    public function index()
    {
        $user = Auth::user();
        // You can retrieve user information here and pass it to the view if needed
        return view('profile.index', compact('user'));
    }
}
