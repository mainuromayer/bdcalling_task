<?php

use App\Http\Controllers\Auth\AuthApiController;
use App\Http\Controllers\Auth\AuthController;

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


//Route::group(['middleware'=>'api','prefix'=>'auth'],function($router){
//    Route::post('/register',[AuthController::class, 'register']);
//    Route::post('/login',[AuthController::class, 'login']);
//});


Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');
Route::middleware('auth:api')->get('/user-details', [AuthApiController::class, 'getUserDetails'])->name('api.user.details');

Route::post('/register', [AuthApiController::class, 'register'])->name('api.register');
Route::post('/register/store', [AuthApiController::class, 'store'])->name('api.register.store');

Route::post('/forgot-password', [AuthApiController::class, 'forgotPassword'])->name('api.forgot-password');
Route::post('/reset-password', [AuthApiController::class, 'resetPasswordAction'])->name('api.reset-password.action');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');
    Route::post('/verify-login-otp', [AuthApiController::class, 'verifyLoginOtpAction'])->name('api.verify-login.otp');
});

Route::post('/verify-reset-otp', [AuthApiController::class, 'verifyResetOtpAction'])->name('api.verify-reset.otp');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');
    Route::post('/verify-login-otp', [AuthApiController::class, 'verifyLoginOtpAction'])->name('api.verify-login.otp');
});
