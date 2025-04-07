<?php
namespace App\Http\ApiRequests\Admin\Article;

use App\RestfulApi\ApiFormRequest;
use App\Models\Article;
class ArticleUpdateApiRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Article::rules([
            'title'       => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'body'        => 'sometimes|required|string',
            'image'       => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }
}
