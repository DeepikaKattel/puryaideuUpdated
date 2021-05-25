<?php

namespace App\Http\Controllers;

use App\Price;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $price = Price::with('vehicleType')->get();
        return view('admin.price.index', compact('price'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicleType = DB::table('vehicle_types')->get();
        return view('admin.price.create',compact('vehicleType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $price = new Price();
        $price->vehicle_type = request('vehicle_type');
        $price->rate = request('rate');
        $price->distance = request('distance');
        $price->total_amount = $price->rate * $price->distance;
        $price->save();
        $prices =  $price->save();
        if ($prices) {
            return redirect('/price')->with("status", "The record has been stored");
        } else {
            return redirect('/price')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $price = Price::find($id);
        $vehicleType = DB::table('vehicle_types')->get();
        return view('admin.price.edit', compact('price','vehicleType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $price = Price::find($id);
        $price->vehicle_type = request('vehicle_type');
        $price->rate = request('rate');
        $price->distance = request('distance');
        $price->total_amount = $price->rate * $price->distance;

        $price->save();

        if ($price) {
            return redirect('/price')->with("status", "The record has been updated");
        } else {
            return redirect('/price')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $price = Price::find($id)->delete();
        return redirect('/price')->with('status','Deleted Successfully');
    }
}
