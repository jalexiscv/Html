<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Carousel.
 * Constructor flexible.
 */
class Carousel extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $id ID único del carrusel.
     *     @var array $slides Array de slides [['src' => '', 'alt' => '', 'caption_title' => '', 'caption_text' => '', 'active' => bool]].
     *     @var bool $controls Mostrar controles prev/next. Default: true.
     *     @var bool $indicators Mostrar indicadores. Default: true.
     *     @var bool $fade Transición fade. Default: false.
     *     @var bool|string $ride Autoplay ('carousel' o true). Default: true.
     *     @var array $attributes Opciones adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'id' => 'carousel-' . uniqid(),
            'slides' => [],
            'controls' => true,
            'indicators' => true,
            'fade' => false,
            'ride' => 'carousel',
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $carousel = $this->createComponent('div', $this->options['attributes']);
        $carousel->setId($this->options['id']);
        $carousel->addClass('carousel slide');

        if ($this->options['fade']) {
            $carousel->addClass('carousel-fade');
        }

        if ($this->options['ride']) {
            $carousel->setAttribute('data-bs-ride', $this->options['ride'] === true ? 'carousel' : $this->options['ride']);
        }

        // Indicators
        if ($this->options['indicators']) {
            $carousel->append($this->createIndicators());
        }

        // Inner
        $inner = $this->createComponent('div', ['class' => 'carousel-inner']);
        foreach ($this->options['slides'] as $index => $slide) {
            $inner->append($this->createSlide($slide, $index));
        }
        $carousel->append($inner);

        // Controls
        if ($this->options['controls']) {
            $carousel->append($this->createControl('prev'));
            $carousel->append($this->createControl('next'));
        }

        return $carousel;
    }

    private function createIndicators(): TagInterface
    {
        $indicators = $this->createComponent('div', ['class' => 'carousel-indicators']);

        foreach ($this->options['slides'] as $index => $slide) {
            $isActive = $slide['active'] ?? ($index === 0);
            $btn = $this->createComponent('button', [
                'type' => 'button',
                'data-bs-target' => '#' . $this->options['id'],
                'data-bs-slide-to' => (string)$index,
                'aria-label' => "Slide " . ($index + 1)
            ]);

            if ($isActive) {
                $btn->addClass('active');
                $btn->setAttribute('aria-current', 'true');
            }

            $indicators->append($btn);
        }
        return $indicators;
    }

    private function createSlide(array $slide, int $index): TagInterface
    {
        $isActive = $slide['active'] ?? ($index === 0);
        $item = $this->createComponent('div', ['class' => 'carousel-item' . ($isActive ? ' active' : '')]);

        if (isset($slide['interval'])) {
            $item->setAttribute('data-bs-interval', (string)$slide['interval']);
        }

        $img = $this->createComponent('img', [
            'src' => $slide['src'],
            'class' => 'd-block w-100',
            'alt' => $slide['alt'] ?? ''
        ]);
        $item->append($img);

        if (!empty($slide['caption_title']) || !empty($slide['caption_text'])) {
            $caption = $this->createComponent('div', ['class' => 'carousel-caption d-none d-md-block']);
            if (!empty($slide['caption_title'])) {
                $caption->append($this->createComponent('h5', [], $slide['caption_title']));
            }
            if (!empty($slide['caption_text'])) {
                $caption->append($this->createComponent('p', [], $slide['caption_text']));
            }
            $item->append($caption);
        }

        return $item;
    }

    private function createControl(string $direction): TagInterface
    {
        $control = $this->createComponent('button', [
            'class' => "carousel-control-{$direction}",
            'type' => 'button',
            'data-bs-target' => '#' . $this->options['id'],
            'data-bs-slide' => $direction
        ]);

        $icon = $this->createComponent('span', [
            'class' => "carousel-control-{$direction}-icon",
            'aria-hidden' => 'true'
        ]);

        $visuallyHidden = $this->createComponent('span', ['class' => 'visually-hidden'], ucfirst($direction));

        $control->append($icon);
        $control->append($visuallyHidden);

        return $control;
    }
}
