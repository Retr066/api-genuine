<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\HandlerError;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return ResponseHelper::success($products, 'Productos encontrados');
    }

    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new HandlerError('Producto no encontrado', 404);
        }

        return ResponseHelper::success($product, 'Producto encontrado');
    }


    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create($validated);
    
        return ResponseHelper::success($product, 'Producto creado', 201);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $validated = $request->validated();

        $product = Product::find($id);

        if (!$product) {
            throw new HandlerError('Producto no encontrado', 404);
        }

        $product->update($validated);
        return ResponseHelper::success($product, 'Producto actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new HandlerError('Producto no encontrado', 404);
        }

        $product->delete();
        return ResponseHelper::success(null, 'Producto eliminado');
    }

    


    /**
     * Display the specified resource.
     */
    public function getProductsByCategory(string $category)
    {
        $found_category = Category::where('name', $category)->first();

        if (!$found_category) {
            throw new HandlerError('Categoría no encontrada', 404);
        }
        $products = Product::whereHas('category', function ($query) use ($category) {
            $query->where('name', $category);
        })->get();
        
        return ResponseHelper::success([
            'products' => $products,
            'number_of_products' => $products->count()
        ], 'Productos encontrados');
    }

}
