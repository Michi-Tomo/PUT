<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Driverinfo;
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


         return view('driverprofile.index', compact('driverInfo'));
     }
 
     // Show the edit profile page
     public function edit()
     {
         $user = Auth::user();
         return view('driverprofile.edit', compact('user'));
     }
 
     // Update the profile information
     public function update(Request $request)
     {
         $user = Auth::user();
         
         $request->validate([
             'name' => 'required|string|max:255',
             'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
             'phone' => 'nullable|string|max:15',
             'password' => 'nullable|string|min:8|confirmed',
         ]);
 
         $user->name = $request->name;
         $user->email = $request->email;
         $user->phone = $request->phone;
         
         if ($request->filled('password')) {
             $user->password = Hash::make($request->password);
         }
 
         $user->save();
 
         return redirect()->route('driverprofile.index')->with('success', 'プロフィールが更新されました。');
     }
}
