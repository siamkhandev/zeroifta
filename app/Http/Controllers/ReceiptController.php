<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $receipts = Receipt::where('driver_id',$request->driver_id)->get();
        if(count($receipts) >0){
            return response()->json(['status'=>200,'message'=>'receipts found','data'=>$receipts],200);
        }else{
            return response()->json(['status'=>404,'message'=>'receipts not found','data'=>(object)[]],404);
        }
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id'=>'required|exists:users,id',
            'fuel_station_name' => 'required',
            'price_per_gallon' => 'required',
            'gallons_bought' => 'required',
            'location' => 'required',
            'image'=>'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }
        $receipt = new Receipt();
        $receipt->driver_id = $request->driver_id;
        $receipt->fuel_station_name = $request->fuel_station_name;
        $receipt->price_per_gallon = $request->price_per_gallon;
        $receipt->gallons_bought = $request->gallons_bought;
        $receipt->location = $request->location;
        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('receipts'), $imageName);
            $receipt->receipt_image= $imageName;
        }
        $receipt->save();
        return response()->json(['status'=>200,'message'=>'receipts saved','data'=>$receipt],200);
    }
}
