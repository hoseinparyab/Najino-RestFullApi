<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\User;
use App\SearchOptions\UsersSearchOptions;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            return User::search($inputs, new UsersSearchOptions)->paginate();
        });
    }

    public function getUserInfo(User $user): ServiceResult
    {
        return app(ServiceWrapper::class)(fn () => $user);
    }

    public function registerUser(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $inputs['password'] = Hash::make($inputs['password']);

            return User::create($inputs);
        });
    }

    public function updateUser(array $inputs, User $user): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $user) {
            if (isset($inputs['password'])) {
                $inputs['password'] = Hash::make($inputs['password']);
            }

            $user->update($inputs);

            return $user;
        });
    }

    public function deleteUser(User $user): ServiceResult
    {
        return app(ServiceWrapper::class)(fn () => $user->delete());
    }
}
