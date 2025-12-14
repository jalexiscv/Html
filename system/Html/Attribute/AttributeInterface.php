<?php

declare(strict_types=1);

namespace Higgs\Html\Attribute;

use ArrayAccess;
use Higgs\Html\AlterableInterface;
use Higgs\Html\EscapableInterface;
use Higgs\Html\PreprocessableInterface;
use Higgs\Html\RenderableInterface;
use Higgs\Html\StringableInterface;


/**
 * @template-extends ArrayAccess<int, mixed>
 */
interface AttributeInterface extends
    AlterableInterface,
    ArrayAccess,
    EscapableInterface,
    PreprocessableInterface,
    RenderableInterface,
    StringableInterface
{
    /**
     * {@inheritdoc}
     *
     * @return AttributeInterface
     */
    public function alter(callable ...$closures): AttributeInterface;

    /**
     * Añade un valor al atributo.
     *
     * @param mixed[]|string|null ...$value
     *   El valor a añadir.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public function append(...$value): AttributeInterface;

    /**
     * Comprueba si el atributo contiene una cadena o subcadena.
     *
     * @param mixed[]|string ...$substring
     *   La cadena a comprobar.
     *
     * @return bool
     *   Verdadero o Falso.
     */
    public function contains(...$substring): bool;

    /**
     * Elimina el atributo actual.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public function delete(): AttributeInterface;

    /**
     * Obtiene el nombre del atributo.
     *
     * @return string
     *   El nombre del atributo.
     */
    public function getName(): string;

    /**
     * Obtiene el valor del atributo como un array.
     *
     * @return array<int, string>
     *   El valor del atributo como array.
     */
    public function getValuesAsArray(): array;

    /**
     * Obtiene el valor del atributo como cadena.
     *
     * @return string|null
     *   El valor del atributo como cadena.
     */
    public function getValuesAsString(): ?string;

    /**
     * Comprueba si el atributo es booleano.
     *
     * @return bool
     *   Verdadero o Falso.
     */
    public function isBoolean();

    /**
     * Elimina un valor del atributo.
     *
     * @param array|string ...$value
     *   El valor a eliminar.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public function remove(...$value): AttributeInterface;

    /**
     * Reemplaza un valor del atributo.
     *
     * @param mixed[]|string $original
     *   El valor original.
     * @param mixed[]|string ...$replacement
     *   El valor de reemplazo.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public function replace($original, ...$replacement): AttributeInterface;

    /**
     * Establece el valor.
     *
     * @param array|string|null ...$value
     *   El valor.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public function set(...$value): AttributeInterface;

    /**
     * Establece el atributo como booleano.
     *
     * @param bool $boolean
     *   Verdadero o Falso.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public function setBoolean($boolean = true): AttributeInterface;
}
