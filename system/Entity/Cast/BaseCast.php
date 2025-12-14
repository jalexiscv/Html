<?php

namespace Higgs\Entity\Cast;
abstract class BaseCast implements CastInterface
{
    public static function get($value, array $params = [])
    {
        return $value;
    }

    public static function set($value, array $params = [])
    {
        return $value;
    }
}