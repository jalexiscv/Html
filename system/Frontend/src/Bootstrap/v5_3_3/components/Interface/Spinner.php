<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Spinner.
 * Constructor flexible.
 */
class Spinner extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $type Tipo (border, grow). Default: 'border'.
     *     @var string $variant Color (primary, secondary, etc).
     *     @var bool $small Tamaño pequeño. Default: false.
     *     @var string $text Texto para accesibilidad (visually-hidden).
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'type' => 'border',
            'variant' => null,
            'small' => false,
            'text' => 'Loading...',
            'attributes' => ['role' => 'status']
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $class = 'spinner-' . $this->options['type']; // border or grow

        if ($this->options['small']) {
            $class .= ' spinner-' . $this->options['type'] . '-sm';
        }

        if ($this->options['variant']) {
            $class .= ' text-' . $this->options['variant'];
        }

        $spinner = $this->createComponent('div', $attributes);
        $spinner->addClass($class);

        $spinner->append($this->createComponent('span', ['class' => 'visually-hidden'], $this->options['text']));

        return $spinner;
    }
}
