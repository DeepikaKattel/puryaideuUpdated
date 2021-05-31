<?php

namespace App\Http\Controllers;

use App\Banners;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banners::get();
        return view('admin.banner.index', compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner = new Banners();
        if($request->hasFile('banner')){
            $filenameWithExt = $request->file('banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('banner')->getClientOriginalExtension();
            $fileNameToStore1 = $filename.'_'.time().".".$extension;
            $path = $request->file('banner')->storeAs('public/images/banner', $fileNameToStore1);
        } else {
            $fileNameToStore1 = 'no-image.jpg';
        }
        $banner->banner = $fileNameToStore1;
        $banner->name = request('name');
        $banner->expire_date = request('expire_date');
        $banner->added_date = Carbon::now();
        $banner->save();
        $banners =  $banner->save();
        if ($banners) {
            return redirect('/banner')->with("status", "The record has been stored");
        } else {
            return redirect('/banner')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function show(Banners $banners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banners::find($id);
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $banner = Banners::find($id);
        if($request->hasFile('banner')){
            $filenameWithExt = $request->file('banner')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('banner')->getClientOriginalExtension();
            $fileNameToStore1 = $filename.'_'.time().".".$extension;
            $path = $request->file('banner')->storeAs('public/images/banner', $fileNameToStore1);
            Storage::delete('public/images/banner/'.$banner->banner);
        }
        if($request->hasFile('banner')) {
            $banner->banner = $fileNameToStore1;
        }
        $banner->name = request('name');
        $banner->expire_date = request('expire_date');
        $banner->added_date = Carbon::now();
        $banner->save();
        $banners =  $banner->save();

        if ($banners) {
            return redirect('/banner')->with("status", "The record has been updated");
        } else {
            return redirect('/banner')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banners::find($id)->delete();
        return redirect('/banner')->with('status','Deleted Successfully');
    }

    public function status(Request $request, $id){
        $data=Banners::find($id);

        if($data->status==0){
            $data->status=1;
        }else{
            $data->status=0;
        }

        $data->save();
        return redirect()->back()->with('message', 'Status of'.' '.$data->id.' '.'has been changed successfully');

    }
}
