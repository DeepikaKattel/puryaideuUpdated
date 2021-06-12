<?php

namespace App\Http\Controllers\Api;

use App\available_riders;
use App\Http\Controllers\Controller;
use App\Rider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AvailableRidersController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/available_riders",
     *   tags={"Riders"},
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

    public function available_riders(){
        $available = available_riders::with('rider')->where('status','=','1')->get();
        return response(['available'=>$available],200);
    }

    /**
     * @OA\Post(
     ** path="/api/location_riders",
     *   tags={"Riders"},
     *   summary="Location",
     *   operationId="location",
     *      @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *
     *             @OA\Property(
     *                 property="rider_id",
     *                 type="string"
     *
     *             ),
     *              @OA\Property(
     *                 property="location",
     *                 type="string"
     *
     *             ),
     *
     *         )
     *     )
     *   ),
     *


     *   @OA\Response(
     *      response=201,
     *       description="Riders location stored",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      ),
     *
     *
     *   ),

     *)
     **/

    public function store(Request $request){
        $available = new available_riders();
        $available->rider_id= request('rider_id');
        $available->location = request('location');
        $available->save();
        return response(['available'=>$available],200);
    }

     /**
      * @OA\Post(
      ** path="/api/rider_register",
      *   tags={"Riders"},
      *   summary="Register Rider",
      *   operationId="register rider",
      *      @OA\RequestBody(
      *      @OA\MediaType(
      *         mediaType="multipart/form-data",
      *         @OA\Schema(
      *          @OA\Property(
      *                 property="name",
      *                 type="string"
      *
      *             ),
      *          @OA\Property(
      *                 property="email",
      *                 type="string",
      *                 format="email"
      *
      *             ),
      *
      *
      *             @OA\Property(
      *                 property="phone",
      *                 type="string"
      *
      *             ),
      *              @OA\Property(
      *                 property="profile_pic",
      *                 type="string",
      *                  format="file",
      *
      *             ),
      *             @OA\Property(
      *                 property="licence",
      *                 type="file"
      *
      *
      *             ),
      *             @OA\Property(
      *                 property="licence_number",
      *                 type="string"
      *             ),
      *             @OA\Property(
      *                 property="experience",
      *                 type="string"
      *
      *             ),
      *              example={"name":"Deepika","email":"deepik@gmail.com","phone": "+977 9812323132", "profile_pic": "2312.jpg","license":"license.png","license_number": "2323132", "experience": "2"}
      *        )
      *     )
      *   ),

      *   @OA\Response(
      *      response=201,
      *       description="Successful Registration",
      *      @OA\MediaType(
      *           mediaType="application/json",
      *      )
      *   )
      *
      *
      *)
      **/
    public function rider(Request $request)
    {
        $this->validate($request, [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'gender' => ['nullable'],
            'dob' => ['nullable'],
            'phone' => ['required'],
            'contact2' => ['nullable'],
            'city' => ['nullable'],
            'area' => ['nullable'],
            'license' => ['required'],
            'license_number' => ['required'],
            'experience' => ['required'],
            'wallet' => ['required'],
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 2,
            'dob' => $request->input('dob'),
            'phone' => $request->input('phone'),
            'contact2' => $request->input('contact2'),
            'city' => $request->input('city'),
            'area' => $request->input('area'),
            'approved_at' => $request->input('approved_at')
        ]);
        $user->save();

        $rider_user = $user->id;

        if ($request->hasFile('license')) {
            $filenameWithExt = $request->file('license')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('license')->getClientOriginalExtension();
            $fileNameToStore1 = $filename . '_' . time() . "." . $extension;
            $path = $request->file('license')->storeAs('public/images/documents', $fileNameToStore1);
        } else {
            $fileNameToStore1 = 'no-image.jpg';
        }

        $rider = new Rider([
            'user_id' => $rider_user,
            'license_number' => $request->input('license_number'),
            'license' => $fileNameToStore1,
            'experience' => $request->input('experience'),
            'wallet' => $request->input('wallet'),
        ]);
        $rider->save();

        return response(['msg'=>'Rider Registered Successfully'],200);
    }
}
