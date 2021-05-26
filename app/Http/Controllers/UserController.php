<?php

namespace App\Http\Controllers;

use App\Rider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function unapproved()
    {
        $user = User::whereNull('approved_at')->select('id')->value('id');
        $riders = Rider::with('user')->where('user_id','=',$user)->get();
        $ridersCount = count($riders);

        return view('admin.unapproved', compact('riders','ridersCount'));
    }

    public function approve(Request $request, $rider_id)
    {
        $rider = Rider::find($rider_id);
        $user = $rider->user_id;


        if($request->hasFile('license')){
            $filenameWithExt = $request->file('license')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('license')->getClientOriginalExtension();
            $fileNameToStore1 = $filename.'_'.time().".".$extension;
            $path = $request->file('license')->storeAs('public/images/documents', $fileNameToStore1);

            Storage::delete('public/images/documents/'.$rider->license);
        }
        if($request->hasFile('license')){
            $rider->license = $fileNameToStore1;
        }
        $rider->trained = request('trained');
        $rider->save();
        $user  = User::find($user);

        $user->update(['approved_at' => now()]);

        return redirect()->route('admin.unapproved')->withMessage('User approved successfully');
    }

    public function index(){
        $users = User::with('roles')->whereNotNull('approved_at')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        $error = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gender' => ['required'],
            'role' => ['required'],
            'dob'=> ['required'],
            'contact1' => ['required'],
            'contact2' => ['required'],
            'city' => ['required'],
            'area' => ['required']

        ]);
        $user = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->role = request('role');
        $user->password = Hash::make($request['password']);
        $user->gender = request('gender');
        $user->dob = request('dob');
        $user->contact1 = request('contact1');
        $user->contact2 = request('contact2');
        $user->city = request('city');
        $user->area = request('area');
        $user->approved_at = now();
        $user->save();

        if ($user->role == '2'){
            if($request->hasFile('license')){
                $filenameWithExt = $request->file('license')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('license')->getClientOriginalExtension();
                $fileNameToStore1 = $filename.'_'.time().".".$extension;
                $path = $request->file('license')->storeAs('public/images/documents', $fileNameToStore1);
            } else {
                $fileNameToStore1 = 'no-image.jpg';
            }
            $rider = new Rider();
            $rider->user_id = $user->id;
            $rider->license = $fileNameToStore1;
            $rider->license_number = request('license_number');
            $rider->experience = request('experience');
            $rider->save();
        }



        $usersave = $user->save();




        if ($usersave) {
            return redirect('/users')->with("status", "The record has been stored");
        } else {
            return redirect('/users')->with("error", "There is an error");
        }
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect()->back()->with('status', 'Deleted Successfully');
    }

    public function map(){
        return view('map');
    }
}
