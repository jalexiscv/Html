<?php
declare(strict_types=1);

namespace Kint\Parser;

use Closure;
use Kint\Zval\ClosureValue;
use Kint\Zval\ParameterValue;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;
use ReflectionFunction;

class ClosurePlugin extends AbstractPlugin
{
    public function getTypes(): array
    {
        return ['object'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (!$var instanceof Closure) {
            return;
        }
        $object = new ClosureValue();
        $object->transplant($o);
        $o = $object;
        $object->removeRepresentation('properties');
        $closure = new ReflectionFunction($var);
        $o->filename = $closure->getFileName();
        $o->startline = $closure->getStartLine();
        foreach ($closure->getParameters() as $param) {
            $o->parameters[] = new ParameterValue($param);
        }
        $p = new Representation('Parameters');
        $p->contents = &$o->parameters;
        $o->addRepresentation($p, 0);
        $statics = [];
        if ($v = $closure->getClosureThis()) {
            $statics = ['this' => $v];
        }
        if (\count($statics = $statics + $closure->getStaticVariables())) {
            $statics_parsed = [];
            foreach ($statics as $name => &$static) {
                $obj = Value::blank('$' . $name);
                $obj->depth = $o->depth + 1;
                $statics_parsed[$name] = $this->parser->parse($static, $obj);
                if (null === $statics_parsed[$name]->value) {
                    $statics_parsed[$name]->access_path = null;
                }
            }
            $r = new Representation('Uses');
            $r->contents = $statics_parsed;
            $o->addRepresentation($r, 0);
        }
    }
}