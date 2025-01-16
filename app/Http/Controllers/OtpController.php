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
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email|numeric',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'User not found.',
                'data' => (object)[]
            ], 400);
        }

        if ($user->otp_code == $request->otp) {
            $user->otp_code = null;

            if ($request->email) {
                $user->is_email_verified = true;
            }

            if ($request->phone) {
                $user->is_phone_verified = true;
            }

            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'OTP verified successfully.',
                'data' => (object)[]
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Invalid OTP.',
            'data' => (object)[]
        ], 400);
    }
}
