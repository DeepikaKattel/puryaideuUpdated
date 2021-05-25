<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plan = Plan::with('planType')->get();
        return view('admin.plan.index', compact('plan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $planType = DB::table('plan_types')->get();
        return view('admin.plan.create',compact('planType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = new Plan();
        $plan->title = request('title');
        $plan->plan_type = request('plan_type');
        $plan->value = request('value');

        $plan->save();
        $plans =  $plan->save();
        if ($plans) {
            return redirect('/plan')->with("status", "The record has been stored");
        } else {
            return redirect('/plan')->with("error", "There is an error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::find($id);
        $planType = DB::table('plan_types')->get();
        return view('admin.plan.edit', compact('plan','planType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);
        $plan->title = request('title');
        $plan->plan_type = request('plan_type');
        $plan->value = request('value');
        $plan->save();

        if ($plan) {
            return redirect('/plan')->with("status", "The record has been updated");
        } else {
            return redirect('/plan')->with("error", "There is an error");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::find($id)->delete();
        return redirect('/plan')->with('status','Deleted Successfully');
    }
}
