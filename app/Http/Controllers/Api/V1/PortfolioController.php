<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\ApiRequests\Portfolio\StorePortfolioRequest;
use App\Http\ApiRequests\Portfolio\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    protected $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }
    public function index()
    {
        $result = $this->portfolioService->getAllPortfolios();
        return response()->json($result->data);
    }

    public function store(StorePortfolioRequest $request)
    {
        $validated = $request->validated();

        $result = $this->portfolioService->createPortfolio($validated);
        return response()->json($result->data, 201);
    }

    public function show(Portfolio $portfolio)
    {
        $result = $this->portfolioService->getPortfolio($portfolio);
        return response()->json($result->data);
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        $validated = $request->validated();

        $result = $this->portfolioService->updatePortfolio($validated, $portfolio);
        return response()->json($result->data);
    }

    public function destroy(Portfolio $portfolio)
    {
        $result = $this->portfolioService->deletePortfolio($portfolio);
        return response()->json(null, 204);
    }
}
