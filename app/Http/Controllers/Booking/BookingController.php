<?php
namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;

class BookingController extends Controller
{

    public function index()
    {
        return view('booking.index',[
        ]);
    }


}
