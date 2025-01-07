<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Subscribe to a plan.
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plan_id' => 'required|string', // Price ID (not the plan amount)
            'payment_method_id' => 'nullable|string', // Optional payment method ID
        ]);
    
        try {
            // Set Stripe secret key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
            // Get the user from the database
            $user = User::find($request->user_id);
    
            // Check if the user has a Stripe customer ID
            if (!$user->stripe_customer_id) {
                // Create a new customer in Stripe if none exists
                $stripeCustomer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
    
                $user->stripe_customer_id = $stripeCustomer->id;
                $user->save();
            }
    
            // Get the Stripe Price ID from the Plan model
            $priceId = Plan::find($request->plan_id)->stripe_plan_id;
    
            // Check if the user already has an active subscription
            $currentSubscription = \Stripe\Subscription::all([
                'customer' => $user->stripe_customer_id,
                'status' => 'active',
            ]);
    
            if ($currentSubscription->data) {
                // User has an active subscription, update it
                $subscriptionId = $currentSubscription->data[0]->id;
    
                if ($request->has('payment_method_id')) {
                    // Attach the new payment method to the customer
                    \Stripe\PaymentMethod::attach(
                        $request->payment_method_id,
                        ['customer' => $user->stripe_customer_id]
                    );
    
                    // Set the new payment method as default
                    \Stripe\Customer::update(
                        $user->stripe_customer_id,
                        ['invoice_settings' => ['default_payment_method' => $request->payment_method_id]]
                    );
                }
    
                // Update the subscription
                $updatedSubscription = \Stripe\Subscription::update($subscriptionId, [
                    'items' => [
                        ['id' => $currentSubscription->data[0]->items->data[0]->id, 'price' => $priceId],
                    ],
                ]);
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Subscription updated successfully',
                    'data' => $updatedSubscription,
                ]);
            } else {
                // No active subscription, create a new one
                $subscriptionData = [
                    'customer' => $user->stripe_customer_id,
                    'items' => [
                        ['price' => $priceId],
                    ],
                    'expand' => ['latest_invoice.payment_intent'],
                ];
    
                if ($request->has('payment_method_id')) {
                    // Attach the new payment method to the customer
                    \Stripe\PaymentMethod::attach(
                        $request->payment_method_id,
                        ['customer' => $user->stripe_customer_id]
                    );
    
                    // Set the new payment method as default
                    \Stripe\Customer::update(
                        $user->stripe_customer_id,
                        ['invoice_settings' => ['default_payment_method' => $request->payment_method_id]]
                    );
                }
    
                // Create the subscription
                $newSubscription = \Stripe\Subscription::create($subscriptionData);
    
                // Save subscription in the database
                $subscriptionModel = new Subscription();
                $subscriptionModel->user_id = $user->id;
                $subscriptionModel->stripe_customer_id = $user->stripe_customer_id;
                $subscriptionModel->stripe_subscription_id = $newSubscription->id;
                $subscriptionModel->plan_id = $request->plan_id;
                $subscriptionModel->status = 'active';
                $subscriptionModel->save();
    
                $user->is_subscribed = true;
                $user->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Subscription created successfully',
                    'data' => $newSubscription,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
                'data' => (object)[],
            ], 500);
        }
    }
    


    /**
     * Get available subscription plans.
     */
    public function getPlans()
    {
        $plans = $this->subscriptionService->getPlans();

        return response()->json([
            'status' => 200,
            'message' => 'Subscription plans retrieved successfully',
            'data' => $plans,
        ]);
    }

    /**
     * Cancel the user's subscription.
     */
    public function cancelSubscription(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    try {
        // Set Stripe secret key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get the user from the database
        $user = User::find($request->user_id);

        // Check if the user has a Stripe customer ID
        if (!$user->stripe_customer_id) {
            return response()->json([
                'status' => 404,
                'message' => 'Stripe customer not found for this user.',
                'data' => (object)[],
            ], 404);
        }

        // Find the active subscription for the user
        $subscription = Subscription::where('user_id', $request->user_id)
            ->where('status', 'active')  // Only consider active subscriptions
            ->first();

        if (!$subscription) {
            return response()->json([
                'status' => 404,
                'message' => 'No active subscription found for this user.',
                'data' => (object)[],
            ], 404);
        }

        // Retrieve the subscription from Stripe
        $stripeSubscription = \Stripe\Subscription::retrieve($subscription->stripe_subscription_id);

        // Cancel the subscription on Stripe
        $cancelledSubscription = $stripeSubscription->cancel();

        // Update the subscription status in the database
        $subscription->status = 'cancelled';
        $subscription->save();

        // Update the user's subscription status
        $user->is_subscribed = false;
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Subscription cancelled successfully',
            'data' => $cancelledSubscription,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'Failed to cancel subscription',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    /**
     * Get the authenticated user's subscription details.
     */
    public function getSubscriptionDetails()
    {
        $subscription = Subscription::where('user_id', auth()->id())->first();

        if (!$subscription) {
            return response()->json([
                'status' => 404,
                'message' => 'No active subscription found',
                'data' => (object) [],
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Subscription details retrieved successfully',
            'data' => $subscription,
        ]);
    }
}
