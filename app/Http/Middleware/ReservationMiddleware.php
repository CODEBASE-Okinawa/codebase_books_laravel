<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // ルートパラメーターからreservationIdを取得する
        $reservationId = $request->route()->parameter('reservationId');
        // reservationIdを抽出条件にReservationデータを取得
        $reservation = Reservation::find($reservationId);

        if($reservation->start_at < Carbon::now()) {

            // Reservationを削除する
            $reservation->delete();

            return redirect()->route('book.show', ['bookId' => $reservation->book_id]);
  
        }

        return $next($request);

    }
}