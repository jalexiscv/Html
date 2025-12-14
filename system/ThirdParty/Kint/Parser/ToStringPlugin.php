<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;
use ReflectionClass;

class ToStringPlugin extends AbstractPlugin
{
    public static $blacklist = ['SimpleXMLElement', 'SplFileObject',];

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
        $reflection = new ReflectionClass($var);
        if (!$reflection->hasMethod('__toString')) {
            return;
        }
        foreach (self::$blacklist as $class) {
            if ($var instanceof $class) {
                return;
            }
        }
        $r = new Representation('toString');
        $r->contents = (string)$var;
        $o->addRepresentation($r);
    }
}