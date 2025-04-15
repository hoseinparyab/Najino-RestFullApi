<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\ApiRequests\Admin\User\UserDestroyApiRequest;
use App\Http\ApiRequests\Admin\User\UserIndexApiRequest;
use App\Http\ApiRequests\Admin\User\UserShowApiRequest;
use App\Http\ApiRequests\Admin\User\UserStoreApiRequest;
use App\Http\ApiRequests\Admin\User\UserUpdateApiRequest;
use App\SearchOptions\UsersSearchOptions;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\User\UserDetailsApiResource;
use App\Http\Resources\Admin\User\UsersListApiResource;
use App\Models\User;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\UserService;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }


    public function index(UserIndexApiRequest $request)
    {
        $result = $this->userService->getAllUsers($request->all());

        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withData(UsersListApiResource::collection($result->data)->resource)->build()->response();
    }

    public function store(UserStoreApiRequest $request)
    {
        $result = $this->userService->registerUser($request->validated());

        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('User created successfully')->withData($result->data)->build()->response();
    }


    public function show(UserShowApiRequest $request, User $user)
    {
        $result = $this->userService->getUserInfo($user);

        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withData(new UserDetailsApiResource($result->data))->build()->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateApiRequest $request, User $user)
    {
        $result = $this->userService->updateUser($request->validated(), $user);

        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('User updated successfully')->withData($result->data)->build()->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserDestroyApiRequest $request, User $user)
    {
        $result = $this->userService->deleteUser($user);

        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::withMessage('User deleted successfully')->build()->response();

    }
}
