<?php
namespace App\Http\Controllers\Booking;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function index()
    {
        $vehicles = Vehicle::all();
        $bookings = Booking::all();
        return view('booking.index',[
            'vehicles' => $vehicles,
            'bookings' => $bookings
        ]);
    }

    public function store(Request $request)
    {
        $booking = new Booking();
        $booking->fill($request->all());
        $booking->save();
        return response()->json($booking);
    }

    public function getBookingJson()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }


}
