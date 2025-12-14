<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\InstanceValue;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionProperty;
use UnitEnum;

class ClassStaticsPlugin extends AbstractPlugin
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
        if (!$o instanceof InstanceValue) {
            return;
        }
        $class = \get_class($var);
        $reflection = new ReflectionClass($class);
        if (!isset(self::$cache[$class])) {
            $consts = [];
            foreach ($reflection->getConstants() as $name => $val) {
                if ($var instanceof UnitEnum && $val instanceof UnitEnum && $o->classname == \get_class($val)) {
                    continue;
                }
                $const = Value::blank($name);
                $const->const = true;
                $const->depth = $o->depth + 1;
                $const->owner_class = $class;
                $const->operator = Value::OPERATOR_STATIC;
                $creflection = new ReflectionClassConstant($class, $name);
                $const->access = Value::ACCESS_PUBLIC;
                if ($creflection->isProtected()) {
                    $const->access = Value::ACCESS_PROTECTED;
                } elseif ($creflection->isPrivate()) {
                    $const->access = Value::ACCESS_PRIVATE;
                }
                if ($this->parser->childHasPath($o, $const)) {
                    $const->access_path = '\\' . $class . '::' . $name;
                }
                $const = $this->parser->parse($val, $const);
                $consts[] = $const;
            }
            self::$cache[$class] = $consts;
        }
        $statics = new Representation('Static class properties', 'statics');
        $statics->contents = self::$cache[$class];
        foreach ($reflection->getProperties(ReflectionProperty::IS_STATIC) as $static) {
            $prop = new Value();
            $prop->name = '$' . $static->getName();
            $prop->depth = $o->depth + 1;
            $prop->static = true;
            $prop->operator = Value::OPERATOR_STATIC;
            $prop->owner_class = $static->getDeclaringClass()->name;
            $prop->access = Value::ACCESS_PUBLIC;
            if ($static->isProtected()) {
                $prop->access = Value::ACCESS_PROTECTED;
            } elseif ($static->isPrivate()) {
                $prop->access = Value::ACCESS_PRIVATE;
            }
            if ($this->parser->childHasPath($o, $prop)) {
                $prop->access_path = '\\' . $prop->owner_class . '::' . $prop->name;
            }
            $static->setAccessible(true);
            if (KINT_PHP74 && !$static->isInitialized()) {
                $prop->type = 'uninitialized';
                $statics->contents[] = $prop;
            } else {
                $static = $static->getValue();
                $statics->contents[] = $this->parser->parse($static, $prop);
            }
        }
        if (empty($statics->contents)) {
            return;
        }
        \usort($statics->contents, ['Kint\\Parser\\ClassStaticsPlugin', 'sort']);
        $o->addRepresentation($statics);
    }

    private static function sort(Value $a, Value $b): int
    {
        $sort = ((int)$a->const) - ((int)$b->const);
        if ($sort) {
            return $sort;
        }
        $sort = Value::sortByAccess($a, $b);
        if ($sort) {
            return $sort;
        }
        return InstanceValue::sortByHierarchy($a->owner_class, $b->owner_class);
    }
}