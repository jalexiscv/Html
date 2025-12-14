<?php
declare(strict_types=1);

namespace Kint\Zval;
class TraceValue extends Value
{
    public $hints = ['trace'];

    public function getType(): string
    {
        return 'Debug Backtrace';
    }

    public function getSize(): ?string
    {
        if (!$this->size) {
            return 'empty';
        }
        return parent::getSize();
    }
}