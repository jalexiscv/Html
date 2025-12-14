<?php

namespace Higgs\Entity\Cast;

use Higgs\HTTP\URI;

class URICast extends BaseCast
{
    public static function get($value, array $params = []): URI
    {
        return $value instanceof URI ? $value : new URI($value);
    }
}