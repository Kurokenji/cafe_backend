<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Route::get('/items', [OrderController::class, 'getItems']);
    Route::put('/orders/{id}/prepare', [OrderController::class, 'prepareOrder']);
    Route::put('/orders/{id}/deliver', [OrderController::class, 'startDelivery']);
    Route::put('/orders/{id}/complete', [OrderController::class, 'completeDelivery']);
    Route::put('/orders/{id}/pay', [OrderController::class, 'markAsPaid']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    
    Route::post('/items', [ItemController::class, 'store']);
    Route::put('/itemse/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);

    Route::get('/orders', [OrderController::class, 'getOrders']);

});

Route::get('/items', [ItemController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/orders', [OrderController::class, 'placeOrder']);
