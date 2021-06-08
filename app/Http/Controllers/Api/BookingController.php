<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
