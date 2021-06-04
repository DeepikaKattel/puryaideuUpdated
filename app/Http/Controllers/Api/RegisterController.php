<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/user_register",
     *   tags={"Register"},
     *   summary="Register",
     *   operationId="register",
     *      @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *          @OA\Property(
     *                 property="name",
     *                 type="string"
     *
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email"
     *
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password"
     *             ),
     *
     *             @OA\Property(
     *                 property="contact1",
     *                 type="string"
     *
     *             ),
     *
     *
     *         )
     *     )
     *   ),
     *


     *   @OA\Response(
     *      response=201,
     *       description="Successful Registration",
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
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request){
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'gender' => 'nullable',
            'dob'=> 'nullable',
            'phone' => 'required|unique:users',
            'contact2' => 'nullable',
            'city' => 'nullable',
            'area' => 'nullable'
        ]);

//        if ($validator->fails()) {
//            return response()->json(['message' => $validator->errors()], 401);
//        }
        $validator['password'] = Hash::make($request->password);
        $validator['approved_at'] = Carbon::now();

        $user =  User::create($validator);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken],201);
    }

}
