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
            'message' => 'Failed to create subscription',
            'error' => $e->getMessage(),
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
            'subscription_id' => 'required|string',
        ]);

        $subscription = Subscription::where('stripe_subscription_id', $request->subscription_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->subscriptionService->cancelSubscription($subscription);

        return response()->json([
            'status' => 200,
            'message' => 'Subscription cancelled successfully',
            'data' => (object) [],
        ]);
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
