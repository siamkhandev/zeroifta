<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyContactUs;
use App\Models\CompanyDriver;
use App\Models\Message;
use App\Models\Plan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Stripe\Customer;
use Stripe\PaymentMethod as StripePaymentMethod;
use Stripe\Stripe;
use Stripe\Subscription;
use App\Models\Subscription as ModelsSubscription;

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

        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();
        $paymentMethod = $request->payment_method;
        $plan = Plan::find($request->plan_id);

        try {
            // Check for existing Stripe Customer or create one
            $customer = $user->stripe_customer_id
                ? Customer::retrieve($user->stripe_customer_id)
                : Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);

            if (!$user->stripe_customer_id) {
                $user->update(['stripe_customer_id' => $customer->id]);
            }

            // Attach payment method and set as default
            $paymentMethodObj = \Stripe\PaymentMethod::retrieve($paymentMethod);
            $paymentMethodObj->attach(['customer' => $customer->id]);

            Customer::update($customer->id, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod,
                ],
            ]);

            // Check for existing subscription
            $subscriptions = Subscription::all(['customer' => $customer->id, 'status' => 'active']);

            if ($subscriptions->data) {
                // Update existing subscription
                $subscription = $subscriptions->data[0];
                $updatedSubscription = Subscription::update($subscription->id, [
                    'items' => [
                        [
                            'id' => $subscription->items->data[0]->id,
                            'price' => $plan->stripe_plan_id,
                        ],
                    ],
                    'proration_behavior' => 'create_prorations',
                ]);

                ModelsSubscription::where('stripe_subscription_id', $subscription->id)->update([
                    'plan' => $plan->billing_period,
                    'amount' => $plan->price,
                    'status' => 'active',
                    'plan_id' => $plan->id,
                ]);

                return redirect('/subscribe')->with('success', 'Subscription updated successfully.');
            } else {
                // Create a new subscription
                $newSubscription = Subscription::create([
                    'customer' => $customer->id,
                    'items' => [[
                        'price' => $plan->stripe_plan_id,
                    ]],
                    'default_payment_method' => $paymentMethod,
                    'proration_behavior' => 'create_prorations',
                ]);

                // Store Payment Info in Database
                ModelsSubscription::create([
                    'company_id' => $user->id,
                    'stripe_payment_id' => $customer->id,
                    'stripe_subscription_id' => $newSubscription->id,
                    'plan' => $plan->billing_period,
                    'amount' => $plan->price,
                    'status' => 'active',
                    'plan_id' => $plan->id,
                ]);

                $user->update(['is_subscribed' => 1]);

                return redirect('/subscribe')->with('success', 'Subscription purchased successfully.');
            }
        } catch (Exception $e) {
            return redirect('/subscribe')->with('error', 'Error managing subscription: ' . $e->getMessage());
        }
    }
}
