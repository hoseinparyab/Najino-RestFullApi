<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    /**
     * Register a new user and generate API token
     *
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Create API token with 30 days expiration
            $tokenResult = $user->createToken('auth_token', ['*'], now()->addDays(30));
            $token = $tokenResult->plainTextToken;
            $tokenModel = $tokenResult->accessToken;

            // Store token in remember_token
            $user->remember_token = $token;
            $user->save();

            \Log::info('User registered successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'token_id' => $tokenModel->id
            ]);

            return [
                'user' => $user,
                'token' => $token,
                'expires_at' => $tokenModel->expires_at,
                'token_model' => $tokenModel,
            ];
        });
    }

    /**
     * Login user and generate new API token (deletes all existing tokens)
     *
     * @param array $credentials
     * @param bool $remember
     * @return array
     */
    public function login(array $credentials, bool $remember = false): array
    {
        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();
        
        // Delete all existing tokens for security
        $user->tokens()->delete();

        // Set token expiration based on remember me
        $expiration = $remember ? now()->addMonth() : now()->addDays(30);

        // Create new API token
        $tokenResult = $user->createToken('auth_token', ['*'], $expiration);
        $token = $tokenResult->plainTextToken;
        $tokenModel = $tokenResult->accessToken;

        // Update remember_token
        $user->remember_token = $token;
        $user->save();

        \Log::info('User logged in', [
            'user_id' => $user->id,
            'remember' => $remember,
            'expires_at' => $expiration->toDateTimeString()
        ]);

        return [
            'user' => $user,
            'token' => $token,
            'expires_at' => $tokenModel->expires_at,
            'token_model' => $tokenModel,
        ];
    }

    /**
     * Validate token from cookie and authenticate user
     * 
     * @param string $token
     * @return array|null
     */
    public function validateToken(string $token): ?array
    {
        $parts = explode('|', $token);
        if (count($parts) !== 2) {
            return null;
        }

        $tokenValue = $parts[1];
        $tokenModel = PersonalAccessToken::findToken($tokenValue);

        if (!$tokenModel || ($tokenModel->expires_at && $tokenModel->expires_at <= now())) {
            return null;
        }

        $user = User::find($tokenModel->tokenable_id);
        if (!$user) {
            return null;
        }

        Auth::login($user);

        return [
            'user' => $user,
            'token' => $token,
            'token_model' => $tokenModel,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function deleteExpiredTokens(User $user): void
    {
        $user->tokens()
            ->where('name', 'auth_token')
            ->where('created_at', '<', now()->subDays(30))
            ->delete();
    }
}
