<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Layout;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Row.
 */
class Row extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var mixed $content Contenido (columnas).
     *     @var string|null $gutters Gutter class (g-0, gx-5).
     *     @var array $attributes Atributos.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'gutters' => null,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $row = $this->createComponent('div', $this->options['attributes'], $this->options['content']);
        $row->addClass('row');

        if ($this->options['gutters']) {
            $row->addClass($this->options['gutters']);
        }

        return $row;
    }
}
