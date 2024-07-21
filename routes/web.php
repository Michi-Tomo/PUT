<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
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

// Route::get('/resister', function () {
//     return view('resister');
// });

// Route::get('/driver', function () {
//     return view('driver');
// });




// Route::get('/driver', [App\Http\Controllers\PickController::class, 'register'])->name('driver');

Route::get('/driver/register', [App\Http\Controllers\DriverController::class, 'showRegistrationForm'])->name('driver.register');
Route::post('/driver/register', [App\Http\Controllers\DriverController::class, 'register'])->name('driver.register.submit');

// Route::get('/')

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/picks/search', [PickController::class, 'search'])->name('picks.search');
Route::post('/picks/search/submit', [PickController::class, 'store'])->name('picks.search.submit'); // store action for form submission
Route::post('/picks/search', [PickController::class, 'store'])->name('picks.store');
Route::get('/picks/result', [PickController::class, 'result'])->name('picks.result');



Route::get('/rate', [RatingController::class, 'show'])->name('rate.show');
Route::post('/rate', [RatingController::class, 'store'])->name('rate.store');

//BookingController
//表示
Route::get('/bookings/accept', [BookingController::class, 'showAccept'])->name('booking.accept');
Route::get('/bookings/decision', [BookingController::class, 'showDecision'])->name('booking.decision');
Route::get('/bookings/refuse', [BookingController::class, 'showRefuse'])->name('booking.refuse');

//APIからデータの取得
Route::post('/picks/result/store', [BookingController::class, 'store'])->name('bookings.store');

