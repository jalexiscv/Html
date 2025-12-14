<?php

namespace Higgs\CLI\Exceptions;

use Higgs\Exceptions\DebugTraceableTrait;
use RuntimeException;

class CLIException extends RuntimeException
{
    use DebugTraceableTrait;

    public static function forInvalidColor(string $type, string $color)
    {
        return new static(lang('CLI.invalidColor', [$type, $color]));
    }
}