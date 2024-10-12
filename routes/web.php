<?php

use App\Modules\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('verify_login.otp');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('login-check', [AuthController::class, 'loginCheck'])->name('login.check'); // Removed middleware

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/store', [AuthController::class, 'store'])->name('register.store');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/forgot-password/create', [AuthController::class, 'forgotPasswordAction'])->name('forgot-password.create');

// Reset password routes without middleware
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPasswordAction'])->name('reset-password.action');

Route::get('/two-steps/login', [AuthController::class, 'twoStepsLogin'])->name('two-steps.login');
Route::get('/two-steps/reset-password', [AuthController::class, 'twoStepsResetPassword'])->name('two-steps.reset-password');

Route::middleware(['verify_login.otp'])->group(function () {
    Route::post('/verify_login-otp', [AuthController::class, 'verifyLoginOtpAction'])
        ->name('verify-login.otp.action');
});

Route::post('/verify_reset-otp', [AuthController::class, 'verifyResetOtpAction'])->name('verify-reset.otp.action');




Route::get('logs', [LogViewerController::class, 'index']);


