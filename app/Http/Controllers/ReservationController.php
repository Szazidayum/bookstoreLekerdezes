<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(){
        $reservations =  Reservation::all();
        return $reservations;
    }

    public function show ($user_id, $book_id, $start)
    {
        $reservation = Reservation::where('user_id', $user_id)->where('book_id', $book_id)->where('start', $start)->get();
        return $reservation[0];
    }
    public function destroy($user_id, $book_id, $start)
    {
        ReservationController::show($user_id, $book_id, $start)->delete();
    }

    public function store(Request $request)
    {
        $reservation = new Reservation();
        $reservation->user_id = $request->user_id;
        $reservation->book_id = $request->book_id;
        $reservation->start = $request->start;
        $reservation->message = $request->message;
        $reservation->message_date = $request->message_date;
        $reservation->status = $request->status;
        $reservation->save();
    }

    public function update(Request $request, $user_id, $book_id, $start)
    {
        $reservation = ReservationController::show($user_id, $book_id, $start);
        $reservation->user_id = $request->user_id;
        $reservation->book_id = $request->book_id;
        $reservation->start = $request->start;
        $reservation->message = $request->message;
        $reservation->message_date = $request->message_date;
        $reservation->status = $request->status;
        $reservation->save();
    }

    //LEKÉRDEZÉS

    //1. Hány darab előjegyzése van a bejelentkezett felhasználónak?
    public function userReservation(){
        $reservation = Reservation::all()
        ->count();
        return $reservation;
    }

    //A bejelentkezett felhasználó 3 napnál régebbi előjegyzéseit add meg
    public function older($day){
        $user = Auth::user();
        $reservation = DB::table('reservation as r')
        ->select('r.book_id', 'r.start')
        ->where('r.user_id', $user->id)
        ->whereRaw('DATEDIFF(CURRENT_DATE, r.start > ?', $day)
        ->get();
        return $reservation;
    }

    //Admin tudja törölni a selejtezett könyveket
    public function deleteOldReservs(){
        $reservation = DB::table('reservation')
        ->where('status', 1)
        ->delete();
        return $reservation;
    }


}
