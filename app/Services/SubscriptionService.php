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
    public function getPlans($data)
    {
        $plans = Plan::where(function ($query) use ($data) {
            $query->where('billing_period', $data['period'])
                  ->orWhere('slug', 'free');
        })
        ->orderByRaw("CASE 
            WHEN slug = 'free' THEN 1
            WHEN billing_period = 'monthly' THEN 2
            WHEN billing_period = 'yearly' THEN 3
            ELSE 4
        END")
        ->orderBy('price', 'asc')
        ->get();
        $customizedPlans = $plans->map(function ($plan) {
            // Customize the description
            if ($plan->slug == 'free') {
                $plan->summary ="";
                $plan->description = [
                    [
                        "heading"=>"You are availing all the features of the Premium Monthly Plan for 6 months.",
                        "subtitle"=>"",
                        "description"=>[],
                    ]
                    
                    ];
                    $plan->not_included =[];
                $plan->price = "Trial Plan (6 Month Only)";
                $plan->is_recommended=0;
            } elseif ($plan->slug == 'basic_monthly') {
                $plan->summary ="";
                $plan->description = [
                    [
                        "heading" => "Fuel Station Recommendations",
                        "subtitle"=>"",
                        "description" => ["Get the best fuel stops based on the unburdened fuel price to maximize savings."]
                    ],
                    [
                        "heading" => "Monthly Savings and IFTA Reports",
                        "subtitle"=>"",
                        "description" => ["Review your savings each month to track how much you've kept in your pocket."]
                    ],
                    [
                        "heading" => "Customize odometer reading and truck MPG's",
                        "subtitle"=>"",
                        "description" => []
                    ],
                    
                ];
                $plan->not_included = [
                    [
                        "heading" => "No live vehicle tracking or alerts.",
                        "subtitle"=>"",
                        "description" =>["Get the best fuel stops based on the unburdened fuel price to maximize savings."]
                    ],
                    [
                        "heading" => "",
                        "subtitle"=>"",
                        "description" => ["No customization of app features, such as setting a minimum number of gallons to fuel, adding stops to trips, or change the default reserve fuel amount."]
                    ],
                    [
                        "heading" => "",
                        "subtitle"=>"",
                        "description" => ["Can't customize fuel tank capacity"]
                    ],
                    
                ];
                
                $plan->is_recommended=0;
                $plan->price='$'.$plan->price.' - Monthly';
            }elseif ($plan->slug == 'premium_monthly') {
                $plan->summary="";
                $plan->description = [
                    [
                        "heading" => "All Features of the Basic Plan.",
                        "subtitle"=>"",
                        "description" => []
                    ],
                    [
                        "heading" => "Automatic IFTA Reporting",
                        "subtitle"=>"",
                        "description" => ["Simplify compliance with automated tax reporting."]
                    ],
                    [
                        "heading" => "Fully Customizable App and Features",
                        "subtitle"=>"Tailor the app to your needs.",
                        "description" => [
                            "Adjust settings like minimum gallons to fuel,",
                            "Add unlimited stops to trips.",
                            "Change the default reserve fuel amount.",
                            "Customize odometer reading and truck MPG's",
                            "Customizable alerts (choose at wish preferred distances to get notified of your upcoming stop)"

                        ]
                    ],
                    [
                        "heading" => "Live Vehicle Tracking",
                        "subtitle"=>"",
                        "description" => ["Monitor your fleet in real-time and track your trucks' positions."]
                    ],
                    [
                        "heading" => "Alerts and Notifications",
                        "subtitle"=>"",
                        "description" => ["Receive alerts if drivers miss suggested fuel stops or deviate from planned routes."]
                    ],
                    [
                        "heading" => "Advanced Trip Planning and Analytics",
                        "subtitle"=>"",
                        "description" => ["Optimize routes with predictive fuel pricing, weather, traffic behavior and vehicle performance data."]
                    ],
                    
                ];
                $plan->not_included =[];
                $plan->is_recommended=1;
                $plan->price='$'.$plan->price.' - Monthly';
            }elseif ($plan->slug == 'premium_plus_monthly') {
                $plan->summary ="Our Premium+ Subscription offers the most comprehensive set of features designed to elevate your fleet management experience. This plan includes everything from our Basic and Premium plans, plus advanced integrations to maximize efficiency and streamline operations.";
                $plan->description = [
                    [
                        "heading" => "Fuel Station Recommendations",
                        "subtitle"=>"",
                        "description" => ["Based on unburdened fuel prices for smarter fueling decisions."]
                    ],
                    [
                        "heading" => "Monthly Savings Reports",
                        "subtitle"=>"",
                        "description" => ["Track your savings and optimize your costs."]
                    ],
                    [
                        "heading" => "Automatic IFTA Reporting",
                        "subtitle"=>"",
                        "description" => ["Eliminate audits and simplify tax compliance with automated reporting."]
                    ],
                    [
                        "heading" => "Live Vehicle Tracking and Alerts",
                        "subtitle"=>"",
                        "description" => ["Real-time tracking of all trucks, with alerts for missed fuel stops and deviations from optimized routes."]
                    ],
                    [
                        "heading" => "Fully Customizable App",
                        "subtitle"=>"",
                        "description" => ["Set your minimum fueling amounts, add stops, and personalize features to fit your unique needs."]
                    ],
                    [
                        "heading" => "Admin Panel API Integration",
                        "subtitle"=>"",
                        "description" => ["Sync your existing fleet software with ZeroIFTA. All truck, driver, and essential fleet information is automatically shared and updated without manual input, ensuring a streamlined workflow between systems."]
                    ],
                    [
                        "heading" => "Real-Time Data Sync",
                        "subtitle"=>"",
                        "description" => ["Maintain accurate fleet information with automatic updates, helping you keep track of crucial data effortlessly."]
                    ],
                   
                ];
                $plan->not_included =[];
                $plan->price='$'.$plan->price.' - Monthly';
                $plan->is_recommended=0;
            } elseif ($plan->slug == 'basic_yearly') {
                $plan->summary = "Equivalent to $51.25 per month (10% discount)";
                $plan->description = [
                    [
                        "heading" => "Fuel Station Recommendations",
                        "subtitle"=>"",
                        "description" => ["Get the best fuel stops based on the unburdened fuel price to maximize savings."]
                    ],
                    [
                        "heading" => "Monthly Savings and IFTA Reports",
                        "subtitle"=>"",
                        "description" => ["Review your savings each month to track how much you've kept in your pocket."]
                    ],
                    [
                        "heading" => "Customize odometer reading and truck MPG's",
                        "subtitle"=>"",
                        "description" => []
                    ],
                    
                ];
                $plan->not_included=[
                    [
                        "heading" => "No Live Vehicle Tracking or Alerts",
                        "subtitle"=>"",
                        "description" => []
                    ],
                    [
                        "heading" => "",
                        "subtitle"=>"",
                        "description" => ["No customization of app features, such as setting a minimum number of gallons to fuel, adding stops to trips, or change the default reserve fuel amount."]
                    ],
                    [
                        "heading" => "",
                        "subtitle"=>"",
                        "description" => ["Can't customize fuel tank capacity"]
                    ]
                ];
                $plan->price='$'.$plan->price.' - Year';
                $plan->is_recommended=0;
            }elseif ($plan->slug == 'premium_yearly') {
                $plan->summary = "Equivalent to $60.83 per month (around 9% discount)";
                $plan->description = [
                    [
                        "heading" => "All Features of the Basic Plan.",
                        "subtitle"=>"",
                        "description" => []
                    ],
                    [
                        "heading" => "Automatic IFTA Reporting:",
                        "subtitle"=>"",
                        "description" => ["Simplify compliance with automated tax reporting."]
                    ],
                    [
                        "heading" => "Fully Customizable App and Features:",
                        "subtitle"=>"Tailor the app to your needs.",
                        "description" => [
                            "Adjust settings like minimum gallons to fuel",
                            "Add unlimited stops to trips",
                            "Change the default reserve fuel amount",
                            "Customize odometer reading and truck MPG's",
                            "Customizable alerts (choose at wish preferred distances to get notified of your upcoming stop)",

                        ]
                    ],
                    [
                        "heading" => "Live Vehicle Tracking",
                        "subtitle"=>"",
                        "description" => ["Monitor your fleet in real-time and track your trucks' positions."]
                    ],
                    [
                        "heading" => "Alerts and Notifications",
                        "subtitle"=>"",
                        "description" => ["Receive alerts if drivers miss suggested fuel stops or deviate from planned routes."]
                    ],
                    [
                        "heading" => "Advanced Trip Planning and Analytics",
                        "subtitle"=>"",
                        "description" => ["Optimize routes with predictive fuel pricing, weather, traffic behavior and vehicle performance data."]
                    ],
                    
                ];
                $plan->not_included =[];
                $plan->price='$'.$plan->price.' - Year';
                $plan->is_recommended=1;
            }elseif ($plan->slug == 'premium_plus_yearly') {
                $plan->summary = "The Premium+ Yearly Subscription gives you full access to all of ZeroIFTA's most powerful features at a discounted rate, offering the ultimate solution for fleet management and fuel optimization.";
                $plan->description = [
                    [
                        "heading" => "Fuel Station Recommendations",
                        "subtitle"=>"",
                        "description" => ["Based on unburdened fuel prices for smarter fueling decisions."]
                    ],
                    [
                        "heading" => "Monthly Savings Reports",
                        "subtitle"=>"",
                        "description" => ["Track your savings and optimize your costs."]
                    ],
                    [
                        "heading" => "Automatic IFTA Reporting",
                        "subtitle"=>"",
                        "description" => ["Eliminate audits and simplify tax compliance with automated reporting."]
                    ],
                    [
                        "heading" => "Live Vehicle Tracking and Alerts",
                        "subtitle"=>"",
                        "description" => ["Monitor your fleet in real-time and receive alerts for missed stops or route changes."]
                    ],
                    [
                        "heading" => "Fully Customizable App",
                        "subtitle"=>"",
                        "description" => ["Adjust settings like minimum gallons to fuel, add stops, and tailor the app to fit your needs."]
                    ],
                    [
                        "heading" => "Fully Customizable App",
                        "subtitle"=>"",
                        "description" => ["Adjust settings like minimum gallons to fuel, add stops, and tailor the app to fit your needs."]
                    ],
                    [
                        "heading" => "Advanced Trip Planning and Analytics",
                        "subtitle"=>"",
                        "description" => ["Utilize predictive fuel pricing, weather data, and vehicle performance insights for efficient route planning."]
                    ],
                    [
                        "heading" => "API Integration with Admin Panel",
                        "subtitle"=>"",
                        "description" => ["Seamlessly connect your software with ZeroIFTA, ensuring all truck, driver, and crucial fleet information is automatically shared and synced without manual input."]
                    ],
                    [
                        "heading" => "Special Yearly Rate: $995",
                        "subtitle"=>"",
                        "description" => ["Secure the full suite of Premium+ features for a whole year and save over 15% compared to the monthly plan. Enjoy seamless integration, powerful analytics, and advanced tools designed to maximize your fleet's efficiency and keep your business running smoothly."]
                    ]
                ];
                $plan->not_included =[];
                $plan->price='$'.$plan->price.' - Year';
                $plan->is_recommended=0;
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
