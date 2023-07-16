<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Http;


class IsbnController extends Controller
{
    public function index() {
        $isbn = '本の名前';
        return view('admin.isbn', ['isbn' => $isbn]);
    }   
    
    public function search(Request $request) {

        $isbnId = $request->input('isbn_10');

        if($isbnId){
            $url = 'https://www.googleapis.com/books/v1/volumes?q='.$isbnId;
            $response = Http::get($url);
        }
            $response = $response->json();
        if(isset($response['items'])){
            $item = $response['items'][0]['volumeInfo'];
            $title = $item['title'];
            $image = $item['imageLinks']['thumbnail'];
            $isbn = $item['industryIdentifiers']['0']['identifier'];

            $bookItem = Book::where('isbn_10', $isbn)->first('isbn_10');
            $bookIsbn = $bookItem->isbn_10;
            
            $book = [
                'title' => $title,
                'image' => $image,
                'isbn_10' => $isbn,
                'bookIsbn' => $bookIsbn,
            ];    
        }
        return view('admin.isbn', compact('book'));
    }

    public function create(Request $request) {   
        
       //画像を保存して、そのパスを保存
    //    $imagePath = $request->image_path->store('');
    // dd($request->image_path);
        Book::create([
            'title' => $request->title,
            'isbn_10' => $request->isbn_10,
            'image_path' => $request->image_path,
        ]);
        return redirect()->route('book.index');    
    }   

}
