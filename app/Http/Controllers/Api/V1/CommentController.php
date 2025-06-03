<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\ApiRequests\Comment\CommentStoreApiRequest;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\RestfulApi\Facades\ApiResponse;
use App\Services\CommentService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentStoreApiRequest $request): JsonResponse
    {
        try {
            $result = $this->commentService->createComment($request->validated());

            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to create comment')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withMessage('Comment created successfully')
                ->withData($this->commentService->getCommentResource($result->data))
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

    public function destroy(Comment $comment): JsonResponse
    {
        try {
            if (! auth()->user()->is_admin && auth()->id() !== $comment->user_id) {
                return ApiResponse::withMessage('Unauthorized action.')
                    ->withStatus(403)
                    ->build()
                    ->response();
            }

            $result = $this->commentService->deleteComment($comment);

            if (! $result->ok) {
                return ApiResponse::withMessage('Failed to delete comment')
                    ->withStatus(500)
                    ->build()
                    ->response();
            }

            return ApiResponse::withMessage('Comment deleted successfully')
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
