<?php

namespace Higgs\Entity\Cast;
class ArrayCast extends BaseCast
{
    public static function get($value, array $params = []): array
    {
        if (is_string($value) && (strpos($value, 'a:') === 0 || strpos($value, 's:') === 0)) {
            $value = unserialize($value);
        }
        return (array)$value;
    }

    public static function set($value, array $params = []): string
    {
        return serialize($value);
    }
}