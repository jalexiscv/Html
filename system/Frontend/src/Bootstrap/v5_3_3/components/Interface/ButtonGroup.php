<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Interface;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente ButtonGroup.
 * Constructor flexible.
 */
class ButtonGroup extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var array $buttons Array de objetos Button o TagInterface.
     *     @var bool $vertical Orientación vertical. Default: false.
     *     @var string|null $size Tamaño del grupo (sm, lg).
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'buttons' => [],
            'vertical' => false,
            'size' => null,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $groupClass = $this->options['vertical'] ? 'btn-group-vertical' : 'btn-group';

        $group = $this->createComponent('div', $this->options['attributes']);
        $group->addClass($groupClass);
        $group->setAttribute('role', 'group');

        $this->addSizeClasses($group, $this->options['size'], 'btn-group');

        foreach ($this->options['buttons'] as $btn) {
            $group->append($btn);
        }

        return $group;
    }
}
