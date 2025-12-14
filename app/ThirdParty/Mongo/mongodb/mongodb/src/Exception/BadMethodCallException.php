<?php

namespace MongoDB\Exception;

use BadMethodCallException as BaseBadMethodCallException;
use function sprintf;

class BadMethodCallException extends BaseBadMethodCallException implements Exception
{
    public static function classIsImmutable(string $class)
    {
        return new static(sprintf('%s is immutable', $class));
    }

    public static function unacknowledgedWriteResultAccess(string $method)
    {
        return new static(sprintf('%s should not be called for an unacknowledged write result', $method));
    }
}