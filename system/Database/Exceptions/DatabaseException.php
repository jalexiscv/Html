<?php

namespace Higgs\Database\Exceptions;

use Higgs\Exceptions\HasExitCodeInterface;
use Error;

class DatabaseException extends Error implements ExceptionInterface, HasExitCodeInterface
{
    public function getExitCode(): int
    {
        return EXIT_DATABASE;
    }
}