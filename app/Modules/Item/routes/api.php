<?php

use App\Modules\Item\Http\Controllers\ItemApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['module' => 'Item', 'middleware' => 'verify_login.otp'], function () {
    Route::prefix('items')->group(function () {
        Route::get('/', [ItemApiController::class, 'list'])->name('item.list');
        Route::post('/', [ItemApiController::class, 'store'])->name('item.store');
        Route::put('{id}', [ItemApiController::class, 'update'])->name('item.update');
        Route::delete('{id}', [ItemApiController::class, 'destroy'])->name('item.destroy');
    });
});




//Route::group(['middleware' => 'auth:api'], function () {
//    Route::post('/items', [ItemController::class, 'store']);
//    Route::get('/items', [ItemController::class, 'index']);
//    Route::put('/items/{id}', [ItemController::class, 'update']);
//    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
//});
//
//Route::group(['middleware' => ['auth:api', 'admin']], function () {
//    Route::get('/admin/items/unapproved', [AdminController::class, 'unapprovedItems']);
//    Route::put('/admin/items/{id}/approve', [AdminController::class, 'approve']);
//    Route::put('/admin/items/{id}/reject', [AdminController::class, 'reject']);
//    Route::delete('/admin/items/{id}', [AdminController::class, 'destroy']);
//});
