<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Driverinfo;
use App\Models\Booking;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverProfileController extends Controller
{
    // Show the profile page
    public function index()
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        $driverRatings = Rating::where('driver_id', Auth::user()->id)->get();
        $avgRating = collect($driverRatings)->pluck('rating')->avg();

        return view('driverprofile.index', ['driverInfo' => $driverInfo, 'avgRating'=>$avgRating]);


    }

    // Show the edit profile page
    public function edit()
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        return view('driverprofile.edit', compact('user', 'driverInfo'));
    }

    // Update the profile information
    public function update(Request $request)
    {
        $user = Auth::user();
        $driverInfo = $user->driverInfo;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'age' => 'required|integer',
            'driver_license' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255',
            'driver_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $driverInfo->age = $request->age;
        $driverInfo->driver_license = $request->driver_license;
        $driverInfo->license_plate = $request->license_plate;

        if ($request->hasFile('driver_image')) {
            $image = $request->file('driver_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('public', $imageName);
            $driverInfo->driver_image = $imageName;
        }

        $driverInfo->save();

        return redirect()->route('driverprofile.index')->with('success', 'プロフィールが更新されました。');
    }
}
