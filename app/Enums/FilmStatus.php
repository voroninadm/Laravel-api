<?php

namespace App\Enums;

enum FilmStatus: string
{
    case Pending = 'pending';
    case OnModeration = 'moderate';
    case Ready = 'ready';
}
