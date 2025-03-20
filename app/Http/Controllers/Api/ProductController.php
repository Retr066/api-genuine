<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        return response()->json($products);
    }


    /**
     * Display the specified resource.
     */
    public function getProductsByCategory(string $category)
    {
        $products = Products::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->get();
        return response()->json(['products' => $products,'number_of_products' => $products->count()]);
    }

}
