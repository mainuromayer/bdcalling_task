<?php

use App\Modules\Dashboard\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'Module' => 'Dashboard',
        'middleware' => ['web', 'auth']
    ],
    function () {
        Route::prefix('dashboard')->group(function () {
            Route::match(['get', 'post'], '/', [DashboardController::class, 'index'])->name('dashboard.view');
        });
    }
);

