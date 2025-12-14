<?php

namespace Higgs\Events;

use Config\Modules;
use Config\Services;

class Events
{
    public const PRIORITY_LOW = 200;
    public const PRIORITY_NORMAL = 100;
    public const PRIORITY_HIGH = 10;
    protected static $listeners = [];
    protected static $initialized = false;
    protected static $simulate = false;
    protected static $performanceLog = [];
    protected static $files = [];

    public static function on($eventName, $callback, $priority = self::PRIORITY_NORMAL)
    {
        if (!isset(static::$listeners[$eventName])) {
            static::$listeners[$eventName] = [true, [$priority], [$callback],];
        } else {
            static::$listeners[$eventName][0] = false;
            static::$listeners[$eventName][1][] = $priority;
            static::$listeners[$eventName][2][] = $callback;
        }
    }

    public static function trigger($eventName, ...$arguments): bool
    {
        if (!static::$initialized) {
            static::initialize();
        }
        $listeners = static::listeners($eventName);
        foreach ($listeners as $listener) {
            $start = microtime(true);
            $result = static::$simulate === false ? $listener(...$arguments) : true;
            if (CI_DEBUG) {
                static::$performanceLog[] = ['start' => $start, 'end' => microtime(true), 'event' => strtolower($eventName),];
            }
            if ($result === false) {
                return false;
            }
        }
        return true;
    }

    public static function initialize()
    {
        if (static::$initialized) {
            return;
        }
        $config = config('Modules');
        $events = APPPATH . 'Config' . DIRECTORY_SEPARATOR . 'Events.php';
        $files = [];
        if ($config->shouldDiscover('events')) {
            $files = Services::locator()->search('Config/Events.php');
        }
        $files = array_filter(array_map(static function (string $file) {
            if (is_file($file)) {
                return realpath($file) ?: $file;
            }
            return false;
        }, $files));
        static::$files = array_unique(array_merge($files, [$events]));
        foreach (static::$files as $file) {
            include $file;
        }
        static::$initialized = true;
    }

    public static function listeners($eventName): array
    {
        if (!isset(static::$listeners[$eventName])) {
            return [];
        }
        if (!static::$listeners[$eventName][0]) {
            array_multisort(static::$listeners[$eventName][1], SORT_NUMERIC, static::$listeners[$eventName][2]);
            static::$listeners[$eventName][0] = true;
        }
        return static::$listeners[$eventName][2];
    }

    public static function removeListener($eventName, callable $listener): bool
    {
        if (!isset(static::$listeners[$eventName])) {
            return false;
        }
        foreach (static::$listeners[$eventName][2] as $index => $check) {
            if ($check === $listener) {
                unset(static::$listeners[$eventName][1][$index], static::$listeners[$eventName][2][$index]);
                return true;
            }
        }
        return false;
    }

    public static function removeAllListeners($eventName = null)
    {
        if ($eventName !== null) {
            unset(static::$listeners[$eventName]);
        } else {
            static::$listeners = [];
        }
    }

    public static function getFiles()
    {
        return static::$files;
    }

    public static function setFiles(array $files)
    {
        static::$files = $files;
    }

    public static function simulate(bool $choice = true)
    {
        static::$simulate = $choice;
    }

    public static function getPerformanceLogs()
    {
        return static::$performanceLog;
    }
}