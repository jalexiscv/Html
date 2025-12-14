<?php
declare(strict_types=1);

namespace Kint\Parser;

use InvalidArgumentException;
use Kint\Utils;
use Kint\Zval\Value;

class ArrayLimitPlugin extends AbstractPlugin
{
    public static $trigger = 1000;
    public static $limit = 50;
    public static $numeric_only = true;

    public function getTypes(): array
    {
        return ['array'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_BEGIN;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (self::$limit >= self::$trigger) {
            throw new InvalidArgumentException('ArrayLimitPlugin::$limit can not be lower than ArrayLimitPlugin::$trigger');
        }
        $depth = $this->parser->getDepthLimit();
        if (!$depth) {
            return;
        }
        if ($o->depth >= $depth - 1) {
            return;
        }
        if (\count($var) < self::$trigger) {
            return;
        }
        if (self::$numeric_only && Utils::isAssoc($var)) {
            return;
        }
        $base = clone $o;
        $base->depth = $depth - 1;
        $obj = $this->parser->parse($var, $base);
        if ('array' != $obj->type) {
            return;
        }
        $obj->depth = $o->depth;
        $i = 0;
        foreach ($obj->value->contents as $child) {
            $child->depth = $o->depth + 1;
            $this->recalcDepthLimit($child);
        }
        $var2 = \array_slice($var, 0, self::$limit, true);
        $base = clone $o;
        $slice = $this->parser->parse($var2, $base);
        \array_splice($obj->value->contents, 0, self::$limit, $slice->value->contents);
        $o = $obj;
        $this->parser->haltParse();
    }

    protected function recalcDepthLimit(Value $o): void
    {
        $hintkey = \array_search('depth_limit', $o->hints, true);
        if (false !== $hintkey) {
            $o->hints[$hintkey] = 'array_limit';
        }
        $reps = $o->getRepresentations();
        if ($o->value) {
            $reps[] = $o->value;
        }
        foreach ($reps as $rep) {
            if ($rep->contents instanceof Value) {
                $this->recalcDepthLimit($rep->contents);
            } elseif (\is_array($rep->contents)) {
                foreach ($rep->contents as $child) {
                    if ($child instanceof Value) {
                        $this->recalcDepthLimit($child);
                    }
                }
            }
        }
    }
}