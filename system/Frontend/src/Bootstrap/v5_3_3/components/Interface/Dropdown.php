<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Dropdown.
 * Constructor flexible.
 */
class Dropdown extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var mixed $toggle Contenido/Texto del botón toggle.
     *     @var array $items Items del menú [['text' => '', 'url' => '', 'divider' => bool, 'header' => bool]].
     *     @var string $variant Variante del botón. Default: 'secondary'.
     *     @var string $direction Dirección (dropup, dropend, dropstart). Default: 'dropdown'.
     *     @var bool $split Split dropdown. Default: false.
     *     @var string $size Tamaño del botón.
     *     @var bool $dark Menú oscuro. Default: false.
     *     @var array $attributes Atributos del contenedor.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'toggle' => 'Dropdown',
            'items' => [],
            'variant' => 'secondary',
            'direction' => 'dropdown',
            'split' => false,
            'size' => null,
            'dark' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $wrapper = $this->createComponent('div', $this->options['attributes']);

        // Direction class
        $direction = $this->options['direction'] === 'dropdown' ? 'dropdown' : $this->options['direction']; // 'dropdown' is default class but container is usually 'dropdown'
        // Actually, 'dropup', 'dropend', 'dropstart' replace 'dropdown' on the wrapper if needed?
        // Bootstrap docs: .dropdown, .dropup, .dropend, .dropstart, .dropcenter (v5.2+)
        $wrapper->addClass($direction);
        if ($this->options['direction'] === 'center') $wrapper->addClass('dropdown-center');

        // Toggle Button
        $btnClass = 'btn btn-' . $this->options['variant'] . ' dropdown-toggle';
        if ($this->options['size']) $btnClass .= ' btn-' . $this->options['size'];

        if ($this->options['split']) {
            // Split button logic: Button + Toggle
            $btnMain = $this->createComponent('button', [
                'type' => 'button',
                'class' => 'btn btn-' . $this->options['variant'] . ($this->options['size'] ? ' btn-' . $this->options['size'] : '')
            ], $this->options['toggle']);

            $btnToggle = $this->createComponent('button', [
                'type' => 'button',
                'class' => $btnClass . ' dropdown-toggle-split',
                'data-bs-toggle' => 'dropdown',
                'aria-expanded' => 'false'
            ]);
            $btnToggle->append($this->createComponent('span', ['class' => 'visually-hidden'], 'Toggle Dropdown'));

            $wrapper->addClass('btn-group'); // Split needs btn-group wrapper
            $wrapper->removeClass($direction); // remove if btn-group handles it? No, btn-group + dropup usually works.

            $wrapper->append($btnMain);
            $wrapper->append($btnToggle);
        } else {
            $btn = $this->createComponent('button', [
                'class' => $btnClass,
                'type' => 'button',
                'data-bs-toggle' => 'dropdown',
                'aria-expanded' => 'false'
            ], $this->options['toggle']);
            $wrapper->append($btn);
        }

        // Menu
        $menuClass = 'dropdown-menu';
        if ($this->options['dark']) $menuClass .= ' dropdown-menu-dark';

        $ul = $this->createComponent('ul', ['class' => $menuClass]);

        foreach ($this->options['items'] as $item) {
            $li = $this->createComponent('li');

            if ($item['divider'] ?? false) {
                $li->append($this->createComponent('hr', ['class' => 'dropdown-divider']));
            } elseif ($item['header'] ?? false) {
                $li->append($this->createComponent('h6', ['class' => 'dropdown-header'], $item['text'] ?? ''));
            } else {
                $a = $this->createComponent('a', [
                    'class' => 'dropdown-item' . (($item['active'] ?? false) ? ' active' : '') . (($item['disabled'] ?? false) ? ' disabled' : ''),
                    'href' => $item['url'] ?? '#'
                ], $item['text'] ?? '');
                $li->append($a);
            }
            $ul->append($li);
        }

        $wrapper->append($ul);

        return $wrapper;
    }
}
