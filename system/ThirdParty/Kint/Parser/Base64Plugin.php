<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;

class Base64Plugin extends AbstractPlugin
{
    public static $min_length_hard = 16;
    public static $min_length_soft = 50;

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
        if (\strlen($var) < self::$min_length_hard || \strlen($var) % 4) {
            return;
        }
        if (\preg_match('/^[A-Fa-f0-9]+$/', $var)) {
            return;
        }
        if (!\preg_match('/^[A-Za-z0-9+\\/=]+$/', $var)) {
            return;
        }
        $data = \base64_decode($var, true);
        if (false === $data) {
            return;
        }
        $base_obj = new Value();
        $base_obj->depth = $o->depth + 1;
        $base_obj->name = 'base64_decode(' . $o->name . ')';
        if ($o->access_path) {
            $base_obj->access_path = 'base64_decode(' . $o->access_path . ')';
        }
        $r = new Representation('Base64');
        $r->contents = $this->parser->parse($data, $base_obj);
        if (\strlen($var) > self::$min_length_soft) {
            $o->addRepresentation($r, 0);
        } else {
            $o->addRepresentation($r);
        }
    }
}