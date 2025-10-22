<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoRequest;
use App\Models\Film;


class PromoController extends Controller
{
    public function show()
    {
        return "show promo film";
    }

    public function store(PromoRequest $request, Film $film)
    {
        $film->update(['is_promo' => $request->boolean('is_promo')]);

        cache()->forget(Film::CACHE_PROMO_KEY);

        return $this->successResponse([
            'message' => 'Данные фильма успешно обновлены.',
        ], 201);
    }
}
