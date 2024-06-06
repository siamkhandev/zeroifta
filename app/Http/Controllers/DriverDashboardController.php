<?php

namespace App\Http\Controllers;

use App\Models\Contactus;
use App\Models\DriverVehicle;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverDashboardController extends Controller
{
    public function index(Request $request)
    {
        $dashboardData = [];
        $dashboardData['vehicle'] = DriverVehicle::with('vehicle')->where('driver_id',$request->driver_id)->first();
        if ($dashboardData['vehicle'] && $dashboardData['vehicle']->vehicle) {
            $dashboardData['vehicle']->vehicle->vehicle_image = 'http://54.164.54.21/images/' . $dashboardData['vehicle']->vehicle->vehicle_image;
        }
        $dashboardData['recentTrips'] = [];
        return response()->json(['status'=>200,'message'=>'Data Fetched','data'=>$dashboardData],200);
    }
    public function contactus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id'=>'required|exists:users,id',
            'subject' => 'required',
            'message'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }
        $contact = new Contactus();
        $contact->driver_id = $request->driver_id;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        return response()->json(['status'=>200,'message'=>'Request submitted successfully','data'=>$contact],200);
    }
}
