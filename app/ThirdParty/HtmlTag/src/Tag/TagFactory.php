<?php

namespace drupol\htmltag\Tag;

use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Attributes\AttributesInterface;
use Exception;
use ReflectionClass;
use function class_implements;
use function in_array;
use function sprintf;

class TagFactory implements TagFactoryInterface
{
    public static $registry = ['attributes_factory' => AttributesFactory::class, '!--' => Comment::class, '*' => Tag::class,];

    public static function build($name, array $attributes = [], $content = null)
    {
        return (new static())->getInstance($name, $attributes, $content);
    }

    public function getInstance($name, array $attributes = [], $content = null)
    {
        $attributes_factory_classname = static::$registry['attributes_factory'];
        $attributes = $attributes_factory_classname::build($attributes);
        $tag_classname = isset(static::$registry[$name]) ? static::$registry[$name] : static::$registry['*'];
        if (!in_array(TagInterface::class, class_implements($tag_classname), true)) {
            throw new Exception(sprintf('The class (%s) must implement the interface %s.', $tag_classname, TagInterface::class));
        }
        $tag = (new ReflectionClass($tag_classname))->newInstanceArgs([$attributes, $name, $content,]);
        return $tag;
    }
}