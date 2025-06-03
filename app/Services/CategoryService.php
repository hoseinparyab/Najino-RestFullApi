<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\Category;
use App\SearchOptions\CategoriesSearchOptions;

class CategoryService
{
    public function getAllCategories(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            return Category::search($inputs, new CategoriesSearchOptions)->paginate();
        });
    }

    public function getCategoryInfo(Category $category): ServiceResult
    {
        return app(ServiceWrapper::class)(fn () => $category);
    }

    public function createCategory(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            return Category::create($inputs);
        });
    }

    public function updateCategory(array $inputs, Category $category): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $category) {
            $category->update($inputs);

            return $category;
        });
    }

    public function deleteCategory(Category $category): ServiceResult
    {
        return app(ServiceWrapper::class)(fn () => $category->delete());
    }
}
