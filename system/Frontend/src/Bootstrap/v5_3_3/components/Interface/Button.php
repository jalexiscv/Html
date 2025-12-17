<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Button de Bootstrap 5.
 * Constructor flexible.
 */
class Button extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var mixed $content Contenido del botón.
     *     @var string $variant Variante de color. Default: 'primary'.
     *     @var string|null $size Tamaño (sm, lg). Default: null.
     *     @var string $type Tipo de botón (button, submit). Default: 'button'.
     *     @var bool $outline Si es variante outline. Default: false.
     *     @var array $attributes Atributos HTML adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'variant' => 'primary',
            'size' => null,
            'type' => 'button',
            'outline' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['type'] = $this->options['type'];

        $variant = $this->options['variant'];
        if ($this->options['outline'] && !str_starts_with($variant, 'outline-')) {
            $variant = 'outline-' . $variant;
        }

        $btn = $this->createComponent('button', $attributes, $this->options['content']);
        $btn->addClass('btn');

        $this->addVariantClasses($btn, $variant, 'btn');
        $this->addSizeClasses($btn, $this->options['size'], 'btn');

        return $btn;
    }
}
