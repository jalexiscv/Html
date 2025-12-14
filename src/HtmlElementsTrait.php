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
     *
     * @param array $attributes Atributos HTML del elemento (clave => valor).
     * @param mixed $content Contenido del elemento (string, TagInterface, o array de ellos).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function div(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('div', $attributes, $content);
    }

    /**
     * Crea un elemento span.
     *
     * @param array $attributes Atributos HTML del elemento.
     * @param mixed $content Contenido del elemento.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function span(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('span', $attributes, $content);
    }

    /**
     * Crea un elemento de párrafo (p).
     *
     * @param array $attributes Atributos HTML del elemento.
     * @param mixed $content Contenido del elemento.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function p(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('p', $attributes, $content);
    }

    /**
     * Crea un elemento de enlace (a).
     *
     * @param string $href URL destino del enlace.
     * @param mixed $content Contenido del enlace (texto o elementos).
     * @param array $attributes Atributos adicionales (ej: target, rel).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function a(string $href, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['href'] = $href;
        return self::tag('a', $attributes, $content);
    }

    /**
     * Crea un elemento de imagen (img).
     *
     * @param string $src URL de la imagen.
     * @param string $alt Texto alternativo para accesibilidad.
     * @param array $attributes Atributos adicionales (ej: width, height, loading).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function img(string $src, string $alt = '', array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        $attributes['alt'] = $alt;
        return self::tag('img', $attributes);
    }

    /**
     * Crea un elemento de lista desordenada (ul).
     *
     * @param array $attributes Atributos HTML de la lista.
     * @param mixed $content Elementos de la lista (generalmente etiquetas li).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function ul(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ul', $attributes, $content);
    }

    /**
     * Crea un elemento de lista ordenada (ol).
     *
     * @param array $attributes Atributos HTML de la lista.
     * @param mixed $content Elementos de la lista.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function ol(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ol', $attributes, $content);
    }

    /**
     * Crea un elemento de ítem de lista (li).
     *
     * @param array $attributes Atributos HTML del ítem.
     * @param mixed $content Contenido del ítem.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function li(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('li', $attributes, $content);
    }

    /**
     * Crea un elemento de entrada (input).
     *
     * @param string $type Tipo de input (text, email, password, etc).
     * @param string $name Nombre del campo para el formulario.
     * @param string|null $value Valor actual del campo.
     * @param array $attributes Atributos adicionales.
     * @return TagInterface La instancia del elemento creado.
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
     *
     * @param mixed $content Contenido del botón (texto o iconos).
     * @param string $type Tipo de botón (button, submit, reset).
     * @param array $attributes Atributos adicionales.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function button(mixed $content, string $type = 'button', array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        return self::tag('button', $attributes, $content);
    }

    /**
     * Crea un elemento de script.
     *
     * @param string|null $src URL del script (opcional si es script inline).
     * @param mixed $content Contenido del script (código JS inline).
     * @param array $attributes Atributos adicionales (ej: async, defer, type).
     * @return TagInterface La instancia del elemento creado.
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
     *
     * @param string $rel Relación del recurso (ej: stylesheet, icon).
     * @param string $href URL del recurso.
     * @param array $attributes Atributos adicionales.
     * @return TagInterface La instancia del elemento creado.
     */
    public static function link(string $rel, string $href, array $attributes = []): TagInterface
    {
        $attributes['rel'] = $rel;
        $attributes['href'] = $href;
        return self::tag('link', $attributes);
    }

    /**
     * Crea un elemento meta.
     *
     * @param array $attributes Atributos del meta tag (ej: name, content, charset).
     * @return TagInterface La instancia del elemento creado.
     */
    public static function meta(array $attributes = []): TagInterface
    {
        return self::tag('meta', $attributes);
    }

    /**
     * Crea un componente web personalizado.
     *
     * @param string $name Nombre del componente (debe contener guión).
     * @param array $attributes Atributos del componente.
     * @param mixed $content Contenido del componente.
     * @return TagInterface La instancia del elemento creado.
     * @throws InvalidArgumentException Si el nombre no contiene un guión.
     */
    public static function webComponent(string $name, array $attributes = [], mixed $content = null): TagInterface
    {
        if (!str_contains($name, '-')) {
            throw new InvalidArgumentException('Web component names must contain a hyphen');
        }
        return self::tag($name, $attributes, $content);
    }
}
