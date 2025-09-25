<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Film $film)
    {
        return "comments to film";
    }

    public function store(Request $request, Film $film)
    {
        return "add new comment to film";
    }

    public function update(Request $request, Film $film)
    {
        return "update comment to film";
    }

    public function destroy(Request $request, Film $film)
    {
        return "delete comment to film";
    }
}
