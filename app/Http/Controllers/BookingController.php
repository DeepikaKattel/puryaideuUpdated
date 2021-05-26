<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Rider;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $booking= VehicleType::with('vehicleType','user')->get();
        return view('admin.booking.index', compact('booking'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicleType = DB::table('vehicle_types')->get();
        return view('admin.booking.create',compact('vehicleType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = new Booking();
        $booking->origin = request('origin');
        $booking->destination = request('destination');
        $booking->passenger_number = request('passenger_number');
        $booking->name = request('name');
        $booking->phone_number = request('phone_number');
        $booking->vehicle_type = request('vehicle_type');
        if(Auth::user()->isCustomer()) {
            $booking->user_id = Auth::user()->id;
        }else{
            $booking->user_id = request('user_id');
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
    public function update(Request $request, Booking $booking)
    {
        //
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
        $data=Booking::find($id);

        if($data->status==0){
            $data->status=1;
        }else{
            $data->status=0;
        }

        $data->save();
        return redirect()->back()->with('message', 'The booking status'.' '.$data->id.' '.'has been changed successfully');

    }
}
