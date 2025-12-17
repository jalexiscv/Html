<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Form;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Form.
 */
class Form extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var mixed $content Contenido del formulario.
     *     @var string $action URL de acción.
     *     @var string $method Método (POST, GET). Default: POST.
     *     @var bool $multipart Multipart/form-data. Default: false.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'content' => '',
            'action' => '',
            'method' => 'POST',
            'multipart' => false,
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        if ($this->options['action']) $attributes['action'] = $this->options['action'];
        $attributes['method'] = $this->options['method'];

        if ($this->options['multipart']) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        return $this->createComponent('form', $attributes, $this->options['content']);
    }
}
