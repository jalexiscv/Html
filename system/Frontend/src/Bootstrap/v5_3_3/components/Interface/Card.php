<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Card de Bootstrap 5.
 * Constructor flexible.
 */
class Card extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string|null $title Título de la tarjeta.
     *     @var mixed $content Contenido principal (texto o HTML).
     *     @var mixed $header Cabecera de la tarjeta.
     *     @var mixed $footer Pie de la tarjeta.
     *     @var string|null $image URL de la imagen.
     *     @var string $image_position Posición de imagen (top, bottom). Default: 'top'.
     *     @var array $attributes Atributos del contenedor .card.
     *     @var array $body_attributes Atributos del .card-body.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'title' => null,
            'content' => '',
            'header' => null,
            'footer' => null,
            'image' => null,
            'image_position' => 'top',
            'attributes' => [],
            'body_attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $card = $this->createComponent('div', $this->options['attributes']);
        $card->addClass('card');

        // Header
        if ($this->options['header']) {
            $header = $this->createComponent('div', ['class' => 'card-header'], $this->options['header']);
            $card->append($header);
        }

        // Image Top
        if ($this->options['image'] && $this->options['image_position'] === 'top') {
            $card->append($this->createImage());
        }

        // Body
        $bodyAttributes = $this->options['body_attributes'];
        $body = $this->createComponent('div', $bodyAttributes);
        $body->addClass('card-body');

        if ($this->options['title']) {
            $body->append($this->createComponent('h5', ['class' => 'card-title'], $this->options['title']));
        }

        if ($this->options['content']) {
            $contentClass = is_string($this->options['content']) ? 'card-text' : '';
            // Check if content is just raw text, if so wrap in p.card-text
            if (is_string($this->options['content']) && $this->options['content'] !== '') {
                $body->append($this->createComponent('p', ['class' => 'card-text'], $this->options['content']));
            } else {
                $body->append($this->options['content']);
            }
        }

        $card->append($body);

        // Image Bottom
        if ($this->options['image'] && $this->options['image_position'] === 'bottom') {
            $card->append($this->createImage());
        }

        // Footer
        if ($this->options['footer']) {
            $footer = $this->createComponent('div', ['class' => 'card-footer text-body-secondary'], $this->options['footer']);
            $card->append($footer);
        }

        return $card;
    }

    private function createImage(): TagInterface
    {
        $class = 'card-img-' . $this->options['image_position'];
        return $this->createComponent('img', [
            'src' => $this->options['image'],
            'class' => $class,
            'alt' => $this->options['title'] ?? 'Card image'
        ]);
    }
}
