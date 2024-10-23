<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\FuelTaxController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\DriversController;
use App\Http\Controllers\Company\DriverVehiclesController;
use App\Http\Controllers\Company\VehiclesController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PaymentController;
use App\Models\CompanyContactUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',[AdminController::class,'index'])->name('dashboard')->middleware('auth');

Route::get('/testsocket',[AdminController::class,'socket']);
Route::get('login', function () {
    return view('login');
});
Route::get('company/register',[CompanyController::class,'create'])->name('company.register');
Route::post('company/register',[CompanyController::class,'store'])->name('register');
Route::post('login',[AdminController::class,'login'])->name('login');
Route::get('/read-dat-file', [UsersController::class, 'readDatFile'])->name('read.dat.file');
Route::middleware('auth')->group(function () {
    Route::get('profile',[UsersController::class,'profile'])->name('profile');
    Route::post('profile/update',[UsersController::class,'profileUpdate'])->name('profile.update');
    Route::post('password/update',[UsersController::class,'passwordUpdate'])->name('passwords.update');
    

    Route::get('logout',[AdminController::class,'logout'])->name('logout');

    Route::get('companies',[CompaniesController::class,'index'])->name('companies');
    Route::get('companies/edit/{id}',[CompaniesController::class,'edit'])->name('companies.edit');
    Route::post('companies/update/{id}',[CompaniesController::class,'update'])->name('companies.update');
    Route::get('companies/delete/{id}',[CompaniesController::class,'delete'])->name('companies.delete');

    Route::get('plans',[PlansController::class,'index'])->name('plans');
    Route::get('plans/create',[PlansController::class,'create'])->name('plans.create');
    Route::post('plans/store',[PlansController::class,'store'])->name('plans.store');
    Route::get('plans/edit/{id}',[PlansController::class,'edit'])->name('plans.edit');
    Route::post('plans/update/{id}',[PlansController::class,'update'])->name('plans.update');
    Route::get('plans/delete/{id}',[PlansController::class,'delete'])->name('plans.delete');

    Route::get('fuel_taxes',[FuelTaxController::class,'index'])->name('fuel_taxes');
    Route::get('fuel_taxes/create',[FuelTaxController::class,'create'])->name('fuel_taxes.create');
    Route::post('fuel_taxes/store',[FuelTaxController::class,'store'])->name('fuel_taxes.store');
    Route::get('fuel_taxes/edit/{id}',[FuelTaxController::class,'edit'])->name('fuel_taxes.edit');
    Route::post('fuel_taxes/update/{id}',[FuelTaxController::class,'update'])->name('fuel_taxes.update');
    Route::get('fuel_taxes/delete/{id}',[FuelTaxController::class,'delete'])->name('fuel_taxes.delete');

    Route::get('vehicles/all',[VehiclesController::class,'index'])->name('allvehicles');
    Route::get('vehicle/create',[VehiclesController::class,'create'])->name('vehicles.create');
    Route::post('vehicle/store',[VehiclesController::class,'store'])->name('vehicle.store');
    Route::get('vehicle/edit/{id}',[VehiclesController::class,'edit'])->name('vehicle.edit');
    Route::post('vehicle/update/{id}',[VehiclesController::class,'update'])->name('vehicle.update');
    Route::get('vehicle/delete/{id}',[VehiclesController::class,'delete'])->name('vehicle.delete');
    Route::get('/vehicles/import', [VehiclesController::class, 'importForm'])->name('vehicles.importform');
    Route::post('/vehicles/import', [VehiclesController::class, 'import'])->name('vehicle.import');

    Route::get('/driver/vehicles', [DriverVehiclesController::class,'index'])->name('driver_vehicles');
    Route::get('driver/vehicles/add', [DriverVehiclesController::class,'create'])->name('driver_vehicles.add');
    Route::post('driver/vehicles/store', [DriverVehiclesController::class,'store'])->name('driver_vehicles.store');
    Route::get('driver/vehicles/edit/{id}', [DriverVehiclesController::class,'edit'])->name('driver_vehicles.edit');
    Route::post('driver/vehicles/update/{id}', [DriverVehiclesController::class,'update'])->name('driver_vehicles.update');
    Route::get('driver/vehicles/delete/{id}', [DriverVehiclesController::class,'destroy'])->name('driver_vehicles.delete');

    Route::get('drivers/all',[DriversController::class,'index'])->name('drivers.all');
    Route::get('drivers/create',[DriversController::class,'create'])->name('drivers.create');
    Route::post('drivers/store',[DriversController::class,'store'])->name('driver.store');
    Route::get('drivers/edit/{id}',[DriversController::class,'edit'])->name('driver.edit');
    Route::post('drivers/update/{id}',[DriversController::class,'update'])->name('driver.update');
    Route::get('drivers/delete/{id}',[DriversController::class,'delete'])->name('driver.delete');
    Route::get('drivers/track/{id}',[DriversController::class,'track'])->name('driver.track');
    Route::get('/drivers/import', [DriversController::class, 'importForm'])->name('drivers.importform');
    Route::post('/drivers/import', [DriversController::class, 'import'])->name('drivers.import');

    Route::get('contactus',[CompanyController::class,'contactus'])->name('contactus');
    Route::post('contactus',[CompanyController::class,'submitContactUs'])->name('company.contactus.submit');
    ////
    Route::get('contactus/all',[AdminController::class,'contactUsForms'])->name('admin.contactus');
    Route::get('contactform/read/{id}',[AdminController::class,'readForm'])->name('contactform.detail');
    Route::get('contactform/delete/{id}',[AdminController::class,'deleteForm'])->name('contactform.delete');

    Route::get('/checkout', [PaymentController::class, 'showCheckoutForm'])->name('checkout.form');
    Route::post('/checkout', [PaymentController::class, 'processPayment'])->name('checkout.process');

    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
    Route::get('purchase/{id}', [PaymentController::class, 'purchase'])->name('purchase');
    Route::get('subscribe', [CompanyController::class, 'showPlans'])->name('subscribe');
    Route::post('pay', [PaymentController::class, 'subscribe'])->name('pay');
    Route::get('payments', [PaymentController::class, 'allPayments'])->name('payments');
    Route::get('/cancel-subscription/{id}', [PaymentController::class, 'cancel'])->name('cancel.subscription');
    Route::post('/messages', [ContactUsController::class, 'store'])->name('messages.store');
    Route::get('/messages/{contact_id}', [ContactUsController::class, 'fetchMessages'])->name('messages.fetch');
    //Route::post('/messages/read/{id}', [ContactUsController::class, 'markAsRead'])->name('messages.markAsRead');
    ////////
    Route::get('company/contactus/all',[CompanyController::class,'contactUsForms'])->name('company.contactus');
    Route::get('company/contactform/read/{id}',[CompanyController::class,'readForm'])->name('company.contactform.detail');

    /////////
    Route::get('fleet',[CompanyController::class,'fleet'])->name('fleet');

});