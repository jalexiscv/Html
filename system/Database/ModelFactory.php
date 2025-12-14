<?php

namespace Higgs\Database;

use Higgs\Config\Factories;

class ModelFactory
{
    public static function get(string $name, bool $getShared = true, ?ConnectionInterface $connection = null)
    {
        return Factories::models($name, ['getShared' => $getShared], $connection);
    }

    public static function injectMock(string $name, $instance)
    {
        Factories::injectMock('models', $name, $instance);
    }

    public static function reset()
    {
        Factories::reset('models');
    }
}