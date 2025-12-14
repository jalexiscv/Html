<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;
use Traversable;

class IteratorPlugin extends AbstractPlugin
{
    public static $blacklist = ['DOMNamedNodeMap', 'DOMNodeList', 'mysqli_result', 'PDOStatement', 'SplFileObject',];

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
        if (!$var instanceof Traversable) {
            return;
        }
        foreach (self::$blacklist as $class) {
            if ($var instanceof $class) {
                $b = new Value();
                $b->name = $class . ' Iterator Contents';
                $b->access_path = 'iterator_to_array(' . $o->access_path . ', true)';
                $b->depth = $o->depth + 1;
                $b->hints[] = 'blacklist';
                $r = new Representation('Iterator');
                $r->contents = [$b];
                $o->addRepresentation($r);
                return;
            }
        }
        $data = \iterator_to_array($var);
        $base_obj = new Value();
        $base_obj->depth = $o->depth;
        if ($o->access_path) {
            $base_obj->access_path = 'iterator_to_array(' . $o->access_path . ')';
        }
        $r = new Representation('Iterator');
        $r->contents = $this->parser->parse($data, $base_obj);
        $r->contents = $r->contents->value->contents;
        $primary = $o->getRepresentations();
        $primary = \reset($primary);
        if ($primary && $primary === $o->value && [] === $primary->contents) {
            $o->addRepresentation($r, 0);
        } else {
            $o->addRepresentation($r);
        }
    }
}