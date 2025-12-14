<?php

declare(strict_types=1);

namespace Higgs\Html\Attributes;

use ArrayAccess;
use ArrayIterator;
use Countable;
use Higgs\Html\PreprocessableInterface;
use Higgs\Html\RenderableInterface;
use Higgs\Html\StringableInterface;
use IteratorAggregate;
use Traversable;

/**
 * @template-extends IteratorAggregate<mixed>
 */
interface AttributesInterface extends
    ArrayAccess,
    Countable,
    IteratorAggregate,
    PreprocessableInterface,
    RenderableInterface,
    StringableInterface
{
    /**
     * Añade un valor a un atributo.
     *
     * @param string $key
     *   El nombre del atributo.
     * @param array|string ...$values
     *   Los valores del atributo.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function append($key, ...$values): AttributesInterface;

    /**
     * Comprueba si un atributo contiene un valor.
     *
     * @param string $key
     *   El nombre del atributo.
     * @param mixed[]|string ...$values
     *   Los valores del atributo.
     *
     * @return bool
     *   Verdadero si contiene el valor.
     */
    public function contains(string $key, ...$values): bool;

    /**
     * Elimina un atributo.
     *
     * @param array|string ...$keys
     *   El/los nombre(s) del atributo a eliminar.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function delete(string ...$keys): AttributesInterface;

    /**
     * Comprueba si un atributo existe.
     *
     * @param string $key
     *   El nombre del atributo.
     * @param mixed|string ...$values
     *   El valor a comprobar si el nombre del atributo existe.
     *
     * @return bool
     *   Verdadero si el atributo existe, falso en caso contrario.
     */
    public function exists(string $key, ...$values): bool;

    /**
     * Obtiene el almacenamiento.
     *
     * @return ArrayIterator<mixed>
     *   El array de almacenamiento.
     */
    public function getStorage(): ArrayIterator;

    /**
     * Obtiene los valores como un array.
     *
     * @return array<string, mixed>
     *   Los valores de los atributos indexados por nombre.
     */
    public function getValuesAsArray(): array;

    /**
     * Importa atributos.
     *
     * @param array|Traversable $data
     *   Los datos a importar.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function import($data): AttributesInterface;

    /**
     * Fusiona atributos.
     *
     * @param array<mixed> ...$dataset
     *   Los datos a fusionar.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function merge(array ...$dataset): AttributesInterface;

    /**
     * Elimina un valor de un atributo específico.
     *
     * @param string $key
     *   El nombre del atributo.
     * @param array|string ...$values
     *   Los valores del atributo.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function remove(string $key, ...$values): AttributesInterface;

    /**
     * Reemplaza un valor por otro.
     *
     * @param string $key
     *   El nombre del atributo.
     * @param string $value
     *   El valor del atributo.
     * @param string ...$replacements
     *   Los valores de reemplazo.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function replace(string $key, string $value, string ...$replacements): AttributesInterface;

    /**
     * Establece un atributo.
     *
     * @param string $key
     *   El nombre del atributo.
     * @param string|null ...$values
     *   Los valores del atributo.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function set(string $key, ...$values): AttributesInterface;

    /**
     * Retorna los atributos sin un atributo específico.
     *
     * @param string ...$keys
     *   El/los nombre(s) del atributo a eliminar.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function without(string ...$keys): AttributesInterface;
}
