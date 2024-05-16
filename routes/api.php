<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\ReceiptController;
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
Route::post('login',[AuthController::class,'login']);
Route::middleware('auth:api')->group( function () {
    Route::post('profile',[AuthController::class,'profile']);
    Route::post('password/change',[AuthController::class,'changePassword']);
    Route::post('profile/update',[AuthController::class,'profileUpdate']);
    ////dashboard/////
    Route::post('dashboard',[DriverDashboardController::class,'index']);

    //////vehcile
    Route::post('vehicle',[VehicleController::class,'index']);
    Route::post('vehicle/update',[VehicleController::class,'update']);
    ////receipts
    Route::post('receipts',[ReceiptController::class,'index']);
    Route::post('receipt/create',[ReceiptController::class,'create']);
    ////contact us
    Route::post('contactus',[DriverDashboardController::class,'contactus']);
});