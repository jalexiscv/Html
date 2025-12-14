<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Value;
use SplObjectStorage;

class SplObjectStoragePlugin extends AbstractPlugin
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
        if (!$var instanceof SplObjectStorage || !($r = $o->getRepresentation('iterator'))) {
            return;
        }
        $r = $o->getRepresentation('iterator');
        if ($r) {
            $o->size = !\is_array($r->contents) ? null : \count($r->contents);
        }
    }
}