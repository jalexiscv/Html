<?php

namespace Higgs\Entity\Cast;
class BooleanCast extends BaseCast
{
    public static function get($value, array $params = []): bool
    {
        return (bool)$value;
    }
}