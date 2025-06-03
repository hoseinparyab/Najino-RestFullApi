<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Models\Role;
use Illuminate\Support\Arr;

class RoleService
{
    public function getAllRoles(): ServiceResult
    {
        return app(ServiceWrapper::class)(function () {
            return Role::all();
        });
    }

    public function getRoleInfo(Role $role): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($role) {
            return $role;
        });
    }

    public function AddNewRole(array $inputs): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs) {
            $role = Role::create(Arr::except($inputs, ['permissions']));
            $role->permissions()->attach($inputs['permissions']);

            return $role;

        });
    }

    public function updateRole(array $inputs, Role $role): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($inputs, $role) {
            $role->update(Arr::except($inputs, ['permissions']));
            $role->permissions()->sync($inputs['permissions']);

            return $role;

        });
    }

    public function deleteRole(Role $role): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($role) {
            return $role->delete();
        });
    }
}
