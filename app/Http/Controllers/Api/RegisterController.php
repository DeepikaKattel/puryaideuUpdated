<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Twilio\Jwt\ClientToken;
use Twilio\Rest\Client;


class RegisterController extends Controller
{

    protected $code, $user;

    function __construct()
    {
        $this->user = new User();
    }


    /**
     * @OA\Post(
     ** path="/api/send_sms",
     *   tags={"OTP"},
     *   summary="SMS",
     *   operationId="sms",
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
     *                 property="phone",
     *                 type="string"
     *
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password"
     *             ),
     *         )
     *     )
     *   ),
     *


     *   @OA\Response(
     *      response=201,
     *       description="Please check your phone for otp",
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
        $code = rand(1000, 9999); //generate random code
        $request['code'] = $code; //add code in $request body
        $request['approved_at'] = Carbon::now();
        $this->user->store($request); //call store method of model
        return $this->sendSms($request);// send and return its response
    }
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
     *
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 format="password"
     *             ),
     *
     *             @OA\Property(
     *                 property="phone",
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
            'area' => 'nullable',
        ]);

//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 401);
//        }
        $validator['password'] = Hash::make($request->password);
        $validator['approved_at'] = Carbon::now();


        $user =  User::create($validator);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken],201);
    }
    /**
     * @OA\Post(
     ** path="/api/verify_user",
     *   tags={"SMS Verification"},
     *   summary="SMS",
     *   operationId="sms",
     *      @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *
     *             @OA\Property(
     *                 property="phone",
     *                 type="string"
     *
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 type="string"
     *             ),
     *         )
     *     )
     *   ),
     *


     *   @OA\Response(
     *      response=201,
     *       description="Verified Successfully",
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

    public function verifyContact(Request $request)
    {
        $phone = $request->phone;
        $user = User::where('phone',$phone)
                ->first();

        if ($request->code == $user->code) {
            $request["code_status"] = 'verified';
            $user->updateModel($request);
            $msg["message"] = "verified";
            return $msg;
        } else {
            $msg["message"] = "not verified";
            return $msg;
        }
    }



    public function sendSms($request)
    {
        $message = "Your Verification Code is-" .$request->code;


        $client = new Client(config('services.twilio.TWILIO_SID'), config('services.twilio.TWILIO_AUTH_TOKEN'));
        $client->messages->create(
            "+977 9843670972",
                    [
                        'from' => "+17082653883",
                        'body' => $message
                    ]
        );









    }

}
