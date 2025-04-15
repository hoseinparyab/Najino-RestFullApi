<?php

namespace App\Http\ApiRequests\Admin\User;

use App\RestfulApi\ApiFormRequest;
use Illuminate\Support\Facades\Gate;
class UserShowApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('user_read');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

        ];
    }
}
