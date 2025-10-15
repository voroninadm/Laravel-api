<?php

namespace App\Jobs;

use App\Contracts\FilmRepositoryInterface;
use App\Enums\FilmStatus;
use App\Exceptions\FilmsRepositoryException;
use App\Models\Film;
use App\Models\Genre;
use App\Services\FilmService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class FilmUpdateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Film $film)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(FilmRepositoryInterface $repository, FilmService $service): void
    {
        $data = $repository->getFilm($this->film->imdb_id);

        if(empty($data)) {
            throw new FilmsRepositoryException('Отсутствуют данные для обновления');
        }

        $this->film = $data['film'];

        // Скачивание файлов и установка значений
        foreach ($data['links'] as $field => $link) {
            if (!empty($link)) {
                $this->film->$field = $service->saveFile($link, $field, $this->film->id);
            }
        }

        DB::beginTransaction();

        $genresIds = [];
        foreach ($data['genres'] as $genre) {
            $genresIds[] = Genre::firstOrCreate(['name' => $genre])->id;
        }

        $this->film->status = FilmStatus::OnModeration;
        $this->film->save();
        $this->film->genres()->attach($genresIds);

        DB::commit();
    }
}
