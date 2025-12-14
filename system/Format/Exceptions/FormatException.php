<?php

namespace Higgs\Format\Exceptions;

use Higgs\Exceptions\DebugTraceableTrait;
use Higgs\Exceptions\ExceptionInterface;
use RuntimeException;

class FormatException extends RuntimeException implements ExceptionInterface
{
    use DebugTraceableTrait;

    public static function forInvalidFormatter(string $class)
    {
        return new static(lang('Format.invalidFormatter', [$class]));
    }

    public static function forInvalidJSON(?string $error = null)
    {
        return new static(lang('Format.invalidJSON', [$error]));
    }

    public static function forInvalidMime(string $mime)
    {
        return new static(lang('Format.invalidMime', [$mime]));
    }

    public static function forMissingExtension()
    {
        return new static(lang('Format.missingExtension'));
    }
}