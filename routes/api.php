<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HouseResidentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\FinancialSummaryController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/residents', [ResidentController::class, 'index']);
Route::get('/residents/{id}', [ResidentController::class, 'showDetail']);
Route::post('/residents', [ResidentController::class, 'store']);
Route::put('/residents/{id}', [ResidentController::class, 'update']);
Route::get('/images/residents/{filename}', [ResidentController::class, 'showImage']);

Route::get('/houses', [HouseController::class, 'index']);
Route::get('/houses/{id}', [HouseController::class, 'showDetail']);
Route::post('/houses', [HouseController::class, 'store']);
Route::put('/houses/{id}', [HouseController::class, 'update']);

Route::get('/payments', [PaymentController::class, 'index']);
Route::get('/payments/{id}', [PaymentController::class, 'showDetail']);
Route::patch('/payments/{id}/paid', [PaymentController::class, 'updatePaidStatus']);
Route::post('/payments', [PaymentController::class, 'store']);

Route::get('/expenses', [ExpenseController::class, 'index']);
Route::get('/expenses/{id}', [ExpenseController::class, 'showDetail']);
Route::post('/expenses', [ExpenseController::class, 'store']);

Route::get('/house-residents', [HouseResidentController::class, 'index']);

Route::get('/fee-types', [FeeTypeController::class, 'index']);
Route::get('/expense-categories', [ExpenseCategoryController::class, 'index']);

Route::get('/financial-summary', [FinancialSummaryController::class, 'index']);