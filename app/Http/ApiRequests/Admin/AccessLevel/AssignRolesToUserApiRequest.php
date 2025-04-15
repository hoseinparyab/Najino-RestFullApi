<?php
namespace App\Http\ApiRequests\Admin\AccessLevel;

use App\RestfulApi\ApiFormRequest;

class AssignRolesToUserApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
            return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'roles'   => 'required|array', //TODO: check if the role is exists
            'roles.*' => 'exists:roles,id', //TODO: check if the role is exists
        ];
    }
}
