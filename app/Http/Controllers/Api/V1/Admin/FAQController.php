<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\ApiRequests\FAQ\IndexFAQRequest;
use App\Http\ApiRequests\FAQ\StoreFAQRequest;
use App\Http\ApiRequests\FAQ\UpdateFAQRequest;
use App\Http\ApiRequests\FAQ\DeleteFAQRequest;
use App\Http\Resources\FAQ\FAQResource;
use App\Http\Resources\FAQ\FAQCollection;
use App\Services\FAQService;
use App\RestfulApi\ApiResponse;
use Throwable;

class FAQController extends Controller
{
    private $faqService;

    public function __construct(FAQService $faqService)
    {
        $this->faqService = $faqService;
    }

    public function index(IndexFAQRequest $request)
    {
        try {
            $filters = $request->validated();
            $perPage = $request->input('per_page', 10);
            $faqs = $this->faqService->getAll($filters, $perPage);
            return new FAQCollection($faqs);
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    public function store(StoreFAQRequest $request)
    {
        try {
            $faq = $this->faqService->create($request->validated());
            return new FAQResource($faq);
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    public function show(int $id)
    {
        try {
            $faq = $this->faqService->find($id);
            if (!$faq) {
                return ApiResponse::withMessage('FAQ not found')
                    ->withStatus(404)
                    ->build()
                    ->response();
            }
            return new FAQResource($faq);
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    public function update(UpdateFAQRequest $request, int $id)
    {
        try {
            $faq = $this->faqService->find($id);
            if (!$faq) {
                return ApiResponse::withMessage('FAQ not found')
                    ->withStatus(404)
                    ->build()
                    ->response();
            }
            $this->faqService->update($faq, $request->validated());
            return new FAQResource($faq);
        } catch (Throwable $th) {
            app()[ExceptionHandler::class]->report($th);
            return ApiResponse::withMessage('Something went wrong, please try again later!')
                ->withStatus(500)
                ->build()
                ->response();
        }
    }

    public function destroy(DeleteFAQRequest $request, int $id)
    {
        try {
            $faq = $this->faqService->find($id);
            if (!$faq) {
                return ApiResponse::withMessage('FAQ not found')
                    ->withStatus(404)
                    ->build()
                    ->response();
            }
            $this->faqService->delete($faq);
            return ApiResponse::withMessage('FAQ deleted successfully')
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
