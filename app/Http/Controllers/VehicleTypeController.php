<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicleType = VehicleType::get();
        return view('admin.vehicleType.index', compact('vehicleType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicleType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicleType = new VehicleType();
        $vehicleType->name = request('name');
        $vehicleType->price_km = request('price_km');
        $vehicleType->price_min = request('price_min');
        $vehicleType->base_fare = request('base_fare');
        $vehicleType->commission = request('commission');
        $vehicleType->capacity = request('capacity');
        $vehicleType->save();
        $vehicleTypes =  $vehicleType->save();
        if ($vehicleTypes) {
            return redirect('/vehicleType')->with("status", "The record has been stored");
        } else {
            return redirect('/vehicleType')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleType $vehicleType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicleType = VehicleType::find($id);
        return view('admin.vehicleType.edit', compact('vehicleType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicleType = VehicleType::find($id);
        $vehicleType->name = request('name');
        $vehicleType->price_km = request('price_km');
        $vehicleType->price_min = request('price_min');
        $vehicleType->base_fare = request('base_fare');
        $vehicleType->commission = request('commission');
        $vehicleType->capacity = request('capacity');
        $vehicleType->save();

        if ($vehicleType) {
            return redirect('/vehicleType')->with("status", "The record has been updated");
        } else {
            return redirect('/vehicleType')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicleType = VehicleType::find($id)->delete();
        return redirect('/vehicleType')->with('status','Deleted Successfully');
    }
    public function status(Request $request, $id){
        $data=VehicleType::find($id);

        if($data->status==0){
            $data->status=1;
        }else{
            $data->status=0;
        }

        $data->save();
        return redirect()->back()->with('message', 'Status of'.' '.$data->model.' '.'has been changed successfully');

    }
}
