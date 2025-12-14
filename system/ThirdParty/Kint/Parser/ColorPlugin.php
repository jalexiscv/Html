<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\ColorRepresentation;
use Kint\Zval\Value;

class ColorPlugin extends AbstractPlugin
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
        if (\strlen($var) > 32) {
            return;
        }
        $trimmed = \strtolower(\trim($var));
        if (!isset(ColorRepresentation::$color_map[$trimmed]) && !\preg_match('/^(?:(?:rgb|hsl)[^\\)]{6,}\\)|#[0-9a-fA-F]{3,8})$/', $trimmed)) {
            return;
        }
        $rep = new ColorRepresentation($var);
        if ($rep->variant) {
            $o->removeRepresentation($o->value);
            $o->addRepresentation($rep, 0);
            $o->hints[] = 'color';
        }
    }
}