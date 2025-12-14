<?php

namespace Higgs\Entity\Cast;
class FloatCast extends BaseCast
{
    public static function get($value, array $params = []): float
    {
        return (float)$value;
    }
}