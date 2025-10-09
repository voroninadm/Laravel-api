<?php

namespace App\Contracts;

interface FilmRepositoryInterface
{
    // TODO: прописать типы данных
    public function getFilm(string $imdbId);
}
