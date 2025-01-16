<?php


namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    // Send OTP via SMS
    public function sendSmsOtp($phoneNumber, $otp)
    {
        return $this->twilio->messages->create($phoneNumber, [
            'from' => env('TWILIO_PHONE_NUMBER'),
            'body' => "Your OTP code is: $otp"
        ]);
    }

    // Send OTP via Email
    public function sendEmailOtp($email, $otp)
    {
        Mail::raw("Your OTP code is: $otp", function ($message) use ($email) {
            $message->to($email)
                ->subject('Your OTP Code')
                ->from(env('TWILIO_EMAIL_FROM'));
        });
    }
}
