<?php

namespace Higgs\Exceptions;

use RuntimeException;

class FrameworkException extends RuntimeException implements ExceptionInterface
{
    use DebugTraceableTrait;

    public static function forEnabledZlibOutputCompression()
    {
        return new static(lang('Core.enabledZlibOutputCompression'));
    }

    public static function forInvalidFile(string $path)
    {
        return new static(lang('Core.invalidFile', [$path]));
    }

    public static function forCopyError(string $path)
    {
        return new static(lang('Core.copyError', [$path]));
    }

    public static function forMissingExtension(string $extension)
    {
        if (strpos($extension, 'intl') !== false) {
            $message = sprintf('The framework needs the following extension(s) installed and loaded: %s.', $extension);
        } else {
            $message = lang('Core.missingExtension', [$extension]);
        }
        return new static($message);
    }

    public static function forNoHandlers(string $class)
    {
        return new static(lang('Core.noHandlers', [$class]));
    }

    public static function forFabricatorCreateFailed(string $table, string $reason)
    {
        return new static(lang('Fabricator.createFailed', [$table, $reason]));
    }
}