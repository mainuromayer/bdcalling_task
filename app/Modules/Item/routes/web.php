<?php

use App\Modules\Item\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::group(['Module' => 'Item', 'middleware' => 'auth'], function () {
    Route::prefix('item')->group(function () {
        Route::match(['get', 'post'], '/', [ItemController::class, 'list'])->name('item.list');
        Route::get('create', [ItemController::class, 'create'])->name('item.create');
        Route::post('store', [ItemController::class, 'store'])->name('item.store');
        Route::get('edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
        Route::delete('delete/{id}', [ItemController::class, 'destroy'])->name('item.destroy'); // Delete Route
    });
});

