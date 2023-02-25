<?php

namespace App\Http\Middleware;

use App\Models\Book;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class BookRedirectBranchMiddleware
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
        $user = Auth::user();
        $bookId = $request->route()->parameter('bookId');

        $book = Book::find($bookId);
        if (is_null($book)) {
            return redirect()->route('book.index');
        }

        $reservation = $user->reservations()->where('book_id', $bookId)->first(); // 自分の予約を取得

        if (! is_null($reservation)){
            return redirect()->route('reservation.show',['reservationId' => $reservation->id]);
        }

        $lending = $user->lendings()
            ->where('book_id', $bookId)
            ->where('is_returned', 0)
            ->first(); // 自分の借りてる本を取得

        if (! is_null($lending)){
            return redirect()->route('lending.show',['lendingId' => $lending->id]);
        }

        return $next($request);

    }
}
