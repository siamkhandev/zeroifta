<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Company\CompanyController;
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

Route::get('/', function () {
    return view('admin.index');
})->middleware('auth');
Route::get('login', function () {
    return view('login');
});
Route::get('company/register',[CompanyController::class,'create'])->name('company.register');
Route::post('company/register',[CompanyController::class,'store'])->name('register');
Route::post('login',[AdminController::class,'login'])->name('login');
Route::get('logout',[AdminController::class,'logout'])->name('logout');

Route::get('companies',[CompaniesController::class,'index'])->name('companies');
Route::get('companies/delete/{id}',[CompaniesController::class,'delete'])->name('companies.delete');
