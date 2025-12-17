<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Form;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Check/Radio.
 */
class Check extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $name Nombre.
     *     @var string $type 'checkbox' o 'radio'. Default: 'checkbox'.
     *     @var string|null $value Valor del input.
     *     @var string|null $label Etiqueta.
     *     @var bool $checked Marcado.
     *     @var bool $switch Estilo switch (solo checkbox).
     *     @var bool $inline En línea.
     *     @var array $attributes Atributos.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'name' => '',
            'type' => 'checkbox',
            'value' => '1',
            'label' => '',
            'checked' => false,
            'switch' => false,
            'inline' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['type'] = $this->options['type'];
        $attributes['name'] = $this->options['name'];
        $attributes['value'] = $this->options['value'];
        $attributes['class'] = ($attributes['class'] ?? '') . ' form-check-input';

        $id = $attributes['id'] ?? 'check-' . $this->options['name'] . '-' . uniqid();
        $attributes['id'] = $id;

        if ($this->options['checked']) {
            $attributes['checked'] = 'checked';
        }

        if ($this->options['type'] === 'checkbox' && $this->options['switch']) {
            $attributes['role'] = 'switch';
        }

        $input = $this->createComponent('input', $attributes);
        $label = $this->createComponent('label', ['class' => 'form-check-label', 'for' => $id], $this->options['label']);

        $wrapperClass = 'form-check';
        if ($this->options['switch']) $wrapperClass .= ' form-switch';
        if ($this->options['inline']) $wrapperClass .= ' form-check-inline';

        $wrapper = $this->createComponent('div', ['class' => $wrapperClass]);
        $wrapper->append($input);
        $wrapper->append($label);

        return $wrapper;
    }
}
