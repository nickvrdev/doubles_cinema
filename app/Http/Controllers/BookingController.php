<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timeslot;
use App\Models\Booking;
use Auth;

class BookingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * List of all user bookings
     */
    public function index()
    {
      // Use withTrashed to display cancelled bookings
      $bookings = Booking::where('user_id', Auth::user()->id)->get();
      return view('booking.index')->with(compact('bookings'));
    }
    
    /**
     * Create a booking
     */
    public function create(Request $request)
    {
      $validation = \Validator::make($request->all(), [
        'timeslot' => 'bail|required|exists:timeslots,id',
        'ticket' => 'required|min:1',
      ]);

      if($validation->fails()) {
        $error_data = $validation->errors()->all();
        dd($error_data);
        return redirect()->back()->withInput()->withErrors($error_data);
      }
      
      $timeslot = Timeslot::findOrFail($request->input('timeslot'));
      $ticket_count = $request->input('ticket');
      $ticket_available = $timeslot->countAvailableTimeslots();
      if($ticket_count > $ticket_available){
        return redirect()->back()->withInput()->withMessage('Tickets no longer available');
      }
      
      $booking = Booking::create([
        'user_id' => Auth::user()->id,
        'cinema_id' => $timeslot->cinema_id,
        'film_id' => $timeslot->film_id,
        'timeslot_id' => $timeslot->id,
        //'ticket_count' => ($ticket_count > $ticket_available) ? $ticket_available : $ticket_count,
        'ticket_count' => $ticket_count,
        'hash' => Booking::hashGen(),
      ]);
      return redirect()->route('booking.index');
    }
    
    /**
     * Cancel a booking
     */
    public function cancel(Request $request)
    {
      $booking = Booking::find($request->input('booking'));
      if($booking && $booking->timeslot->cancelable()){
        $booking->delete();
      }
      else {
        // Could not remove booking
      }
      return redirect()->route('booking.index');
    }

}
