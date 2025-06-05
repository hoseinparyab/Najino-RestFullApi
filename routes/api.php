<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\ProfileController;
use Illuminate\Support\Facades\Route;

// Home routes - show only 4 latest articles
Route::get('/home/articles', [HomeController::class, 'index']);

// Blog routes - show all articles with pagination and latest articles
Route::get('/blog/articles', [BlogController::class, 'index']);
Route::get('/blog/articles/latest', [BlogController::class, 'latest']);
Route::get('/blog/articles/{article}', [BlogController::class, 'show']);
// FAQ routes
Route::get('/faqs', [HomeController::class, 'faqs']);

// Portfolio routes
Route::get('/portfolios', [HomeController::class, 'portfolios']);
Route::get('/portfolios/{id}', [HomeController::class, 'portfolio']);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Contact routes
Route::post('/contact', [ContactController::class, 'store']);


// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Comments routes
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::patch('/profile', [ProfileController::class, 'update']);
});
