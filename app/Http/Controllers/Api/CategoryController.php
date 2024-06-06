<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Helpers\UploadHelper;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('images')->get();
        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated(); 
          
        $category = Category::create($validated); 

        if(!empty($validated['images'])) { 
            UploadHelper::uploadCategoryImages($request, $category);
        } 

        return new CategoryResource($category); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {    
        return new CategoryResource($category); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated(); 

        $category->update($validated);  
 
        if(!empty($validated['images'])) {
            UploadHelper::deleteOldCategoryImages($category);
            UploadHelper::uploadCategoryImages($request, $category);
        }

        return new CategoryResource($category); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
 
        return response()->noContent();
    }
}
