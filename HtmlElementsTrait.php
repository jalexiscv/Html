<?php

declare(strict_types=1);

namespace Higgs\Html;

use Higgs\Html\Tag\TagInterface;
use InvalidArgumentException;

/**
 * Trait HtmlElementsTrait
 * Provides semantic HTML tag helper methods.
 */
trait HtmlElementsTrait
{
    /**
     * Creates a div element.
     */
    public static function div(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('div', $attributes, $content);
    }

    /**
     * Creates a span element.
     */
    public static function span(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('span', $attributes, $content);
    }

    /**
     * Creates a paragraph element.
     */
    public static function p(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('p', $attributes, $content);
    }

    /**
     * Creates an anchor element.
     */
    public static function a(string $href, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['href'] = $href;
        return self::tag('a', $attributes, $content);
    }

    /**
     * Creates an image element.
     */
    public static function img(string $src, string $alt = '', array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        $attributes['alt'] = $alt;
        return self::tag('img', $attributes);
    }

    /**
     * Creates an unordered list element.
     */
    public static function ul(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ul', $attributes, $content);
    }

    /**
     * Creates an ordered list element.
     */
    public static function ol(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ol', $attributes, $content);
    }

    /**
     * Creates a list item element.
     */
    public static function li(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('li', $attributes, $content);
    }

    /**
     * Creates an input element.
     */
    public static function input(string $type, string $name, ?string $value = null, array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        $attributes['name'] = $name;
        if ($value !== null) {
            $attributes['value'] = $value;
        }
        return self::tag('input', $attributes);
    }

    /**
     * Creates a button element.
     */
    public static function button(mixed $content, string $type = 'button', array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        return self::tag('button', $attributes, $content);
    }

    /**
     * Creates a script element.
     */
    public static function script(string $src = null, mixed $content = null, array $attributes = []): TagInterface
    {
        if ($src !== null) {
            $attributes['src'] = $src;
        }
        return self::tag('script', $attributes, $content);
    }

    /**
     * Creates a link element.
     */
    public static function link(string $rel, string $href, array $attributes = []): TagInterface
    {
        $attributes['rel'] = $rel;
        $attributes['href'] = $href;
        return self::tag('link', $attributes);
    }

    /**
     * Creates a meta element.
     */
    public static function meta(array $attributes = []): TagInterface
    {
        return self::tag('meta', $attributes);
    }

    /**
     * Crea un componente web personalizado
     */
    public static function webComponent(string $name, array $attributes = [], mixed $content = null): TagInterface
    {
        if (!str_contains($name, '-')) {
            throw new InvalidArgumentException('Web component names must contain a hyphen');
        }
        return self::tag($name, $attributes, $content);
    }
}
