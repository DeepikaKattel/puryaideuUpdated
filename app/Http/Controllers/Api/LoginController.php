<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Otp;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/user_login",
     *   tags={"Auth"},
     *   operationId="login",
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="phone",
     *                 type="string"
     *             ),
     *
     *             example={"phone": "+977 9843670972"}
     *         )
     *     )
     *   ),
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


//    public function login(Request $request)
//    {
//        $loginData = $request->validate([
//            'phone' => 'required',
//            'password'=>'required'
//        ]);
//
//        $user = User::where('email', '=', $request->email)->first();
//        if ($user === null) {
//            return response(['phone' => 'This User does not exist, check your details'], 400);
//        }
//        if (Auth::attempt(['phone'=>$request->phone]) ) {
//            $accessToken = auth()->user()->createToken('authToken')->accessToken;
//            return response(['user' => auth()->user(), 'access_token' => $accessToken,'success' => 'Logged in successfully']);
//        }
//        return response(['success' => 'Not authorized'], 400);
//
//
//    }
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'phone' => 'required',
        ]);

        $user = User::where([['phone','=', $request->phone],['code_status','=','verified']])->first();
        if ($user === null) {
            return response(['phone' => 'This User does not exist, check your details'], 400);
        }elseif($user){
            Auth::login($user,true);
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response(['user' => auth()->user(), 'access_token' => $accessToken,'success' => 'Logged in successfully'],200);
        }else{
            return response(['success' => 'Not authorized'], 400);
        }
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->scopes(['profile','email'])->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);
        return response(['success'=> 'Logged in successfully']);
    }

    public function findOrCreateUser($user)
    {
        $authUser = User::where(['email' => $user->getEmail()])->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->offsetGet('given_name').' '.$user->offsetGet('family_name'),
            'email'    => $user->email,
            'password'    => 'google1234',
            'google_id' => $user->id

        ]);
    }




    /**
     * @OA\Get(
     *   path="/api/user_logout",
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
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        $otp = Otp::where('phone','=',$request->user()->phone)->first();
        $otp->update(['code_status' => 'Pending']);
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * @OA\Get(
     *   path="/api/user_detail",
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
    public function user(){
        $user = Auth::user();
        return response(['user'=>$user],200);
    }
    /**
     * @OA\Put(
     *   path="/api/user_update/{id}",
     *   tags={"User"},
     *   security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
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
     *
     *   @OA\Response(
     *      response=200,
     *       description="Successfully Updated",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/

    public function update(Request $request,$id)
    {
        $user=User::find($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->gender = request('gender');
        $user->dob = request('dob');
        $user->phone = request('phone');
        $user->contact2 = request('contact2');
        $user->city = request('city');
        $user->area = request('area');
        $user->approved_at = now();
        if($request->hasFile('profile_pic')){
            $filenameWithExt = $request->file('profile_pic')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('license')->getClientOriginalExtension();
            $fileNameToStore1 = $filename.'_'.time().".".$extension;
            $path = $request->file('profile_pic')->storeAs('public/images/profile_pic', $fileNameToStore1);
        } else {
            $fileNameToStore1 = 'no-image.jpg';
        }
        if($request->hasFile('profile_pic')) {
            $user->profile_pic = $fileNameToStore1;
        }
        $user->save();
        return response(['user'=>$user],200);

    }

    /**
     * @OA\Get(
     *   path="/api/history",
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

    public function history(){
        $user = Auth::user();
        $booking = Booking::where('user_id','=',$user->id)->get();
        return response(['booking'=>$booking],200);
    }

}
