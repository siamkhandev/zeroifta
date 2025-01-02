<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\PaymentMethod as StripePaymentMethod;
use Stripe\Token;

class PaymentMethodController extends Controller
{
    public function allPaymentMethod(Request $request)
    {
        $paymentMethods = PaymentMethod::where('user_id', $request->user_id)->get();
        return response()->json(['status'=>200,'message' => 'Payment methods fetched successfully', 'data' => $paymentMethods]);
    }
    public function addPaymentMethod(Request $request)
    {
        
        $validated = $request->validate([
            'token' => 'required|string', // Stripe payment method token
            'method_name' => 'required|string', // Name for the payment method
        ]);
    
        try {
            // Set Stripe secret key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
            // Retrieve or create a Stripe customer for the authenticated user
            $user = User::find($request->user_id);
            if (!$user->stripe_customer_id) {
                // Create a new customer on Stripe
                $customer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
        
                // Save the customer ID to the user
                $user->update(['stripe_customer_id' => $customer->id]);
            } else {
                // Retrieve existing Stripe customer
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            }
        
            // Create a PaymentMethod from the token
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $validated['token'], // Use the `tok_` received from the Android app
                ],
            ]);
        
            // Attach the payment method to the Stripe customer
            $paymentMethod->attach(['customer' => $customer->id]);
        
            // Update default payment method for the customer
            \Stripe\Customer::update($customer->id, [
                'invoice_settings' => ['default_payment_method' => $paymentMethod->id],
            ]);
        
            // Store payment method details in the database
            $storedPaymentMethod = PaymentMethod::create([
                'user_id' => $user->id,
                'method_name' => $validated['method_name'],
                'card_number' => substr($paymentMethod->card->last4, -4), // Store last 4 digits
                'expiry_date' => $paymentMethod->card->exp_month . '/' . $paymentMethod->card->exp_year, // Expiry date
                'stripe_payment_method_id' => $paymentMethod->id, // Stripe payment method ID
                'is_default' => true, // Mark as default
            ]);
        
            return response()->json([
                'status' => 200,
                'message' => 'Payment method added successfully',
                'data' => $storedPaymentMethod,
            ]);
        } catch (\Exception $e) {
            // Handle errors
            return response()->json([
                'status' => 500,
                'message' => 'Failed to add payment method',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }
    
    public function getPaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)->firstOrFail();
        return response()->json(['status'=>200,'message' => 'Payment method fetched successfully', 'data' => $paymentMethod]);
    }
    public function editPaymentMethod(Request $request, $id)
    {
        $validated = $request->validate([
            'method_name' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date_format:m/y',
        ]);

        $paymentMethod = PaymentMethod::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $paymentMethod->update($validated);

        return response()->json(['status'=>200,'message' => 'Payment method updated successfully', 'data' => $paymentMethod]);
    }
    public function deletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

        // Initialize Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // If you have stored Stripe's PaymentMethod ID, you can detach it from the customer
            if (!empty($paymentMethod->stripe_payment_method_id)) {
                StripePaymentMethod::retrieve($paymentMethod->stripe_payment_method_id)->detach();
            }

            // Delete the payment method from your database
            $paymentMethod->delete();

            return response()->json(['status'=>200,'message' => 'Payment method deleted successfully','data'=>(object)[]]);
        } catch (\Exception $e) {
            return response()->json(['status'=>500,'message' => $e->getMessage(),'data'=>(object)[]], 500);
    }
    }
    public function makeDefault(Request $request,$id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)->firstOrFail();

        // Reset all default flags for the user
        PaymentMethod::where('id', $id)->update(['is_default' => false]);

        // Set this method as default
        $paymentMethod->update(['is_default' => true]);

        return response()->json(['status'=>200,'message' => 'Payment method set as default', 'data' => $paymentMethod]);
    }
}
