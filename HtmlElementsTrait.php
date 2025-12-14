<?php

declare(strict_types=1);

namespace Higgs\Html;

use Higgs\Html\Tag\TagInterface;
use InvalidArgumentException;

/**
 * Trait HtmlElementsTrait
 * Provee métodos de ayuda para etiquetas HTML semánticas.
 */
trait HtmlElementsTrait
{
    /**
     * Crea un elemento div.
     */
    public static function div(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('div', $attributes, $content);
    }

    /**
     * Crea un elemento span.
     */
    public static function span(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('span', $attributes, $content);
    }

    /**
     * Crea un elemento de párrafo (p).
     */
    public static function p(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('p', $attributes, $content);
    }

    /**
     * Crea un elemento de enlace (a).
     */
    public static function a(string $href, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['href'] = $href;
        return self::tag('a', $attributes, $content);
    }

    /**
     * Crea un elemento de imagen (img).
     */
    public static function img(string $src, string $alt = '', array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        $attributes['alt'] = $alt;
        return self::tag('img', $attributes);
    }

    /**
     * Crea un elemento de lista desordenada (ul).
     */
    public static function ul(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ul', $attributes, $content);
    }

    /**
     * Crea un elemento de lista ordenada (ol).
     */
    public static function ol(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ol', $attributes, $content);
    }

    /**
     * Crea un elemento de ítem de lista (li).
     */
    public static function li(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('li', $attributes, $content);
    }

    /**
     * Crea un elemento de entrada (input).
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
     * Crea un elemento de botón (button).
     */
    public static function button(mixed $content, string $type = 'button', array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        return self::tag('button', $attributes, $content);
    }

    /**
     * Crea un elemento de script.
     */
    public static function script(string $src = null, mixed $content = null, array $attributes = []): TagInterface
    {
        if ($src !== null) {
            $attributes['src'] = $src;
        }
        return self::tag('script', $attributes, $content);
    }

    /**
     * Crea un elemento de enlace a recurso (link).
     */
    public static function link(string $rel, string $href, array $attributes = []): TagInterface
    {
        $attributes['rel'] = $rel;
        $attributes['href'] = $href;
        return self::tag('link', $attributes);
    }

    /**
     * Crea un elemento meta.
     */
    public static function meta(array $attributes = []): TagInterface
    {
        return self::tag('meta', $attributes);
    }

    /**
     * Crea un componente web personalizado.
     */
    public static function webComponent(string $name, array $attributes = [], mixed $content = null): TagInterface
    {
        if (!str_contains($name, '-')) {
            throw new InvalidArgumentException('Web component names must contain a hyphen');
        }
        return self::tag($name, $attributes, $content);
    }
}
