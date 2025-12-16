<?php

declare(strict_types=1);

namespace Higgs\Html\Tag;

use Higgs\Html\Attribute\AttributeInterface;
use Higgs\Html\Attributes\AttributesInterface;
use Higgs\Html\Html;
use Higgs\Html\StringableInterface;

/**
 * Class AbstractTag
 * Proporciona la funcionalidad base para todas las etiquetas HTML.
 */
abstract class AbstractTag implements TagInterface
{
    protected string $name;
    protected AttributesInterface $attributes;
    protected array $content = [];
    protected array $preprocessCallbacks = [];
    protected bool $escapeContent = true; // Por defecto, el contenido se escapa

    /**
     * Constructor de AbstractTag.
     *
     * @param string $name El nombre de la etiqueta.
     * @param AttributesInterface $attributes Los atributos de la etiqueta.
     * @param mixed ...$content El contenido inicial.
     */
    public function __construct(string $name, AttributesInterface $attributes, ...$content)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->content(...$content);
    }

    /**
     * Clona el objeto, asegurando una copia profunda de los atributos.
     */
    public function __clone()
    {
        $this->attributes = clone $this->attributes;
    }

    /**
     * Convierte la etiqueta a su representación de cadena.
     *
     * @return string La etiqueta HTML renderizada.
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Gestiona los atributos de la etiqueta.
     *
     * @param string|null $name El nombre del atributo a obtener o establecer.
     * @param mixed ...$value El valor a establecer para el atributo.
     * @return AttributeInterface|string|self
     */
    public function attr(?string $name = null, ...$value)
    {
        if (null === $name) {
            return $this->attributes->render();
        }

        if (empty($value)) {
            return $this->attributes->get($name);
        }

        $this->attributes->set($name, ...$value);

        return $this;
    }

    /**
     * Gestiona el contenido de la etiqueta.
     *
     * @param mixed ...$data El contenido a establecer.
     * @return string|null El contenido actual como cadena.
     */
    public function content(...$data): ?string
    {
        if (empty($data)) {
            return $this->renderContent();
        }

        $this->content = [];
        $this->addContent(...$data);

        return null;
    }

    /**
     * Agrega contenido a la etiqueta.
     *
     * @param mixed ...$data El contenido a agregar.
     */
    protected function addContent(...$data): void
    {
        foreach ($data as $item) {
            if (is_array($item)) {
                $this->addContent(...$item);
            } elseif (null !== $item) {
                $this->content[] = $item;
            }
        }
    }

    /**
     * Obtiene el contenido como un array.
     *
     * @return array El contenido.
     */
    public function getContentAsArray(): array
    {
        return $this->content;
    }

    /**
     * Renderiza la etiqueta completa.
     *
     * @return string La etiqueta HTML.
     */
    public function render(): string
    {
        $attributes = $this->attributes->render();
        $content = $this->renderContent();

        return "<{$this->name}{$attributes}>{$content}</{$this->name}>";
    }

    /**
     * Renderiza solo el contenido de la etiqueta.
     *
     * @return string El contenido renderizado.
     */
    protected function renderContent(): string
    {
        $content = '';
        $processedContent = $this->preprocess($this->content);
        foreach ($processedContent as $item) {
            $string = $this->ensureString($item);
            if ($this->escapeContent && !$item instanceof TagInterface && !$item instanceof StringableInterface) {
                $string = $this->escape($string);
            }
            $content .= $string;
        }

        return $content;
    }

    /**
     * Habilita o deshabilita el escapado del contenido de la etiqueta.
     *
     * @param bool $enable Si es true (por defecto), el contenido se escapará; si es false, no.
     * @return self
     */
    public function setEscape(bool $enable = true): self
    {
        $this->escapeContent = $enable;
        return $this;
    }

    /**
     * Escapa un valor, cumpliendo con la EscapableInterface.
     *
     * @param mixed $value El valor a escapar.
     * @return string|null El valor escapado.
     */
    public function escape($value): ?string
    {
        $string = $this->ensureString($value);
        if (null === $string) {
            return null;
        }
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Agrega funciones de preprocesamiento.
     *
     * @param callable ...$callback Las funciones a agregar.
     * @return self
     */
    public function addPreprocess(callable ...$callback): self
    {
        $this->preprocessCallbacks = array_merge($this->preprocessCallbacks, $callback);
        return $this;
    }

    /**
     * Preprocesa los valores de un objeto, cumpliendo con la PreprocessableInterface.
     *
     * @param array $values Los valores a preprocesar.
     * @param array $context El contexto (no utilizado actualmente).
     * @return array Los valores procesados.
     */
    public function preprocess(array $values, array $context = []): array
    {
        foreach ($this->preprocessCallbacks as $callback) {
            $values = array_map($callback, $values);
        }
        return $values;
    }

    /**
     * Altera el objeto de la etiqueta aplicando uno o más closures.
     *
     * @param callable ...$closures Los closures a aplicar. Cada uno recibe la instancia de la etiqueta.
     * @return self
     */
    public function alter(callable ...$closures): self
    {
        foreach ($closures as $closure) {
            $closure($this);
        }

        return $this;
    }

    /**
     * Asegura que un valor sea una cadena.
     *
     * @param mixed $value El valor a convertir.
     * @return string|null La representación de cadena del valor.
     */
    protected function ensureString($value): ?string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_numeric($value) || (is_object($value) && method_exists($value, '__toString'))) {
            return (string) $value;
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        // Para otros tipos como array o resource, devuelve una representación o null
        return null;
    }


    /**
     * Agrega contenido hijo a la etiqueta.
     * 
     * @param mixed ...$content El contenido a agregar.
     * @return self
     */
    public function addChild(...$content)
    {
        $this->addContent(...$content);
        return $this;
    }
}
