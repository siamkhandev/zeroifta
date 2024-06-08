<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Charge;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showCheckoutForm()
    {
        return view('checkout');
    }

    public function purchase($id)
    {
        $plan = Plan::whereId($id)->first();
        return view('company.subscribe', compact('plan'));
    }
    public function subscribe(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'plan_id' => 'required|exists:plans,id',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();
        $paymentMethod = $request->payment_method;
        $plan = Plan::find($request->plan_id);

        // Create Customer in Stripe
        $customer = Customer::create([
            'email' => $user->email,
            'name' => $user->name,
            'payment_method' => $paymentMethod,
            'invoice_settings' => [
                'default_payment_method' => $paymentMethod,
            ],
        ]);

        if ($plan->recurring) {
            // Create Subscription for recurring plan
            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [['price' => $plan->stripe_plan_id]],
                'default_payment_method' => $paymentMethod,
            ]);

            // Store Payment Info in Database
            Payment::create([
                'company_id' => $user->id,
                'stripe_payment_id' => $customer->id,
                'stripe_subscription_id' => $subscription->id,
                'plan' => $plan->billing_period,
                'amount' => $plan->price,
                'status' => 'active',
                'plan_id' => $plan->id,
            ]);
            User::whereId($user->id)->update(['is_subscribed'=>1]);
        } else {
            // Handle one-time payment for non-recurring plan
            \Stripe\PaymentIntent::create([
                'amount' => $plan->price * 100,
                'currency' => 'usd',
                'customer' => $customer->id,
                'payment_method' => $paymentMethod,
                'off_session' => true,
                'confirm' => true,
            ]);

            // Store Payment Info in Database
            Payment::create([
                'company_id' => $user->id,
                'stripe_payment_id' => $customer->id,
                'stripe_subscription_id' =>null,
                'plan' => 'one-time',
                'amount' => $plan->price,
                'status' => 'active',
                'plan_id' => $plan->id,
            ]);
            User::whereId($user->id)->update(['is_subscribed'=>1]);
        }

        return redirect('/subscribe')->with('success', 'Subscription purchased successfully.');
    }
    public function cancel($id)
    {
        $user = Auth::user();

        Stripe::setApiKey(config('services.stripe.secret'));

        $subscriptionId = $id;

        if ($subscriptionId) {
            try {
                $subscription = Subscription::retrieve($subscriptionId);
                $subscription->cancel();
                User::whereId($user->id)->update(['is_subscribed'=>0]);
                Payment::where('company_id',$user->id)->update(['status'=>'cancelled']);
                return redirect('subscribe')->with('success', 'Subscription cancelled successfully.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to cancel subscription. Please try again later.');
            }
        } else {
            return redirect()->back()->with('error', 'No active subscription found.');
        }
    }
    public function allPayments()
    {
        $payments = Payment::with('user','planName')->get();
      
        return view('admin.payments.index',get_defined_vars());    
    }
}
