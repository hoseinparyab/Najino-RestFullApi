<?php
namespace App\Http\ApiRequests\Admin\Comment;

use App\RestfulApi\ApiFormRequest;

class CommentRequestApi  extends ApiFormRequest
{
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'is_approved'      => 'required|boolean',
            'rejection_reason' => 'nullable|string|max:500|required_if:is_approved,false',
        ];
    }

    public function messages(): array
    {
        return [
            'is_approved.required'         => 'The approval status is required.',
            'is_approved.boolean'          => 'The approval status must be true or false.',
            'rejection_reason.required_if' => 'A rejection reason is required when disapproving a comment.',
            'rejection_reason.max'         => 'The rejection reason must not exceed 500 characters.',
        ];
    }

    public function attributes(): array
    {
        return [
            'is_approved'      => 'approval status',
            'rejection_reason' => 'rejection reason',
        ];
    }
}
