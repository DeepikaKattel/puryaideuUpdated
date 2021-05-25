<?php

namespace App\Http\Controllers;

use App\PlanType;
use Illuminate\Http\Request;

class PlanTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planType = PlanType::get();
        return view('admin.planType.index', compact('planType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.planType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $planType = new PlanType();
        $planType->name = request('name');
        $planType->percentage = request('percentage');
        $planType->criteria = request('criteria');
        $planType->remarks = request('remarks');
        $planType->save();
        $planTypes =  $planType->save();
        if ($planTypes) {
            return redirect('/planType')->with("status", "The record has been stored");
        } else {
            return redirect('/planType')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlanType  $planType
     * @return \Illuminate\Http\Response
     */
    public function show(PlanType $planType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlanType  $planType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $planType = PlanType::find($id);
        return view('admin.planType.edit', compact('planType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlanType  $planType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $planType = PlanType::find($id);
        $planType->name = request('name');
        $planType->percentage = request('percentage');
        $planType->criteria = request('criteria');
        $planType->remarks = request('remarks');
        $planType->save();

        if ($planType) {
            return redirect('/planType')->with("status", "The record has been updated");
        } else {
            return redirect('/planType')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlanType  $planType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $planType = PlanType::find($id)->delete();
        return redirect('/planType')->with('status','Deleted Successfully');
    }
}
