<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\userController;


Route::get('/login', [userController::class, 'login'])->name('login');
Route::post('/login-submit', [userController::class, 'loginSubmit'])->name('login.submit');

Route::get('/register', [userController::class, 'register'])->name('register');
Route::post('/register-submit', [userController::class, 'registerSubmit'])->name('register.submit');


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/', [userController::class, 'home'])->name('home');
    Route::get('/orders', [userController::class, 'orders'])->name('orders');
    Route::get('/products', [userController::class, 'products'])->name('products');
    Route::get('/products/add', [userController::class, 'addProduct'])->name('products.add');
    Route::post('/products/add/submit', [userController::class, 'addProductSubmit'])->name('products.add.submit');
    Route::get('/logout', [userController::class, 'logout'])->name('logout');
});

