<?php

namespace App\Http\ApiRequests\Admin\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ArticleIndexApiRequest extends FormRequest
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
            'search' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',
            'sort_by' => 'nullable|string|in:title,created_at,view_count',
            'sort_order' => 'nullable|string|in:asc,desc',
        ];
    }
}
