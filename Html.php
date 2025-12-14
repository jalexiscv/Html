<?php
declare(strict_types=1);

namespace Higgs\Html;

use Higgs\Html\Attribute\AttributeFactory;
use Higgs\Html\Attribute\AttributeInterface;
use Higgs\Html\Attributes\AttributesFactory;
use Higgs\Html\Attributes\AttributesInterface;
use Higgs\Html\Tag\TagFactory;
use Higgs\Html\Tag\TagInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class Html
 * Clase principal para la generación de HTML con soporte mejorado para PHP 8.0+
 */
final class Html implements HtmlTagInterface
{
    private static array $cache = [];
    private static array $themeDefaults = [];

    public static function attribute(string $name, mixed $value): AttributeInterface
    {
        return AttributeFactory::build($name, $value);
    }

    public static function attributes(array $attributes = []): AttributesInterface
    {
        return AttributesFactory::build($attributes);
    }

    /**
     * Crea una etiqueta HTML con caché opcional
     */
    public static function tag(string $name, array $attributes = [], mixed $content = null, bool $useCache = false): TagInterface
    {
        $cacheKey = $useCache ? self::generateCacheKey($name, $attributes, $content) : null;
        
        if ($useCache && isset(self::$cache[$cacheKey])) {
            return clone self::$cache[$cacheKey];
        }

        $tag = TagFactory::build($name, $attributes, $content);
        
        if ($useCache) {
            self::$cache[$cacheKey] = clone $tag;
        }

        return $tag;
    }

    /**
     * Crea un formulario con validación y accesibilidad mejorada
     */
    public static function form(array $attributes = []): TagInterface
    {
        $form = self::tag('form', $attributes);
        $form->attr('novalidate', 'novalidate');
        return $form;
    }

    /**
     * Crea un campo de formulario con soporte ARIA
     */
    public static function formField(string $type, string $name, array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        $attributes['name'] = $name;
        $attributes['id'] = $attributes['id'] ?? "field-{$name}";
        
        $field = self::tag('input', $attributes);
        $field->attr('aria-label', $attributes['label'] ?? $name);
        
        if (isset($attributes['required']) && $attributes['required']) {
            $field->attr('aria-required', 'true');
        }

        return $field;
    }

    /**
     * Aplica un tema predefinido a un elemento
     */
    public static function applyTheme(TagInterface $tag, string $themeName): TagInterface
    {
        if (!isset(self::$themeDefaults[$themeName])) {
            throw new RuntimeException("Theme '{$themeName}' not found");
        }

        foreach (self::$themeDefaults[$themeName] as $attr => $value) {
            $tag->attr($attr, $value);
        }

        return $tag;
    }

    /**
     * Registra un nuevo tema
     */
    public static function registerTheme(string $name, array $defaults): void
    {
        self::$themeDefaults[$name] = $defaults;
    }

    // --- Semantic Helpers ---

    public static function div(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('div', $attributes, $content);
    }

    public static function span(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('span', $attributes, $content);
    }

    public static function p(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('p', $attributes, $content);
    }

    public static function a(string $href, mixed $content = null, array $attributes = []): TagInterface
    {
        $attributes['href'] = $href;
        return self::tag('a', $attributes, $content);
    }

    public static function img(string $src, string $alt = '', array $attributes = []): TagInterface
    {
        $attributes['src'] = $src;
        $attributes['alt'] = $alt;
        return self::tag('img', $attributes);
    }

    public static function ul(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ul', $attributes, $content);
    }

    public static function ol(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('ol', $attributes, $content);
    }

    public static function li(array $attributes = [], mixed $content = null): TagInterface
    {
        return self::tag('li', $attributes, $content);
    }

    public static function input(string $type, string $name, ?string $value = null, array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        $attributes['name'] = $name;
        if ($value !== null) {
            $attributes['value'] = $value;
        }
        return self::tag('input', $attributes);
    }

    public static function button(mixed $content, string $type = 'button', array $attributes = []): TagInterface
    {
        $attributes['type'] = $type;
        return self::tag('button', $attributes, $content);
    }

    public static function script(string $src = null, mixed $content = null, array $attributes = []): TagInterface
    {
        if ($src !== null) {
            $attributes['src'] = $src;
        }
        return self::tag('script', $attributes, $content);
    }

    public static function link(string $rel, string $href, array $attributes = []): TagInterface
    {
        $attributes['rel'] = $rel;
        $attributes['href'] = $href;
        return self::tag('link', $attributes);
    }

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

    private static function generateCacheKey(string $name, array $attributes, mixed $content): string
    {
        return md5($name . serialize($attributes) . serialize($content));
    }

    /**
     * Limpia la caché de elementos
     */
    public static function clearCache(): void
    {
        self::$cache = [];
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'b' con el contenido especificado.
     * @param array $args Un array asociativo que contiene los atributos de la etiqueta 'a'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'b' con los atributos especificados.
     */
    public static function get_B(array $args): string
    {
        $content = self::_get_Attribute($args, "content", "", false);
        if (!empty($content)) {
            $b = HtmlTag::tag('b');
            $b->content($content);
            return ($b->render());
        }
        return ("");
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'i' con el contenido especificado.
     * @param array $args Un array asociativo que contiene los atributos de la etiqueta 'i'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'i' con los atributos especificados.
     */
    public static function get_I(array $args): string
    {
        $class = self::_get_Attribute($args, "class", "", false);
        $content = self::_get_Attribute($args, "content", "", false);
        $i = HtmlTag::tag('i');
        $i->attr('class', $class);
        $i->content($content);
        return ($i->render());
    }


    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'a' con el contenido y atributos especificados.
     * @param array $args Un array asociativo que contiene los atributos de la etiqueta 'a'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'a' con los atributos especificados.
     */
    public static function get_A(array $args): string
    {
        $href = self::_get_Attribute($args, "href", "#", false);
        $content = self::_get_Attribute($args, "content", "", false);
        $a = HtmlTag::tag('a');
        $a->attr('href', $href);
        $a->content($content);
        return ($a->render());
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'p' con el contenido especificado.
     * @param array $args Un array asociativo que contiene los atributos de la etiqueta 'p'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'p' con los atributos especificados.
     */
    public static function get_P(array $args): string
    {
        $content = self::_get_Attribute($args, "content", "", false);
        $p = HtmlTag::tag('p');
        $p->content($content);
        return ($p->render());
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'img' con los atributos especificados.
     * @param array $args Un array asociativo que contiene los atributos de la etiqueta 'img'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'img' con los atributos especificados.
     */
    public static function get_Img(array $args): string
    {
        $src = self::_get_Attribute($args, "src", "", true);
        $alt = self::_get_Attribute($args, "alt", "", false);
        $img = HtmlTag::tag('img');
        $img->attr('src', $src);
        $img->attr('alt', $alt);
        return ($img->render());
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'ul' con los elementos especificados.
     * @param array $args Un array asociativo que contiene los elementos de la lista 'ul'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'ul' con los elementos especificados.
     */
    public static function get_Ul(array $args): string
    {
        $items = self::_get_Attribute($args, "items", array(), false);
        $ul = HtmlTag::tag('ul');
        foreach ($items as $item) {
            $li = HtmlTag::tag('li');
            $li->content($item);
            $ul->child($li);
        }
        return ($ul->render());
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'ol' con los elementos especificados.
     * @param array $args Un array asociativo que contiene los elementos de la lista 'ol'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'ol' con los elementos especificados.
     */
    public static function get_Ol(array $args): string
    {
        $items = self::_get_Attribute($args, "items", array(), false);
        $ol = HtmlTag::tag('ol');
        foreach ($items as $item) {
            $li = HtmlTag::tag('li');
            $li->content($item);
            $ol->child($li);
        }
        return ($ol->render());
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'h1' con el contenido especificado.
     * @param array $args Un array asociativo que contiene los atributos de la etiqueta 'h1'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'h1' con los atributos especificados.
     */
    public static function get_H1(array $args): string
    {
        $content = self::_get_Attribute($args, "content", "", false);
        $h1 = HtmlTag::tag('h1');
        $h1->content($content);
        return ($h1->render());
    }

    // Se pueden agregar más métodos aquí para representar otros elementos HTML básicos como 'div', 'span', etc.

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'div' con el contenido y atributos especificados.
     * @param array $args Un array asociativo que contiene los atributos y el contenido de la etiqueta 'div'.
     * @return string Retorna la instancia de Tag representando una etiqueta HTML 'div' con los atributos y contenido especificados.
     */
    public static function get_Div(array $args): string
    {
        $content = self::_get_Attribute($args, "content", "", false);
        $div = self::tag('div');
        $div->content($content);
        // Añadir atributos adicionales si existen
        foreach ($args as $key => $value) {
            if ($key !== 'content') {
                $div->attr($key, $value);
            }
        }
        return ($div->render());
    }


    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'button' con el contenido y atributos especificados.
     * @param array $args Un array asociativo que contiene los atributos y el contenido del botón.
     * @return string Retorna la instancia de Tag representando una etiqueta HTML 'div' con los atributos y contenido especificados.
     */
    public static function get_Button($args = array()): string
    {
        $content = self::_get_Attribute($args, "content", "", false);
        $button = self::tag('button');
        $button->content($content);
        // Añadir atributos adicionales si existen
        foreach ($args as $key => $value) {
            if ($key !== 'content') {
                $button->attr($key, $value);
            }
        }
        return ($button->render());
    }

    /**
     * Crea una instancia de la clase HtmlTag representando una etiqueta HTML 'span' con el contenido y atributos especificados.
     * @param array $args Un array asociativo que contiene los atributos y el contenido de la etiqueta 'span'.
     * @return TagInterface La instancia de Tag representando una etiqueta HTML 'span' con los atributos y contenido especificados.
     */
    public static function get_Span(array $args): string
    {
        $content = self::_get_Attribute($args, "content", "", false);
        $span = self::tag('span');
        $span->content($content);
        // Añadir atributos adicionales si existen
        if (isset($args['attributes']) && is_array($args['attributes'])) {
            foreach ($args['attributes'] as $key => $value) {
                $span->attr($key, $value);
            }
        }
        return ($span->render());
    }

    /**
     * Este método devuelve el valor del atributo especificado por el parámetro $name.
     * Si el atributo no está presente en el array $this->attributes, devuelve el valor
     * predeterminado proporcionado en el parámetro $default.
     * @param array $attributes Los atributos a procesar
     * @param string $key El nombre del atributo cuyo valor se desea obtener.
     * @param mixed $default El valor predeterminado que se devuelve si el atributo no está presente.
     * @param bool $required Si se establece en true, se lanzará una excepción si el atributo no está presente.
     * @return mixed El valor del atributo si está presente, de lo contrario, el valor predeterminado.
     */
    private static function _get_Attribute(array $attributes, string $key, mixed $default, bool $required): mixed
    {
        if (isset($attributes[$key])) {
            if (is_string($attributes[$key])) {
                $return = trim($attributes[$key]);
            } elseif (is_array($attributes[$key])) {
                $return = $attributes[$key];
            } else {
                $return = $attributes[$key];
            }
            return ($return);
        } else {
            if ($required) {
                throw new InvalidArgumentException("El atributo '$key' es obligatorio.");
            } else {
                return ($default);
            }
        }
    }
}

?>
