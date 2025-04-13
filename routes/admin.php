<?php

use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Admin\LoginController;
use App\Http\Controllers\Api\V1\Admin\LogoutController;
Route::post('login', LoginController::class);


Route::middleware('auth:sanctum')->group(function () {
    Route::delete('logout', LogoutController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('user', UserController::class);
    Route::apiResource('articles', ArticleController::class);
});
