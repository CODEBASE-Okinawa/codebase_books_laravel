<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request AS BookRequest;
use App\Models\Book;
use App\Models\Lending;
use App\Models\Reservation;
use Illuminate\Support\Facades\Http;

class RequestController extends Controller
{
    public function index() {
        $isbn = 'リクエスト画面';
        return view('request.index');
    }

    public function search(Request $request) {

        // タイトルでapi検索
        $title = urlencode($request->input('title'));

            $url = 'https://www.googleapis.com/books/v1/volumes?q=intitle:'.$title.'&country=JP&tbm=bks';
            $response = Http::get($url);
        // apiレスポンス
        $books = collect($response->json()['items']);
        // dd($books);

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
        // dd($titleImageIsbn10List);

        // apiから取得したtitleのみを格納
        $titleList = $books->map(function ($book) {
            return $book['volumeInfo']['title'] ?? null;
        })->filter();
        // dd($titleList);

        $titleList = $titleImageIsbn10List->pluck('title');
        // dd($titleList);

        // Booksテーブルにapiで取得したtitleで検索し、id取得
        $existingBookTitles = Book::whereIn('title', $titleList)->pluck('id');

        dd($lending);


        // apiで取得したtitleからBooksテーブルにあるtitleを除いた
        $newBooks = $titleList->diff($existingBookTitles);
        // dd($newBooks);

        // dd($newBooks);
    // dd($responseData);
        return view('request.index');
    }

    public function create(Request $request) {
        BookRequest::create([
            'title' => $request->title,
            'isbn_10' => $request->isbn_10,
            'image_path' => $request->image_path,
        ]);
        return redirect()->route('book.index');
    }
}
