<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Collapse.
 * Constructor flexible.
 */
class Collapse extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $id ID único del collapse.
     *     @var mixed $content Contenido a colapsar.
     *     @var bool $horizontal Si es colapso horizontal. Default: false.
     *     @var bool $visible Si inicia visible (show). Default: false.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'id' => 'collapse-' . uniqid(),
            'content' => '',
            'horizontal' => false,
            'visible' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['id'] = $this->options['id'];

        $collapse = $this->createComponent('div', $attributes);
        $collapse->addClass('collapse');

        if ($this->options['horizontal']) {
            $collapse->addClass('collapse-horizontal');
        }

        if ($this->options['visible']) {
            $collapse->addClass('show');
        }

        // Standard collapse usually just wraps content. 
        // Horizontal collapse requires inner width wrapper often, but basic is just div.

        $collapse->append($this->options['content']);

        return $collapse;
    }
}
