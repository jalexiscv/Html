<?php

namespace Higgs\Files\Exceptions;

use Higgs\Exceptions\DebugTraceableTrait;
use Higgs\Exceptions\ExceptionInterface;
use RuntimeException;

class FileNotFoundException extends RuntimeException implements ExceptionInterface
{
    use DebugTraceableTrait;

    public static function forFileNotFound(string $path)
    {
        return new static(lang('Files.fileNotFound', [$path]));
    }
}