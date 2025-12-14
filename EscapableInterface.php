<?php

declare(strict_types=1);

namespace Higgs\Html;

/**
 * Interfaz EscapableInterface.
 */
interface EscapableInterface
{
    /**
     * Escapa un valor.
     *
     * @param mixed|string|StringableInterface|null $value
     *   El valor a escapar.
     *
     * @return string|StringableInterface|null
     *   El valor escapado.
     */
    public function escape($value);
}
