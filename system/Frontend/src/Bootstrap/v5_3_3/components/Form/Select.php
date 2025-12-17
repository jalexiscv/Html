<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Form;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Select.
 */
class Select extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $name Nombre.
     *     @var array $options_list Array de opciones ['value' => 'Label']. O [['value'=>'', 'text'=>'']].
     *     @var mixed $selected Valor seleccionado.
     *     @var string|null $label Etiqueta.
     *     @var bool $floating Floating label.
     *     @var array $attributes Atributos.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'name' => '',
            'options_list' => [],
            'selected' => null,
            'label' => null,
            'floating' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['name'] = $this->options['name'];
        $attributes['class'] = ($attributes['class'] ?? '') . ' form-select';

        $id = $attributes['id'] ?? 'select-' . $this->options['name'] . '-' . uniqid();
        $attributes['id'] = $id;

        $select = $this->createComponent('select', $attributes);

        foreach ($this->options['options_list'] as $key => $val) {
            $optVal = is_array($val) ? $val['value'] : $key;
            $optText = is_array($val) ? $val['text'] : $val;

            $optAttrs = ['value' => $optVal];
            if ($this->options['selected'] == $optVal) {
                $optAttrs['selected'] = 'selected';
            }

            $select->append($this->createComponent('option', $optAttrs, $optText));
        }

        if ($this->options['label']) {
            $label = $this->createComponent('label', ['for' => $id], $this->options['label']);
            if ($this->options['floating']) {
                $wrapper = $this->createComponent('div', ['class' => 'form-floating mb-3']);
                $wrapper->append($select);
                $wrapper->append($label);
                return $wrapper;
            } else {
                $label->addClass('form-label');
                $wrapper = $this->createComponent('div', ['class' => 'mb-3']);
                $wrapper->append($label);
                $wrapper->append($select);
                return $wrapper;
            }
        }

        return $select;
    }
}
