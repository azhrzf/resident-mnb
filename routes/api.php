<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\PaymentController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/residents', [ResidentController::class, 'show']);
Route::get('/residents/{id}', [ResidentController::class, 'showDetail']);
Route::post('/residents', [ResidentController::class, 'store']);
Route::put('/residents/{id}', [ResidentController::class, 'update']);
Route::get('/images/residents/{filename}', [ResidentController::class, 'showImage']);

Route::get('/houses', [HouseController::class, 'show']);
Route::get('/houses/{id}', [HouseController::class, 'showDetail']);
Route::post('/houses', [HouseController::class, 'store']);
Route::put('/houses/{id}', [HouseController::class, 'update']);

Route::get('/payments', [PaymentController::class, 'show']);
Route::get('/payments/{id}', [PaymentController::class, 'showDetail']);