<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\BlobValue;
use Kint\Zval\Value;

class BinaryPlugin extends AbstractPlugin
{
    public function getTypes(): array
    {
        return ['string'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (!$o instanceof BlobValue || !\in_array($o->encoding, ['ASCII', 'UTF-8'], true)) {
            $o->value->hints[] = 'binary';
        }
    }
}