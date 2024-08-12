<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index']);

    Route::get('/{product}', [ProductController::class, 'show']);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index']);
});