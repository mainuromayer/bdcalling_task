<?php
use App\Modules\User\Http\Controllers\UserController;
use App\Modules\User\Http\Controllers\UserProfileController;
use App\Modules\User\Http\Controllers\AuthPasswordController;
use Illuminate\Support\Facades\Route;

Route::group(['Module' => 'User', 'middleware' => 'auth'], function () {
    Route::prefix('user')->group(function () {
        Route::match(['get', 'post'], '/', [UserController::class, 'list'])->name('user.list');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('user.delete'); // Add delete route
    });
});


