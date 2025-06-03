<?php

namespace App\Services;

use App\Base\ServiceResult;
use App\Base\ServiceWrapper;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function createComment(array $data): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($data) {
            return Comment::create([
                'content' => $data['content'],
                'article_id' => $data['article_id'],
                'user_id' => Auth::id(),
            ]);
        });
    }

    public function deleteComment(Comment $comment): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($comment) {
            return $comment->delete();
        });
    }

    public function getCommentResource(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }

    public function getCommentCollection($comments): CommentCollection
    {
        return new CommentCollection($comments);
    }
}
