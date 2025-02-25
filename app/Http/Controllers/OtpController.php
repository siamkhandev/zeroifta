<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\TwilioService;
use Exception;
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
    public function resendOtp(Request $request)
    {
        if($request->phone && !isset($request->email))
        {
            $user = User::find($request->user_id);
            if(!$user){
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                    'data' => (object)[]
                ],404);
            }
            try{
                if(str_contains($request->phone,'+1')){
                    $smsOTP = rand(100000, 999999);
                    $this->twilioService->sendSmsOtp($request->phone, $smsOTP);

                }else{
                    $smsOTP =123456;
                }


                $user->otp_code = $smsOTP;
                $user->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'OTP sent on phone',
                    'data' => (object)[]
                ]);
            }catch(Exception $e){
                return response()->json([
                    'status' => 500,
                    'message' => $e->getMessage(),
                    'data' => (object)[]
                ]);
            }

        }else if($request->email && !isset($request->phone)){
            $user = User::find($request->user_id);
            if(!$user){
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                    'data' => (object)[]
                ],404);
            }
            $emailOTP = rand(100000, 999999);
            try{
                $this->twilioService->sendEmailOtp($request->email, $emailOTP);
                $user->email_otp= $emailOTP;
                $user->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'OTP sent on email',
                    'data' => (object)[]
                ]);
            }catch(Exception $e){
                return response()->json([
                    'status' => 500,
                    'message' => $e->getMessage(),
                    'data' => (object)[]
                ]);
            }

        }else{
            $user = User::find($request->user_id);
            if(!$user){
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                    'data' => (object)[]
                ],404);
            }
            try{
                if(str_contains($request->phone,'+1')){
                    $smsOTP = rand(100000, 999999);
                    $this->twilioService->sendSmsOtp($request->phone, $smsOTP);

                }else{
                    $smsOTP =123456;
                }
                $emailOTP = rand(100000, 999999);
                $this->twilioService->sendEmailOtp($request->email, $emailOTP);

                $user->otp_code = $smsOTP;
                $user->email_otp= $emailOTP;
                $user->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'OTP sent on phone and email',
                    'data' => (object)[]
                ]);
            }catch(Exception $e){
                return response()->json([
                    'status' => 500,
                    'message' => $e->getMessage(),
                    'data' => (object)[]
                ]);
            }
        }
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
        if($user->otp_code !== $request->sms_otp)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid SMS OTP',
                'data' => (object)[]
            ], 400);
        }
        if($user->email_otp !== $request->email_otp)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid Email OTP',
                'data' => (object)[]
            ], 400);
        }
        if ($user->otp_code == $request->sms_otp) {
            $user->otp_code = null;
            $user->is_phone_verified = true;

        }
        if($user->email_otp == $request->email_otp){
            $user->email_otp = null;
            $user->is_email_verified = true;
        }


        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'OTP verified successfully.',
            'data' => (object)[]
        ]);
    }



}
