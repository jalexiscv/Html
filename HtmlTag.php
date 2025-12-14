<?php

declare(strict_types=1);

namespace Higgs\Html;

use Higgs\Html\Attribute\AttributeFactory;
use Higgs\Html\Attribute\AttributeInterface;
use Higgs\Html\Attributes\AttributesFactory;
use Higgs\Html\Attributes\AttributesInterface;
use Higgs\Html\Tag\TagFactory;
use Higgs\Html\Tag\TagInterface;

/**
 * Clase HtmlTag.
 */
final class HtmlTag implements HtmlTagInterface
{
    /**
     * Crea una instancia de atributo.
     *
     * @param string $name El nombre del atributo.
     * @param mixed $value El valor del atributo.
     * @return AttributeInterface La instancia del atributo.
     */
    public static function attribute(string $name, $value): AttributeInterface
    {
        return AttributeFactory::build($name, $value);
    }

    /**
     * Crea una colección de atributos.
     *
     * @param array $attributes Array de atributos clave-valor.
     * @return AttributesInterface La colección de atributos.
     */
    public static function attributes(array $attributes = []): AttributesInterface
    {
        return AttributesFactory::build($attributes);
    }

    /**
     * Crea una etiqueta HTML.
     *
     * @param string $name Nombre de la etiqueta.
     * @param array $attributes Atributos de la etiqueta.
     * @param mixed $content Contenido de la etiqueta.
     * @return TagInterface La instancia de la etiqueta.
     */
    public static function tag(string $name, array $attributes = [], $content = null): TagInterface
    {
        return TagFactory::build($name, $attributes, $content);
    }
}
