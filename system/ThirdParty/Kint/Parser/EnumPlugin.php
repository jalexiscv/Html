<?php
declare(strict_types=1);

namespace Kint\Parser;

use BackedEnum;
use Kint\Zval\EnumValue;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;
use UnitEnum;

class EnumPlugin extends AbstractPlugin
{
    private static $cache = [];

    public function getTypes(): array
    {
        return ['object'];
    }

    public function getTriggers(): int
    {
        if (!KINT_PHP81) {
            return Parser::TRIGGER_NONE;
        }
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (!$var instanceof UnitEnum) {
            return;
        }
        $class = \get_class($var);
        if (!isset(self::$cache[$class])) {
            $cases = new Representation('Enum values', 'enum');
            $cases->contents = [];
            foreach ($var->cases() as $case) {
                $base_obj = Value::blank($class . '::' . $case->name, '\\' . $class . '::' . $case->name);
                $base_obj->depth = $o->depth + 1;
                if ($var instanceof BackedEnum) {
                    $c = $case->value;
                    $cases->contents[] = $this->parser->parse($c, $base_obj);
                } else {
                    $cases->contents[] = $base_obj;
                }
            }
            self::$cache[$class] = $cases;
        }
        $object = new EnumValue($var);
        $object->transplant($o);
        $object->addRepresentation(self::$cache[$class], 0);
        $o = $object;
    }
}