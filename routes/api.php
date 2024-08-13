<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;

use App\Http\Middleware\AuthTokenIsValid;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group([
    'middleware' => [AuthTokenIsValid::class],
    'prefix' => 'products'
],function () {
    
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
});

Route::group([
    'middleware' => [AuthTokenIsValid::class],
    'prefix' => 'categories'
], function () {

    Route::get('/', [CategoryController::class, 'index']);
});

Route::group([
    'middleware' => [AuthTokenIsValid::class],
    'prefix' => 'orders'
], function () {

    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{order}', [OrderController::class, 'show']);
});