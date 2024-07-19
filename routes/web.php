<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PickController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('top');
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/picks/search', [PickController::class, 'search'])->name('picks.search');
Route::post('/picks/search/submit', [PickController::class, 'store'])->name('picks.search.submit'); // store action for form submission
Route::post('/picks/search', [PickController::class, 'store'])->name('picks.store');
Route::get('/picks/result', [PickController::class, 'result'])->name('picks.result');