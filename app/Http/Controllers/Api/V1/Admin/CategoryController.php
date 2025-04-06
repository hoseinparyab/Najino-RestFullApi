<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return response()->json([
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(),
                [
                    'name' => ['required', 'string', 'min:1', 'max:255'],
                    'parent_id' => ['nullable', 'integer', ],

                ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            $inputs = $validator->validated();
            $category = Category::create([
                'name' => $inputs['name'],
                'parent_id' => $inputs['parent_id']
            ]);

        } catch (\Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later! ')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('category created successfully')->withData($category)->build()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return Response()->json([
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:255'],
                'parent_id' => ['nullable', 'integer'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $category->update($validator->validated());

        } catch (\Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later! ')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('category updated successfully')->withData($category)->build()->response();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('something is wrong try again later! ')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('category deleted successfully')->withStatus(200)->build()->response();
    }

}
