<?php
namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Vehicle;

class BookingController extends Controller
{

    public function index()
    {
        $vehicles = Vehicle::all();
        return view('booking.index',[
            'vehicles' => $vehicles
        ]);
    }


}
