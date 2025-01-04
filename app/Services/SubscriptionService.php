<?php

namespace App\Services;

use App\Models\Plan;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use App\Models\Subscription as SubscriptionModel;
use Exception;
use Stripe\PaymentMethod;

class SubscriptionService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Create a Stripe customer.
     */
    public function createCustomer($user, $paymentMethodId)
    {
        try {
            $customer = Customer::create([
                'email' => $user->email,
                'payment_method' => $paymentMethodId,
                'invoice_settings' => ['default_payment_method' => $paymentMethodId],
            ]);

            $user->update(['stripe_customer_id' => $customer->id]);
            return $customer;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create a subscription for the user.
     */
    public function createSubscription($user, $planId, $paymentMethodId, $hasTrial = false)
    {
        try {
            // Check if the user has a Stripe customer ID, create one if not
            if (!$user->stripe_customer_id) {
                $stripeCustomer = \Stripe\Customer::create([
                    'email' => $user->email, // Use the user's email to create the Stripe customer
                    'payment_method' => $paymentMethodId, // Attach the payment method during customer creation
                    'invoice_settings' => ['default_payment_method' => $paymentMethodId],
                ]);

                // Save the Stripe customer ID in the user record
                $user->stripe_customer_id = $stripeCustomer->id;
                $user->save();
            }
            $paymentMethod = \App\Models\PaymentMethod::findOrFail($paymentMethodId);
            // Retrieve and attach the payment method to the customer
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $user->stripe_customer_id]);

            // Set the payment method as the default for the customer
            \Stripe\Customer::update(
                $user->stripe_customer_id,
                ['invoice_settings' => ['default_payment_method' => $paymentMethodId]]
            );

            // Create the subscription
            $stripeSubscription = \Stripe\Subscription::create([
                'customer' => $user->stripe_customer_id,
                'items' => [['price' => $planId]], // Assuming you use a Stripe price ID here
                'trial_period_days' => $hasTrial ? 180 : null,
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            // Save the subscription and payment method to the database
            $subscription = $user->subscriptions()->create([
                'stripe_subscription_id' => $stripeSubscription->id,
                'plan_id' => $planId,
                'payment_method_id' => $paymentMethodId,
                'status' => 'active',
            ]);

            return $subscription;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }



    /**
     * Get available subscription plans.
     */
    public function getPlans()
    {
        $plans = Plan::orderByRaw("CASE 
            WHEN slug = 'free' THEN 1
            WHEN billing_period = 'monthly' THEN 2
            WHEN billing_period = 'yearly' THEN 3
            ELSE 4
            END")->orderBy('price', 'asc')->get();
        $customizedPlans = $plans->map(function ($plan) {
            // Customize the description
            if ($plan->type == 'free') {
                $plan->description = "You are availing all the features of the Premium Monthly Plan for 6 months. ";
            } elseif ($plan->slug == 'basic_monthly') {
                $plan->description = "Fuel Station Recommendations.Get the best fuel stops based on the unburdened fuel price to maximize savings. ";
            }elseif ($plan->slug == 'premium_monthly') {
                $plan->description = "All Features of the Basic Plan.";
            }elseif ($plan->slug == 'premium_plus_monthly') {
                $plan->description = "Our Premium+ Subscription offers the most comprehensive set of features designed to elevate your fleet management experience. This plan includes everything from our Basic and Premium plans, plus advanced integrations to maximize efficiency and streamline operations.";
            } elseif ($plan->slug == 'basic_yearly') {
                $plan->description = "Fuel Station Recommendations.Get the best fuel stops based on the unburdened fuel price to maximize savings.";
            }elseif ($plan->slug == 'premium_yearly') {
                $plan->description = "All Features of the Basic Plan.";
            }elseif ($plan->slug == 'premium_plus_yearly') {
                $plan->description = "The Premium+ Yearly Subscription gives you full access to all of ZeroIFTA's most powerful features at a discounted rate, offering the ultimate solution for fleet management and fuel optimization.";
            }
    
            // Return the modified plan
            return $plan;
        });
       return $customizedPlans;
    }

    /**
     * Cancel a subscription.
     */
    public function cancelSubscription($subscription)
    {
        try {
            \Stripe\Subscription::update($subscription->stripe_subscription_id, [
                'cancel_at_period_end' => true,
            ]);

            $subscription->update(['status' => 'canceled']);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get trial days for a specific plan.
     */
    private function getTrialDays($planId)
    {
        $trialPlans = [
            '6_month_free_trial_plan_id' => 180,
        ];

        return $trialPlans[$planId] ?? 0;
    }
}
