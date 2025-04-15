<?php

namespace App\Http\ApiRequests\Admin\Article;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
class ArticleIndexApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('article_read');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Article::rules([
            'search' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ]);
    }
}
