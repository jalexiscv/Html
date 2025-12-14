<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\InstanceValue;
use Kint\Zval\Value;

class BlacklistPlugin extends AbstractPlugin
{
    public static $blacklist = [];
    public static $shallow_blacklist = ['Psr\\Container\\ContainerInterface'];

    public function getTypes(): array
    {
        return ['object'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_BEGIN;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        foreach (self::$blacklist as $class) {
            if ($var instanceof $class) {
                $this->blacklistValue($var, $o);
                return;
            }
        }
        if ($o->depth <= 0) {
            return;
        }
        foreach (self::$shallow_blacklist as $class) {
            if ($var instanceof $class) {
                $this->blacklistValue($var, $o);
                return;
            }
        }
    }

    protected function blacklistValue(&$var, Value &$o): void
    {
        $object = new InstanceValue();
        $object->transplant($o);
        $object->classname = \get_class($var);
        $object->spl_object_hash = \spl_object_hash($var);
        $object->clearRepresentations();
        $object->value = null;
        $object->size = null;
        $object->hints[] = 'blacklist';
        $o = $object;
        $this->parser->haltParse();
    }
}