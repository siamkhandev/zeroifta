<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\DriverVehicle;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            $user->image = 'http://zeroifta.alnairtech.com/drivers/'.$user->driver_image;
            $vehicle = Vehicle::select(
                'id',
                'vehicle_image',
                'vehicle_number',
                'mpg',
                'odometer_reading',
                'fuel_left',
                'fuel_tank_capacity',
                'model',
                'make',
                'make_year',
                'license_plate_number'
            )
            ->whereHas('driverVehicle', function ($query) use ($request) {
                $query->where('driver_id', $request->driver_id);
            })
            ->first();
            if ($vehicle) {
                $vehicle->vehicle_image = url('vehicles/' . $vehicle->vehicle_image);
            }
            $user->vehicle = $vehicle;
            $checkSubscription = Payment::where('company_id',$user->id)->where('status','active')->first();
            $user->subscription = $checkSubscription;
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
           
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }
        $email = $request->email;

        $token = Str::random(60);

        // Store the token in the password_resets table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email], // Where clause
            [
                'email' => $email,
                'token' => bcrypt($token), // Encrypt the token for security
                'created_at' => now(),
            ]
        );
        try {
            // You can customize the mail class ResetPasswordMail to structure the email
            Mail::to($email)->send(new ResetPasswordMail($token));
    
            return response()->json(['status' => 200, 'message' => 'Reset password token sent to the given email', 'data' => (object)[]], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Failed to send email: ' . $e->getMessage(), 'data' => (object)[]], 500);
        }
        
        

       
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
    $tokenData = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if (!$tokenData) {
        return response()->json(['status' =>400, 'message' => 'Invalid email or token.','data'=>(object)[]], 400);
    }

    // Check if the provided token matches the stored one
    if (!Hash::check($request->token, $tokenData->token)) {
        return response()->json(['status' =>400,'message' => 'Invalid token.','data'=>(object)[]], 400);
    }

    // Update the user's password
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['status' =>404,'message' => 'User not found.','data'=>(object)[]], 404);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    // Delete the token record to prevent reuse
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    return response()->json(['status' =>200,'message' => 'Password reset successfully.','data'=>(object)[]], 200);
}
}
