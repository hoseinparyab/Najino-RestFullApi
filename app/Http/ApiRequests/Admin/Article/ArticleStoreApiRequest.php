<?php

namespace App\Http\ApiRequests\Admin\Article;

use App\Models\Article;
use App\RestfulApi\ApiFormRequest;
use Illuminate\Support\Facades\Gate;

class ArticleStoreApiRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('article_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Article::rules();
    }
}
