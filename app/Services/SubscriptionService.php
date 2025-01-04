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
            WHEN billing_cycle = 'monthly' THEN 2
            WHEN billing_cycle = 'yearly' THEN 3
            ELSE 4
            END")->get();
        $customizedPlans = $plans->map(function ($plan) {
            // Customize the description
            if ($plan->type == 'free') {
                $plan->description = "This is the free plan: " . $plan->description;
            } elseif ($plan->billing_cycle == 'monthly') {
                $plan->description = "Monthly Plan: " . $plan->description;
            } elseif ($plan->billing_cycle == 'yearly') {
                $plan->description = "Yearly Plan: " . $plan->description;
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
