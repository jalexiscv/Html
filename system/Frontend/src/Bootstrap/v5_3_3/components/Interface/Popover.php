<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Popover.
 * Realmente es un atributo helper más que un componente visual independiente,
 * pero esta clase ayuda a generar el botón/elemento trigger configurado.
 * Constructor flexible.
 */
class Popover extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var mixed $content Texto/Contenido del popover (atributo data-bs-content).
     *     @var string $title Título del popover.
     *     @var string $trigger_text Texto del elemento activador (botón/link).
     *     @var string $placement Posición. Default: 'right'.
     *     @var string $variant Variante del botón activador. Default: 'secondary'.
     *     @var array $attributes Atributos adicionales del activador.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'title' => '',
            'trigger_text' => 'Popover',
            'placement' => 'right',
            'variant' => 'secondary',
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['type'] = 'button';
        $attributes['data-bs-toggle'] = 'popover';
        $attributes['data-bs-title'] = $this->options['title'];
        $attributes['data-bs-content'] = $this->options['content'];
        $attributes['data-bs-placement'] = $this->options['placement'];

        $btn = $this->createComponent('button', $attributes, $this->options['trigger_text']);
        $btn->addClass('btn btn-' . $this->options['variant']);

        return $btn;
    }
}
