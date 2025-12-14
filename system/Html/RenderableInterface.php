<?php

declare(strict_types=1);

namespace Higgs\Html;

/**
 * Interfaz RenderableInterface.
 */
interface RenderableInterface
{
    /**
     * Renderiza el objeto.
     *
     * @return string
     *   El objeto renderizado como cadena.
     */
    public function render(): string;
}
