<?php

declare(strict_types=1);

namespace Higgs\Html\Tag;

use Higgs\Html\AbstractBaseHtmlTagObject;
use Higgs\Html\Attributes\AttributesInterface;
use Higgs\Html\StringableInterface;

abstract class AbstractTag extends AbstractBaseHtmlTagObject implements TagInterface
{
    /**
     * Constructor de la Etiqueta.
     *
     * @param AttributesInterface $attributes
     *   El objeto de atributos.
     * @param string|null $tag
     *   El nombre de la etiqueta.
     * @param mixed $content
     *   El contenido.
     */
    public function __construct(
        /**
         * Los atributos de la etiqueta.
         */
        private AttributesInterface $attributes,
        /**
         * El nombre de la etiqueta.
         */
        private ?string $tag = null,
        mixed $content = null
    ) {
        $this->content($content);
    }

    public function content(...$data): ?string
    {
        if ([] !== $data) {
            if (null === reset($data)) {
                $data = null;
            }

            $this->content = $data;
        }

        return $this->renderContent();
    }

    /**
     * Renderiza el contenido de la etiqueta.
     */
    protected function renderContent(): ?string
    {
        return [] === ($items = array_map([$this, 'escape'], $this->getContentAsArray())) ?
            null :
            implode('', $items);
    }

    /**
     * @return array<int, string>
     */
    public function getContentAsArray(): array
    {
        return $this->preprocess(
            $this->ensureFlatArray((array)$this->content)
        );
    }

    public function preprocess(array $values, array $context = []): array
    {
        return ($values);
    }

    /**
     * @param array<string> $arguments
     *
     * @return TagInterface
     */
    public static function __callStatic(string $name, array $arguments = [])
    {
        return new static($arguments[0], $name);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Lista de elementos vacíos de HTML5.
     *
     * @var array<string>
     */
    private const VOID_ELEMENTS = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 
        'link', 'meta', 'param', 'source', 'track', 'wbr'
    ];

    public function render(): string
    {
        $content = $this->renderContent();
        $isVoid = in_array(strtolower($this->tag), self::VOID_ELEMENTS, true);

        if ($isVoid) {
            // Los elementos vacíos no pueden tener contenido.
            return sprintf('<%s%s>', $this->tag, $this->attributes->render());
        }

        // Los elementos no vacíos deben tener estrictamente una etiqueta de cierre, incluso si el contenido es nulo/vacío.
        return sprintf('<%s%s>%s</%s>', $this->tag, $this->attributes->render(), $content ?? '', $this->tag);
    }

    public function alter(callable ...$closures): TagInterface
    {
        foreach ($closures as $closure) {
            $this->content = $closure(
                $this->ensureFlatArray((array)$this->content)
            );
        }

        return $this;
        return $this;
    }

    /**
     * Maneja el establecimiento dinámico de atributos vía llamadas a métodos.
     * Ejemplo: $tag->id('my-id') se convierte en $tag->attr('id', 'my-id')
     *
     * @param string $name
     * @param array $arguments
     * @return $this|mixed
     */
    public function __call(string $name, array $arguments)
    {
        if (empty($arguments)) {
            // Get attribute value if no arguments
             return $this->attributes[$name] ?? null;
        }

        // Set attribute value
        $this->attr($name, ...$arguments);
        return $this;
    }

    public function attr(?string $name = null, ...$value)
    {
        if (null === $name) {
            return ($this->attributes->render());
        }

        if ([] === $value) {
            return ($this->attributes[$name]);
        }

        return $this->attributes[$name]->set($value);
    }

    public function escape($value): ?string
    {
        $return = $this->ensureString($value);

        if ($value instanceof StringableInterface) {
            return ($return);
        }

        //return null === $return ?$return :htmlentities($return);
        return null === $return ? $return : $return;
    }

    public function serialize()
    {
        return serialize([
            'tag' => $this->tag,
            'attributes' => $this->attributes->getValuesAsArray(),
            'content' => $this->renderContent(),
        ]);
    }

    public function unserialize($serialized)
    {
        $unserialize = unserialize($serialized);

        $this->tag = $unserialize['tag'];
        $this->attributes = $this->attributes->import($unserialize['attributes']);
        $this->content = $unserialize['content'];
    }
}
