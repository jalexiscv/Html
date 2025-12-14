<?php
declare(strict_types=1);

namespace Kint\Zval;
trait ParameterHoldingTrait
{
    public $parameters = [];
    private $paramcache;

    public function getParams(): string
    {
        if (null !== $this->paramcache) {
            return $this->paramcache;
        }
        $out = [];
        foreach ($this->parameters as $p) {
            $type = $p->getType();
            if ($type) {
                $type .= ' ';
            }
            $default = $p->getDefault();
            if ($default) {
                $default = ' = ' . $default;
            }
            $ref = $p->reference ? '&' : '';
            $out[] = $type . $ref . $p->getName() . $default;
        }
        return $this->paramcache = \implode(', ', $out);
    }
}