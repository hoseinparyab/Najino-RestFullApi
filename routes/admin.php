<?php

use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('user', UserController::class);
Route::apiResource('categories', CategoryController::class);
