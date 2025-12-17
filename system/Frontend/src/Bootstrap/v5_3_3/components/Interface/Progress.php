<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Progress.
 * Constructor flexible.
 */
class Progress extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var int $value Valor actual (0-100).
     *     @var int $min Mínimo. Default: 0.
     *     @var int $max Máximo. Default: 100.
     *     @var string $label Etiqueta visible dentro de la barra.
     *     @var bool $striped Rayado. Default: false.
     *     @var bool $animated Animado. Default: false.
     *     @var string $variant Variante de color (success, info, warning, danger).
     *     @var int|string $height Altura (px).
     *     @var array $attributes Atributos del container .progress.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'value' => 0,
            'min' => 0,
            'max' => 100,
            'label' => '',
            'striped' => false,
            'animated' => false,
            'variant' => null,
            'height' => null,
            'attributes' => ['role' => 'progressbar']
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['aria-valuenow'] = (string)$this->options['value'];
        $attributes['aria-valuemin'] = (string)$this->options['min'];
        $attributes['aria-valuemax'] = (string)$this->options['max'];

        if ($this->options['height']) {
            $attributes['style'] = "height: {$this->options['height']}px;";
        }

        $progress = $this->createComponent('div', $attributes);
        $progress->addClass('progress');

        // Progress Bar
        $barClasses = ['progress-bar'];
        if ($this->options['striped']) $barClasses[] = 'progress-bar-striped';
        if ($this->options['animated']) $barClasses[] = 'progress-bar-animated';
        if ($this->options['variant']) $barClasses[] = 'bg-' . $this->options['variant'];

        $width = ($this->options['value'] - $this->options['min']) / ($this->options['max'] - $this->options['min']) * 100;

        $bar = $this->createComponent('div', [
            'class' => implode(' ', $barClasses),
            'style' => "width: {$width}%"
        ], $this->options['label']);

        $progress->append($bar);

        return $progress;
    }
}
