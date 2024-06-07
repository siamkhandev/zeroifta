<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function showCheckoutForm()
    {
        return view('checkout');
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => 1000, // Amount in cents ($10.00)
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Test Charge',
            ]);

            return back()->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }
}
