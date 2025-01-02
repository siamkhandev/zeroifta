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
            'encrypted_card_details' => 'required|string', // Encrypted data from app
            'method_name' => 'required|string|max:255',
        ]);
        $user = User::find($request->user_id);

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
        openssl_private_decrypt(base64_decode($validated['encrypted_card_details']), $decryptedData, $privateKey);

        if (!$decryptedData) {
            return response()->json(['status' => 400, 'message' => 'Failed to decrypt card details', 'data' => (object)[]], 400);
        }

        // Parse decrypted data
        $cardDetails = json_decode($decryptedData, true);

        // if (!$cardDetails || !isset($cardDetails['card_number'], $cardDetails['expiry_date'], $cardDetails['cvv'])) {
        //     return response()->json(['status' => 400, 'message' => 'Invalid card details', 'data' => (object)[]], 400);
        // }

        // Validate expiry date format
        // if (!preg_match('/^\d{2}\/\d{4}$/', $cardDetails['expiry_date'])) {
        //     return response()->json(['status' => 400, 'message' => 'Invalid expiry date format', 'data' => (object)[]], 400);
        // }

        // Extract expiry month and year
        //[$expMonth, $expYear] = explode('/', $cardDetails['expiry_date']);

     Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $stripeCustomer = Customer::create([
                'name' => $user->name,
                'email' => $user->email,
            ]);
            // $cardToken = Token::create([
            //     'card' => [
            //        'number' => '4242424242424242', // Replace with a test card number
            //         'exp_month' => 12,
            //         'exp_year' => 2026,
            //         'cvc' => '123',
            //     ],
            // ]);
            $stripe = new \Stripe\StripeClient('sk_test_51FYXgWJOfbRIs4ne6dmGfFbmR1pKgX5V1CQVQHSSlzjCom2KemJylbslX2ylQ2dpbrvmSBGUQSWt6kXETr1ByRR500fTaO7v7k');
            $toekn = $stripe->paymentMethods->create([
                'card' => [
                    'number' => $cardDetails['cardNumber'],
                    'exp_month' => $cardDetails['expiryMonth'],
                    'exp_year' => $cardDetails['expiryYear'],
                    'cvc' => $cardDetails['cvc'],
                ],
            ]);
            $stripeCustomer->sources->create([
                'source' => $toekn->id,
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
                'status' => 200,
                'message' => 'Payment method added successfully',
                'data' => $paymentMethod,
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // Handle Stripe-specific errors
            return response()->json(['status' => 400, 'message' => $e->getMessage(), 'data' => (object)[]], 400);
        } catch (\Exception $e) {
            // Handle other errors
            return response()->json(['status' => 500, 'message' => $e->getMessage(), 'data' => (object)[]], 500);
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
