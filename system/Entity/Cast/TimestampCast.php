<?php

namespace Higgs\Entity\Cast;

use Higgs\Entity\Exceptions\CastException;

class TimestampCast extends BaseCast
{
    public static function get($value, array $params = [])
    {
        $value = strtotime($value);
        if ($value === false) {
            throw CastException::forInvalidTimestamp();
        }
        return $value;
    }
}