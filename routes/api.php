<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products', 'controller' => ProductController::class], function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store')->where('id', '[0-9]+');
    Route::put('/{id}', 'update')->where('id', '[0-9]+');   
    Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
    Route::get('/category/{category}', 'getProductsByCategory')
        ->where('category', '[A-Za-z]+');
});

Route::group(['prefix' => 'categories', 'controller' => CategoryController::class], function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show')->where('id', '[0-9]+');
    Route::post('/', 'store');
    Route::put('/{id}', 'update')->where('id', '[0-9]+');
    Route::delete('/{id}', 'destroy')->where('id', '[0-9]+');
});
