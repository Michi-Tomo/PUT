<?php

namespace App\Http\Controllers;

use App\Models\Driverinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driverinfo::findOrFail($id);
        $averageRating = $driver->averageRating();

        return view('drivers.show', compact('driver', 'averageRating'));

        try {
            $driver = Driverinfo::findOrFail($id);
            $averageRating = $driver->averageRating();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // ドライバーが見つからなかった場合の処理
            return redirect()->route('home')->with('error', 'Driver not found.');
        }

        return view('drivers.show', compact('driver', 'averageRating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
