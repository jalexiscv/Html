<?php

namespace Higgs\Entity\Cast;
final class IntBoolCast extends BaseCast
{
    public static function get($value, array $params = []): bool
    {
        return (bool)$value;
    }

    public static function set($value, array $params = []): int
    {
        return (int)$value;
    }
}