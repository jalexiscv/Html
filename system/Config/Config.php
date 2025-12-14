<?php

namespace Higgs\Config;
class Config
{
    public $logDeprecations;
    public $deprecationLogLevel;

    public static function get(string $name, bool $getShared = true)
    {
        return Factories::config($name, ['getShared' => $getShared]);
    }

    public static function injectMock(string $name, $instance)
    {
        Factories::injectMock('config', $name, $instance);
    }

    public static function reset()
    {
        Factories::reset('config');
    }
}