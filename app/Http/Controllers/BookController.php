<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index() {
        $user = Auth::user();

        $statusList = [];

        // 自分が借りている本データ取得
        $now_lendings = Book::with(['latestLending' => function ($now_lending) use ($user)  {
            $now_lending->where( 'user_id', '=', $user->id )->where('is_returned', '=', 0);
        }])
        ->get();

        $myLendingBookIdList = $now_lendings->pluck('latestLending')->pluck('book_id')->reject(null);

        foreach ($myLendingBookIdList as $myLendingBookId) {
            $statusList[$myLendingBookId] = MY_LENDING;
        }

        // 自分が予約している本データ取得
        $reservations = Book::with(['latestReservation' => function ($reservation) use ($user) {
            $reservation->where('user_id', '=', $user->id);
        }])
        ->get();

        $myReservationBookIdList = $reservations->pluck('latestReservation')->pluck('book_id')->reject(null);

        foreach ($myReservationBookIdList as $myReservationBookId) {
            $statusList[$myReservationBookId] = MY_RESERVATION;
        }

        $exceptBookIdList = $myLendingBookIdList->merge($myReservationBookIdList);

        // 貸出中、貸出可能データ取得
        $lendings = Book::with(['latestLending' => function ($latestLending) use ($user)  {
            $latestLending->where( 'user_id', '!=', $user->id )->where('is_returned', '=', 0);
        }])
        ->whereNotIn('id', $exceptBookIdList)
        ->get();

        foreach ($lendings as $book) {

            if($book->latestLending){
                $statusList[$book->id] = OTHER_LENDING;
            }else{
                $statusList[$book->id] = NO_LENDING;
            }
        }

        $books = Book::all();

        return view('book.index', compact( 'user', 'statusList', 'books'));
    }
    public function show(int $bookId)
    {
        // book_idで最新の貸出情報を抽出
        $lending = Book::where('id', $bookId)->with('latestLending')->first();

        if($lending->latestLending){
            if($lending->latestLending->is_returned == 0){
                $status = OTHER_LENDING;
            }else{
                $status = NO_LENDING;
            }
        }else{
            $status = NO_LENDING;
        }

        $book = Book::find($bookId);
        $now = Carbon::now()->toDateString();
        return view('book.show', compact('book', 'now', 'status'));
    }
}
