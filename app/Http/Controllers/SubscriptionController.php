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
            'plan_id' => 'required|string',
            'payment_method_id' => 'required|string',

        ]);

        $user =User::find($request->user_id);
        $plan = Plan::findOrFail($request->plan_id);

        // Determine if the plan has a trial
        $hasTrial = $plan->price == 0 ?? false;
        // Create the subscription
        $subscription = $this->subscriptionService->createSubscription(
            $user,
            $request->plan_id,
            $request->payment_method_id,
            $hasTrial
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription created successfully',
            'data' => $subscription,
        ]);
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
