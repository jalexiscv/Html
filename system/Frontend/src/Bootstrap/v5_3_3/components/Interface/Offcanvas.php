<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Offcanvas.
 * Constructor flexible.
 */
class Offcanvas extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $id ID único (requerido para triggers).
     *     @var string $title Título.
     *     @var mixed $content Contenido del cuerpo.
     *     @var string $placement Posición (start, end, top, bottom). Default: 'start'.
     *     @var bool|string $backdrop Backdrop (true, false, 'static'). Default: true.
     *     @var bool $scroll Permitir scroll del body. Default: false.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'id' => 'offcanvas-' . uniqid(),
            'title' => '',
            'content' => '',
            'placement' => 'start',
            'backdrop' => true,
            'scroll' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['id'] = $this->options['id'];
        $attributes['tabindex'] = '-1';
        $attributes['aria-labelledby'] = $this->options['id'] . 'Label';

        if ($this->options['backdrop'] === 'static') {
            $attributes['data-bs-backdrop'] = 'static';
        } elseif ($this->options['backdrop'] === false) {
            $attributes['data-bs-backdrop'] = 'false';
        }

        if ($this->options['scroll']) {
            $attributes['data-bs-scroll'] = 'true';
        }

        $offcanvas = $this->createComponent('div', $attributes);
        $offcanvas->addClass('offcanvas offcanvas-' . $this->options['placement']);

        // Header
        $header = $this->createComponent('div', ['class' => 'offcanvas-header']);
        $header->append($this->createComponent('h5', ['class' => 'offcanvas-title', 'id' => $this->options['id'] . 'Label'], $this->options['title']));
        $header->append($this->createComponent('button', [
            'type' => 'button',
            'class' => 'btn-close',
            'data-bs-dismiss' => 'offcanvas',
            'aria-label' => 'Close'
        ]));
        $offcanvas->append($header);

        // Body
        $body = $this->createComponent('div', ['class' => 'offcanvas-body'], $this->options['content']);
        $offcanvas->append($body);

        return $offcanvas;
    }
}
