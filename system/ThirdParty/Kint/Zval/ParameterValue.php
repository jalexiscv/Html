<?php
declare(strict_types=1);

namespace Kint\Zval;

use Kint\Utils;
use ReflectionParameter;

class ParameterValue extends Value
{
    public $type_hint;
    public $default;
    public $position;
    public $hints = ['parameter'];

    public function __construct(ReflectionParameter $param)
    {
        parent::__construct();
        if ($type = $param->getType()) {
            $this->type_hint = Utils::getTypeString($type);
        }
        $this->reference = $param->isPassedByReference();
        $this->name = $param->getName();
        $this->position = $param->getPosition();
        if ($param->isDefaultValueAvailable()) {
            $default = $param->getDefaultValue();
            switch (\gettype($default)) {
                case 'NULL':
                    $this->default = 'null';
                    break;
                case 'boolean':
                    $this->default = $default ? 'true' : 'false';
                    break;
                case 'array':
                    $this->default = \count($default) ? 'array(...)' : 'array()';
                    break;
                default:
                    $this->default = \var_export($default, true);
                    break;
            }
        }
    }

    public function getType(): ?string
    {
        return $this->type_hint;
    }

    public function getName(): string
    {
        return '$' . $this->name;
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }
}