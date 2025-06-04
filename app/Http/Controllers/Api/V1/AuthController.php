<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiRequests\Auth\LoginApiRequest;
use App\Http\ApiRequests\Auth\RegisterApiRequest;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user
     *
     * @param RegisterApiRequest $request
     * @return JsonResponse
     */
    public function register(RegisterApiRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());
        $tokenModel = $result['token_model'];

        $response = response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => $result['user'],
                'token' => $result['token'],
                'expires_at' => $tokenModel->expires_at->toDateTimeString(),
                'current_token' => [
                    'id' => $tokenModel->id,
                    'name' => $tokenModel->name,
                    'created_at' => $tokenModel->created_at->toDateTimeString(),
                    'expires_at' => $tokenModel->expires_at->toDateTimeString(),
                ],
            ],
        ], 201);

        // Set auth token cookie
        return $response->cookie('auth_token', $result['token'], 60 * 24 * 30); // 30 days
    }

    /**
     * Login user
     *
     * @param LoginApiRequest $request
     * @return JsonResponse
     */
    public function login(LoginApiRequest $request): JsonResponse
    {
        $remember = $request->boolean('remember', false);
        $result = $this->authService->login($request->validated(), $remember);
        $tokenModel = $result['token_model'];

        $response = response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => $result['user'],
                'token' => $result['token'],
                'expires_at' => $tokenModel->expires_at->toDateTimeString(),
                'current_token' => [
                    'id' => $tokenModel->id,
                    'name' => $tokenModel->name,
                    'created_at' => $tokenModel->created_at->toDateTimeString(),
                    'expires_at' => $tokenModel->expires_at->toDateTimeString(),
                ],
            ],
        ]);

        // Set auth token cookie with appropriate expiration
        $cookieMinutes = $remember ? 60 * 24 * 30 : 60 * 24; // 30 days or 1 day
        return $response->cookie('auth_token', $result['token'], $cookieMinutes);
    }

    /**
     * Check if the token in cookie is valid
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkToken(Request $request): JsonResponse
    {
        $token = $request->cookie('auth_token');
        
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'No auth token found in cookie',
            ], 401);
        }

        $result = $this->authService->validateToken($token);
        
        if (!$result) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired token',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Token is valid',
            'data' => [
                'user' => $result['user'],
                'token' => $token,
            ],
        ]);
    }

    /**
     * Logout user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        
        if ($user) {
            // Revoke current token
            $user->currentAccessToken()->delete();
            
            // Clear remember token
            $user->remember_token = null;
            $user->save();
        }

        $response = response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);

        // Remove auth token cookie
        return $response->withoutCookie('auth_token');
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }
}
