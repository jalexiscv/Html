<?php

namespace Higgs\Entity\Cast;
class CSVCast extends BaseCast
{
    public static function get($value, array $params = []): array
    {
        return explode(',', $value);
    }

    public static function set($value, array $params = []): string
    {
        return implode(',', $value);
    }
}