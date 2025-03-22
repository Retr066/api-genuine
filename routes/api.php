<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products', 'controller' => ProductController::class], function () {
    Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'aea');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
});


Route::get('/products/category/{category}', [ProductController::class , 'getProductsByCategory'])
        ->where('category', '[A-Za-z]+')
        ->name('products.by.category');
