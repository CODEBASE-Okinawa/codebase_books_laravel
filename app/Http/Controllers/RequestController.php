<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request AS BookRequest;
use App\Models\Book;
use App\Models\Lending;
use App\Models\Reservation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function index() {
        $isbn = 'リクエスト画面';
        return view('request.index');
    }

    public function search(Request $request) {

        $user = Auth::user();
        $statusList = [];

        // タイトルでapi検索
        $title = urlencode($request->input('title'));
        $url = 'https://www.googleapis.com/books/v1/volumes?q=intitle:'.$title.'&country=JP&tbm=bks';
        $response = Http::get($url);

        // apiレスポンス
        $books = collect($response->json()['items']);

        // apiから取得したtitleとisbnとimage_pathを格納
        $titleImageIsbn10List = $books->map(function ($book) {
            $title = $book['volumeInfo']['title'] ?? null;
            $image_path = $book['volumeInfo']['imageLinks']['thumbnail'];
            $isbn10 = null;

            if (isset($book['volumeInfo']['industryIdentifiers'])) {
                $isbn10 = collect($book['volumeInfo']['industryIdentifiers'])
                    ->firstWhere('type', 'ISBN_10')['identifier'] ?? null;
            }
            return compact('title', 'isbn10', 'image_path');
        })->filter();

        // apiから取得したtitleのみを格納
        $titleList = $books->map(function ($book) {
            return $book['volumeInfo']['title'] ?? null;
        })->filter();

        // 検索結果のタイトルリスト
        $titleList = $titleImageIsbn10List->pluck('title');

        // Booksテーブルにapiで取得したtitleで検索し、id取得
        $existingBookList = Book::whereIn('title', $titleList)->get();
        $existingBookId = $existingBookList->pluck('id');
        $existingBookTitleList = $existingBookList->pluck('title'); // DB登録済みのタイトルリスト

        // 自分が借りているの本id取得
        // Lendingsテーブルにbook_idとis_returned=1かつを検索
        $nowLendings = $existingBookId->map(function ($id) use ($user) {
            return Lending::where( 'user_id', '=', $user->id )->where('book_id', '=', $id)->where('is_returned', '=', 0)->pluck('book_id')->first();
        });

        foreach ($nowLendings as $nowLendingBookId) {
            if($nowLendingBookId){
                $statusList[$nowLendingBookId] = MY_LENDING;
            }
        }

        // 自分が予約している本データ取得
        // Lendingsテーブルにbook_idとis_returned=0かつを検索
        $nowReservations = $existingBookId->map(function ($id) use ($user) {
            return Reservation::where( 'user_id', '=', $user->id )->where('book_id', $id)->where('deleted_at', '=', null)->pluck('book_id')->first();
        });

        foreach ($nowReservations as $nowReservationBookId) {
            if($nowReservationBookId){
                $statusList[$nowReservationBookId] = MY_RESERVATION;
            }
        }

        // 他の人が借りている本
        // Lendingsテーブルにbook_idとis_returned=0かつを検索
        $lendings = $existingBookId->map(function ($id) use ($user) {
            return Lending::where( 'user_id', '!=', $user->id )->where('book_id', '=', $id)->where('is_returned', '=', 0)->pluck('book_id')->first();
        });
// dd($lendings);
        if($lendings){
            foreach ($lendings as $lendingBookId) {
                if($lendingBookId){
                    $statusList[$lendingBookId] = OTHER_LENDING;
                }
            }
        }
        $exceptBookIdList = $nowReservations->merge($nowLendings)->merge($lendings);

        // BooksテーブルにあるAPI検索した対象の本の中で、他ユーザーが貸出中、貸出可能データ
        $noLendingBooksId = $existingBookId->diff($exceptBookIdList);        

        foreach ($noLendingBooksId as $bookId) {
            if($bookId){
                $statusList[$bookId] = NO_LENDING;
            }
        }

        // apiで取得したtitleからBooksテーブルにあるtitleを除いた本
        // 購入リクエストを送れる本
        // プロフェッショナルWebプログラミング Laravel
        $newBooks = collect($titleList->diff($existingBookTitleList));

        $countExistingBookTitle = count($newBooks);
        $countRequestBook = count($titleImageIsbn10List);
        
        $requestBooksList=[];

        foreach ($newBooks as $newBookTitle) {
            $target = $titleImageIsbn10List->firstWhere('title', $newBookTitle);

            $requestBooksList[] = [
                'title' => $target['title'],
                'isbn_10' => $target['isbn10'],
                'image_path' => $target['image_path'],
            ];
        }
        $books = Book::all();
        // dd($statusList);
        return view('request.index', compact('books', 'statusList', 'requestBooksList'));
    }

    public function create(Request $request) {
        BookRequest::create([
            'title' => $request->title,
            'isbn_10' => $request->isbn_10,
            'image_path' => $request->image_path,
        ]);
        return redirect()->route('book.index');
    }

    public function show() {
        $bookRequestList = BookRequest::all();
        return view('request.show', compact('bookRequestList'));
    }

}
