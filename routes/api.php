<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverContactUsController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\FuelStationController;
use App\Http\Controllers\IFTAController;
use App\Http\Controllers\IndependentTruckerController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/calculate-ifta', [IFTAController::class, 'findCheapestFuelStops']);
//Route::post('/findgas', [IFTAController::class, 'findFuelStations']);
Route::post('/findgas', [IFTAController::class, 'getDecodedPolyline'])->name('findgas');
Route::post('login',[AuthController::class,'login']);
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::middleware('auth:api')->group( function () {
    Route::post('profile',[AuthController::class,'profile']);
    Route::post('password/change',[AuthController::class,'changePassword']);
    Route::post('profile/update',[AuthController::class,'profileUpdate']);
    ////dashboard/////
    Route::post('dashboard',[DriverDashboardController::class,'index']);

    //////vehcile
    Route::post('vehicles/all',[VehicleController::class,'allVehicles']);
    Route::post('trips/all',[VehicleController::class,'allTrips']);
    Route::post('trip/detail',[TripController::class,'tripDetail']);
    Route::post('vehicle',[VehicleController::class,'index']);
    //Route::post('vehicle/add',[VehicleController::class,'addVehicle']);
    Route::post('vehicle/update',[VehicleController::class,'update']);
    Route::delete('vehicle/{id}',[VehicleController::class,'delete']);
    ////receipts
    Route::post('receipts',[ReceiptController::class,'index']);
    Route::post('receipt/create',[ReceiptController::class,'create']);
    ////contact us
    Route::post('contactus',[DriverDashboardController::class,'contactus']);

    Route::post('contactus/all',[DriverContactUsController::class,'getContactUs']);
    Route::post('chat/get',[DriverContactUsController::class,'getChat']);
    Route::post('chat/send',[DriverContactUsController::class,'send']);
});
//Route::post('/trip/start', [TripController::class, 'store']);
Route::post('/trip/start', [IFTAController::class, 'getDecodedPolyline']);
Route::post('/get-active-trip', [TripController::class, 'getActiveTrip']);
Route::post('/trip/update', [IFTAController::class, 'updateTrip']);
Route::post('/trip/delete', [TripController::class, 'deleteTrip']);
Route::post('/trip/complete', [TripController::class, 'completeTrip']);
Route::get('/user-trip/{user_id}', [TripController::class, 'getTrip']);
Route::post('/save-fuel-stations', [FuelStationController::class, 'store']);
Route::get('/get-fuel-stations/{user_id}', [FuelStationController::class, 'getFuelStations']);
Route::post('stops/add',[TripController::class,'storeStop']);
///
Route::post('register',[IndependentTruckerController::class,'store']);
Route::post('vehicle/add',[IndependentTruckerController::class,'addVehicle']);
///
Route::post('/payment-methods', [PaymentMethodController::class, 'allPaymentMethod']);
Route::post('/payment-methods/store', [PaymentMethodController::class, 'addPaymentMethod']);
Route::get('/payment-methods/{id}', [PaymentMethodController::class, 'getPaymentMethod']);
Route::put('/payment-methods/{id}', [PaymentMethodController::class, 'editPaymentMethod']);
Route::delete('/payment-methods/{id}', [PaymentMethodController::class, 'deletePaymentMethod']);
Route::post('/payment-methods/{id}/default', [PaymentMethodController::class, 'makeDefault']);
