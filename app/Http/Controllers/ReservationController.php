<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

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
        $reservation->save();
    }

    public function update(Request $request, $user_id, $book_id, $start)
    {
        $reservation = ReservationController::show($user_id, $book_id, $start);
        $reservation->user_id = $request->user_id;
        $reservation->book_id = $request->book_id;
        $reservation->start = $request->start;
        $reservation->save();
    }

    //LEKÉRDEZÉS

    //1. Hány darab előjegyzése van a bejelentkezett felhasználónak?
    public function userReservation(){
        $reservation = Reservation::all()
        ->count();
        return $reservation;
    }

    


}
