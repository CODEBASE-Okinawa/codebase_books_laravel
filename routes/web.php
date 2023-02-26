<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\LendingController;
use App\Models\Reservation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

// 確認用route 後で消す
Route::get('/mail', function () {
    return view('mails.remind_return_book');
});
Route::get('/get', [LendingController::class, 'send']);
// ここまで

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'delete_all_past_reservation'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // bookルーティング
    Route::get('/books', [BookController::class, 'index'])->name('book.index');
    Route::get('/books/{bookId}', [BookController::class, 'show'])->middleware(['book_redirect_branch'])->name('book.show');

    // lendingルーティング
    Route::get('/lendings', [LendingController::class, 'index'])->name('lending.index');
    Route::get('/lendings/{lendingId}', [LendingController::class, 'show'])->name('lending.show');
    Route::post('/lendings', [LendingController::class, 'store'])->name('lending.store');
    Route::put('/lendings/{lendingId}/return',[LendingController::class,'updateIsReturned'])->name('lending.updateIsReturned');

    //reservationルーティング
    Route::post('/reservations',[ReservationController::class,'store'])->name('reservation.store');
    Route::get('/reservations',[ReservationController::class,'index'])->name('reservation.index');
    Route::get('/reservations/{reservationId}',[ReservationController::class,'show'])->middleware(['delete_past_reservation'])->name('reservation.show');
    Route::delete('/reservations/{reservationId}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
});

require __DIR__.'/auth.php';
