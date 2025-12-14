<?php

namespace Higgs\Entity\Cast;
interface CastInterface
{
    public static function get($value, array $params = []);

    public static function set($value, array $params = []);
}