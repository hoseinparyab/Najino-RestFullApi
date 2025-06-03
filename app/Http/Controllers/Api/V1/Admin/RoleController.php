<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\ApiRequests\Admin\Role\RoleDestroyApiRequest;
use App\Http\ApiRequests\Admin\Role\RoleIndexApiRequest;
use App\Http\ApiRequests\Admin\Role\RoleShowApiRequest;
use App\Http\ApiRequests\Admin\Role\RoleStoreApiRequest;
use App\Http\ApiRequests\Admin\Role\RoleUpdateApiRequest;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\RoleService;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private RoleService $roleService) {}

    public function index(RoleIndexApiRequest $request)
    {
        $result = $this->roleService->getAllRoles();
        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Roles fetched successfully')->withData($result->data)->build()->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreApiRequest $request)
    {
        $result = $this->roleService->AddNewRole($request->validated());
        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Role created successfully')->withData($result->data)->build()->response();

    }

    /**
     * Display the specified resource.
     */
    public function show(RoleShowApiRequest $request, Role $role)
    {
        $result = $this->roleService->getRoleInfo($role);

        return ApiResponse::withData($result->data)->build()->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateApiRequest $request, Role $role)
    {

        $result = $this->roleService->updateRole($request->validated(), $role);
        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Role updated successfully')->withData($result->data)->build()->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleDestroyApiRequest $request, Role $role)
    {
        $result = $this->roleService->deleteRole($role);
        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('Role deleted successfully')->build()->response();
    }
}
