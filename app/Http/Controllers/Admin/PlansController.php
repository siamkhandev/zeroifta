<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('id','desc')->get();
        return view('admin.plans.index',get_defined_vars());
    }
    public function create()
    {
        return view('admin.plans.add');
    }
    public function store(Request $request)

    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'price_type' => 'required',
            
           
        ]);
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->price_type = $request->price_type;
        $plan->save();
        return redirect('plans')->withSuccess('Plan Added Successfully');
    }
    public function edit($id)
    {
        $plan = Plan::find($id);
        return view('admin.plans.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required',
            'price_type' => 'required',
            
           
        ]);
        $plan = Plan::find($id);
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->price_type = $request->price_type;
        $plan->update();
        return redirect('plans')->withSuccess('Plan Updated Successfully');
    }
    public function delete($id)
    {
        $plan = Plan::find($id);
        $plan->delete();
        return redirect('plans')->withError('Plan Deleted Successfully');
    }
}
