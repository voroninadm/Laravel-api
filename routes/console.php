<?php

use App\Jobs\FilmsUpdateJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('sanctum:prune-expired --hours=24')->daily();
Schedule::job(new FilmsUpdateJob)->dailyAt('04:00');
