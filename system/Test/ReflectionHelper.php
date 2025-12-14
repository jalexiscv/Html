<?php

namespace Higgs\Test;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionObject;
use ReflectionProperty;

trait ReflectionHelper
{
    public static function getPrivateMethodInvoker($obj, $method)
    {
        $refMethod = new ReflectionMethod($obj, $method);
        $refMethod->setAccessible(true);
        $obj = (gettype($obj) === 'object') ? $obj : null;
        return static fn(...$args) => $refMethod->invokeArgs($obj, $args);
    }

    public static function setPrivateProperty($obj, $property, $value)
    {
        $refProperty = self::getAccessibleRefProperty($obj, $property);
        $refProperty->setValue($obj, $value);
    }

    private static function getAccessibleRefProperty($obj, $property)
    {
        $refClass = is_object($obj) ? new ReflectionObject($obj) : new ReflectionClass($obj);
        $refProperty = $refClass->getProperty($property);
        $refProperty->setAccessible(true);
        return $refProperty;
    }

    public static function getPrivateProperty($obj, $property)
    {
        $refProperty = self::getAccessibleRefProperty($obj, $property);
        return is_string($obj) ? $refProperty->getValue() : $refProperty->getValue($obj);
    }
}