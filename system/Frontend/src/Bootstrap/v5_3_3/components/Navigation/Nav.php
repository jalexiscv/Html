<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Nav (Base navigation).
 * Constructor flexible.
 */
class Nav extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var array $items Array de items [['text' => '', 'url' => '', 'active' => bool, 'disabled' => bool]].
     *     @var bool $navbar Si es true, usa clase 'navbar-nav' en lugar de 'nav'. Default: false.
     *     @var bool $pills Estilo pills. Default: false.
     *     @var bool $tabs Estilo tabs. Default: false.
     *     @var bool $fill Llenar espacio. Default: false.
     *     @var bool $justified Justificado. Default: false.
     *     @var bool $vertical Vertical. Default: false.
     *     @var string $element Elemento base (ul, nav). Default: 'ul'.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'items' => [],
            'navbar' => false,
            'pills' => false,
            'tabs' => false,
            'fill' => false,
            'justified' => false,
            'vertical' => false,
            'element' => 'ul',
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $tag = $this->options['element'];
        $nav = $this->createComponent($tag, $this->options['attributes']);

        $baseClass = $this->options['navbar'] ? 'navbar-nav' : 'nav';
        $nav->addClass($baseClass);

        if ($this->options['pills']) $nav->addClass('nav-pills');
        if ($this->options['tabs']) $nav->addClass('nav-tabs');
        if ($this->options['fill']) $nav->addClass('nav-fill');
        if ($this->options['justified']) $nav->addClass('nav-justified');
        if ($this->options['vertical']) $nav->addClass('flex-column');

        foreach ($this->options['items'] as $item) {
            $nav->append($this->createNavItem($item));
        }

        return $nav;
    }

    private function createNavItem(array $item): TagInterface
    {
        $li = $this->createComponent('li', ['class' => 'nav-item']);

        $linkAttrs = ['class' => 'nav-link'];
        if ($item['active'] ?? false) {
            $linkAttrs['class'] .= ' active';
            $linkAttrs['aria-current'] = 'page';
        }
        if ($item['disabled'] ?? false) {
            $linkAttrs['class'] .= ' disabled';
            $linkAttrs['aria-disabled'] = 'true';
            $linkAttrs['tabindex'] = '-1';
        }

        $linkAttrs['href'] = $item['url'] ?? '#';

        $a = $this->createComponent('a', $linkAttrs, $item['text'] ?? '');
        $li->append($a);

        return $li;
    }
}
