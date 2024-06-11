<?php

namespace App\Http\Controllers;

use App\Models\CompanyContactUs;
use App\Models\Message;
use Illuminate\Http\Request;

class DriverContactUsController extends Controller
{
   public function getContactUs(Request $request)
   {
    $forms = CompanyContactUs::with('company')->where('company_id',$request->company_id)->orderBy('company_contact_us.id','desc')->get();
    return response()->json(['status'=>200,'message'=>'forms fetched','data'=>$forms]);
   }
   public function getChat(Request $request)
   {
        $messages = Message::where('contact_id', $request->contact_id)->orderBy('created_at', 'asc')->get();
        return response()->json(['status'=>200,'message'=>'messages fetched','data'=>$messages]);
   }
   public function send(Request $request)
    {
      
        $request->validate([
            'contact_id' => 'required|exists:company_contact_us,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'contact_id' => $request->contact_id,
            'message' => $request->message,
            'sender' => $request->sender,
        ]);

        return response()->json(['status'=>200,'message'=>'messages sent','data'=>$message]);
    }
}
