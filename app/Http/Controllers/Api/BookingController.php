<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function near_riders()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     ** path="/api/user_booking",
     *   tags={"Booking"},
     *   security={{"bearerAuth":{}}},
     *   summary="Book",
     *   operationId="book",
     *      @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *          @OA\Property(
     *                 property="origin",
     *                 type="string"
     *             ),
     *          @OA\Property(
     *                 property="destination",
     *                 type="string"
     *             ),
     *
     *
     *             @OA\Property(
     *                 property="distance",
     *                 type="string",
     *              ),
     *              @OA\Property(
     *                 property="duration",
     *                 type="string",
     *             ),
     *           @OA\Property(
     *                 property="passenger_number",
     *                 type="number"
     *             ),
     *             @OA\Property(
     *                 property="vehicle_type",
     *                 type="number"
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="phone_number",
     *                 type="string"
     *             ),
     *
     *              example={"origin":"Kathmandu","destination":"biratnagar","distance": "10.5km", "duration": "2 hours","passenger_number":"2","vehicle_type":"2","name":"Deepika","phone_number":"98132313"}
     *
     *
     *         )
     *     )
     *   ),
     *


     *   @OA\Response(
     *      response=201,
     *       description="Successful Booking",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function store(Request $request)
    {
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
            return response([$booking,'status' => 'The record has been stored',201]);
        } else {
            return response(['message' => 'Booking Failed']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * @OA\Get(
     *   path="/api/statusB{id}",
     *   tags={"Booking"},
     *   security={{"bearerAuth":{}}},
     *   summary="User Booking Status",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function status(Request $request, $id){
        Cache::forget('booking');
        $data=Booking::find($id);

        if($data->status=='Waiting'){
            $data->status='Received Rider';
        }else{
            $data->status='Cancel';
        }

        $data->save();
        return response(['message', 'The booking status'.' '.$data->id.' '.'has been changed successfully']);

    }

    /**
     * @OA\Get(
     *   path="/api/statusCancel{id}",
     *   tags={"Booking"},
     *   security={{"bearerAuth":{}}},
     *   summary="Cancel booking",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function cancel_ride(Request $request, $id){
        Cache::forget('booking');

        $data=Booking::find($id);

        $data->status='Cancel';

        $data->save();
        return response(['message', 'The booking status'.' '.$data->id.' '.'has been changed successfully']);

    }
    /**
     * @OA\Get(
     *   path="/api/statusOfRider{id}",
     *   tags={"Booking"},
     *   security={{"bearerAuth":{}}},
     *   summary="Rider Booking Status",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
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
        return response(['message', 'The booking status'.' '.$data->id.' '.'has been changed successfully']);

    }

    /**
     * @OA\Get(
     *   path="/api/estimated_price",
     *   tags={"User"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/

    public function estimated_price(){
        $user = Auth::user();
        $booking = Booking::where('user_id','=',$user->id)->select('distance','vehicle_type')->first();
        $vehicle = VehicleType::where('id','=',$booking->vehicle_type)->select('price_km')->value('price_km');
        $distance = floatval($booking->distance);
        $estimated_price = $distance * $vehicle;

        return response($estimated_price,200);
    }
}
