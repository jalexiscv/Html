<?php

namespace MongoDB\Exception;

use MongoDB\Driver\Exception\InvalidArgumentException as DriverInvalidArgumentException;
use function array_pop;
use function count;
use function get_debug_type;
use function implode;
use function is_array;
use function sprintf;

class InvalidArgumentException extends DriverInvalidArgumentException implements Exception
{
    public static function invalidType(string $name, $value, $expectedType)
    {
        if (is_array($expectedType)) {
            switch (count($expectedType)) {
                case 1:
                    $typeString = array_pop($expectedType);
                    break;
                case 2:
                    $typeString = implode('" or "', $expectedType);
                    break;
                default:
                    $lastType = array_pop($expectedType);
                    $typeString = sprintf('%s", or "%s', implode('", "', $expectedType), $lastType);
                    break;
            }
            $expectedType = $typeString;
        }
        return new static(sprintf('Expected %s to have type "%s" but found "%s"', $name, $expectedType, get_debug_type($value)));
    }
}