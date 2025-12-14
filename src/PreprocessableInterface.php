<?php

declare(strict_types=1);

namespace Higgs\Html;

/**
 * Interfaz PreprocessableInterface.
 */
interface PreprocessableInterface
{
    /**
     * Preprocesa los valores de un objeto.
     *
     * @param array<mixed> $values
     *   Los valores a preprocesar.
     * @param array<mixed> $context
     *   El contexto.
     *
     * @return array<int, mixed>
     *   Los valores procesados.
     */
    public function preprocess(array $values, array $context = []): array;
}
