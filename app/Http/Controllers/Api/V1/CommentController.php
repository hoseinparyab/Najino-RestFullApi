<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use App\Models\Comment;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request): JsonResponse
    {
        $comment = $this->commentService->createComment($request->validated());

        return response()->json([
            'message' => 'Comment submitted successfully. Waiting for admin approval.',
            'comment' => $this->commentService->getCommentResource($comment)
        ], 201);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        if (!auth()->user()->is_admin && auth()->id() !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $this->commentService->deleteComment($comment);
        return response()->json(['message' => 'Comment deleted successfully.'], 200);
    }

    public function approve(Comment $comment): JsonResponse
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $approvedComment = $this->commentService->approveComment($comment);
        return response()->json([
            'message' => 'Comment approved successfully.',
            'comment' => $this->commentService->getCommentResource($approvedComment)
        ], 200);
    }

    public function pending(): JsonResponse
    {
        $pendingComments = $this->commentService->getPendingComments();
        return response()->json([
            'comments' => $this->commentService->getCommentCollection($pendingComments)
        ], 200);
    }
}
