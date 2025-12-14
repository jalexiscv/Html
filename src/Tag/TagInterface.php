<?php

declare(strict_types=1);

namespace Higgs\Html\Tag;

use Higgs\Html\AlterableInterface;
use Higgs\Html\Attribute\AttributeInterface;
use Higgs\Html\EscapableInterface;
use Higgs\Html\PreprocessableInterface;
use Higgs\Html\RenderableInterface;
use Higgs\Html\StringableInterface;


interface TagInterface extends
    AlterableInterface,
    EscapableInterface,
    PreprocessableInterface,
    RenderableInterface,
    StringableInterface
{
    /**
     * Obtiene los atributos como una cadena o un atributo específico si se proporciona $name.
     *
     * @param string $name
     *   El nombre del atributo.
     * @param mixed ...$value
     *   El valor.
     *
     * @return AttributeInterface|string
     *   Los atributos como cadena o un objeto Attribute específico.
     */
    public function attr(?string $name = null, ...$value);

    /**
     * Establece u obtiene el contenido.
     *
     * @param mixed ...$data
     *   El contenido.
     *
     * @return string|null
     *   El contenido.
     */
    public function content(...$data): ?string;

    /**
     * Obtiene el contenido.
     *
     * @return array<int, string>
     *   El contenido como un array.
     */
    public function getContentAsArray(): array;
}
