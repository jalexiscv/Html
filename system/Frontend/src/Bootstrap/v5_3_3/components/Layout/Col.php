<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Layout;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Col.
 */
class Col extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var mixed $content Contenido.
     *     @var string|int|null $size Tamaño (1-12, auto).
     *     @var string|null $breakpoint Breakpoint (sm, md, lg, xl, xxl).
     *     @var array $attributes Atributos.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'size' => null,
            'breakpoint' => null,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $class = 'col';
        if ($this->options['breakpoint']) {
            $class .= '-' . $this->options['breakpoint'];
        }
        if ($this->options['size']) {
            $class .= '-' . $this->options['size'];
        }

        $col = $this->createComponent('div', $this->options['attributes'], $this->options['content']);
        $col->addClass($class);
        return $col;
    }
}
