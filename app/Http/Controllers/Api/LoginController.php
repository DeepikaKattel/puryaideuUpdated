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
     *                 property="email",
     *                 type="string",
     *                 format="email"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                  format="password"
     *             ),
     *             example={"email": "nitesh@gmail.com", "password": "nitesh123"}
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
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->first();
        if ($user === null) {
            return response(['email' => 'This User does not exist, check your details'], 400);
        }

        if (!auth()->attempt($loginData)) {
            return response(['password' => 'Password Incorrect'], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken,'success' => 'Logged in successfully']);
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

    public function username()
    {
        return 'phone';
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
