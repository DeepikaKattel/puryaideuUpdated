<?php

namespace App\Http\Controllers;

use App\Rider;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle= Vehicle::with('vehicleType','rider')->get();
        return view('admin.vehicle.index', compact('vehicle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicleType = DB::table('vehicle_types')->get();
        $riders = Rider::with('user')->get();
        return view('admin.vehicle.create',compact('vehicleType','riders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->rider_id = request('rider_id');
        $vehicle->vehicle_type = request('vehicle_type');
        $vehicle->brand = request('brand');
        $vehicle->model = request('model');
        $vehicle->vehicle_year = request('vehicle_year');
        $vehicle->vehicle_colour = request('vehicle_colour');
        $vehicle->license_number = request('license_number');
        $vehicle->save();
        $vehiclesave = $vehicle->save();
        if ($vehiclesave) {
            return redirect('/vehicle')->with("status", "The record has been stored");
        } else {
            return redirect('/vehicle')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle= Vehicle::find($id);

        $vehicleType = DB::table('vehicle_types')->get();

        $riders = Rider::with('user')->get();


        return view('admin.vehicle.edit', compact('vehicle','vehicleType','riders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->rider_id = request('rider_id');
        $vehicle->vehicle_type = request('vehicle_type');
        $vehicle->brand = request('brand');
        $vehicle->model = request('model');
        $vehicle->vehicle_year = request('vehicle_year');
        $vehicle->vehicle_colour = request('vehicle_colour');
        $vehicle->license_number = request('license_number');
        $vehicle->save();
        $vehiclesave = $vehicle->save();
        if ($vehiclesave) {
            return redirect('/vehicle')->with("status", "The record has been stored");
        } else {
            return redirect('/vehicle')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle= Vehicle::find($id)->delete();
        return redirect('/vehicle')->with('status','Deleted Successfully');
    }

    public function status(Request $request, $id){
        $data=Vehicle::find($id);

        if($data->status==0){
            $data->status=1;
        }else{
            $data->status=0;
        }

        $data->save();
        return redirect()->back()->with('message', 'Status of'.' '.$data->model.' '.'has been changed successfully');

    }
}
