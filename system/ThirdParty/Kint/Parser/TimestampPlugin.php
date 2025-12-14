<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Value;

class TimestampPlugin extends AbstractPlugin
{
    public static $blacklist = [2147483648, 2147483647, 1073741824, 1073741823,];

    public function getTypes(): array
    {
        return ['string', 'integer'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (\is_string($var) && !\ctype_digit($var)) {
            return;
        }
        if ($var < 0) {
            return;
        }
        if (\in_array($var, self::$blacklist, true)) {
            return;
        }
        $len = \strlen((string)$var);
        if (9 === $len || 10 === $len) {
            $o->value->label = 'Timestamp';
            $o->value->hints[] = 'timestamp';
        }
    }
}