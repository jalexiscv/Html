<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Layout;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Container.
 */
class Container extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var mixed $content Contenido.
     *     @var string $type Tipo (fluid, sm, md, lg, xl, xxl). Default: '' (container).
     *     @var array $attributes Atributos.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'type' => '',
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $class = 'container';
        if ($this->options['type']) {
            $class .= '-' . $this->options['type'];
        }

        $container = $this->createComponent('div', $this->options['attributes'], $this->options['content']);
        $container->addClass($class);
        return $container;
    }
}
