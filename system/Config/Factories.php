<?php

namespace Higgs\Config;

use Higgs\Database\ConnectionInterface;
use Higgs\Model;
use Config\Services;

class Factories
{
    protected static $options = [];
    protected static $basenames = [];
    protected static $instances = [];
    private static array $configOptions = ['component' => 'config', 'path' => 'Config', 'instanceOf' => null, 'getShared' => true, 'preferApp' => true,];

    public static function models(string $name, array $options = [], ?ConnectionInterface &$conn = null)
    {
        return self::__callStatic('models', [$name, $options, $conn]);
    }

    public static function __callStatic(string $component, array $arguments)
    {
        $name = trim(array_shift($arguments), '\\ ');
        $options = array_shift($arguments) ?? [];
        $options = array_merge(self::getOptions(strtolower($component)), $options);
        if (!$options['getShared']) {
            if ($class = self::locateClass($options, $name)) {
                return new $class(...$arguments);
            }
            return null;
        }
        $basename = self::getBasename($name);
        if (isset(self::$basenames[$options['component']][$basename])) {
            $class = self::$basenames[$options['component']][$basename];
            if (self::verifyInstanceOf($options, $class)) {
                return self::$instances[$options['component']][$class];
            }
        }
        if (!$class = self::locateClass($options, $name)) {
            return null;
        }
        self::$instances[$options['component']][$class] = new $class(...$arguments);
        self::$basenames[$options['component']][$basename] = $class;
        return self::$instances[$options['component']][$class];
    }

    public static function getOptions(string $component): array
    {
        $component = strtolower($component);
        if (isset(self::$options[$component])) {
            return self::$options[$component];
        }
        $values = $component === 'config' ? self::$configOptions : config('Factory')->{$component} ?? [];
        return self::setOptions($component, $values);
    }

    public static function setOptions(string $component, array $values): array
    {
        $values['component'] = strtolower($values['component'] ?? $component);
        self::reset($values['component']);
        $values['path'] = trim($values['path'] ?? ucfirst($values['component']), '\\ ');
        $values = array_merge(Factory::$default, $values);
        self::$options[$component] = $values;
        self::$options[$values['component']] = $values;
        return $values;
    }

    public static function getBasename(string $name): string
    {
        if ($basename = strrchr($name, '\\')) {
            return substr($basename, 1);
        }
        return $name;
    }

    public static function reset(?string $component = null)
    {
        if ($component) {
            unset(static::$options[$component], static::$basenames[$component], static::$instances[$component]);
            return;
        }
        static::$options = [];
        static::$basenames = [];
        static::$instances = [];
    }

    public static function injectMock(string $component, string $name, object $instance)
    {
        $component = strtolower($component);
        self::getOptions($component);
        $class = get_class($instance);
        $basename = self::getBasename($name);
        self::$instances[$component][$class] = $instance;
        self::$basenames[$component][$basename] = $class;
    }

    protected static function locateClass(array $options, string $name): ?string
    {
        if (class_exists($name, false) && self::verifyPreferApp($options, $name) && self::verifyInstanceOf($options, $name)) {
            return $name;
        }
        $basename = self::getBasename($name);
        $appname = $options['component'] === 'config' ? 'Config\\' . $basename : rtrim(APP_NAMESPACE, '\\') . '\\' . $options['path'] . '\\' . $basename;
        if ($options['preferApp'] && class_exists($appname) && self::verifyInstanceOf($options, $name)) {
            return $appname;
        }
        if (class_exists($name) && self::verifyInstanceOf($options, $name)) {
            return $name;
        }
        $locator = Services::locator();
        if (strpos($name, '\\') !== false) {
            if (!$file = $locator->locateFile($name, $options['path'])) {
                return null;
            }
            $files = [$file];
        } elseif (!$files = $locator->search($options['path'] . DIRECTORY_SEPARATOR . $name)) {
            return null;
        }
        foreach ($files as $file) {
            $class = $locator->getClassname($file);
            if ($class && self::verifyInstanceOf($options, $class)) {
                return $class;
            }
        }
        return null;
    }

    protected static function verifyPreferApp(array $options, string $name): bool
    {
        if (!$options['preferApp']) {
            return true;
        }
        if ($options['component'] === 'config') {
            return strpos($name, 'Config') === 0;
        }
        return strpos($name, APP_NAMESPACE) === 0;
    }

    protected static function verifyInstanceOf(array $options, string $name): bool
    {
        if (!$options['instanceOf']) {
            return true;
        }
        return is_a($name, $options['instanceOf'], true);
    }
}