<?php

namespace App\Http\Controllers;

use App\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function admin()
    {

        return view('admin.dashboard');
    }

    public function approval()
    {
        return view('approval');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }



}
