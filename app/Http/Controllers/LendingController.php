<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lending;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class LendingController extends Controller
{
    public function updateIsReturned(Request $request, int $lendingId)
    {
        $user = Auth::user();

        $lending = $user->lendings()->where('id', $lendingId)->first();
        
        $lending->update([
                'is_returned' => 1
            ]);

        return redirect()->route('book.show',['bookId' => $lending->book_id]);

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
    
}
