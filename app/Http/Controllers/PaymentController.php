<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Charge;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription as ModelsSubscription;
use App\Models\User;
use Exception;
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

        try {
            // Check for existing Stripe Customer or create one
            $customer = $user->stripe_customer_id
                ? Customer::retrieve($user->stripe_customer_id)
                : Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'payment_method' => $paymentMethod,
                    'invoice_settings' => [
                        'default_payment_method' => $paymentMethod,
                    ],
                ]);

            if (!$user->stripe_customer_id) {
                $user->update(['stripe_customer_id' => $customer->id]);
            }

            // Check for existing subscription
            $subscriptions = Subscription::all(['customer' => $customer->id, 'status' => 'active']);

            if ($subscriptions->data) {
                dd("here");
                // Update existing subscription
                $subscription = $subscriptions->data[0];
                $updatedSubscription = Subscription::update($subscription->id, [
                    'items' => [
                        [
                            'id' => $subscription->items->data[0]->id,
                            'price' => $plan->stripe_plan_id,
                        ],
                    ],
                    'proration_behavior' => 'create_prorations',
                ]);

                ModelsSubscription::where('stripe_subscription_id', $subscription->id)->update([
                    'plan' => $plan->billing_period,
                    'amount' => $plan->price,
                    'status' => 'active',
                    'plan_id' => $plan->id,
                ]);

                return redirect('/subscribe')->with('success', 'Subscription updated successfully.');
            } else {
                // Create a new subscription
                $newSubscription = Subscription::create([
                    'customer' => $customer->id,
                    'items' => [[
                        'price' => $plan->stripe_plan_id,
                    ]],
                    'default_payment_method' => $paymentMethod,
                    'proration_behavior' => 'create_prorations',
                ]);

                // Store Payment Info in Database
                ModelsSubscription::create([
                    'company_id' => $user->id,
                    'stripe_payment_id' => $customer->id,
                    'stripe_subscription_id' => $newSubscription->id,
                    'plan' => $plan->billing_period,
                    'amount' => $plan->price,
                    'status' => 'active',
                    'plan_id' => $plan->id,
                ]);

                $user->update(['is_subscribed' => 1]);

                return redirect('/subscribe')->with('success', 'Subscription purchased successfully.');
            }
        } catch (Exception $e) {
            return redirect('/subscribe')->with('error', 'Error managing subscription: ' . $e->getMessage());
        }
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
                ModelsSubscription::where('user_id',$user->id)->update(['status'=>'cancelled']);
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
        $payments = ModelsSubscription::with('user','planName')->get();

        return view('admin.payments.index',get_defined_vars());
    }
}
