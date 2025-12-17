<?php

declare(strict_types=1);

namespace Higgs\Frontend\Bootstrap\v5_3_3\Components\Navigation;

use Higgs\Frontend\Bootstrap\v5_3_3\AbstractComponent;
use Higgs\Html\Tag\TagInterface;

/**
 * Componente Navbar de Bootstrap 5.
 * Constructor flexible.
 */
class Navbar extends AbstractComponent
{
    private array $options;

    /**
     * @param array $options {
     *     @var array $brand Configuración de marca ['text' => '', 'url' => '#', 'image' => null].
     *     @var string $expand Breakpoint de expansión (sm, md, lg, xl, xxl). Default: 'lg'.
     *     @var string $variant Variante de color (light, dark). Default: 'light'.
     *     @var string $bgBackground Clase de fondo (bg-light, bg-dark, bg-primary). Default: 'bg-light'.
     *     @var mixed $content Contenido del navbar (items, forms, etc).
     *     @var bool $container Si debe incluir un container fluido o normal. Default: true.
     *     @var string $container_type Tipo de container (container, container-fluid). Default: 'container-fluid'.
     *     @var array $attributes Atributos adicionales.
     * }
     */
    public function __construct(array $options = [])
    {
        $this->options = $this->resolveOptions($options, [
            'brand' => null,
            'expand' => 'lg',
            'variant' => 'light',
            'bgBackground' => 'bg-light',
            'content' => '',
            'container' => true,
            'container_type' => 'container-fluid',
            'attributes' => []
        ]);
    }

    public function render(): TagInterface
    {
        $attributes = $this->options['attributes'];
        $nav = $this->createComponent('nav', $attributes);
        $nav->addClass('navbar');
        $nav->addClass('navbar-expand-' . $this->options['expand']);

        // Variant data-bs-theme="dark/light" in v5.3+ or navbar-dark/light in older.
        // v5.3 uses data-bs-theme.
        $nav->setAttribute('data-bs-theme', $this->options['variant']);
        $nav->addClass($this->options['bgBackground']);

        $wrapper = $nav;
        if ($this->options['container']) {
            $container = $this->createComponent('div', ['class' => $this->options['container_type']]);
            $nav->append($container);
            $wrapper = $container;
        }

        // Brand
        if ($this->options['brand']) {
            $brandData = $this->options['brand'];
            $brand = $this->createComponent('a', ['class' => 'navbar-brand', 'href' => $brandData['url'] ?? '#']);

            if (isset($brandData['image'])) {
                $img = $this->createComponent('img', [
                    'src' => $brandData['image'],
                    'alt' => $brandData['text'] ?? 'Brand',
                    'class' => 'd-inline-block align-text-top'
                ]);
                // If height/width provided? Bootstrap usually expects manual sizing or class.
                $brand->append($img);
                if (isset($brandData['text'])) {
                    $brand->append(' ' . $brandData['text']);
                }
            } else {
                $brand->append($brandData['text'] ?? '');
            }
            $wrapper->append($brand);
        }

        // Toggler
        // We need an ID for collapse. 
        $collapseId = 'navbar-collapse-' . uniqid();

        $toggler = $this->createComponent('button', [
            'class' => 'navbar-toggler',
            'type' => 'button',
            'data-bs-toggle' => 'collapse',
            'data-bs-target' => '#' . $collapseId,
            'aria-controls' => $collapseId,
            'aria-expanded' => 'false',
            'aria-label' => 'Toggle navigation'
        ]);
        $toggler->append($this->createComponent('span', ['class' => 'navbar-toggler-icon']));
        $wrapper->append($toggler);

        // Collapse
        $collapse = $this->createComponent('div', ['class' => 'collapse navbar-collapse', 'id' => $collapseId]);

        if ($this->options['content']) {
            $collapse->append($this->options['content']);
        }

        $wrapper->append($collapse);

        return $nav;
    }
}
