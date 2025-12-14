<?php

namespace drupol\htmltag;

use drupol\htmltag\Attribute\AttributeFactory;
use drupol\htmltag\Attributes\AttributesFactory;
use drupol\htmltag\Tag\TagFactory;

final class HtmlTag implements HtmlTagInterface
{
    public static function attribute($name, $value)
    {
        return AttributeFactory::build($name, $value);
    }

    public static function attributes(array $attributes = [])
    {
        return AttributesFactory::build($attributes);
    }

    public static function tag($name, array $attributes = [], $content = null)
    {
        return TagFactory::build($name, $attributes, $content);
    }
}