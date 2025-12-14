<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;

class TablePlugin extends AbstractPlugin
{
    public function getTypes(): array
    {
        return ['array'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (empty($o->value->contents)) {
            return;
        }
        $array = $this->parser->getCleanArray($var);
        if (\count($array) < 2) {
            return;
        }
        $keys = null;
        foreach ($array as $elem) {
            if (!\is_array($elem) || \count($elem) < 2) {
                return;
            }
            if (null === $keys) {
                $keys = \array_keys($elem);
            } elseif (\array_keys($elem) !== $keys) {
                return;
            }
        }
        foreach ($o->value->contents as $childarray) {
            if (empty($childarray->value->contents)) {
                return;
            }
        }
        $table = new Representation('Table');
        $table->contents = $o->value->contents;
        $table->hints[] = 'table';
        $o->addRepresentation($table, 0);
    }
}