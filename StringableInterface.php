<?php

declare(strict_types=1);

namespace Higgs\Html;

/**
 * Interfaz StringableInterface.
 */
interface StringableInterface extends \Stringable
{
    /**
     * Obtiene una representación en cadena del objeto.
     *
     * @return string
     *   La cadena.
     */
    public function __toString(): string;
}
