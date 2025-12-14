<?php

namespace Higgs\Database;

use Higgs\Config\BaseConfig;
use Config\Database as DbConfig;
use InvalidArgumentException;

class Config extends BaseConfig
{
    protected static $instances = [];
    protected static $factory;

    public static function getConnections(): array
    {
        return static::$instances;
    }

    public static function forge($group = null)
    {
        $db = static::connect($group);
        return static::$factory->loadForge($db);
    }

    public static function connect($group = null, bool $getShared = true)
    {
        if ($group instanceof BaseConnection) {
            return $group;
        }
        if (is_array($group)) {
            $config = $group;
            $group = 'custom-' . md5(json_encode($config));
        } else {
            $dbConfig = config('Database');
            if ($group === null) {
                $group = (ENVIRONMENT === 'testing') ? 'tests' : $dbConfig->defaultGroup;
            }
            assert(is_string($group));
            if (!isset($dbConfig->{$group})) {
                throw new InvalidArgumentException($group . ' is not a valid database connection group.');
            }
            $config = $dbConfig->{$group};
        }
        if ($getShared && isset(static::$instances[$group])) {
            return static::$instances[$group];
        }
        static::ensureFactory();
        $connection = static::$factory->load($config, $group);
        static::$instances[$group] = $connection;
        return $connection;
    }

    protected static function ensureFactory()
    {
        if (static::$factory instanceof Database) {
            return;
        }
        static::$factory = new Database();
    }

    public static function utils($group = null)
    {
        $db = static::connect($group);
        return static::$factory->loadUtils($db);
    }

    public static function seeder(?string $group = null)
    {
        $config = config('Database');
        return new Seeder($config, static::connect($group));
    }
}