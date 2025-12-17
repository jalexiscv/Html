<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Pagination.
 * Constructor flexible.
 */
class Pagination extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var int $total Total ítems.
     *     @var int $current Página actual.
     *     @var int $perPage Ítems por página. Default: 10.
     *     @var string $url_pattern Patrón de URL (ej: /page/(:num)).
     *     @var string $size Tamaño (sm, lg).
     *     @var string $alignment Alineación (center, end).
     *     @var array $attributes Atributos del nav.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'total' => 0,
            'current' => 1,
            'perPage' => 10,
            'url_pattern' => '?page=(:num)',
            'size' => null,
            'alignment' => null,
            'attributes' => ['aria-label' => 'Page navigation']
        ]);
    }

    public function render(): TagInterface
    {
        $nav = $this->createComponent('nav', $this->options['attributes']);
        $ul = $this->createComponent('ul', ['class' => 'pagination']);

        $this->addSizeClasses($ul, $this->options['size'], 'pagination');
        if ($this->options['alignment']) {
            $ul->addClass('justify-content-' . $this->options['alignment']);
        }

        $totalPages = (int)ceil($this->options['total'] / $this->options['perPage']);
        $current = $this->options['current'];

        // Prev
        $ul->append($this->createPageItem(
            '&laquo;',
            $this->getUrl($current - 1),
            $current <= 1,
            false,
            'Previous'
        ));

        // Pages (Simplified logic: show all or simple range)
        // For full component, normally we'd implement windowing logic (e.g. 1 2 ... 5 6 7 ... 10)
        // Let's implement simple full range for now as per "Basic" requirement, or a small window?
        // Let's do simple 1..N loop for robustness for now.
        for ($i = 1; $i <= $totalPages; $i++) {
            $ul->append($this->createPageItem(
                (string)$i,
                $this->getUrl($i),
                false,
                $i === $current
            ));
        }

        // Next
        $ul->append($this->createPageItem(
            '&raquo;',
            $this->getUrl($current + 1),
            $current >= $totalPages,
            false,
            'Next'
        ));

        $nav->append($ul);
        return $nav;
    }

    private function createPageItem(string $text, string $url, bool $disabled, bool $active, ?string $label = null): TagInterface
    {
        $li = $this->createComponent('li', ['class' => 'page-item']);
        if ($disabled) $li->addClass('disabled');
        if ($active) $li->addClass('active');

        $attrs = ['class' => 'page-link', 'href' => $disabled ? '#' : $url];
        if ($label) $attrs['aria-label'] = $label;
        if ($disabled) {
            $attrs['tabindex'] = '-1';
            $attrs['aria-disabled'] = 'true';
        }

        $a = $this->createComponent('a', $attrs);
        if ($label) {
            $a->append($this->createComponent('span', ['aria-hidden' => 'true'], $text));
        } else {
            $a->append($text);
        }

        $li->append($a);
        return $li;
    }

    private function getUrl(int $page): string
    {
        return str_replace('(:num)', (string)$page, $this->options['url_pattern']);
    }
}
