<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index(Comment $comment)
    {
        return "comments to film";
    }

    public function store(Request $request, Comment $comment)
    {
        return "add new comment to film";
    }

    public function update(Request $request, Comment $comment)
    {
        return "update comment to film";
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete-comment', $comment);
        $comment->delete();

        return $this->successResponse([
            'message' => 'Комментарий успешно удален.',
        ]);
    }
}
