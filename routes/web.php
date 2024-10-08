<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get( '/login', [AuthController::class, 'login'] )->name( 'login' );
Route::post( 'login-check', array( AuthController::class, 'loginCheck' ) )->name( 'login.check' );

Route::get( '/register', [AuthController::class, 'register'] )->name( 'register' );
Route::post( '/register/store', [AuthController::class, 'store'] )->name( 'register.store' );


Route::get( '/logout', [AuthController::class, 'logout'] )->name( 'logout' )->middleware('auth');


//Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
//Route::post('/forgot-password/create', [AuthController::class, 'forgotPasswordAction'])->name('forgot-password.create');
//
//Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password');
//Route::post('/reset-password', [AuthController::class, 'resetPasswordAction'])->name('forgot-password.update');

//Route::get( '/verify-email', [AuthController::class, 'verifyEmail'] )->name( 'verify-email' );
//Route::get( '/two-steps', [AuthController::class, 'twoSteps'] )->name( 'two-steps' );
