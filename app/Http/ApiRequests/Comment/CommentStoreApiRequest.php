<?php
namespace App\Http\ApiRequests\Comment;

use App\RestfulApi\ApiFormRequest;

class CommentStoreApiRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content'    => 'required|string|max:1000',
            'article_id' => 'required|exists:articles,id',
            'parent_id'  => 'nullable|exists:comments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required'    => 'The comment content is required.',
            'content.string'      => 'The comment content must be a string.',
            'content.max'         => 'The comment content must not exceed 1000 characters.',
            'article_id.required' => 'The article ID is required.',
            'article_id.exists'   => 'The selected article does not exist.',
            'parent_id.exists'    => 'The parent comment does not exist.',
        ];
    }

    public function attributes(): array
    {
        return [
            'content'    => 'comment content',
            'article_id' => 'article',
            'parent_id'  => 'parent comment',
        ];
    }
}
