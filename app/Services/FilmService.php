<?php

namespace App\Services;

use App\Http\Resources\FilmListResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmService
{
    /** Сохраняем файлы с постерами и тд по ссылке
     * @param string $url
     * @param string $type
     * @param string $film_id
     * @return string
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function saveFile(string $url, string $type, string $film_id): string
    {
        // Храним файл с hash суффиксом - предотвращает перезапись файлов и кеширование старых версий
        // Ограничиваем количество файлов в одной папке

        // Выполняем запрос и проверяем успешность
        $response = Http::timeout(10)->throw()->get($url)->body();
        $ext = pathinfo($url, PATHINFO_EXTENSION);

        // Добавляем hash
        $hashedName = $film_id . '-' . Str::random(8) . '.' . $ext;

        // Формируем путь с поддиректорией (для ограничения количества файлов в папке)
        $subfolder = substr(md5($film_id), 0, 2);
        $path = "{$type}/{$subfolder}/{$hashedName}";

        Storage::disk('public')->put($path, $response);

        return Storage::disk('public')->url($path);
    }

    /** Оборачиваем коллекцию фильмов в возвращаемый листинг-ресурс
     * @param LengthAwarePaginator $collection
     * @return string
     */
    public function listResourceWrap(LengthAwarePaginator $collection): string
    {
        return $collection->getCollection()->transform(function ($film) {
                return new FilmListResource($film);
            });
    }
}
