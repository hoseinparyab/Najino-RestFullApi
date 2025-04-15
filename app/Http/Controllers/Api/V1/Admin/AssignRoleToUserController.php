<?php
namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\ApiRequests\Admin\AccessLevel\AssignRolesToUserApiRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\AccessLevelService;

class AssignRoleToUserController extends Controller
{
    public function __construct(public AccessLevelService $service)
    {
    }

    public function __invoke(AssignRolesToUserApiRequest $request, User $user)
    {
        $result = $this->service->assignRolesToUser($user, $request->validated()['roles']);

        if (! $result->ok) {
            return ApiResponse::withMessage('Something is wrong. try again later!')->withStatus(500)->build()->response();
        }

        return ApiResponse::build()->response();
    }
}
