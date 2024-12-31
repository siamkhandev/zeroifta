<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentMethod as StripePaymentMethod;

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
            'encrypted_card_details' => 'required|string', // Encrypted data from app
            'method_name' => 'required|string|max:255',
        ]);
        $privateKey = file_get_contents('http://zeroifta.alnairtech.com/my_rsa_key');
        openssl_private_decrypt(base64_decode($validated['encrypted_card_details']), $decryptedData, $privateKey);
        if (!$decryptedData) {
            return response()->json(['status' =>400,'message'=> 'Failed to decrypt card details','data'=>(object)[]], 400);
        }
        $cardDetails = json_decode($decryptedData, true);
        if (!$cardDetails || !isset($cardDetails['card_number'], $cardDetails['expiry_date'])) {
            return response()->json(['status' =>400,'message'=>'Invalid card details','data'=>(object)[]], 400);
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $stripePaymentMethod = StripePaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => $cardDetails['card_number'],
                    'exp_month' => substr($cardDetails['expiry_date'], 0, 2),
                    'exp_year' => substr($cardDetails['expiry_date'], -4),
                ],
            ]);

            // Store payment method in the database
            $paymentMethod = PaymentMethod::create([
                'user_id' => auth()->id(),
                'method_name' => $validated['method_name'],
                'card_number' => substr($cardDetails['card_number'], -4), // Store last 4 digits only
                'expiry_date' => $cardDetails['expiry_date'], // Store expiry date
                
                'is_default' => false,
            ]);

            return response()->json([
                'status'=>200,
                'message' => 'Payment method added successfully',
                'data' => $paymentMethod,
               
            ]);
        } catch (\Exception $e) {
            return response()->json(['status'=>500,'message' => $e->getMessage(),'data'=>(object)[]], 500);
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
