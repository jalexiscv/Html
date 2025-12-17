<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Content;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Table.
 */
class Table extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var array $headers Array de headers (strings).
     *     @var array $rows Array de filas (arrays de celdas).
     *     @var bool $striped Striped.
     *     @var bool $hover Hoverable.
     *     @var bool $bordered Bordered.
     *     @var string|null $variant Variante (dark, primary, etc).
     *     @var bool $responsive Responsive wrapper.
     *     @var array $attributes Atributos table.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'headers' => [],
            'rows' => [],
            'striped' => false,
            'hover' => false,
            'bordered' => false,
            'variant' => null,
            'responsive' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $class = 'table';
        if ($this->options['striped']) $class .= ' table-striped';
        if ($this->options['hover']) $class .= ' table-hover';
        if ($this->options['bordered']) $class .= ' table-bordered';
        if ($this->options['variant']) $class .= ' table-' . $this->options['variant'];

        $attributes['class'] = ($attributes['class'] ?? '') . ' ' . $class;

        $table = $this->createComponent('table', $attributes);

        // Thead
        if (!empty($this->options['headers'])) {
            $thead = $this->createComponent('thead');
            $tr = $this->createComponent('tr');
            foreach ($this->options['headers'] as $h) {
                $tr->append($this->createComponent('th', ['scope' => 'col'], $h));
            }
            $thead->append($tr);
            $table->append($thead);
        }

        // Tbody
        if (!empty($this->options['rows'])) {
            $tbody = $this->createComponent('tbody');
            foreach ($this->options['rows'] as $row) {
                $tr = $this->createComponent('tr');
                foreach ($row as $cell) {
                    $tr->append($this->createComponent('td', [], $cell));
                }
                $tbody->append($tr);
            }
            $table->append($tbody);
        }

        if ($this->options['responsive']) {
            $wrapper = $this->createComponent('div', ['class' => 'table-responsive']);
            $wrapper->append($table);
            return $wrapper;
        }

        return $table;
    }
}
