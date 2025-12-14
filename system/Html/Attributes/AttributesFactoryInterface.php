<?php

declare(strict_types=1);

namespace Higgs\Html\Attributes;

interface AttributesFactoryInterface
{
    /**
     * Crea una nueva colección de atributos.
     *
     * @param array $attributes
     *   Los atributos.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public static function build(
        array $attributes = []
    );

    /**
     * Obtiene una instancia de atributos.
     *
     * @param array $attributes
     *   Los atributos.
     *
     * @return AttributesInterface
     *   Los atributos.
     */
    public function getInstance(
        array $attributes = []
    );
}
