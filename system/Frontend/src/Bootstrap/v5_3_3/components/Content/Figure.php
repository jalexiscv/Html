<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Content;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Figure.
 */
class Figure extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $src URL imagen.
     *     @var string $caption Caption text.
     *     @var string|null $alt Alt text.
     *     @var string $align Alineación caption (start, end, center). Default: start.
     *     @var array $attributes Atributos figure.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'src' => '',
            'caption' => '',
            'alt' => '',
            'align' => 'start',
            'attributes' => ['class' => 'figure']
        ]);
    }

    public function render(): TagInterface
    {
        $figure = $this->createComponent('figure', $this->options['attributes']);

        $img = $this->createComponent('img', [
            'src' => $this->options['src'],
            'class' => 'figure-img img-fluid rounded',
            'alt' => $this->options['alt']
        ]);
        $figure->append($img);

        if ($this->options['caption']) {
            $capClass = 'figure-caption';
            if ($this->options['align'] !== 'start') {
                $capClass .= ' text-' . $this->options['align'];
            }
            $figure->append($this->createComponent('figcaption', ['class' => $capClass], $this->options['caption']));
        }

        return $figure;
    }
}
