<?php

namespace App\Http\Controllers;

use App\Models\Film;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::with('genres')->paginate(8);

        return response()->json([
            'films' =>$films,
        ], 201);
    }

    public function show($id)
    {
        $film = Film::with('genres')->findOrFail($id);
        return response()->json([
            'film' =>$film,
        ]);
    }
}
