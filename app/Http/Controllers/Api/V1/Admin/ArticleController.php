<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\ApiRequests\Admin\Article\ArticleStoreApiRequest;
use App\Http\ApiRequests\Admin\Article\ArticleUpdateApiRequest;
use App\Http\Resources\Admin\Article\ArticleDetailsResource;
use App\Http\Resources\Admin\Article\ArticleListResource;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function __construct(private ArticleService $articleService)
    {
    }

    /**
     * Display a listing of the articles.
     */
    public function index(Request $request)
    {
        $articles = $this->articleService->getAllArticles($request->all());
        return ApiResponse::withData(ArticleListResource::collection($articles)->resource)
            ->build()
            ->response();
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(ArticleStoreApiRequest $request)
    {
        $article = $this->articleService->createArticle($request->validated());
        return ApiResponse::withMessage('Article created successfully')
            ->withData(new ArticleDetailsResource($article))
            ->build()
            ->response();
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        $article->load(['user', 'category']);
        return ApiResponse::withData(new ArticleDetailsResource($article))
            ->build()
            ->response();
    }

    /**
     * Update the specified article in storage.
     */
    public function update(ArticleUpdateApiRequest $request, Article $article)
    {
        $article = $this->articleService->updateArticle($article, $request->validated());
        return ApiResponse::withMessage('Article updated successfully')
            ->withData(new ArticleDetailsResource($article))
            ->build()
            ->response();
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        $this->articleService->deleteArticle($article);
        return ApiResponse::withMessage('Article deleted successfully')
            ->withStatus(200)
            ->build()
            ->response();
    }
}
