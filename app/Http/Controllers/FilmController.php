<?php

namespace App\Http\Controllers;

use App\Enums\FilmStatus;
use App\Http\Requests\Film\AddFilmRequest;
use App\Http\Requests\Film\UpdateFilmRequest;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use App\Services\FilmService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index(Request $request, FilmService $service)
    {
        $films = Film::select(Film::FIELDS_LIST)
            ->filterByGenre($request->genre)
            ->filterByStatus($request->status, $request->user())
            ->ordered($request->order_by, $request->order_to)
            ->paginate(8);

        $service->listResourceWrap($films);

        return $this->paginatedResponse($films);
    }

    public function show(Film $film): Responsable
    {
        return $this->successResponse(new FilmResource($film));
    }

    public function store(AddFilmRequest $request)
    {
        Film::create([
            'imdb_id' => $request->input('imdb'),
            'status' => FilmStatus::Pending,
        ]);

        return $this->successResponse(null, 201);
    }

    public function update( UpdateFilmRequest $request, Film $film)
    {
        $film->update($request->validated());
        return $this->successResponse([
            'message' => 'Фильм успешно обновлен.',
        ]);
    }

    public function similar(Film $film, FilmService $service)
    {
        $similarFilms = Film::with('genres')
            ->whereHas('genres', function ($query) use ($film) {
                $query->whereIn('genres.id',
                    $film->genres()->pluck('genres.id')
                );
            })
            ->where('id', '!=', $film->id)
            ->inRandomOrder()
            ->paginate(4);

        $service->listResourceWrap($similarFilms);

        return $this->paginatedResponse($similarFilms);
    }

}
