<?php

use App\Http\Controllers\Api\Products\CategoryController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Sales\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
Route::post('sales', [SaleController::class, 'store']);