<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\SplFileInfoRepresentation;
use Kint\Zval\Value;
use SplFileInfo;
use SplFileObject;

class SplFileInfoPlugin extends AbstractPlugin
{
    public function getTypes(): array
    {
        return ['object'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_COMPLETE;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (!$var instanceof SplFileInfo || $var instanceof SplFileObject) {
            return;
        }
        $r = new SplFileInfoRepresentation(clone $var);
        $o->addRepresentation($r, 0);
        $o->size = $r->getSize();
    }
}