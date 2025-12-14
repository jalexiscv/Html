<?php

declare(strict_types=1);

namespace Higgs\Html;

/**
 * Interfaz AlterableInterface.
 */
interface AlterableInterface
{
    /**
     * Altera los valores de un objeto.
     *
     * @param callable ...$closures
     *   El/los cierre(s) (closures).
     *
     * @return object
     *   El objeto.
     */
    public function alter(callable ...$closures);
}
