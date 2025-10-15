<?php

namespace App\Jobs;

use App\Enums\FilmStatus;
use App\Models\Film;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FilmsUpdateJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Film::where('status', FilmStatus::Pending)->chunk(500, function ($films) {
            foreach ($films as $film) {
                FilmUpdateJob::dispatch($film);
            }
        });
    }
}
