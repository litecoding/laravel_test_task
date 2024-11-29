<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', [AuthController::class, 'logout']);

use App\Http\Controllers\OrderApiController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/orders', [OrderApiController::class, 'index'])->name('api.orders.index');
    Route::post('/orders', [OrderApiController::class, 'store'])->name('api.orders.store');
    Route::get('/orders/{order}', [OrderApiController::class, 'show'])->name('api.orders.show');
    Route::put('/orders/{order}', [OrderApiController::class, 'update'])->name('api.orders.update');
    Route::delete('/orders/{order}', [OrderApiController::class, 'destroy'])->name('api.orders.destroy');
});
