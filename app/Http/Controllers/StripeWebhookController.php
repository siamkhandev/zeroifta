<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Webhook received', ['request' => $request->all()]);
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the webhook secret from the environment
        $endpointSecret = 'we_1QcnA5JOfbRIs4neqlFiBPnl';

        // Verify the webhook signature
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (SignatureVerificationException $e) {
            Log::error('Webhook signature verification failed.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event based on its type
        switch ($event->type) {
            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;
            case 'customer.subscription.created':
                $this->handleSubscriptionSucceeded($event->data->object);
                break;
            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'customer.subscription.updated':
                $this->handleSubscriptionUpdated($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;

            default:
                Log::info('Unhandled event type: ' . $event->type);
        }

        return response()->json(['status' => 'success'], 200);
    }

    protected function handlePaymentSucceeded($invoice)
    {
        Log::info('Payment succeeded', ['invoice' => $invoice]);
        // Update subscription status in your database
    }
    protected function handleSubscriptionSucceeded($invoice)
    {
        Log::info('Subscription Created succeeded', ['invoice' => $invoice]);
        // Update subscription status in your database
    }


    protected function handlePaymentFailed($invoice)
    {
        Log::info('Payment failed', ['invoice' => $invoice]);
        // Notify the customer and/or retry payment
    }

    protected function handleSubscriptionUpdated($subscription)
    {
        Log::info('Subscription updated', ['subscription' => $subscription]);
        // Update subscription details in your database
    }

    protected function handleSubscriptionDeleted($subscription)
    {
        Log::info('Subscription deleted', ['subscription' => $subscription]);
        // Mark the subscription as canceled in your database
    }
}
