<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Toast.
 * Constructor flexible.
 */
class Toast extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $id ID único.
     *     @var string $header_text Texto cabecera o titulo ("11 mins ago").
     *     @var string $header_title Título fuerte (Nombre app, etc).
     *     @var mixed $content Contenido cuerpo.
     *     @var string|null $img Imagen en cabecera.
     *     @var array $attributes Atributos container.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'id' => 'toast-' . uniqid(),
            'header_text' => '',
            'header_title' => '',
            'content' => '',
            'img' => null,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['id'] = $this->options['id'];
        $attributes['role'] = 'alert';
        $attributes['aria-live'] = 'assertive';
        $attributes['aria-atomic'] = 'true';

        $toast = $this->createComponent('div', $attributes);
        $toast->addClass('toast');

        // Header
        $header = $this->createComponent('div', ['class' => 'toast-header']);

        if ($this->options['img']) {
            $header->append($this->createComponent('img', ['src' => $this->options['img'], 'class' => 'rounded me-2', 'alt' => '...']));
        }

        if ($this->options['header_title']) {
            $header->append($this->createComponent('strong', ['class' => 'me-auto'], $this->options['header_title']));
        }

        if ($this->options['header_text']) {
            $header->append($this->createComponent('small', [], $this->options['header_text']));
        }

        $header->append($this->createComponent('button', [
            'type' => 'button',
            'class' => 'btn-close',
            'data-bs-dismiss' => 'toast',
            'aria-label' => 'Close'
        ]));

        $toast->append($header);

        // Body
        $body = $this->createComponent('div', ['class' => 'toast-body'], $this->options['content']);
        $toast->append($body);

        return $toast;
    }
}
