<?php
namespace App\Http\ApiRequests\Admin\User;

use App\Models\User;
use App\RestfulApi\ApiFormRequest;

class UserUpdateApiRequest extends ApiFormRequest
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
        return User::rules([

            'first_name' => ['required', 'string', 'min:1', 'max:255'],
            'last_name'  => ['required', 'string', 'min:1', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email', Rule::unique('users', 'email')->ignore($this->user->id)],
            'password'   => ['nullable', 'string', 'min:8', 'max:255'],
        ]);
    }
}
