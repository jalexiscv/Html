<?php

namespace MongoDB\Exception;

use function get_debug_type;
use function sprintf;

class ResumeTokenException extends RuntimeException
{
    public static function invalidType($value)
    {
        return new static(sprintf('Expected resume token to have type "array or object" but found "%s"', get_debug_type($value)));
    }

    public static function notFound()
    {
        return new static('Resume token not found in change document');
    }
}