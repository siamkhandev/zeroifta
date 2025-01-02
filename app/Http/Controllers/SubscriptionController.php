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
    ]);

    try {
        // Set Stripe secret key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get the user from the database
        $user = User::find($request->user_id);

        // Check if the user has a Stripe customer ID
        if (!$user->stripe_customer_id) {
            // If no Stripe customer exists, create a new customer in Stripe
            $stripeCustomer = \Stripe\Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                // Optionally add more customer details like address, phone, etc.
            ]);

            // Save the Stripe customer ID in your database
            $user->stripe_customer_id = $stripeCustomer->id;
            $user->save();
        }

        // Ensure you are passing a valid price_id, not a direct price
        $priceId = Plan::find($request->plan_id); // Plan ID should be a valid Stripe Price ID (not the price amount)

        // Create the subscription
        $subscription = \Stripe\Subscription::create([
            'customer' => $user->stripe_customer_id,
            'items' => [
                ['price' => $priceId->stripe_plan_id], // Pass the Stripe Price ID here
            ],
            'expand' => ['latest_invoice.payment_intent'], // Expand payment intent details
        ]);

        // Assuming you have a Subscription model to store the subscription info in your database
        $subscriptionModel = new Subscription();  // Replace with your actual Subscription model
        $subscriptionModel->user_id = $user->id;  // Associate with the user
        $subscriptionModel->stripe_customer_id = $user->stripe_customer_id;
        $subscriptionModel->stripe_subscription_id = $subscription->id;
        $subscriptionModel->plan_id = $request->plan_id;  // Store the Price ID in your database
        $subscriptionModel->status = 'active';  // You can set the status based on the subscription details
        $subscriptionModel->save();

        // Update the user's subscription status
        $user->is_subscribed = true;
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Subscription created successfully',
            'data' => $subscription,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' =>$e->getMessage(),
            'data' =>(object)[] 
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
