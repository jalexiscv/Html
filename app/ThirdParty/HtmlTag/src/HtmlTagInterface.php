<?php

namespace drupol\htmltag;

use drupol\htmltag\Attribute\AttributeInterface;
use drupol\htmltag\Attributes\AttributesInterface;
use drupol\htmltag\Tag\TagInterface;

interface HtmlTagInterface
{
    public static function attribute($name, $value);

    public static function attributes(array $attributes = []);

    public static function tag($name, array $attributes = [], $content = null);
}