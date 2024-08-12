<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index']);

    Route::get('/{product}', [ProductController::class, 'show']);
});