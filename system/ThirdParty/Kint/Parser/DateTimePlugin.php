<?php
declare(strict_types=1);

namespace Kint\Parser;

use DateTime;
use Kint\Zval\DateTimeValue;
use Kint\Zval\Value;

class DateTimePlugin extends AbstractPlugin
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
        if (!$var instanceof DateTime) {
            return;
        }
        $object = new DateTimeValue($var);
        $object->transplant($o);
        $o = $object;
    }
}