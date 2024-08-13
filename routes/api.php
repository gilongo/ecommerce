<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

use App\Http\Middleware\AuthTokenIsValid;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'products'],function () {
    
    Route::get('/', [ProductController::class, 'index'])->middleware(AuthTokenIsValid::class);

    Route::get('/{product}', [ProductController::class, 'show'])->middleware(AuthTokenIsValid::class);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index']);
});