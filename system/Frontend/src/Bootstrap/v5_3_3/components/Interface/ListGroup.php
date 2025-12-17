<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente ListGroup.
 * Constructor flexible.
 */
class ListGroup extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var array $items Items de lista [['text' => '', 'url' => '', 'active' => bool, 'disabled' => bool]].
     *     @var bool $flush Sin bordes externos. Default: false.
     *     @var bool $numbered Lista numerada. Default: false.
     *     @var bool $horizontal Horizontal. Default: false.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'items' => [],
            'flush' => false,
            'numbered' => false,
            'horizontal' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $tag = $this->options['numbered'] ? 'ol' : 'ul';
        // If items are links (have url), we might want a div container usually, or just use 'a' tags inside.
        // But standard list group is usually ul/li or div/a.
        // Let's check logic: if strictly links, maybe use div.list-group + a.list-group-item.
        // Standard Bootstrap: ul.list-group > li.list-group-item.

        // Let's default to ul/li unless specific need?
        // If user provides 'url' in items, we can use actions (div > a) or (ul > li > a?? No, ul > li or div > a).
        // Let's support both via checking items. If any item has URL, maybe switch to div > a or keep ul > li (but li shouldn't be a link itself unless a child).
        // Bootstrap: "List group items can be buttons or links" -> use <div> or <ul>.

        $hasLinks = false;
        foreach ($this->options['items'] as $item) {
            if (!empty($item['url'])) {
                $hasLinks = true;
                break;
            }
        }

        if ($hasLinks && !$this->options['numbered']) {
            $tag = 'div';
        }

        $list = $this->createComponent($tag, $this->options['attributes']);
        $list->addClass('list-group');

        if ($this->options['flush']) $list->addClass('list-group-flush');
        if ($this->options['numbered']) $list->addClass('list-group-numbered');
        if ($this->options['horizontal']) $list->addClass('list-group-horizontal');

        foreach ($this->options['items'] as $item) {
            $list->append($this->createItem($item, $tag));
        }

        return $list;
    }

    private function createItem(array $item, string $parentTag): TagInterface
    {
        $tag = ($parentTag === 'div' || !empty($item['url'])) ? 'a' : 'li';
        if (isset($item['onClick']) || (isset($item['type']) && $item['type'] === 'button')) {
            $tag = 'button';
        }

        $attributes = ['class' => 'list-group-item'];

        if ($tag === 'a') {
            $attributes['class'] .= ' list-group-item-action';
            $attributes['href'] = $item['url'] ?? '#';
        } elseif ($tag === 'button') {
            $attributes['class'] .= ' list-group-item-action';
            $attributes['type'] = 'button';
        }

        if ($item['active'] ?? false) {
            $attributes['class'] .= ' active';
            $attributes['aria-current'] = 'true';
        }

        if ($item['disabled'] ?? false) {
            $attributes['class'] .= ' disabled';
            if ($tag === 'a') $attributes['aria-disabled'] = 'true';
            if ($tag === 'button') $attributes['disabled'] = 'disabled';
        }

        return $this->createComponent($tag, $attributes, $item['text'] ?? '');
    }
}
