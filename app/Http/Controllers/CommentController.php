<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Film;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index(Film $film)
    {
        $comments = $film->comments()->orderBy('created_at', 'desc')
            ->with('author:id,name')->get();

        return $this->successResponse(CommentResource::collection($comments));
    }

    public function store(Film $film, CommentRequest $request)
    {
        $film->comments()->create([
            'rating' => $request->rating,
            'text' => $request->text,
            'user_id' => Auth::id(),
        ]);

        return $this->successResponse([
            'message' => 'Комментарий успешно создан.',
        ], 201);
    }

    public function update(Comment $comment, CommentRequest $request)
    {
        Gate::authorize('comment.update', $comment);

        $comment->update($request->validated());
        return $this->successResponse([
            'message' => 'Комментарий успешно обновлен.'
        ]);
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
