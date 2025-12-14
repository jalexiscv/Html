<?php

namespace Higgs\Entity\Cast;
class IntegerCast extends BaseCast
{
    public static function get($value, array $params = []): int
    {
        return (int)$value;
    }
}