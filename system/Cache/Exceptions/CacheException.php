<?php

namespace Higgs\Cache\Exceptions;

use Higgs\Exceptions\DebugTraceableTrait;
use Higgs\Exceptions\ExceptionInterface;
use RuntimeException;

class CacheException extends RuntimeException implements ExceptionInterface
{
    use DebugTraceableTrait;

    public static function forUnableToWrite(string $path)
    {
        return new static(lang('Cache.unableToWrite', [$path]));
    }

    public static function forInvalidHandlers()
    {
        return new static(lang('Cache.invalidHandlers'));
    }

    public static function forNoBackup()
    {
        return new static(lang('Cache.noBackup'));
    }

    public static function forHandlerNotFound()
    {
        return new static(lang('Cache.handlerNotFound'));
    }
}