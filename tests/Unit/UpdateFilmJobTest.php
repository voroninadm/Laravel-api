<?php

use App\Contracts\FilmRepositoryInterface;
use App\Enums\FilmStatus;
use App\Jobs\FilmUpdateJob;
use App\Models\Film;
use App\Models\Genre;
use App\Services\FilmService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;

uses(RefreshDatabase::class);

it('updates a film and dispatches get comments job', function () {
    Queue::fake();

    $localFileUrl = 'http://example.localhost/storage/file.ext';
    $externalFileUrl = 'http://example.com/file.ext';

    $genres = Genre::factory(3)->create();
    $film = Film::factory()->pending()->create();

    $data = [
        'film' => $film,
        'genres' => $genres->pluck('name')->toArray(),
        'links' => [
            'poster_image' => $externalFileUrl,
        ],
    ];

    // Мокаем репозиторий через Pest helper
    $repository = mock(FilmRepositoryInterface::class, function (MockInterface $mock) use ($data) {
        $mock->shouldReceive('getFilm')->andReturn($data);
    });

    // Мокаем сервис через Pest helper
    $service = mock(FilmService::class, function (MockInterface $mock) use ($localFileUrl) {
        $mock->shouldReceive('saveFile')->andReturn($localFileUrl);
    });

    // Запускаем джоб
    (new FilmUpdateJob($film))->handle($repository, $service);

    $film->refresh();

    expect($film->status)->toBe(FilmStatus::OnModeration->value)
        ->and($film->poster_image)->toBe($localFileUrl);
});
