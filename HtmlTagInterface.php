<?php

declare(strict_types=1);

namespace Higgs\Html;

use Higgs\Html\Attribute\AttributeInterface;
use Higgs\Html\Attributes\AttributesInterface;
use Higgs\Html\Tag\TagInterface;

/**
 * Interfaz HtmlTagInterface.
 */
interface HtmlTagInterface
{
    /**
     * Crea un nuevo atributo.
     * @param string $name El nombre del atributo.
     * @param array<mixed>|string $value El valor del atributo.
     * @return AttributeInterface El atributo creado.
     */
    public static function attribute(string $name, $value): AttributeInterface;

    /**
     * Crea una colección de atributos.
     *
     * @param array<mixed> $attributes Los atributos.
     *
     * @return AttributesInterface La colección de atributos.
     */
    public static function attributes(array $attributes = []): AttributesInterface;

    /**
     * Crea una nueva etiqueta.
     *
     * @param string $name El nombre de la etiqueta.
     * @param array<mixed> $attributes Los atributos.
     * @param mixed $content El contenido.
     *
     * @return TagInterface La etiqueta creada.
     */
    public static function tag(string $name, array $attributes = [], $content = null): TagInterface;
}
