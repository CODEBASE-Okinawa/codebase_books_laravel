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
        $user = Auth::user();

        $reservations = $user->reservations()->where('start_at', '>=', Carbon::now())->with('book')->get()->sortBy('start_at');

        return view('reservation.index', compact('reservations'));
    
    }

    public function show(int $reservationId)
    {
        $user = Auth::user();

        $reservation = $user->reservations
            ->where('id', $reservationId)
            ->first();

        // dd($reservations);

        return view('reservation.show', compact('reservation'));
    }


    public function destroy(Request $request, int $reservationId)
    {
        // 削除処理
        $user = Auth::user();

        $reservation = $user->reservations
            ->where('id', $reservationId)
            ->first();

        $reservation->delete();

        return redirect()->route('reservation.index');
    }

}
