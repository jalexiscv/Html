<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;

class JsonPlugin extends AbstractPlugin
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
        if (!isset($var[0]) || ('{' !== $var[0] && '[' !== $var[0])) {
            return;
        }
        $json = \json_decode($var, true);
        if (!$json) {
            return;
        }
        $json = (array)$json;
        $base_obj = new Value();
        $base_obj->depth = $o->depth;
        if ($o->access_path) {
            $base_obj->access_path = 'json_decode(' . $o->access_path . ', true)';
        }
        $r = new Representation('Json');
        $r->contents = $this->parser->parse($json, $base_obj);
        if (!\in_array('depth_limit', $r->contents->hints, true)) {
            $r->contents = $r->contents->value->contents;
        }
        $o->addRepresentation($r, 0);
    }
}