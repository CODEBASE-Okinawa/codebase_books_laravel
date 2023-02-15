<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ReservationController extends Controller
{
    
    public function store(Request $request)
    {

        $user = Auth::user();

        $user->reservations()->create([

            'book_id' => $request->get('book_id'),
            'start_at'=> Carbon::parse($request->get('start_at')),
            'end_at' => Carbon::parse($request->get('end_at')),
        ]);

        return redirect()->route('reservation.index');
    }

    public function index()
    {
        return 'aaaaa';
    }

}
