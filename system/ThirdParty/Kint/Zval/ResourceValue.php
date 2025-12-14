<?php
declare(strict_types=1);

namespace Kint\Zval;
class ResourceValue extends Value
{
    public $resource_type;

    public function getType(): string
    {
        if ($this->resource_type) {
            return $this->resource_type . ' resource';
        }
        return 'resource';
    }

    public function transplant(Value $old): void
    {
        parent::transplant($old);
        if ($old instanceof self) {
            $this->resource_type = $old->resource_type;
        }
    }
}