<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\Stripe;
use Stripe\PaymentMethod as StripePaymentMethod;
use Stripe\Token;
use Stripe\Customer as StripeCustomer;

class PaymentMethodController extends Controller
{
    public function allPaymentMethod(Request $request)
    {
        try {
            // Set Stripe secret key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Get the authenticated user
            $user = User::find($request->user_id);

            if (!$user->stripe_customer_id) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Stripe customer found for the user',
                    'data' => (object)[],
                ], 404);
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

            return response()->json([
                'status' => 200,
                'message' => 'Payment methods retrieved successfully',
                'data' => $filteredMethods,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to retrieve payment methods',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function addPaymentMethod(Request $request)
    {
        
        $validated = $request->validate([
            'token' => 'required|string', // Stripe payment method token
            'method_name' => 'required|string', // Name for the payment method
        ]);
        $privateKey = '-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEApJsv/AC05XsMNA0kt4P2C+pKV6FVqk6INlPKBEdyq9AO1/ku
zkVq+EcbCM2m2vmOn68iFTmsrebkP5aUV9gd2Pvj9nzegvN3sN0qaBQxkCyP52Kl
875tB5eT8KRnUZ/2ZVjHdSqoFr6O53F8bcDVzHoB5SPA9fv53d9y3OMm4uCLv1Xe
ClayEmevPD6T1julsvo4kmV7hlABIGZ4JiEKCKb/E1jVCbVgR44Y6yxm0PhcTHWr
/Pcos+PS2OaOnfjLJN2kjcxnd+jMRwtJJ8MbYORpta0ZWgqaU2UiBkmXGv/tnDDB
Wcp+RQGa6wA3JP098rj7XOTsiLcSKO2xNHS/VwIDAQABAoIBAGjr+oQZNzVnX3n2
PsczOCyUJNsCnYY3FJ/8fLKJkFBwCGYmEW2t1ed3+4V7ALZniD/E9GavIqCeojLe
GqR7v1rGBKLjKTozUsHL1/ILnSQXI4sL2Fgrs3e5aLVlNe5Tlk03b7wBeq80vAZO
0k9rMVxrELYsOh0Rhk2k1qRxriHCk4s27FtzE6XVwthpFZFnJgIOwM01DGkzo1Fi
FCNyEuRLsz0mRAgUIjhswW6WexCKDMMZEiOuLa6UfQCaGs54Es3N4qbwUuZLQqlz
Bszv6HwLsOVMj1LYkLLesHkqqTERYv58Q5ZtuS8JCVwbXYF53vQaZBHDz/3Nknbj
IiRdYaECgYEA6omtEiXIP++LZLup/C1AWymuerywTcrOHtkSprZm7/QuwRh9XHoh
2FXlmTQMwOPs3MkmQ/l47T4Ab9/jBytS915rMpvF2a4ei8B+5rZ6qcBaOJDGvLS4
jBzNP5cMM7SmQx63QNd/uRrEKdmUJTy7MWSVJiFFl2L8KK1C7yvcFikCgYEAs6tI
C/3bbxpuhK62zNy8cZ1a33qbS5/VAPmG/dtM4f4GSOIHYOQ+IFyKX5uFzr7xELUx
4p9RwfIU4XCqn+VZq5ZMsUgVkahRF2aicc/ygV1ZWCZ41atdFs74DW5TbFL7R2Ks
oqavhTf0Hw2kiaW74zbnGe3hbtn5z3W5oYU12X8CgYBLo7s9bxH2DLtX8W4Q9kcb
H4Y170Ss0gtHx5pMSedI2+d4Pv2vJXRk4M77ad3zF478ZaMBqSNm3+gkLIB7f21y
efD4kWRtn8oaKCrFHXTR6kculwKBOYeLKH7JU12MD2bPnshbESUP/aHmHVW57Kwy
cc3oTjKzcCkCtV4w5GRGgQKBgDoNxiHZzOWBbOSCb56SVHGBnrNHMpak9nZyKiQs
kBMVuYIjRq8QEOL0A+IQppO/LrVvVscbI5e/WO/fL8KqoObIkc9Ws2F1OX6OMz8D
KiCSwSOyiqi/zjxoc84jL+F4jqjqQU3s/hnVkpPWHKw9WRB51QKT0pu24vkd2PVP
za6RAoGBAMcX2CEqe4NZCDRsN41BsnV95UU/2iQbItBmI6/mqoqGymZDPUXmR41l
cf8B1OsNs6eYrx/8ebrnfrjjwpw2G64jaj62q1O7Qhh3GsjTOuuATvQum06k7EYG
CpNLB7aULQtFKuJCSUZtdRs33b9s3e3lYJRUFOzOqswk9gCl5uu0
-----END RSA PRIVATE KEY-----';

        $decryptedData = '';
        openssl_private_decrypt(base64_decode($validated['token']), $decryptedData, $privateKey);

        if (!$decryptedData) {
            return response()->json(['status' => 400, 'message' => 'Failed to decrypt token', 'data' => (object)[]], 400);
        }
       
        // Parse decrypted data
        $token = json_decode($decryptedData, true);
        dd($token);
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
                    'token' =>  $token, // Use the `tok_` received from the Android app
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
    public function deletePaymentMethod(Request $request)
    {
        $paymentMethod = PaymentMethod::where('stripe_payment_method_id', $request->id)->first();

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
    public function makeDefault(Request $request)
    {
        try {
            // Retrieve the payment method and ensure it belongs to the authenticated user
            $paymentMethod = PaymentMethod::where('stripe_payment_method_id', $request->id)
                ->firstOrFail();

            // Initialize Stripe
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $user = User::find($request->user_id);
            // Retrieve the Stripe customer ID from your database (assumes you store it)
            $stripeCustomerId = $user->stripe_customer_id;

            if (!$stripeCustomerId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Stripe customer not found for the user.',
                    'data' => (object) [],
                ], 400);
            }

            // Update the default payment method on Stripe
            $stripeCustomer = StripeCustomer::update($stripeCustomerId, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod->stripe_payment_method_id,
                ],
            ]);

            // Reset the `is_default` flag for all payment methods of the user
            PaymentMethod::where('user_id', $user->id)
                ->update(['is_default' => false]);

            // Set the selected payment method as default
            $paymentMethod->update(['is_default' => true]);

            return response()->json([
                'status' => 200,
                'message' => 'Payment method set as default',
                'data' => $paymentMethod,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to set default payment method: ' . $e->getMessage(),
                'data' => (object) [],
            ], 500);
        }
    }
}
