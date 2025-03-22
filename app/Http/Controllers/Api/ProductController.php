<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            'message'=> 'Listado de productos',
            'data'=> $products
        ], 200);
    }

    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message'=> 'Producto no encontrado',
                'data'=> null
            ], 404);
        }

        return response()->json([
            'message'=> 'Producto encontrado',
            'data'=> $product
        ], 200);
    }


    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if (!$validated) {
            return response()->json([
                'message'=> 'Datos inválidos',
                'data'=> $validated
            ], 400);
        }
    
        // Crear el producto con los datos validados
        $product = Product::create($validated);
    
        return response()->json([
            'message'=> 'Producto creado',
            'data'=> $product
        ], 201);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $validated = $request->validated();

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message'=> 'Producto no encontrado',
                'data'=> null
            ], 404);
        }

        $product->update($validated);
        return response()->json([
            'message'=> 'Producto actualizado',
            'data'=> $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message'=> 'Producto no encontrado',
                'data'=> null
            ], 404);
        }

        $product->delete();
        return response()->json([
            'message'=> 'Producto eliminado',
            'data'=> $product
        ], 200);
    }

    


    /**
     * Display the specified resource.
     */
    public function getProductsByCategory(string $category)
    {
        $products = Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->get();
        return response()->json(['products' => $products,'number_of_products' => $products->count()]);
    }

}
