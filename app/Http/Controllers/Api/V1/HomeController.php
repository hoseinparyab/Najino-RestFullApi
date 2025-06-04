<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\FAQ\FAQResource;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Models\Article;
use App\Models\Portfolio;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\ArticleService;
use App\Services\FAQService;
use App\Services\PortfolioService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class HomeController extends Controller
{
    protected $articleService;
    protected $portfolioService;
    protected $faqService;

    public function __construct(ArticleService $articleService, PortfolioService $portfolioService, FAQService $faqService)
    {
        $this->articleService = $articleService;
        $this->portfolioService = $portfolioService;
        $this->faqService = $faqService;
    }

    public function index()
    {
        try {
            $result = $this->articleService->getAllArticles([]);

            if (! $result->ok) {
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

            if (! $result->ok) {
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
    public function portfolios()
    {
        try {
            $result = $this->portfolioService->getAllPortfolios();

            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to fetch portfolios')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData(PortfolioResource::collection($result->data))
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
    public function portfolio($id)
    {
        try {
            $portfolio = Portfolio::findOrFail($id);
            $result = $this->portfolioService->getPortfolio($portfolio);

            if (! $result->ok) {
                return ApiResponse::withMessage('Portfolio not found')
                    ->withStatus(404)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData(new PortfolioResource($result->data))
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

    public function faqs()
    {
        try {
            $faqs = $this->faqService->getActiveFAQs();
            return FAQResource::collection($faqs);
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }
}
