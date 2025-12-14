<?php
declare(strict_types=1);

namespace Kint\Parser;

use ArrayObject;
use Kint\Zval\Value;

class ArrayObjectPlugin extends AbstractPlugin
{
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
        if (!$var instanceof ArrayObject) {
            return;
        }
        $flags = $var->getFlags();
        if (ArrayObject::STD_PROP_LIST === $flags) {
            return;
        }
        $var->setFlags(ArrayObject::STD_PROP_LIST);
        $o = $this->parser->parse($var, $o);
        $var->setFlags($flags);
        $this->parser->haltParse();
    }
}