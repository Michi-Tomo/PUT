<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PickController;

use App\Http\Controllers\PickController;
use App\Http\Controllers\RatingController;


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



Route::get('/driver', [App\Http\Controllers\PickController::class, 'register'])->name('driver');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/picks/search', [PickController::class, 'search'])->name('picks.search');
Route::post('/picks/search/submit', [PickController::class, 'store'])->name('picks.search.submit'); // store action for form submission
Route::post('/picks/search', [PickController::class, 'store'])->name('picks.store');
Route::get('/picks/result', [PickController::class, 'result'])->name('picks.result');

Route::get('/rate', [RatingController::class, 'show'])->name('rate.show');
Route::post('/rate', [RatingController::class, 'store'])->name('rate.store');


