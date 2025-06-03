<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\ApiRequests\Portfolio\StorePortfolioRequest;
use App\Http\ApiRequests\Portfolio\UpdatePortfolioRequest;
use App\Http\ApiRequests\Portfolio\DeletePortfolioRequest;
use App\Http\ApiRequests\Portfolio\IndexPortfolioRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use App\RestfulApi\Facades\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class PortfolioController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }
    public function index(IndexPortfolioRequest $request)
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

    public function store(StorePortfolioRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = $this->portfolioService->createPortfolio($validated);

            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to create portfolio')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withData(new PortfolioResource($result->data))
                ->withStatus(201)
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

    public function show(Portfolio $portfolio)
    {
        try {
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

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        try {
            $validated = $request->validated();
            $result = $this->portfolioService->updatePortfolio($validated, $portfolio);

            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to update portfolio')
                    ->withStatus(500)
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

    public function destroy(DeletePortfolioRequest $request, Portfolio $portfolio)
    {
        try {
            $result = $this->portfolioService->deletePortfolio($portfolio);

            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to delete portfolio')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withMessage('Portfolio deleted successfully')
                ->withStatus(204)
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
