<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\SourceRepresentation;
use Kint\Zval\ThrowableValue;
use Kint\Zval\Value;
use Throwable;

class ThrowablePlugin extends AbstractPlugin
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
        if (!$var instanceof Throwable) {
            return;
        }
        $throw = new ThrowableValue($var);
        $throw->transplant($o);
        $r = new SourceRepresentation($var->getFile(), $var->getLine());
        $r->showfilename = true;
        $throw->addRepresentation($r, 0);
        $o = $throw;
    }
}