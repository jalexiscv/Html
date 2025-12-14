<?php

declare(strict_types=1);

namespace Higgs\Html\Attribute;

interface AttributeFactoryInterface
{
    /**
     * Crea un nuevo atributo.
     *
     * @param string $name
     *   El nombre del atributo.
     * @param mixed[]|string|null $value
     *   El valor del atributo.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public static function build(string $name, $value = null): AttributeInterface;

    /**
     * Obtiene una instancia del atributo.
     *
     * @param string $name
     *   El nombre del atributo.
     * @param mixed[]|string|null $value
     *   El valor del atributo.
     *
     * @return AttributeInterface
     *   El atributo.
     */
    public function getInstance(string $name, $value = null): AttributeInterface;
}
