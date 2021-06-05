<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *   path="/api/user_login",
     *   tags={"Login"},
     *   operationId="login",
     *   @OA\RequestBody(
     *      @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             @OA\Property(
     *                 property="phone",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 type="string"
     *
     *             ),
     *             example={"phone": "+977 9843670972", "otp": "4233"}
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
            'code'=>'required'
        ]);

        $user = User::where([['phone','=', $request->phone],['code','=',$request->code]])->first();
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
     *   tags={"Auth"},
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
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}
