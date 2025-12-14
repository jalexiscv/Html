<?php

namespace drupol\htmltag\Attribute;

use Exception;
use ReflectionClass;
use function class_implements;
use function in_array;
use function sprintf;

class AttributeFactory implements AttributeFactoryInterface
{
    public static $registry = ['*' => Attribute::class,];

    public static function build($name, $value = null)
    {
        return (new static())->getInstance($name, $value);
    }

    public function getInstance($name, $value = null)
    {
        $attribute_classname = isset(static::$registry[$name]) ? static::$registry[$name] : static::$registry['*'];
        if (!in_array(AttributeInterface::class, class_implements($attribute_classname), true)) {
            throw new Exception(sprintf('The class (%s) must implement the interface %s.', $attribute_classname, AttributeInterface::class));
        }
        $attribute = (new ReflectionClass($attribute_classname))->newInstanceArgs([$name, $value,]);
        return $attribute;
    }
}