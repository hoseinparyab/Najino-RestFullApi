<?php

namespace App\Http\ApiRequests\Admin\Role;

use App\RestfulApi\ApiFormRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleUpdateApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('role_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $role = $this->route('role');
        $roleId = $role instanceof Role ? $role->id : $role;

        return Role::rules(['name' => 'required|string|unique:roles,name,' . $roleId]);
    }
}
