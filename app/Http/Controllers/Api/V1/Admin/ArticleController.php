<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\SearchOptions\ArticleAuthorSearchOptions;
use App\Http\Resources\Admin\Article\ArticleDetailsApiResource;
use App\Http\Resources\Admin\Article\ArticlesListApiResource;
use App\Services\ArticleService;
use App\RestfulApi\Facades\ApiResponse;
use App\Http\ApiRequests\Admin\Article\ArticleStoreApiRequest;
use App\Http\ApiRequests\Admin\Article\ArticleUpdateApiRequest;
use App\Http\ApiRequests\Admin\Article\ArticleIndexApiRequest;
use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ArticleController extends Controller
{
    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the articles.
     */
    public function index(ArticleIndexApiRequest $request)
    {
        try {
            $result = $this->articleService->getAllArticles($request->validated());

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to fetch articles')->withStatus(500)->build()->response();
            }

            return ApiResponse::withData(ArticlesListApiResource::collection($result->data))->build()->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(ArticleStoreApiRequest $request)
    {
        try {
            $result = $this->articleService->createArticle($request->validated());

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to create article')->withStatus(500)->build()->response();
            }

            return ApiResponse::withMessage('Article created successfully')
                ->withData(new ArticleDetailsApiResource($result->data))
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        try {
            $result = $this->articleService->getArticleInfo($article);

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to fetch article')->withStatus(500)->build()->response();
            }

            return ApiResponse::withData(new ArticleDetailsApiResource($result->data))->build()->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Update the specified article in storage.
     */
    public function update(ArticleUpdateApiRequest $request, Article $article)
    {
        try {
            $result = $this->articleService->updateArticle($request->validated(), $article);

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to update article')->withStatus(500)->build()->response();
            }

            return ApiResponse::withMessage('Article updated successfully')
                ->withData(new ArticleDetailsApiResource($result->data))
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')->withStatus(500)->build()->response();
        }
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        try {
            $result = $this->articleService->deleteArticle($article);

            if (!$result->ok) {
                return ApiResponse::withMessage('Failed to delete article')->withStatus(500)->build()->response();
            }

            return ApiResponse::withMessage('Article deleted successfully')->withStatus(200)->build()->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')->withStatus(500)->build()->response();
        }
    }
}
