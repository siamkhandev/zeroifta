<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;

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
           'billing_period' => 'nullable|string|in:month,year',
            'recurring' => 'required|boolean',
            
           
        ]);
        try{
            Stripe::setApiKey(config('services.stripe.secret'));
            $product = Product::create([
                'name' => $request->name,
            ]);
    
            $stripePriceData = [
                'product' => $product->id,
                'unit_amount' => $request->price * 100,
                'currency' => 'usd',
            ];
    
            if ($request->recurring) {
                $stripePriceData['recurring'] = ['interval' => $request->billing_period];
            }
    
            $price = Price::create($stripePriceData);
            $plan = new Plan();
            $plan->name = $request->name;
            $plan->price = $request->price;
            $plan->billing_period = $request->recurring ? $request->billing_period : null;
            $plan->recurring = $request->recurring;
            $plan->stripe_plan_id = $price->id;
            $plan->description = $request->description;
            $plan->save();
            return redirect('plans')->withSuccess('Plan Added Successfully');
        }catch(Exception $e)
        {
            dd($e->getMessage());
        }
        
    }
    public function edit($id)
    {
        $plan = Plan::find($id);
        return view('admin.plans.edit',get_defined_vars());
    }
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'billing_period' => 'nullable|string|in:month,year',
            'recurring' => 'required|boolean',
        ]);
        $plan = Plan::find($id);
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->billing_period = $request->recurring ? $request->billing_period : null;
        $plan->recurring =$request->recurring;
        $plan->description = $request->description;
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
