<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Alert de Bootstrap 5.
 * 
 * Proporciona mensajes de retroalimentación contextual.
 * Constructor flexible basado en array de opciones.
 */
class Alert extends AbstractComponent
{
    private array $options;

    /**
     * Constructor flexible.
     * 
     * @param array $options {
     *     @var string $content Contenido de la alerta.
     *     @var string $type Tipo de alerta (primary, success, danger, warning, etc). Default: 'primary'.
     *     @var bool $dismissible Si se puede cerrar. Default: false.
     *     @var array $attributes Atributos HTML adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'type' => 'primary',
            'dismissible' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $type = $this->options['type'];

        $classes = ['alert', "alert-{$type}"];

        if ($this->options['dismissible']) {
            $classes[] = 'alert-dismissible';
            $classes[] = 'fade';
            $classes[] = 'show';
        }

        $attributes['role'] = 'alert';

        // Merge helper manually or use AttributesFactory if available, but doing manual string/array merge for standard behavior
        if (isset($attributes['class'])) {
            $existing = is_array($attributes['class']) ? $attributes['class'] : explode(' ', $attributes['class']);
            $classes = array_merge($classes, $existing);
        }
        $attributes['class'] = implode(' ', array_unique($classes));

        $alert = $this->createComponent('div', $attributes, $this->options['content']);

        if ($this->options['dismissible']) {
            $closeBtn = $this->createComponent('button', [
                'type' => 'button',
                'class' => 'btn-close',
                'data-bs-dismiss' => 'alert',
                'aria-label' => 'Close'
            ]);
            $alert->append($closeBtn);
        }

        return $alert;
    }
}
