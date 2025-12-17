<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Badge de Bootstrap 5.
 * Constructor flexible.
 */
class Badge extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $content Contenido del badge.
     *     @var string $variant Variante de color (primary, etc). Default: 'primary'.
     *     @var bool $rounded Si es redondeado (pill). Default: false.
     *     @var bool $pill Alias de rounded.
     *     @var array $attributes Atributos HTML adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'variant' => 'primary',
            'rounded' => false,
            'pill' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $badge = $this->createComponent('span', $attributes, $this->options['content']);
        $badge->addClass('badge');

        $this->addVariantClasses($badge, $this->options['variant'], 'text-bg');

        if ($this->options['rounded'] || $this->options['pill']) {
            $badge->addClass('rounded-pill');
        }

        return $badge;
    }
}
