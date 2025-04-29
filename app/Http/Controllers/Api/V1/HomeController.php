<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\RestfulApi\Facades\ApiResponse;
use App\Http\Resources\Article\ArticleResource;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Models\Article;

class HomeController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        try {
            $result = $this->articleService->getAllArticles([]);

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to fetch articles')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData(ArticleResource::collection($result->data))
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    public function show($id)
    {
        try {
            $article = Article::findOrFail($id);
            $result = $this->articleService->getArticleInfo($article);

            if (!$result->ok) {
                return ApiResponse::withMessage('Article not found')
                    ->withStatus(404)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData(new ArticleResource($result->data))
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }
}
