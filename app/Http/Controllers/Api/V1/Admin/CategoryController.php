<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $result = $this->categoryService->getAllCategories($request->all());

        if (!$result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withData($result->data)->build()->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreApiRequest $request)

    {
        $result = $this->categoryService->createCategory($request->validated());

        if (!$result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Category created successfully')->withData($result->data)->build()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $result = $this->categoryService->getCategoryInfo($category);

        if (!$result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withData($result->data)->build()->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateApiRequest $request, Category $category)
    {
        $result = $this->categoryService->updateCategory($request->validated(), $category);
        if (!$result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Category updated successfully')->withData($result->data)->build()->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $result = $this->categoryService->deleteCategory($category);

        if (!$result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Category deleted successfully')->withStatus(200)->build()->response();
    }
}
