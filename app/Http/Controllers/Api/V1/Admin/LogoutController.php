<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\RestfulApi\Facades\ApiResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->tokens()->delete();

        return ApiResponse::withMessage('logout successfully')->build()->response();
    }
}
