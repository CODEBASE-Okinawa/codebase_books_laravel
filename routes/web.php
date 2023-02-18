<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //reservationルーティング
    Route::post('/reservations',[ReservationController::class,'store'])->name('reservation.store');
    Route::get('/reservations',[ReservationController::class,'index'])->name('reservation.index');
    Route::get('/reservations/{reservationId}',[ReservationController::class,'show'])->name('reservation.show');
    Route::delete('/reservations/{reservationId}', [ReservationController::class, 'destroy'])->middleware(['reservation'])->name('reservation.destroy');
});

require __DIR__.'/auth.php';
