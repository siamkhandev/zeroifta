<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyContactUs;
use App\Models\CompanyDriver;
use App\Models\Message;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Stripe\Customer;
use Stripe\PaymentMethod as StripePaymentMethod;
use Stripe\Stripe;
use Stripe\Subscription;

class AdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->role=='admin')
        {
            $data = User::where('role','company')->take(10)->latest()->get();
        }else{
            if(Auth::user()->is_subscribed==0){
                return redirect('subscription');
            }
            $data = CompanyDriver::with('driver','company')->where('company_id',Auth::id())->take(10)->latest()->get();
        }
        return view('admin.index',get_defined_vars());
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',

        ]);
        $remember = $request->has('remember');
        if ($request->has('remember_me')) {
            $request->session()->put('remember_email', $request->email);
            $request->session()->put('remember_password', $request->password);
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password],$remember)){
            if(Auth::user()->role=='driver'){
                Auth::logout();
                return redirect()->back();
            }
            return redirect('/');
        }else{
            return redirect()->back()->withInput()->withErrors(['email' => 'Invalid Credentials']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

            return redirect('login');
    }
    public function contactUsForms()
    {
        $forms = CompanyContactUs::with('company')->orderBy('company_contact_us.id','desc')->get();

        return view('admin.contactus.index',get_defined_vars());
    }
    public function readForm($id)
    {
        $form = CompanyContactUs::with('company')->find($id);

        return view('admin.contactus.read',get_defined_vars());
    }
    public function deleteForm($id)
    {

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $form = CompanyContactUs::find($id);
        $form->forceDelete();

        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect('contactus/all')->withError('Record Deleted Successfully');
    }
    public function socket()
    {
        return view('socket');
    }
    public function testftp()
    {
        $matchingFiles = [];
        $files = Storage::disk('ftp')->files('/'); // List all files in the root directory

        foreach ($files as $file) {
            if (str_contains($file, 'Cpricing')) { // Check if the file name contains 'Cpricing'
                $matchingFiles[] = $file;

                $content = Storage::disk('ftp')->get($file); // Read the file content

                dd($content);
            }
        }

        if (empty($matchingFiles)) {
            echo "No files found with 'Cpricing' in the name.";
        }
    }
    public function subscription()
    {
        return view('subscription');
    }
    public function buy($plan)
    {

        $plan = Plan::where('slug',$plan)->first();

        return view('buy',get_defined_vars());
    }
    public function pay(Request $request)
    {

        $plan = Plan::find($request->plan_id);
        $paymentMethod = $request->payment_method;
        $user = Auth::user();
        try {
            Stripe::setApiKey('sk_test_51FYXgWJOfbRIs4ne6dmGfFbmR1pKgX5V1CQVQHSSlzjCom2KemJylbslX2ylQ2dpbrvmSBGUQSWt6kXETr1ByRR500fTaO7v7k');
            $customer = Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                'payment_method' => $paymentMethod,
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod,
                ],
            ]);
            dd($customer);
            $subscription = Subscription::create([
                'customer' => $customer->id,
                'items' => [[
                    'plan' => $plan->stripe_plan_id, // The Stripe plan ID
                ]],
            ]);
            $request->user()->subscriptions()->create([
                'stripe_customer_id' => $customer->id,
                'stripe_subscription_id' => $subscription->id,
                'plan_id' => $plan->id,
                'status' => 'active',
            ]);
            User::whereId(Auth::id())->update(['is_subscribed'=>1]);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
