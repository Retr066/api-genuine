<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\HandlerError;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return ResponseHelper::success($categories, 'Categorías encontradas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $category = Category::create($validated);
        return ResponseHelper::success($category, 'Categoría creada', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if(!$category){
            throw new HandlerError('Categoría no encontrada', 404);
        }

        return ResponseHelper::success($category, 'Categoría encontrada');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $validated = $request->validated();
        $category = Category::find($id);
        if(!$category){
            throw new HandlerError('Categoría no encontrada', 404);
        }
        $category->update($validated);
        return ResponseHelper::success($category, 'Categoría actualizada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if(!$category){
            throw new HandlerError('Categoría no encontrada', 404);
        }
        $category->delete();
        return ResponseHelper::success(null, 'Categoría eliminada');
    }
}
