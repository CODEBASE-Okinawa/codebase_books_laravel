<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Lending;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\RemindReturnBookMail;
use Illuminate\Support\Facades\Mail;

class LendingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $lendings = $user->lendings()->where('is_returned', 0)->with('book')->get()->sortBy('start_at');;
        return view('lending.index', compact('user', 'lendings'));
    }

    public function show(int $lendingId)
    {
        $user = Auth::user();

        $lending = $user->lendings()
            ->where('id',$lendingId )
            ->first();

            $now = Carbon::now();

            return view('lending.show', compact('lending', 'now'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $user->lendings()->create([
            'book_id' => $request->get('book_id'),
            'start_at' => Carbon::parse($request->get('start_at')),
            'end_at' => Carbon::parse($request->get('end_at')),
            'is_returned' => $request->get('is_returned'),
        ]);
        return redirect()->route('lending.index');
    }

    public function updateIsReturned(Request $request, int $lendingId)
    {
        $user = Auth::user();

        $lending = $user->lendings()->where('id', $lendingId)->first();

        $lending->update([
            'is_returned' => 1
        ]);

        return redirect()->route('book.show',['bookId' => $lending->book_id]);
    }

    public function send()
    {
        $lendings = Lending::with('user', 'book')->where('end_at', '<', Carbon::now()->addDays(3))->get();
//        dd($lendings);
        $targets = [];
        foreach ($lendings as $lending) {
            $targets['name'] = $lending->user->name;
            $targets['email'] = $lending->user->email;
            $targets['book'] = $lending->book->title;
            $targets['image'] = $lending->book->image_path;
            $targets['end_at'] = $lending->end_at;
        }
        dd($targets);
        foreach ($targets as $target) {
//            dd($target['email']);
            Mail::to($target['email'])->send(new RemindReturnBookMail($target));
        }
    }

}
