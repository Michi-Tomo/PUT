<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PickController;

use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DriverController;

use App\Http\Controllers\MatchingsController;
use App\Http\Controllers\HistoryController;


use App\Http\Controllers\DriverProfileController;

use App\Http\Controllers\ChatController;



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

// 評価の平均取得
Route::get('/drivers/{id}', [DriverController::class, 'show'])->name('driver.rate');



// Route::get('/')

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//PickController
Route::get('/picks/search', [PickController::class, 'search'])->name('picks.search');
Route::post('/picks/search/submit', [PickController::class, 'store'])->name('picks.search.submit'); // store action for form submission
Route::post('/picks/search', [PickController::class, 'store'])->name('picks.store');
Route::get('/picks/result', [PickController::class, 'result'])->name('picks.result');
Route::get('/picks/refuse', [PickController::class, 'showRefuse'])->name('picks.refuse');
Route::get('/picks/driving', [PickController::class, 'driving'])->name('picks.driving');


//RateController
Route::get('/rate', [RatingController::class, 'show'])->name('rate.show');
Route::post('/rate', [RatingController::class, 'store'])->name('rate.store');

//BookingController
Route::get('/bookings/accept', [BookingController::class, 'showAccept'])->name('booking.accept');
Route::get('/bookings/decision', [BookingController::class, 'showDecision'])->name('booking.decision');
Route::get('/bookings/refuse', [BookingController::class, 'showRefuse'])->name('booking.refuse');
Route::get('/bookings/drop', [BookingController::class, 'drop'])->name('bookings.drop');


//APIからデータの取得
Route::post('/picks/result/store', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/mypage', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/driverprofile', [DriverProfileController::class, 'index'])->name('driverprofile.index');
Route::get('/driverprofile/edit', [DriverProfileController::class, 'edit'])->name('driverprofile.edit');
// Route::post('/driverprofile/update', [DriverProfileController::class, 'update'])->name('profile.update');

Route::put('/driverprofile', [DriverProfileController::class, 'update'])->name('driverprofile.update');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

//matching 
// Route::get('/match', function() {
//     return view('match');
// });
Route::get('/match', [MatchingsController::class, 'match'])->name('matchings.match');

Route::get('/chat', [ChatController::class, 'index'])->name('chat');

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
});

Route::get('/history', [HistoryController::class, 'index'])->name('history.index');



