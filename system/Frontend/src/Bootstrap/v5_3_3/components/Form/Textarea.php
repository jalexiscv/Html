<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Form;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Textarea.
 */
class Textarea extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $name Nombre.
     *     @var string|null $value Valor/Contenido.
     *     @var string|null $label Etiqueta.
     *     @var bool $floating Floating label.
     *     @var int $rows Filas. Default: 3.
     *     @var array $attributes Atributos.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'name' => '',
            'value' => '',
            'label' => null,
            'floating' => false,
            'rows' => 3,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['name'] = $this->options['name'];
        $attributes['rows'] = (string)$this->options['rows'];
        $attributes['class'] = ($attributes['class'] ?? '') . ' form-control';

        $id = $attributes['id'] ?? 'textarea-' . $this->options['name'] . '-' . uniqid();
        $attributes['id'] = $id;

        if ($this->options['floating']) {
            $attributes['placeholder'] = $this->options['label'] ?? 'Leave a comment here';
        }

        $textarea = $this->createComponent('textarea', $attributes, $this->options['value']);

        if ($this->options['label']) {
            $label = $this->createComponent('label', ['for' => $id], $this->options['label']);
            if ($this->options['floating']) {
                $wrapper = $this->createComponent('div', ['class' => 'form-floating mb-3']);
                $wrapper->append($textarea);
                $wrapper->append($label);
                return $wrapper;
            } else {
                $label->addClass('form-label');
                $wrapper = $this->createComponent('div', ['class' => 'mb-3']);
                $wrapper->append($label);
                $wrapper->append($textarea);
                return $wrapper;
            }
        }

        return $textarea;
    }
}
