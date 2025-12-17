<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Accordion.
 * Constructor flexible.
 */
class Accordion extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $id ID único del acordeón.
     *     @var array $items Array de items [['title' => '', 'content' => '', 'expanded' => false]].
     *     @var bool $flush Si es estilo flush. Default: false.
     *     @var bool $always_open Si los items se mantienen abiertos independientemente. Default: false.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'id' => 'accordion-' . uniqid(),
            'items' => [],
            'flush' => false,
            'always_open' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $accordion = $this->createComponent('div', $this->options['attributes']);
        $accordion->addClass('accordion');
        $accordion->setId($this->options['id']);

        if ($this->options['flush']) {
            $accordion->addClass('accordion-flush');
        }

        foreach ($this->options['items'] as $index => $item) {
            $accordion->append($this->createItem($item, $index));
        }

        return $accordion;
    }

    private function createItem(array $item, int $index): TagInterface
    {
        $itemId = $this->options['id'] . '-item-' . $index;
        $headerId = $itemId . '-header';
        $collapseId = $itemId . '-collapse';
        $expanded = $item['expanded'] ?? false;

        // Item Container
        $itemDiv = $this->createComponent('div', ['class' => 'accordion-item']);

        // Header (h2 button wrapper)
        $header = $this->createComponent('h2', ['class' => 'accordion-header', 'id' => $headerId]);

        $button = $this->createComponent('button', [
            'class' => 'accordion-button' . ($expanded ? '' : ' collapsed'),
            'type' => 'button',
            'data-bs-toggle' => 'collapse',
            'data-bs-target' => '#' . $collapseId,
            'aria-expanded' => $expanded ? 'true' : 'false',
            'aria-controls' => $collapseId
        ], $item['title']);

        $header->append($button);
        $itemDiv->append($header);

        // Collapse Body
        $collapseDiv = $this->createComponent('div', [
            'id' => $collapseId,
            'class' => 'accordion-collapse collapse' . ($expanded ? ' show' : ''),
            'aria-labelledby' => $headerId
        ]);

        if (!$this->options['always_open']) {
            $collapseDiv->setAttribute('data-bs-parent', '#' . $this->options['id']);
        }

        $body = $this->createComponent('div', ['class' => 'accordion-body'], $item['content']);
        $collapseDiv->append($body);

        $itemDiv->append($collapseDiv);

        return $itemDiv;
    }
}
