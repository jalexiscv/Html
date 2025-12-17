<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Form;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente File input.
 */
class File extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var string $name Nombre.
     *     @var string|null $label Etiqueta.
     *     @var bool $multiple Múltiples archivos.
     *     @var array $attributes Atributos.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'name' => '',
            'label' => null,
            'multiple' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $attributes['type'] = 'file';
        $attributes['name'] = $this->options['name'];
        if ($this->options['multiple']) $attributes['multiple'] = 'multiple';
        $attributes['class'] = ($attributes['class'] ?? '') . ' form-control';

        $id = $attributes['id'] ?? 'file-' . $this->options['name'] . '-' . uniqid();
        $attributes['id'] = $id;

        $input = $this->createComponent('input', $attributes);

        if ($this->options['label']) {
            $label = $this->createComponent('label', ['for' => $id, 'class' => 'form-label'], $this->options['label']);
            $wrapper = $this->createComponent('div', ['class' => 'mb-3']);
            $wrapper->append($label);
            $wrapper->append($input);
            return $wrapper;
        }

        return $input;
    }
}
