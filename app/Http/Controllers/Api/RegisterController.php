<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Otp;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
     *
     *         )
     *     )
     *   ),
     *


     *   @OA\Response(
     *      response=201,
     *       description="Please check your phone for otp",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      ),
     *
     *
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
        $request['phone'] = $request->phone;
        $otp = Otp::where('phone','=',$request->phone);
        if($otp){
            $otp->update(['code' => $code]);
        }else{
            Otp::create($request->all()); //call store method of model
        }
//        return $this->sendSms($request);
        return $this->sparrowSms($request);// send and return its response
    }
    /**
     * @OA\Post(
     ** path="/api/user_register",
     *   tags={"Auth"},
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
     *              example={"name":"Deepika","email":"deepik@gmail.com","phone": "+977 9812323132", "profile_pic": "2312.jpg"}
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
     *      ),
     *      @OA\Schema(
     *             example={"name":"Deepika","email":"deepik@gmail.com","password":"123wsda2","password_confirmation":"123wsda2",
     *             "gender":"Femal","dob":"21/09/2020","phone": "+977 9812323132"}
     *         )
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
            'password' => 'nullable|min:8|confirmed',
            'gender' => 'nullable',
            'dob'=> 'nullable',
            'phone' => 'required|unique:users',
            'contact2' => 'nullable',
            'city' => 'nullable',
            'area' => 'nullable',
            'profile_pic'=>'nullable',
        ]);
        if($request->hasFile('profile_pic')){
            $filenameWithExt = $request->file('profile_pic')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('license')->getClientOriginalExtension();
            $fileNameToStore1 = $filename.'_'.time().".".$extension;
            $path = $request->file('profile_pic')->storeAs('public/images/profile_pic', $fileNameToStore1);
        } else {
            $fileNameToStore1 = 'no-image.jpg';
        }
        $validator['profile_pic'] = $fileNameToStore1;

            $user = User::create($validator);

            if($user){
                Auth::login($user,true);
                $accessToken = $user->createToken('authToken')->accessToken;
            }

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
     *     @OA\Schema(
     *             example={"phone": "+977 9812323132", "code": "3923"}
     *         )
     *      )
     *
     *   ),
     *
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
        $otp = Otp::where('phone',$phone)->first();

        if ($request->code == $otp->code) {
            $otp->update(['code_status' => 'Verified']);
            $msg["message"] = "verified";
            $user = User::where('phone','=',$otp->phone)->first();
            if($user){
                Auth::login($user,true);
                $accessToken = $user->createToken('authToken')->accessToken;
                return [$msg,['user' => $user, 'access_token' => $accessToken],201];
            }
            return [$msg];
        } else {
            $msg["message"] = "not verified";
            return $msg;
        }
    }

    //twillio

    public function sendSms($request)
    {
        $message = "Your Verification Code is-" .$request->code;
        $phone = $request->phone;


        $client = new Client(config('services.twilio.TWILIO_SID'), config('services.twilio.TWILIO_AUTH_TOKEN'));
        $client->messages->create(
            $phone,
                    [
                        'from' => "+17082653883",
                        'body' => $message
                    ]
        );
    }

    public function sparrowSms(Request $request){
        $message = "Puryaideu application. Your Verification Code is-" .$request->code;

        $phone = $request->phone;

        $args = http_build_query(array(
            'token' => 'v2_OhZVmkSiE0Hqkn8fVy9tqsJv1Ey.tcwv',
            'from'  => 'Demo',
            'to'    => $phone,
            'text'  => $message
        ));

        $url = "http://api.sparrowsms.com/v2/sms/";

        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code == 200){
            return response([$response,'msg'=>'SMS Sent Successfully']);
        }else{
            return response([$response,'error'=>'SMS could not be sent']);
        }
    }



}
