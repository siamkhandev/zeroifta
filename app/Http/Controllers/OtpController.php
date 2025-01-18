<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Cache;
class OtpController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    // Generate and send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|regex:/^\+?[1-9]\d{1,14}$/',
            'email' => 'nullable|email',
        ]);

        $otp = rand(100000, 999999);

        if ($request->phone) {
            $this->twilioService->sendSmsOtp($request->phone, $otp);
            Cache::put('otp_' . $request->phone, $otp, now()->addMinutes(5));
        }

        if ($request->email) {
            $this->twilioService->sendEmailOtp($request->email, $otp);
            Cache::put('otp_' . $request->email, $otp, now()->addMinutes(5));
        }

        return response()->json([
            'status' => 200,
            'message' => 'OTP sent successfully',
            'data' => (object)[]
        ]);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'sms_otp' => 'required|numeric',
            'email_otp' => 'required|numeric',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'User not found.',
                'data' => (object)[]
            ], 400);
        }

        $isSmsOtpCorrect = $user->otp_code === $request->sms_otp;
        $isEmailOtpCorrect = $user->email_otp === $request->email_otp;

        // Track response messages for incorrect OTPs
        $errors = [];

        // Update if SMS OTP is correct
        if ($isSmsOtpCorrect) {
            $user->otp_code = null; // Clear SMS OTP
            $user->is_phone_verified = true;
        } else {
            $errors[] = 'SMS OTP is incorrect.';
        }

        // Update if Email OTP is correct
        if ($isEmailOtpCorrect) {
            $user->email_otp = null; // Clear Email OTP
            $user->is_email_verified = true;
        } else {
            $errors[] = 'Email OTP is incorrect.';
        }

        // Save the user if there are changes
        if ($isSmsOtpCorrect || $isEmailOtpCorrect) {
            $user->save();
        }

        // Return error message if any OTP was incorrect
        if (!empty($errors)) {
            return response()->json([
                'status' => 400,
                'message' => implode(' ', $errors),
                'data' => (object)[]
            ], 400);
        }

        // Return success message if both OTPs are correct
        return response()->json([
            'status' => 200,
            'message' => 'Both OTPs verified successfully.',
            'data' => (object)[]
        ]);
    }


       
    
}
