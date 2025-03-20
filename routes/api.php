<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products/{category}', [ProductController::class , 'getProductsByCategory'])->where('category', '[A-Za-z]+')->name('products');
