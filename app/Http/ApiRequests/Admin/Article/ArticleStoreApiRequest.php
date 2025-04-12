<?php

namespace App\Http\ApiRequests\Admin\Article;

use App\Models\Article;
use App\RestfulApi\ApiFormRequest;

class ArticleStoreApiRequest extends ApiFormRequest
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
        return Article::rules();
    }
}
