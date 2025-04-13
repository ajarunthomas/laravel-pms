<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\userController;
use App\Http\Controllers\Product\productController;
use App\Http\Controllers\Order\orderController;


Route::get('/token', [userController::class, 'token'])->middleware('throttle:5,1')->name('token');

Route::group(['middleware' => ['auth:sanctum', 'throttle:60,1']], function(){
    Route::apiResource('/products', productController::class);
    Route::apiResource('/orders', orderController::class);
    
    Route::get('/products-by-category/{category_id}', [productController::class, 'productsByCategory']);
});

