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
    use HtmlElementsTrait, Traits\Macroable, Traits\HtmlFormTrait, Traits\HtmlTableTrait, Traits\HtmlMediaTrait {
        Traits\HtmlFormTrait::input insteadof HtmlElementsTrait;
        HtmlElementsTrait::time insteadof Traits\HtmlFormTrait;
        Traits\HtmlFormTrait::time as inputTime;
    }

    private static array $cache = [];
    private static array $themeDefaults = [];
    
    // ... métodos de fábrica (attribute, attributes, tag) existentes ...
    
    // NOTA: Mantenemos form() y formField() por retrocompatibilidad, 
    // pero ahora form() es simplemente un alias o setup inicial,
    // y la lógica compleja está en los Traits.

    /**
     * Crea una instancia de atributo.
     *
     * @param string $name El nombre del atributo.
     * @param mixed $value El valor del atributo (será convertido a string).
     * @return AttributeInterface La instancia del atributo.
     */
    public static function attribute(string $name, mixed $value): AttributeInterface
    {
        return AttributeFactory::build($name, $value);
    }

    /**
     * Crea una colección de atributos.
     *
     * @param array $attributes Array asociativo de atributos (clave => valor).
     * @return AttributesInterface La colección de atributos.
     */
    public static function attributes(array $attributes = []): AttributesInterface
    {
        return AttributesFactory::build($attributes);
    }

    /**
     * Crea una etiqueta HTML genérica con caché opcional.
     *
     * @param string $name Nombre de la etiqueta HTML (div, span, custom-element, etc).
     * @param array $attributes Atributos de la etiqueta.
     * @param mixed $content Contenido de la etiqueta.
     * @param bool $useCache Si es true, devolverá una copia clonada de una instancia previa si existe.
     * @return TagInterface La instancia de la etiqueta.
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
     * Crea un formulario con validación y accesibilidad mejorada.
     * (Wrapper de conveniencia sobre tag('form'))
     */
    public static function form(array $attributes = []): TagInterface
    {
        $form = self::tag('form', $attributes);
        // Por defecto activamos soporte ARIA/HTML5
        if (!isset($attributes['novalidate'])) {
            //$form->attr('novalidate', 'novalidate'); // Opcional según preferencia
        }
        return $form;
    }

    /**
     * Crea un campo de formulario con soporte ARIA (Legacy Helper).
     * Se recomienda usar los métodos específicos (Html::text, Html::email) en su lugar.
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

    /**
     * Genera una clave de caché única para la etiqueta.
     * @param string $name Nombre de la etiqueta.
     * @param array $attributes Atributos de la etiqueta.
     * @param mixed $content Contenido de la etiqueta.
     * @return string La clave hash generada.
     */
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
}
