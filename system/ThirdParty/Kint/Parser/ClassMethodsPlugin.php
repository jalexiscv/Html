<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\InstanceValue;
use Kint\Zval\MethodValue;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;
use ReflectionClass;

class ClassMethodsPlugin extends AbstractPlugin
{
    private static $cache = [];

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
        $class = \get_class($var);
        if (!isset(self::$cache[$class])) {
            $methods = [];
            $reflection = new ReflectionClass($class);
            foreach ($reflection->getMethods() as $method) {
                $methods[] = new MethodValue($method);
            }
            \usort($methods, ['Kint\\Parser\\ClassMethodsPlugin', 'sort']);
            self::$cache[$class] = $methods;
        }
        if (!empty(self::$cache[$class])) {
            $rep = new Representation('Available methods', 'methods');
            foreach (self::$cache[$class] as $m) {
                $method = clone $m;
                $method->depth = $o->depth + 1;
                if (!$this->parser->childHasPath($o, $method)) {
                    $method->access_path = null;
                } else {
                    $method->setAccessPathFrom($o);
                }
                if ($method->owner_class !== $class && $d = $method->getRepresentation('method_definition')) {
                    $d = clone $d;
                    $d->inherited = true;
                    $method->replaceRepresentation($d);
                }
                $rep->contents[] = $method;
            }
            $o->addRepresentation($rep);
        }
    }

    private static function sort(MethodValue $a, MethodValue $b): int
    {
        $sort = ((int)$a->static) - ((int)$b->static);
        if ($sort) {
            return $sort;
        }
        $sort = Value::sortByAccess($a, $b);
        if ($sort) {
            return $sort;
        }
        $sort = InstanceValue::sortByHierarchy($a->owner_class, $b->owner_class);
        if ($sort) {
            return $sort;
        }
        return $a->startline - $b->startline;
    }
}