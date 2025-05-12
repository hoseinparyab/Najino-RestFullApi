<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data): array
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Store token in remember_token
        $user->remember_token = $token;
        $user->save();

        // Debugging: Check if the token is set
        \Log::info('Token created during registration: ' . $token);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();

        // Delete expired tokens
        $this->deleteExpiredTokens($user);

        // Check for existing valid token (created within last 30 days)
        $tokenModel = $user->tokens()
            ->where('name', 'auth_token')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->latest('created_at')
            ->first();

        if ($tokenModel) {
            $token = $tokenModel->plainTextToken;
            $expiresAt = $tokenModel->expires_at;
        } else {
            // Delete old tokens if you want to keep only one active token
            $user->tokens()->where('name', 'auth_token')->delete();
            $tokenResult = $user->createToken('auth_token', ['*'], now()->addDays(30));
            $token = $tokenResult->plainTextToken;
            $expiresAt = now()->addDays(30);
        }

        return [
            'user' => $user,
            'token' => $token,
            'expires_at' => $expiresAt
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
