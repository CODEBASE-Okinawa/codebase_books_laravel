<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Http;


class IsbnController extends Controller
{
    public function index()
    {
        $isbn = '本の名前';
        return view('admin.isbn', ['isbn' => $isbn]);
    }

    public function search(Request $request)
    {
        $isbnId = $request->input('isbn_10');

        if ($isbnId) {
            $url      = 'https://www.googleapis.com/books/v1/volumes?q=' . $isbnId;
            $response = Http::get($url);
        }
        $response = $response->json();

        if (isset($response['items'])) {
            $item = $response['items'][0]['volumeInfo'];
            $isbn = null;

            // レスポンスによってISBN_10とISBN_13の順番が入れ替わるのでちゃんとISBN_10を探す
            foreach ($item['industryIdentifiers'] as $isbnInfo) {
                if ($isbnInfo['type'] == 'ISBN_10') {
                    $isbn = $isbnInfo['identifier'];
                }
            }

            $book = [
                'title'    => $item['title'],
                'image'    => $item['imageLinks']['thumbnail'],
                'isbn_10'  => $isbn,
                'is_exist' => Book::where('isbn_10', $isbn)->exists(),
            ];
        }
        return view('admin.isbn', compact('book'));
    }

    public function create(Request $request)
    {

        //画像を保存して、そのパスを保存
        //    $imagePath = $request->image_path->store('');
        // dd($request->image_path);
        Book::create([
            'title'      => $request->title,
            'isbn_10'    => $request->isbn_10,
            'image_path' => $request->image_path,
        ]);
        return redirect()->route('book.index');
    }

}
