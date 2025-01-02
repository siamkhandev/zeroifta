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
            'plan_id' => 'required|string', // Stripe plan ID
        ]);
    
        try {
            // Set Stripe secret key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
            $user = User::find($request->user_id);
    
            if (!$user->stripe_customer_id) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Stripe customer found for the user',
                    'data' => (object)[],
                ], 404);
            }
    
            // Create a subscription
            $subscription = \Stripe\Subscription::create([
                'customer' => $user->stripe_customer_id,
                'items' => [
                    ['price' => $request->plan_id],
                ],
                'expand' => ['latest_invoice.payment_intent'], // For payment intent details
            ]);
    
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
