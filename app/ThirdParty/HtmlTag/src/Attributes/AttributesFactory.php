<?php

namespace drupol\htmltag\Attributes;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attribute\AttributeFactoryInterface;
use ReflectionClass;

class AttributesFactory implements AttributesFactoryInterface
{
    public static $registry = ['attribute_factory' => AttributeFactory::class, '*' => Attributes::class,];

    public static function build(array $attributes = [])
    {
        return (new static())->getInstance($attributes);
    }

    public function getInstance(array $attributes = [])
    {
        $attribute_factory_classname = static::$registry['attribute_factory'];
        $attribute_factory_classname = (new ReflectionClass($attribute_factory_classname))->newInstance();
        $attributes_classname = static::$registry['*'];
        $attributes = (new ReflectionClass($attributes_classname))->newInstanceArgs([$attribute_factory_classname, $attributes,]);
        return $attributes;
    }
}