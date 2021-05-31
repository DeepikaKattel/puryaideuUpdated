<?php

namespace App\Http\Controllers;

use App\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $inactive = DB::table('riders')->where('status','=',0)->get();
        $active =  DB::table('riders')->where('status','=',1)->get();
        $inactiveCount = count($inactive);
        Session::put('inactiveCount',$inactiveCount);
        $activeCount = count($active);
        Session::put('activeCount',$activeCount);
        return view('admin.dashboard',compact('activeCount','inactiveCount'));
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

    public function chartjs()
    {
        return view('approval');
    }

    public function chart(){
        $inactive = DB::table('riders')->where('status','=',0)->get();
        $active =  DB::table('riders')->where('status','=',1)->get();
        $inactiveCount = count($inactive);
        $activeCount = count($active);


        return view('chart',compact('activeCount','inactiveCount'));
    }
}
