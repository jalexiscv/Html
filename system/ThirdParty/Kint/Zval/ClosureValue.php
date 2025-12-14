<?php
declare(strict_types=1);

namespace Kint\Zval;
class ClosureValue extends InstanceValue
{
    use ParameterHoldingTrait;

    public $hints = ['object', 'callable', 'closure'];

    public function getAccessPath(): ?string
    {
        if (null !== $this->access_path) {
            return parent::getAccessPath() . '(' . $this->getParams() . ')';
        }
        return null;
    }

    public function getSize(): ?string
    {
        return null;
    }

    public function transplant(Value $old): void
    {
        parent::transplant($old);
        if (0 === $this->depth && \preg_match('/^\\((function|fn)\\s*\\(/i', $this->access_path, $match)) {
            $this->name = \strtolower($match[1]);
        }
    }
}