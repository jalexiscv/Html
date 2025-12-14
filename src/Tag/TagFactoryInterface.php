<?php

declare(strict_types=1);

namespace Higgs\Html\Tag;

interface TagFactoryInterface
{
    /**
     * Crea una nueva etiqueta.
     *
     * @param string $name
     *   El nombre de la etiqueta.
     * @param array<mixed> $attributes
     *   Los atributos de la etiqueta.
     * @param mixed $content
     *   El contenido de la etiqueta.
     *
     * @return TagInterface
     *   La etiqueta.
     */
    public static function build(string $name, array $attributes = [], $content = null): TagInterface;

    /**
     * Crea una nueva etiqueta.
     *
     * @param string $name
     *   El nombre de la etiqueta.
     * @param array<mixed> $attributes
     *   Los atributos de la etiqueta.
     * @param mixed $content
     *   El contenido de la etiqueta.
     *
     * @return TagInterface
     *   La etiqueta.
     */
    public function getInstance(string $name, array $attributes = [], $content = null): TagInterface;
}
