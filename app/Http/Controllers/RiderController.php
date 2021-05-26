<?php

namespace App\Http\Controllers;

use App\Notifications\NewUser;
use App\Rider;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     *
     */
    public function index()
    {
        $riders = Rider::with('user','vehicle')->get();

        return view('admin.riders.index',compact('riders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rider  $rider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rider = Rider::find($id);
        $file = public_path()."/storage/images/documents/".$rider->license;
        $header = [
            'Content-Type' => 'application/pdf',
        ];
        return response()->file($file, $header);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rider  $rider
     * @return \Illuminate\Http\Response
     */
    public function edit(Rider $rider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rider  $rider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'license' => ['required|mimetypes:application/pdf'],
        ]);
        $rider = Rider::find($id);
        if($request->hasFile('license')){
            $filenameWithExt = $request->file('license')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('license')->getClientOriginalExtension();
            $fileNameToStore1 = $filename.'_'.time().".".$extension;
            $path = $request->file('license')->storeAs('public/images/documents', $fileNameToStore1);

            Storage::delete('public/images/documents/'.$rider->license);
        }
        if($request->hasFile('license'))
        {
            $rider->license = $fileNameToStore1;
        }

        $rider->trained = request('trained');

        $rider->save();

        return view('admin.unapproved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rider  $rider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rider = Rider::find($id)->delete();
        return redirect()->back()->with('status', 'Deleted Successfully');
    }


    public function rider(Request $request){

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gender' => ['required'],
            'role' => ['required'],
            'dob'=> ['required'],
            'contact1' => ['required'],
            'contact2' => ['required'],
            'city' => ['required'],
            'area' => ['required'],
            'license' => ['required|mimetypes:application/pdf'],
            'license_number' => ['required'],
            'experience' => ['required']
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'dob' => $request->input('dob'),
            'contact1' => $request->input('contact1'),
            'contact2' => $request->input('contact2'),
            'city' => $request->input('city'),
            'area' => $request->input('area'),
            'approved_at' => $request->input('approved_at')
        ]);
        $user->save();

        $rider_user = $user->id;

        if($request->hasFile('license')){
            $filenameWithExt = $request->file('license')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('license')->getClientOriginalExtension();
            $fileNameToStore1 = $filename.'_'.time().".".$extension;
            $path = $request->file('license')->storeAs('public/images/documents', $fileNameToStore1);
        } else {
            $fileNameToStore1 = 'no-image.jpg';
        }

        $rider = new Rider([
            'user_id' => $rider_user,
            'license_number' => $request->input('license_number'),
            'license' => $fileNameToStore1,
            'experience' => $request->input('experience'),
        ]);
        $rider->save();

//
//        $admin = User::where('role', 1)->first();
//        if ($admin) {
//            $admin->notify(new NewUser($user));
//        }
//
//        return $user;
        return redirect()->intended('home');
    }

    public function status(Request $request, $id){
        $data=Rider::find($id);

        if($data->status==0){
            $data->status=1;
        }else{
            $data->status=0;
        }

        $data->save();
        return redirect()->back()->with('message', 'Status of'.' '.$data->id.' '.'has been changed successfully');

    }
}
