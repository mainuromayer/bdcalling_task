<?php
use App\Modules\User\Http\Controllers\UserController;
use App\Modules\User\Http\Controllers\UserProfileController;
use App\Modules\User\Http\Controllers\AuthPasswordController;
use Illuminate\Support\Facades\Route;

Route::group( [ 'Module' => 'User'], function () {
    Route::prefix( 'user' )->group( function () {
        Route::match( array( 'get', 'post' ), '/', array( UserController::class, 'list' ) )->name( 'user.list' );
        Route::get( 'create', array( UserController::class, 'create' ) )->name( 'user.create' );
        Route::post( 'store', array( UserController::class, 'store' ) )->name( 'user.store' );
        Route::get( 'edit/{id}', array( UserController::class, 'edit' ) )->name( 'user.edit' );
    } );
} );

