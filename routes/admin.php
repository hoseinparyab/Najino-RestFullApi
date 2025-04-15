<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\ArticleController;
use App\Http\Controllers\Api\V1\Admin\LoginController;
use App\Http\Controllers\Api\V1\Admin\LogoutController;
use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\AssignRoleToUserController;

Route::post('login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('logout', LogoutController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('roles', RoleController::class);
    Route::post('users/{user}/assign-roles', AssignRoleToUserController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('articles', ArticleController::class);
});
