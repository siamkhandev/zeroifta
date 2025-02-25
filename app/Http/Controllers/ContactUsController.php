<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{
    public function store(Request $request)
    {
      
        $request->validate([
            'contact_id' => 'required|exists:company_contact_us,id',
            'message' => 'required|string',
        ]);

        Message::create([
            'contact_id' => $request->contact_id,
            'message' => $request->message,
            'sender' => $request->sender,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['success' => 'Message sent']);
    }

    public function fetchMessages($contact_id)
    {
        $messages = Message::where('contact_id', $contact_id)->orderBy('created_at', 'asc')->get();
        return response()->json($messages);
    }
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = true;
        $message->save();

        return response()->json(['success' => 'Message marked as read']);
    }
}
