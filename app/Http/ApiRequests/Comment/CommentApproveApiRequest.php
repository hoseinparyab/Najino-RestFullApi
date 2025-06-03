<?php

namespace App\Http\ApiRequests\Comment;

use App\RestfulApi\ApiFormRequest;
use Illuminate\Support\Facades\Gate;

class CommentApproveApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('comment_approve');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_approved' => 'required|boolean',
            'rejection_reason' => 'nullable|string|max:500|required_if:is_approved,false',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'is_approved.required' => 'The approval status is required.',
            'is_approved.boolean' => 'The approval status must be true or false.',
            'rejection_reason.required_if' => 'A rejection reason is required when disapproving a comment.',
            'rejection_reason.max' => 'The rejection reason cannot exceed 500 characters.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'is_approved' => 'approval status',
            'rejection_reason' => 'rejection reason',
        ];
    }
}
