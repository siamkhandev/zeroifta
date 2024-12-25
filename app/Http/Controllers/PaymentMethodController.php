<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function allPaymentMethod(Request $request)
    {
        $paymentMethods = PaymentMethod::where('user_id', $request->user_id)->get();
        return response()->json(['status'=>200,'message' => 'Payment methods fetched successfully', 'data' => $paymentMethods]);
    }
    public function addPaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:255',
            'card_number' => 'nullable|string|max:16',
            'card_holder_name' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date_format:m/y',
            'cvv' => 'nullable|numeric|digits_between:3,4', // Add CVV validation
        ]);

        $paymentMethod = PaymentMethod::create([
            'user_id' => $request->user_id,
            'method_name' => $validated['method_name'],
            'card_number' => $validated['card_number'],
            'card_holder_name' => $validated['card_holder_name'],
            'expiry_date' => $validated['expiry_date'],
            'cvv' => $validated['cvv'], // Include CVV in create statement
        ]);

        return response()->json(['status'=>200,'message' => 'Payment method added successfully', 'data' => $paymentMethod]);
    }
    public function getPaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)->firstOrFail();
        return response()->json(['status'=>200,'message' => 'Payment method fetched successfully', 'data' => $paymentMethod]);
    }
    public function editPaymentMethod(Request $request, $id)
    {
        $validated = $request->validate([
            'method_name' => 'nullable|string|max:255',
            'card_number' => 'nullable|string|max:16',
            'card_holder_name' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date_format:m/y',
            'cvv' => 'nullable|numeric|digits_between:3,4',

        ]);

        $paymentMethod = PaymentMethod::where('id', $id)->firstOrFail();

        $paymentMethod->update($validated);

        return response()->json(['status'=>200,'message' => 'Payment method updated successfully', 'data' => $paymentMethod]);
    }
    public function deletePaymentMethod($id)
    {
        $paymentMethod = PaymentMethod::where('id',$id)->firstOrFail();

        $paymentMethod->delete();

        return response()->json(['status'=>200,'message' => 'Payment method deleted successfully','data' => (object)[]]);
    }
    public function makeDefault(Request $request,$id)
    {
        $paymentMethod = PaymentMethod::where('id', $id)->firstOrFail();

        // Reset all default flags for the user
        PaymentMethod::where('id', $id)->update(['is_default' => false]);

        // Set this method as default
        $paymentMethod->update(['is_default' => true]);

        return response()->json(['status'=>200,'message' => 'Payment method set as default', 'data' => $paymentMethod]);
    }
}
