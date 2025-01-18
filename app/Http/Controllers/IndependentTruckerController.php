<?php

namespace App\Http\Controllers;

use App\Models\CompanyDriver;
use App\Models\DriverVehicle;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\TwilioService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class IndependentTruckerController extends Controller
{
    public function store(Request $request, TwilioService $twilioService)
    {

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:8|confirmed',
            'username' => 'required|string|max:255',
            //'driver_id' => 'required|string|max:255,unique:users,driver_id',
            'license_number' => 'required|string|max:255',
            'license_state' => 'required|string|max:255',
           'license_start_date' => [
                'required',
                'date_format:m-d-Y',
                function ($attribute, $value, $fail) {
                    // Convert the input to a standard date format
                    $date = \DateTime::createFromFormat('m-d-Y', $value);
                    if (!$date || $date->format('m-d-Y') !== $value) {
                        $fail('The ' . $attribute . ' is not a valid date.');
                    }
                    if ($date > now()) {
                        $fail('The ' . $attribute . ' must be a date before or equal to today.');
                    }
                },
            ],
        ]);
        // $company = new User();
        // $company->name=$request->first_name.' '.$request->last_name;;
        // $company->email=$request->email;
        // $company->password=Hash::make($request->password);
        // $company->role="company";
        // $company->register_type = 'trucker';
        // $company->phone=$request->phone;
        // $company->save();
        try{
            $inputDate = $request->input('license_start_date'); // e.g., '12-30-2019'

            $inputDate = trim($inputDate);
    
            // Ensure the input strictly matches the `m-d-Y` format
            $convertedDate = Carbon::createFromFormat('m-d-Y', $inputDate)->format('Y-m-d');
            $driver = new User();
            $driver->first_name = $request->first_name;
            $driver->last_name = $request->last_name;
            $driver->name = $request->first_name.' '.$request->last_name;
            $driver->username = $request->username;
            //$driver->driver_id = $request->driver_id;
            $driver->license_number = $request->license_number;
            $driver->license_state = $request->license_state;
            $driver->license_start_date =$convertedDate;
            $driver->email = $request->email;
            $driver->phone	 = $request->phone;
            $driver->password= Hash::make($request->password);
            $driver->role='trucker';
    
    
            //$driver->save();
            $otp_sms = rand(100000, 999999);
            $otp_email = rand(100000, 999999);
            $twilioService->sendSmsOtp($request->phone, $otp_sms);
            $twilioService->sendEmailOtp($request->email, $otp_email);
            $driver->otp_code = $otp_sms;
            $driver->email_otp = $otp_email;

            $driver->save();
            $companyDriver = new CompanyDriver();
            $companyDriver->driver_id =$driver->id;
            $companyDriver->company_id =$driver->id;
            $companyDriver->save();
            $driverFind = User::whereId($driver->id)->first();
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
            ->whereHas('driverVehicle', function ($query) use ($request,$driver) {
                $query->where('driver_id', $driver->id);
            })
            ->first();
            $driverFind->token = $driverFind->createToken('zeroifta')->accessToken;
            if ($vehicle) {
                $vehicle->vehicle_image = url('vehicles/' . $vehicle->vehicle_image);
            }
            $driverFind->vehicle = $vehicle;
            $checkSubscription = Subscription::where('user_id',$driver->id)->where('status','active')->first();
            $driverFind->subscription = $checkSubscription;
            $rsaKey =  file_get_contents('http://zeroifta.alnairtech.com/my_rsa_key.pub');
            $driverFind->rsa_key = $rsaKey;
    
            $driverFind->token = $driverFind->createToken('zeroifta')->accessToken;;
            $findCard = PaymentMethod::where('user_id',$driver->id)->where('is_default',true)->first();
            $driverFind->defaultCard = $findCard;
            $driverFind->features = [];
            return response()->json([
                'status'=>200,
                'message'=>'Registration successful',
                'data'=>$driverFind
            ]);
        }catch(Exception $e){
            return response()->json([
                'status'=>400,
                'message'=>$e->getMessage(),
                'data'=>(object)[]
            ]);
        }
        
    }
    public function addVehicle(Request $request)

    {

        $data = $request->validate([
            'vehicle_id'=>'required|unique:vehicles,vehicle_id',
            "vin"=>'required|unique:vehicles,vin',
            "year"=>'required',
            "truck_make"=>'required',
            "vehicle_model"=>'required',
            "fuel_type"=>'required',
            "license_state"=>'required',
            "license_number"=>'required|unique:vehicles,license_plate_number',
            'odometer_reading' => 'required',
            'mpg' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024',
            

        ]);

        $vehicle = new Vehicle();
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->vehicle_number = $request->license_number;
        $vehicle->odometer_reading	 = $request->odometer_reading;
        $vehicle->company_id = $request->driver_id;
        $vehicle->mpg= $request->mpg;
        $vehicle->fuel_tank_capacity= $request->fuel_tank_capacity;
        $vehicle->vehicle_id = $request->vehicle_id;
        $vehicle->vin = $request->vin;
        $vehicle->model = $request->vehicle_model;
        $vehicle->make = $request->truck_make;
        $vehicle->make_year = $request->year;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->license = $request->license_state;
        $vehicle->license_plate_number = $request->license_number;
        $vehicle->secondary_tank_capacity= $request->secondary_fuel_tank_capacity;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('vehicles'), $imageName);
            $vehicle->vehicle_image= $imageName;
        }
        $vehicle->save();

        $driver_vehicle = new DriverVehicle();
        $driver_vehicle->driver_id = $request->driver_id;
        $driver_vehicle->vehicle_id = $vehicle->id;
        $driver_vehicle->company_id = $request->driver_id;
        $driver_vehicle->save();
        $vehicle->vehicle_image = url('vehicles/' . $vehicle->vehicle_image);
        return response()->json(['status'=>200,'message'=>'Vehicle add successfully','data'=>$vehicle]);

    }
}
