<?php

namespace Higgs\Config;

use Config\Encryption;
use Config\Modules;
use Config\Services;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

class BaseConfig
{
    public static $registrars = [];
    protected static $didDiscovery = false;
    protected static $moduleConfig;

    public function __construct()
    {
        static::$moduleConfig = config('Modules');
        $this->registerProperties();
        $properties = array_keys(get_object_vars($this));
        $prefix = static::class;
        $slashAt = strrpos($prefix, '\\');
        $shortPrefix = strtolower(substr($prefix, $slashAt === false ? 0 : $slashAt + 1));
        foreach ($properties as $property) {
            $this->initEnvValue($this->{$property}, $property, $prefix, $shortPrefix);
            if ($this instanceof Encryption && $property === 'key') {
                if (strpos($this->{$property}, 'hex2bin:') === 0) {
                    $this->{$property} = hex2bin(substr($this->{$property}, 8));
                } elseif (strpos($this->{$property}, 'base64:') === 0) {
                    $this->{$property} = base64_decode(substr($this->{$property}, 7), true);
                }
            }
        }
    }

    protected function registerProperties()
    {
        if (!static::$moduleConfig->shouldDiscover('registrars')) {
            return;
        }
        if (!static::$didDiscovery) {
            $locator = Services::locator();
            $registrarsFiles = $locator->search('Config/Registrar.php');
            foreach ($registrarsFiles as $file) {
                $className = $locator->getClassname($file);
                static::$registrars[] = new $className();
            }
            static::$didDiscovery = true;
        }
        $shortName = (new ReflectionClass($this))->getShortName();
        foreach (static::$registrars as $callable) {
            if (!method_exists($callable, $shortName)) {
                continue;
            }
            $properties = $callable::$shortName();
            if (!is_array($properties)) {
                throw new RuntimeException('Registrars must return an array of properties and their values.');
            }
            foreach ($properties as $property => $value) {
                if (isset($this->{$property}) && is_array($this->{$property}) && is_array($value)) {
                    $this->{$property} = array_merge($this->{$property}, $value);
                } else {
                    $this->{$property} = $value;
                }
            }
        }
    }

    protected function initEnvValue(&$property, string $name, string $prefix, string $shortPrefix)
    {
        if (is_array($property)) {
            foreach (array_keys($property) as $key) {
                $this->initEnvValue($property[$key], "{$name}.{$key}", $prefix, $shortPrefix);
            }
        } elseif (($value = $this->getEnvValue($name, $prefix, $shortPrefix)) !== false && $value !== null) {
            if ($value === 'false') {
                $value = false;
            } elseif ($value === 'true') {
                $value = true;
            }
            if (is_bool($value)) {
                $property = $value;
                return;
            }
            $value = trim($value, '\'"');
            if (is_int($property)) {
                $value = (int)$value;
            } elseif (is_float($property)) {
                $value = (float)$value;
            }
            $property = $value;
        }
    }

    protected function getEnvValue(string $property, string $prefix, string $shortPrefix)
    {
        $shortPrefix = ltrim($shortPrefix, '\\');
        $underscoreProperty = str_replace('.', '_', $property);
        switch (true) {
            case array_key_exists("{$shortPrefix}.{$property}", $_ENV):
                return $_ENV["{$shortPrefix}.{$property}"];
            case array_key_exists("{$shortPrefix}_{$underscoreProperty}", $_ENV):
                return $_ENV["{$shortPrefix}_{$underscoreProperty}"];
            case array_key_exists("{$shortPrefix}.{$property}", $_SERVER):
                return $_SERVER["{$shortPrefix}.{$property}"];
            case array_key_exists("{$shortPrefix}_{$underscoreProperty}", $_SERVER):
                return $_SERVER["{$shortPrefix}_{$underscoreProperty}"];
            case array_key_exists("{$prefix}.{$property}", $_ENV):
                return $_ENV["{$prefix}.{$property}"];
            case array_key_exists("{$prefix}_{$underscoreProperty}", $_ENV):
                return $_ENV["{$prefix}_{$underscoreProperty}"];
            case array_key_exists("{$prefix}.{$property}", $_SERVER):
                return $_SERVER["{$prefix}.{$property}"];
            case array_key_exists("{$prefix}_{$underscoreProperty}", $_SERVER):
                return $_SERVER["{$prefix}_{$underscoreProperty}"];
            default:
                $value = getenv("{$shortPrefix}.{$property}");
                $value = $value === false ? getenv("{$shortPrefix}_{$underscoreProperty}") : $value;
                $value = $value === false ? getenv("{$prefix}.{$property}") : $value;
                $value = $value === false ? getenv("{$prefix}_{$underscoreProperty}") : $value;
                return $value === false ? null : $value;
        }
    }
}