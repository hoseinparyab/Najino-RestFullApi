<?php
namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\User;

class AccessLevelService
{

    public function assignRolesToUser(User $user, array $roleIds): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($user, $roleIds) {
            return $user->roles()->sync($roleIds);
        });
    }

}
