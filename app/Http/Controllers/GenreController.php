<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return $this->successResponse($genres);
    }

    public function update (GenreRequest $request,Genre $genre)
    {
        $genre->update($request->validated());
        return $this->successResponse($genre->fresh());
    }
}
