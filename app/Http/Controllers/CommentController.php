<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index(Film $film)
    {
        $comments = $film->comments()->orderBy('created_at', 'desc')
            ->with('author:id,name')->get();

        return $this->successResponse(CommentResource::collection($comments));
    }

    public function store(Request $request, Comment $comment)
    {
        return "add new comment to film";
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('comment.update', $comment);

        return "update comment to film";
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('comment.delete', $comment);
        $comment->delete();

        return $this->successResponse([
            'message' => 'Комментарий успешно удален.',
        ]);
    }
}
