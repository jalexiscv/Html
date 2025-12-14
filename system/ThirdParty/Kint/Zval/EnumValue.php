<?php
declare(strict_types=1);

namespace Kint\Zval;

use BackedEnum;
use UnitEnum;

class EnumValue extends InstanceValue
{
    public $enumval;
    public $hints = ['object', 'enum'];

    public function __construct(UnitEnum $enumval)
    {
        $this->enumval = $enumval;
    }

    public function getValueShort(): ?string
    {
        if ($this->enumval instanceof BackedEnum) {
            if (\is_string($this->enumval->value)) {
                return '"' . $this->enumval->value . '"';
            }
            return (string)$this->enumval->value;
        }
        return null;
    }

    public function getType(): ?string
    {
        if (isset($this->classname)) {
            if (isset($this->enumval->name)) {
                return $this->classname . '::' . $this->enumval->name;
            }
            return $this->classname;
        }
        return null;
    }

    public function getSize(): ?string
    {
        return null;
    }
}