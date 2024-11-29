<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $receipts = Receipt::where('driver_id',$request->driver_id)
        //->where('trip_id',$request->trip_id)
        ->get();

        if(count($receipts) >0){
            foreach ($receipts as $receipt) {
                if (isset($receipt->receipt_image)) {
                    $receipt->receipt_image = 'http://zeroifta.alnairtech.com/receipts/' . $receipt->receipt_image;
                }
            }
            return response()->json(['status'=>200,'message'=>'receipts found','data'=>$receipts],200);
        }else{
            return response()->json(['status'=>404,'message'=>'receipts not found','data'=>[]],404);
        }
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trip_id'=>'required|exists:trips,id',
            'driver_id'=>'required|exists:users,id',
            'fuel_station_name' => 'required',
            'price_per_gallon' => 'required',
            'gallons_bought' => 'required',
            'location' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>422,'message' => $validator->errors()->first(),'data'=>(object)[]], 422);
        }
        $receipt = new Receipt();
        $receipt->trip_id = (int)$request->trip_id;
        $receipt->driver_id = (int)$request->driver_id;
        $receipt->fuel_station_name = $request->fuel_station_name;
        $receipt->price_per_gallon = $request->price_per_gallon;
        $receipt->gallons_bought = $request->gallons_bought;
        $receipt->location = $request->location;
        if($request->hasFile('image')){
            // Generate a unique name for the image
    $imageName = time() . '.' . $request->image->extension();

    // Define the path to save the compressed image
    $destinationPath = public_path('receipts');
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    // Load the image using Intervention Image
    $compressedImage = Image::make($request->image->getRealPath())
        ->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio(); // Maintain aspect ratio
            $constraint->upsize(); // Prevent upsizing
        })
        ->encode('jpg', 75); // Compress with 75% quality

    // Save the compressed image
    $compressedImage->save($destinationPath . '/' . $imageName);

    // Save the file name in the database
    $receipt->receipt_image = $imageName;
        }
        $receipt->save();

        return response()->json(['status'=>200,'message'=>'receipts saved','data'=>$receipt],200);
    }
}
