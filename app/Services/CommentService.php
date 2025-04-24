<?php

namespace App\Services;

use App\Models\Comment;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentCollection;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function createComment(array $data): Comment
    {
        return Comment::create([
            'content' => $data['content'],
            'article_id' => $data['article_id'],
            'user_id' => Auth::id(),
            'is_approved' => false
        ]);
    }

    public function deleteComment(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function approveComment(Comment $comment, array $data): Comment
    {
        $comment->update([
            'is_approved' => $data['is_approved'],
            'rejection_reason' => $data['rejection_reason'] ?? null
        ]);
        return $comment;
    }

    public function getPendingComments()
    {
        return Comment::where('is_approved', false)
            ->with(['user', 'article'])
            ->get();
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
