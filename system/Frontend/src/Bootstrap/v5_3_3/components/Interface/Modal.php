<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Modal.
 * Constructor flexible.
 */
class Modal extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $id ID del modal.
     *     @var string $title Título del modal.
     *     @var mixed $content Contenido del cuerpo.
     *     @var mixed $footer Contenido del pie (botones, etc).
     *     @var string $size Tamaño (sm, lg, xl, fullscreen).
     *     @var bool|string $backdrop 'static' o bool. Default: true.
     *     @var bool $centered Centrado verticalmente. Default: false.
     *     @var bool $scrollable Scrollable. Default: false.
     *     @var bool $fade Animación fade. Default: true.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'id' => 'modal-' . uniqid(),
            'title' => '',
            'content' => '',
            'footer' => null,
            'size' => null,
            'backdrop' => true,
            'centered' => false,
            'scrollable' => false,
            'fade' => true,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['id'] = $this->options['id'];
        $attributes['tabindex'] = '-1';
        $attributes['aria-labelledby'] = $this->options['id'] . 'Label';

        // Backdrop handling
        if ($this->options['backdrop'] === 'static') {
            $attributes['data-bs-backdrop'] = 'static';
            $attributes['data-bs-keyboard'] = 'false';
        } elseif ($this->options['backdrop'] === false) {
            // If false, no backdrop (but bootstrap might need explicit handling or just omit)
            // Usually data-bs-backdrop="false" isn't standard attribute for modal, static is.
            // But let's leave it to user attributes if they want to disable backdrop fully via JS or custom.
            // Actually, Bootstrap 5 uses data-bs-backdrop="static" or boolean via JS options.
            // We'll set it as attribute if false provided explicitly? No, default is true. Set nothing.
        }

        $modal = $this->createComponent('div', $attributes);
        $modal->addClass('modal');
        if ($this->options['fade']) $modal->addClass('fade');
        $modal->setAttribute('aria-hidden', 'true');

        // Dialog
        $dialogClass = 'modal-dialog';
        if ($this->options['size']) $dialogClass .= ' modal-' . $this->options['size'];
        if ($this->options['centered']) $dialogClass .= ' modal-dialog-centered';
        if ($this->options['scrollable']) $dialogClass .= ' modal-dialog-scrollable';

        $dialog = $this->createComponent('div', ['class' => $dialogClass]);

        // Content
        $content = $this->createComponent('div', ['class' => 'modal-content']);

        // Header
        $header = $this->createComponent('div', ['class' => 'modal-header']);
        $header->append($this->createComponent('h1', ['class' => 'modal-title fs-5', 'id' => $this->options['id'] . 'Label'], $this->options['title']));
        $header->append($this->createComponent('button', [
            'type' => 'button',
            'class' => 'btn-close',
            'data-bs-dismiss' => 'modal',
            'aria-label' => 'Close'
        ]));
        $content->append($header);

        // Body
        $body = $this->createComponent('div', ['class' => 'modal-body'], $this->options['content']);
        $content->append($body);

        // Footer
        if ($this->options['footer']) {
            $footer = $this->createComponent('div', ['class' => 'modal-footer'], $this->options['footer']);
            $content->append($footer);
        }

        $dialog->append($content);
        $modal->append($dialog);

        return $modal;
    }
}
