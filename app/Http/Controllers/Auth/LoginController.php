<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rider;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function admin(){
        return view('admin.login');
    }
    public function rider(){
        return view('rider.login');
    }

    public function loginCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::query()->where([
            "email" => $request->email,
            "role" => 3
        ])->get();

        if (count($user) >= 1){
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials) && Auth::user()){
                return redirect()->intended('home');
            }
        }

        return view('auth.login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::query()->where([
            "email" => $request->email,
            "role" => 1
        ])->get();


        if (count($user) >= 1){
            $credentials = $request->only('email', 'password');


            if (Auth::attempt($credentials) && Auth::user()){

                $users = User::all()->whereNotNull('approved_at')->count();
                Session::put('total_users', $users);

                $usersUnapproved = User::whereNull('approved_at')->get();
                $usersCount = count($usersUnapproved);
                Session::put('total_users_unapproved', $usersCount);

                $riders = Rider::all()->count();
                Session::put('riders', $riders);

                $vehicles = Vehicle::all()->count();
                Session::put('vehicles', $vehicles);


                return redirect()->intended('admin/dashboard');
            }
        }

        return view('admin.login')->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function loginRider(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::query()->where([
            "email" => $request->email,
            "role" => 2
        ])->get();

        if (count($user) >= 1){
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials) && Auth::user()){
                return redirect()->intended('home');
            }
        }

        return view('rider.login')->with('error', 'Oppes! You have entered invalid credentials');
    }

//    public function showLoginForm()
//    {
//        $approval = Carbon::now()->toDateTimeString();
//        return view('auth.login', ['approval'=> $approval]);
//    }


}
