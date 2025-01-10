<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Token;

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
        'plan_id' => 'required|string',
        'payment_method_id' => 'nullable|string',
    ]);

    try {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = User::find($request->user_id);

        if (!$user->stripe_customer_id) {
            $stripeCustomer = \Stripe\Customer::create([
                'email' => $user->email,
                'name' => $user->name,
            ]);
            $user->stripe_customer_id = $stripeCustomer->id;
            $user->save();
        }

        $priceId = Plan::find($request->plan_id)->stripe_plan_id;

        $currentSubscription = \Stripe\Subscription::all([
            'customer' => $user->stripe_customer_id,
            'status' => 'active',
        ]);

        if ($currentSubscription->data) {
            $subscriptionId = $currentSubscription->data[0]->id;

            if ($request->has('payment_method_id')) {
                // Attach the new payment method to the customer
                $stripePaymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method_id);
                $stripePaymentMethod->attach(['customer' => $user->stripe_customer_id]);

                // Set the new payment method as default
                \Stripe\Customer::update(
                    $user->stripe_customer_id,
                    ['invoice_settings' => ['default_payment_method' => $request->payment_method_id]]
                );
            }

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
            $subscriptionData = [
                'customer' => $user->stripe_customer_id,
                'items' => [
                    ['price' => $priceId],
                ],
                'expand' => ['latest_invoice.payment_intent'],
            ];

            if ($request->has('payment_method_id')) {
                $stripePaymentMethod = \Stripe\PaymentMethod::retrieve($request->payment_method_id);
                $stripePaymentMethod->attach(['customer' => $user->stripe_customer_id]);

                \Stripe\Customer::update(
                    $user->stripe_customer_id,
                    ['invoice_settings' => ['default_payment_method' => $request->payment_method_id]]
                );
            }

            $newSubscription = \Stripe\Subscription::create($subscriptionData);

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
    public function generateToken(Request $request)
    {
     
        // Validate the card details
        $request->validate([
            'number'    => 'required|digits_between:13,19',
            'exp_month' => 'required|integer|between:1,12',
            'exp_year'  => 'required|integer|min:' . date('Y'),
            'cvc'       => 'required|digits_between:3,4',
        ]);

        try {
            // Set Stripe API key
            Stripe::setApiKey(env('STRIPE_KEY'));

            // Create a token
            $token = Token::create([
                'card' => [
                    'number'    => $request->number,
                    'exp_month' => $request->exp_month,
                    'exp_year'  => $request->exp_year,
                    'cvc'       => $request->cvc,
                ],
            ]);
            dd($token);
            return response()->json([
                'success' => true,
                'token'   => $token->id,
            ], 200);
        } catch (\Stripe\Exception\CardException $e) {
            // Handle specific card errors
            return response()->json([
                'success' => false,
                'message' => $e->getError()->message,
            ], 400);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
