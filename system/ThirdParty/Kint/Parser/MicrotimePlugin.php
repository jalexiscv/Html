<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\MicrotimeRepresentation;
use Kint\Zval\Value;

class MicrotimePlugin extends AbstractPlugin
{
    private static $last = null;
    private static $start = null;
    private static $times = 0;
    private static $group = 0;

    public static function clean(): void
    {
        self::$last = null;
        self::$start = null;
        self::$times = 0;
        ++self::$group;
    }

    public function getTypes(): array
    {
        return ['string', 'double'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (0 !== $o->depth) {
            return;
        }
        if (\is_string($var)) {
            if ('microtime()' !== $o->name || !\preg_match('/^0\\.[0-9]{8} [0-9]{10}$/', $var)) {
                return;
            }
            $usec = (int)\substr($var, 2, 6);
            $sec = (int)\substr($var, 11, 10);
        } else {
            if ('microtime(...)' !== $o->name) {
                return;
            }
            $sec = (int)\floor($var);
            $usec = $var - $sec;
            $usec = (int)\floor($usec * 1000000);
        }
        $time = $sec + ($usec / 1000000);
        if (null !== self::$last) {
            $last_time = self::$last[0] + (self::$last[1] / 1000000);
            $lap = $time - $last_time;
            ++self::$times;
        } else {
            $lap = null;
            self::$start = $time;
        }
        self::$last = [$sec, $usec];
        if (null !== $lap) {
            $total = $time - self::$start;
            $r = new MicrotimeRepresentation($sec, $usec, self::$group, $lap, $total, self::$times);
        } else {
            $r = new MicrotimeRepresentation($sec, $usec, self::$group);
        }
        $r->contents = $var;
        $r->implicit_label = true;
        $o->removeRepresentation($o->value);
        $o->addRepresentation($r);
        $o->hints[] = 'microtime';
    }
}