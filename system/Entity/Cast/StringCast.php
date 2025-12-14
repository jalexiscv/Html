<?php

namespace Higgs\Entity\Cast;
class StringCast extends BaseCast
{
    public static function get($value, array $params = []): string
    {
        return (string)$value;
    }
}