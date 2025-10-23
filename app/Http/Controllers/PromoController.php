<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoRequest;
use App\Models\Film;

class PromoController extends Controller
{
    public function show()
    {
        $film = cache()->remember(Film::CACHE_PROMO_KEY, now()->addDay(), function () {
            return Film::promo()->latest('updated_at')->first();
        });

        return $this->successResponse($film);
    }

    public function store(PromoRequest $request, Film $film)
    {
        $film->update(['is_promo' => $request->boolean('is_promo')]);
        // сбрасываем кэш сразу - на случай false для промо
        cache()->forget(Film::CACHE_PROMO_KEY);

        return $this->successResponse([
            'message' => 'Данные фильма успешно обновлены.',
        ], 201);
    }
}
