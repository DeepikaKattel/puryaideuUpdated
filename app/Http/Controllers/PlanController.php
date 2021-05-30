<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Price;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $plan = Cache::remember('users', 60, function() {
            return Plan::with('planType')->get();
        });
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
        Cache::forget('plan');
        $plan = new Plan();
        $plan->title = request('title');
        $plan->plan_type = request('plan_type');
        $plan->validity = request('validity');
        $plan->activation_date = request('activation_date');
        $plan->expire_date = request('expire_date');
        $plan->usage_limit = request('usage_limit');
        $plan->used = request('used');

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
        Cache::forget('plan');
        $plan = Plan::find($id);
        $plan->title = request('title');
        $plan->plan_type = request('plan_type');
        $plan->validity = request('validity');
        $plan->activation_date = request('activation_date');
        $plan->expire_date = request('expire_date');
        $plan->usage_limit = request('usage_limit');
        $plan->used = request('used');
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

    public function status(Request $request, $id){

        $data = Plan::find($id);

        if($data->status==0){
            Cache::forget('plan');
            $data->status=1;
        }else{
            Cache::forget('plan');
            $data->status=0;
        }

        $data->save();
        return redirect()->back()->with('message', 'Status of'.' '.$data->model.' '.'has been changed successfully');

    }
}
