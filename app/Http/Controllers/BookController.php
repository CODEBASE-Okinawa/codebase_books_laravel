<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index() {
        $books = Book::with('lendings')->get();
        $user = Auth::user();
        return view('book.index', compact('books', 'user'));
    }
    public function show(int $bookId)
    {
        $book = Book::find($bookId);
        return view('book.show', compact('book'));
    }
}
