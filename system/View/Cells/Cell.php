<?php

namespace Higgs\View\Cells;

use Higgs\Traits\PropertiesTrait;
use ReflectionClass;

class Cell
{
    use PropertiesTrait;

    protected string $view = '';

    public function setView(string $view)
    {
        $this->view = $view;
        return $this;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function render(): string
    {
        if (!function_exists('decamelize')) {
            helper('inflector');
        }
        return $this->view($this->view);
    }

    final protected function view(?string $view, array $data = []): string
    {
        $properties = $this->getPublicProperties();
        $properties = $this->includeComputedProperties($properties);
        $properties = array_merge($properties, $data);
        if (empty($view)) {
            $view = decamelize((new ReflectionClass($this))->getShortName());
            $view = str_replace('_cell', '', $view);
        }
        if (!is_file($view)) {
            $ref = new ReflectionClass($this);
            $view = dirname($ref->getFileName()) . DIRECTORY_SEPARATOR . $view . '.php';
        }
        return (function () use ($properties, $view): string {
            extract($properties);
            ob_start();
            include $view;
            return ob_get_clean() ?: '';
        })();
    }

    private function includeComputedProperties(array $properties): array
    {
        $reservedProperties = ['data', 'view'];
        $privateProperties = $this->getNonPublicProperties();
        foreach ($privateProperties as $property) {
            $name = $property->getName();
            if (in_array($name, $reservedProperties, true)) {
                continue;
            }
            $computedMethod = 'get' . ucfirst($name) . 'Property';
            if (method_exists($this, $computedMethod)) {
                $properties[$name] = $this->{$computedMethod}();
            }
        }
        return $properties;
    }
}