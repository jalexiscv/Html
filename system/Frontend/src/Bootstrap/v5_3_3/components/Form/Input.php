<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Form;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Input.
 */
class Input extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $type Tipo (text, email, password, etc).
     *     @var string $name Nombre del campo.
     *     @var string|null $value Valor.
     *     @var string|null $label Etiqueta.
     *     @var string|null $id ID (si null, se genera a partir del name).
     *     @var string|null $placeholder Placeholder.
     *     @var bool $floating Floating label. Default: false.
     *     @var string|null $help_text Texto de ayuda.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'type' => 'text',
            'name' => '',
            'value' => null,
            'label' => null,
            'id' => null,
            'placeholder' => null,
            'floating' => false,
            'help_text' => null,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['type'] = $this->options['type'];
        $attributes['name'] = $this->options['name'];
        if ($this->options['value'] !== null) $attributes['value'] = $this->options['value'];
        $attributes['class'] = ($attributes['class'] ?? '') . ' form-control';

        $id = $this->options['id'] ?? 'input-' . $this->options['name'] . '-' . uniqid();
        $attributes['id'] = $id;

        if ($this->options['placeholder']) {
            $attributes['placeholder'] = $this->options['placeholder'];
        } elseif ($this->options['floating'] && $this->options['label']) {
            // Floating labels require a placeholder (can be empty space)
            $attributes['placeholder'] = $this->options['label'];
        }

        $input = $this->createComponent('input', $attributes);

        // Wrapper logic (if label or floating)
        if ($this->options['label']) {
            $label = $this->createComponent('label', ['for' => $id], $this->options['label']);

            if ($this->options['floating']) {
                $wrapper = $this->createComponent('div', ['class' => 'form-floating mb-3']);
                $wrapper->append($input);
                $wrapper->append($label);
                return $wrapper;
            } else {
                $label->addClass('form-label');
                $wrapper = $this->createComponent('div', ['class' => 'mb-3']);
                $wrapper->append($label);
                $wrapper->append($input);
                if ($this->options['help_text']) {
                    $wrapper->append($this->createComponent('div', ['class' => 'form-text'], $this->options['help_text']));
                }
                return $wrapper;
            }
        }

        return $input;
    }
}
