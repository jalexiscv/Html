<?php

namespace Higgs\Entity\Cast;
class ObjectCast extends BaseCast
{
    public static function get($value, array $params = []): object
    {
        return (object)$value;
    }
}