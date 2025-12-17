<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Tooltip.
 * Genera un elemento trigger configurado para tooltips.
 */
class Tooltip extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $title Texto del tooltip (title attribute).
     *     @var string $trigger_text Texto visible.
     *     @var string $placement Posición. Default: 'top'.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'title' => '',
            'trigger_text' => '',
            'placement' => 'top',
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        // Tooltips can be on any element, usually button or link or span.
        // We'll default to a button if not specified via attributes or logic, but usually user wants a link or text.
        // Let's create a span or button depending on usage.
        // For generic usage, maybe a button is safer for a "Component". 
        // Or if attributes has href, an anchor.

        $tag = isset($this->options['attributes']['href']) ? 'a' : 'button';

        $attributes = $this->options['attributes'];
        $attributes['data-bs-toggle'] = 'tooltip';
        $attributes['data-bs-placement'] = $this->options['placement'];
        $attributes['data-bs-title'] = $this->options['title'];

        if ($tag === 'button' && !isset($attributes['type'])) {
            $attributes['type'] = 'button';
        }

        return $this->createComponent($tag, $attributes, $this->options['trigger_text']);
    }
}
