<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class PaymentMethodsController extends Controller
{
    public function index()
    {
        
            // Set Stripe secret key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Get the authenticated user
            $user = Auth::user();

            if (!$user->stripe_customer_id) {
                return redirect()->back()->withError('No Stripe customer found for the user');
                
            }

            // Retrieve all payment methods for the Stripe customer
            $paymentMethods = \Stripe\PaymentMethod::all([
                'customer' => $user->stripe_customer_id,
                'type' => 'card', // Fetch only card payment methods
            ]);

            // Retrieve the default payment method from Stripe
            $stripeCustomer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            $defaultPaymentMethodId = $stripeCustomer->invoice_settings->default_payment_method;

            $filteredMethods = array_map(function ($method) use ($defaultPaymentMethodId) {
                return [
                    'id' => $method['id'],
                    'name' => $method['billing_details']['name'],
                    'brand' => $method['card']['brand'],
                    'expiry_month' => $method['card']['exp_month'],
                    'expiry_year' => $method['card']['exp_year'],
                    'last4' => $method['card']['last4'],
                    'is_default' => $method['id'] === $defaultPaymentMethodId, // Check if this is the default method
                ];
            }, $paymentMethods->data);
            return view('company.payment_methods.index',get_defined_vars());
            
        
    }
    public function addPaymentMethod()
    {
        return view('company.payment_methods.add');
    }
    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'paymentMethodId' => 'required|string',
            'methodName' => 'required|string|max:255',
        ]);
    
        try {
            // Set the Stripe API secret key
            Stripe::setApiKey(env('STRIPE_SECRET'));
    
            // Retrieve the logged-in user
            $user = auth()->user();
    
            // Retrieve the payment method from Stripe using the PaymentMethod ID
            $paymentMethod = \Stripe\PaymentMethod::retrieve($request->paymentMethodId);
    
            // Check if the user has a Stripe customer ID
            if ($user->stripe_customer_id) {
                // Attach the payment method to the Stripe customer
                $paymentMethod->attach([
                    'customer' => $user->stripe_customer_id,
                ]);
            }
    
            // Check if a default payment method exists for the user
            $existingDefault = PaymentMethod::where('user_id', $user->id)
                ->where('is_default', true)
                ->exists();
    
            // Save the payment method details to the database
            $storedPaymentMethod = PaymentMethod::create([
                'user_id' => $user->id,
                'method_name' => $request->methodName,
                'card_holder_name' => $paymentMethod->billing_details->name ?? null, // Get the cardholder's name from Stripe
                'card_number' => substr($paymentMethod->card->last4, -4), // Store last 4 digits
                'expiry_date' => $paymentMethod->card->exp_month . '/' . $paymentMethod->card->exp_year, // Expiry date
                'stripe_payment_method_id' => $paymentMethod->id, // Stripe payment method ID
                'card_type' => $paymentMethod->card->brand ?? null, // Card type (e.g., Visa, Mastercard)
                'is_default' => !$existingDefault, // Set as default only if no default exists
            ]);
    
            return response()->json(['status' => 200, 'message' => 'Payment method added successfully!', 'data' => $storedPaymentMethod]);
        } catch (ApiErrorException $e) {
            return response()->json(['status' => 500, 'message' => 'Stripe API Error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function setDefaultPaymentMethod(Request $request)
    {
        $request->validate([
            'paymentMethodId' => 'required|string',
        ]);
    
        // Retrieve the logged-in user
        $user = auth()->user();
    
        // Find the selected payment method from the database
        $paymentMethod = PaymentMethod::where('user_id', $user->id)
            ->where('stripe_payment_method_id', $request->paymentMethodId)
            ->first();
    
        if (!$paymentMethod) {
            return response()->json(['status' => 404, 'message' => 'Payment method not found.']);
        }
    
        try {
            // Set the Stripe API secret key
            Stripe::setApiKey(env('STRIPE_SECRET'));
    
            // Check if the user has a Stripe customer ID
            if ($user->stripe_customer_id) {
                // Update the default payment method on Stripe
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
                $customer->invoice_settings->default_payment_method = $paymentMethod->stripe_payment_method_id;
                $customer->save();
            }
    
            // Update the database to set the selected payment method as default
            // Set all other payment methods to non-default
            PaymentMethod::where('user_id', $user->id)->update(['is_default' => false]);
    
            // Set the selected payment method as default
            $paymentMethod->update(['is_default' => true]);
    
            return response()->json(['status' => 200, 'message' => 'Payment method set as default successfully.']);
        } catch (ApiErrorException $e) {
            return response()->json(['status' => 500, 'message' => 'Stripe API Error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
