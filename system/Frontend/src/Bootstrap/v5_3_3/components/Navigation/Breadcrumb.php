<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Breadcrumb.
 * Constructor flexible.
 */
class Breadcrumb extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var array $items Array de items [['text' => '', 'url' => '', 'active' => bool]].
     *     @var string $divider Divisor personalizado (opcional via CSS var, pero Bootstrap usa variable).
     *     @var array $attributes Atributos del nav.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'items' => [],
            'divider' => null,
            'attributes' => ['aria-label' => 'breadcrumb']
        ]);
    }

    public function render(): TagInterface
    {
        $nav = $this->createComponent('nav', $this->options['attributes']);

        if ($this->options['divider']) {
            $nav->setAttribute('style', "--bs-breadcrumb-divider: '{$this->options['divider']}';");
        }

        $ol = $this->createComponent('ol', ['class' => 'breadcrumb']);

        foreach ($this->options['items'] as $item) {
            $liClass = 'breadcrumb-item';
            $isActive = $item['active'] ?? false;

            if ($isActive) {
                $liClass .= ' active';
            }

            $li = $this->createComponent('li', ['class' => $liClass]);

            if ($isActive) {
                $li->setAttribute('aria-current', 'page');
                $li->append($item['text']);
            } else {
                $li->append($this->createComponent('a', ['href' => $item['url'] ?? '#'], $item['text']));
            }

            $ol->append($li);
        }

        $nav->append($ol);

        return $nav;
    }
}
