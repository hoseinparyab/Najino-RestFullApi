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
            return response()->json([
                'message' => 'something is wrong try again later! ',
            ], 500);
        }

        return response()->json([
            'message' => 'category created successfully',
            'data' => $category
        ], 200);
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
            return response()->json(['message' => 'Something went wrong!'], 500);
        }

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ], 200);
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
            return response()->json([
                'message' => 'something is wrong try again later! ',
            ], 500);
        }

        return response()->json([
            'messages' => 'user deleted successfully',
        ], 200);
    }

}
