<?php

use App\Http\Controllers\Api\V1\Admin\ArticleController;
use App\Http\Controllers\Api\V1\Admin\AssignRoleToUserController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\FAQController;
use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\Admin\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::post('login/admin', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('roles', RoleController::class);
    Route::post('users/{user}/assign-roles', AssignRoleToUserController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('faqs', FAQController::class);

    // Portfolio admin routes
    Route::get('/portfolios', [PortfolioController::class, 'index']);
    Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show']);
    Route::post('/portfolios', [PortfolioController::class, 'store']);
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update']);
    Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy']);


    Route::get('/contacts', [ContactController::class, 'index']);
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
});
