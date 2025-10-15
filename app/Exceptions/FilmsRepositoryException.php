<?php

namespace App\Exceptions;

use Exception;

class FilmsRepositoryException extends Exception
{
    public function getStatusCode(): int
    {
        return 500;
    }
}
