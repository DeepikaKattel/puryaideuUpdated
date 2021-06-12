<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Rider;
use App\User;
use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking = Cache::remember('booking', 3, function() {
            return Booking::with('vehicleType','user')->get();
        });
        return view('admin.booking.index', compact('booking'));
    }
    public function rides()
    {
        $booking = Cache::remember('booking', 3, function() {
            return Booking::with('vehicleType','user')->get();
        });
        $users = User::where('role','2')->get();
        $vehicles = Vehicle::with('vehicleType')->get();
        return view('admin.booking.rides', compact('booking','users','vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicleType = DB::table('vehicle_types')->get();
        $users = User::where('role','3')->get();
        return view('admin.booking.create',compact('vehicleType','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cache::forget('booking');
        $booking = new Booking();
        $booking->origin = request('origin');
        $booking->destination = request('destination');
        $booking->distance = request('distance');
        $booking->duration = request('duration');
        $booking->passenger_number = request('passenger_number');
        $booking->vehicle_type = request('vehicle_type');
        if(Auth::user()->isCustomer()) {
            $booking->user_id = Auth::user()->id;
        }else{
            $booking->user_id = request('user_id');
        }

        $count = count((is_countable($request->name)?$request->name:[]));
        for ($i=0; $i < $count; $i++) {
            $booking->name = json_encode($request->name);
            $booking->phone_number = json_encode($request->phone_number);
        }
        $booking->save();
        $bookingsave = $booking->save();
        if ($bookingsave) {
            return redirect('/booking')->with("status", "The record has been stored");
        } else {
            return redirect('/booking')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if(Auth::user()->isRider()) {
            $booking->rider_id = Auth::user()->id;
        }else{
            $booking->rider_id = request('rider_id');
        }
        $booking->vehicle_id = request('vehicle_id');
        $booking->save();

        return redirect()->route('rides')->with('status','Rider has accepted the booking.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function status(Request $request, $id){
        Cache::forget('booking');
        $data=Booking::find($id);

        if($data->status=='Waiting'){
            $data->status='Received Rider';
        }else{
            $data->status='Cancel';
        }

        $data->save();
        return redirect()->back()->with('message', 'The booking status'.' '.$data->id.' '.'has been changed successfully');

    }

    public function cancel_ride(Request $request, $id){
        Cache::forget('booking');

        $data=Booking::find($id);

        $data->status='Cancel';

        $data->save();
        return redirect()->back()->with('message', 'The booking status'.' '.$data->id.' '.'has been changed successfully');

    }

    public function statusRider(Request $request, $id){
        Cache::forget('booking');
        $data=Booking::find($id);
        if($data->ride_status == 'Waiting'){
            $data->ride_status = 'Accepted';
        }elseif($data->ride_status == 'Accepted'){
            $data->ride_status = 'I Reached';
        }elseif($data->ride_status == 'I Reached'){
            $data->ride_status = 'Trip Complete';
        }else{
            $data->ride_status = 'Cancel';
        }

        $data->save();
        return redirect()->back()->with('message', 'The booking status'.' '.$data->id.' '.'has been changed successfully');

    }

}
