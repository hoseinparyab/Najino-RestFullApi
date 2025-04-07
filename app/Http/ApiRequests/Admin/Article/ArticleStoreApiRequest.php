<?php

namespace App\Http\ApiRequests\Admin\Article;

use App\RestfulApi\ApiFormRequest;
use App\Models\Article;
class ArticleStoreApiRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Article::rules();
    }
}
