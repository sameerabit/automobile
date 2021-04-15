<?php
namespace App\Http\Controllers\Booking;

use App\Booking;
use App\Http\Controllers\Controller;
use App\JobCard;
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
        $this->createEmptyJob($booking);
        return response()->json($booking);
    }

    public function getBookingJson()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    public function getSingleBooking($id)
    {
        $booking = Booking::find($id);
        return response()->json($booking);
    }

    public function deleteBooking($id)
    {
        $booking = Booking::find($id);
        $booking->delete();
        return response()->json(["message" => $booking]);
    }

    private function createEmptyJob($booking){
        $startDate = date_create(json_decode($booking->event)->start);
        JobCard::create([
            "booking_id" => $booking->id,
            "date" => date_format($startDate,"Y-m-d"),
            "vehicle_id" => $booking->vehicle_id    
        ]);
    }


}
