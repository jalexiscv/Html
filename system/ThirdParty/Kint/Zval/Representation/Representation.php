<?php
declare(strict_types=1);

namespace Kint\Zval\Representation;
class Representation
{
    public $label;
    public $implicit_label = false;
    public $hints = [];
    public $contents = [];
    protected $name;

    public function __construct(string $label, ?string $name = null)
    {
        $this->label = $label;
        if (null === $name) {
            $name = $label;
        }
        $this->setName($name);
    }

    public function getLabel(): string
    {
        if (\is_array($this->contents) && \count($this->contents) > 1) {
            return $this->label . ' (' . \count($this->contents) . ')';
        }
        return $this->label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = \preg_replace('/[^a-z0-9]+/', '_', \strtolower($name));
    }

    public function labelIsImplicit(): bool
    {
        return $this->implicit_label;
    }
}