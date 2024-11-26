<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->token = $user->createToken('zeroifta')->accessToken;
            $user->image = 'http://zeroifta.alnairtech.com/images/'.$user->image;
            return response()->json(['status'=>200,'message'=>'Logged in successfully','data' => $user], 200);
        } else {
            return response()->json(['status'=>401,'message'=>'Invalid Credentials','data' => (object)[]], 401);
        }
    }
    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }
        $user = User::whereId($request->user_id)->first();
        $user->image = 'http://zeroifta.alnairtech.com/images/'.$user->image;
        return response()->json(['status'=>200,'message'=>'Profile Fetched successfully','data' => $user], 200);
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }

        $user = User::whereId($request->user_id)->first();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['status'=>422,'message' => 'Current password is incorrect','data'=>(object)[]],422);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['status'=>200,'message' => 'Password changed successfully.','data'=>(object)[]], 200);
    }
    public function profileUpdate(Request $request)
    {
    
        $user = User::find($request->user_id);
        if($user){
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->mc = $request->mc;
            $user->dot = $request->dot;
            if($request->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $user->image= $imageName;
            }
            $user->update();
            $user->image = 'http://zeroifta.alnairtech.com/images/'.$user->image;
            return response()->json(['status'=>200,'message' => 'Profile Updated successfully.','data'=>$user], 200);
        }else{
            return response()->json(['status'=>404,'message' => 'User not found','data'=>(object)[]], 404);
        }
        

    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['status'=>200,'message' => __($status),'data'=>(object)[]],200);
        }else{
            return response()->json(['status'=>404,'message' => 'Email Not Found','data'=>(object)[]],404);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
    public function resetPassword(Request $request)
    {
   
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'token' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
    }
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return response()->json([
            'status' => 200,
            'message' => 'Password has been reset successfully.',
            'data' => (object)[]
        ], 200);
    }

    return response()->json([
        'status' => 400,
        'message' => 'Failed to reset password. Invalid token or email.',
        'data' => (object)[]
    ], 400);
}
}
