<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\ArticleService;
use App\Models\Article;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Get all blog articles with optional search and pagination
     *
     * @queryParam search string Search query to filter articles by title. Example: Laravel
     * @queryParam per_page int Number of items per page. Example: 10
     * @queryParam page int Page number. Example: 1
     *
     * @response 200 {
     *   "data": [{"id": 1, "title": "...", ...}],
     *   "pagination": {"total": 15, "per_page": 10, ...}
     * }
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search');
            $perPage = max(1, (int) $request->query('per_page', 10));
            $page = max(1, (int) $request->query('page', 1));
            
            // Get the paginated data
            $result = $this->articleService->getAllArticles([
                'search' => $search,
                'per_page' => $perPage,
                'page' => $page
            ]);
            
            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to fetch articles')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            // Get the paginator instance from the result data
            $paginator = $result->data;
            
            // Format the response
            $response = [
                'data' => ArticleResource::collection($paginator->items()),
                'meta' => [
                    'search' => $search,
                    'total' => $paginator->total(),
                    'per_page' => (int) $paginator->perPage(),
                    'current_page' => (int) $paginator->currentPage(),
                    'last_page' => (int) $paginator->lastPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ]
            ];
            
            return response()->json($response);
                
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);

            return response()->json([
                'message' => 'Something went wrong, please try again later!',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get latest articles
     *
     * @param int $count Number of latest articles to return (default: 4)
     * @return JsonResponse
     */
    public function latest(int $count = 4): JsonResponse
    {
        try {
            $result = $this->articleService->getLatestArticles($count);

            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to fetch latest articles')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData(ArticleResource::collection($result->data))
                ->withAppend(['total' => count($result->data)])
                ->build()
                ->response();
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);

            return ApiResponse::withMessage('Something went wrong while fetching latest articles')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    /**
     * Display the specified article.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $article = Article::findOrFail($id);
            $result = $this->articleService->getArticleInfo($article);

            if (! $result->ok) {
                return ApiResponse::withMessage('Article not found')
                    ->withStatus(404)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData(new ArticleResource($result->data))
                ->build()
                ->response();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return ApiResponse::withMessage('Article not found')
                ->withStatus(404)
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
