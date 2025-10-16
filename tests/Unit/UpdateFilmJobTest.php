<?php

namespace Tests\Unit;

use App\Contracts\FilmRepositoryInterface;
use App\Enums\FilmStatus;
use App\Jobs\FilmUpdateJob;
use App\Models\Film;
use App\Models\Genre;
use App\Services\FilmService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateFilmJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_a_film_and_dispatches_get_comments_job()
    {
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

        $this->mock(FilmRepositoryInterface::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('getFilm')->andReturn($data);
        });

        $this->mock(FilmService::class, function (MockInterface $mock) use ($localFileUrl) {
            $mock->shouldReceive('saveFile')->andReturn($localFileUrl);
        });

        (new FilmUpdateJob($film))->handle(
            app(FilmRepositoryInterface::class),
            app(FilmService::class)
        );

        $this->assertEquals(FilmStatus::OnModeration->value, $film->refresh()->status);
        $this->assertEquals($localFileUrl, $film->poster_image);
    }
}
