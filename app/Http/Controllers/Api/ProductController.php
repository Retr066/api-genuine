<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\HandlerError;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


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
    public function dialogflowWebhook(Request $request)
    {
        $category =  strtolower($request->input('queryResult.parameters.category'));


        if (!$category) {
            return response()->json([
                'fulfillmentText' => "No entendí la categoría. ¿Podrías repetirla?"
            ]);
        }

        $foundCategory = Category::where('name', $category)->first();

        if (!$foundCategory) {
            return response()->json([
                'fulfillmentText' => "Categoría no encontrada"
            ]);
        }

        $productCount = Product::where('category_id', $foundCategory->id)->sum('quantity');

        return response()->json([
            'fulfillmentText' => "La categoría $category tiene $productCount productos disponibles."
        ]);
    }

}
