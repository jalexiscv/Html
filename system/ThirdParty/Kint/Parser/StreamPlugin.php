<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\Representation;
use Kint\Zval\ResourceValue;
use Kint\Zval\StreamValue;
use Kint\Zval\Value;

class StreamPlugin extends AbstractPlugin
{
    public function getTypes(): array
    {
        return ['resource'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_SUCCESS;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (!$o instanceof ResourceValue || 'stream' !== $o->resource_type) {
            return;
        }
        if (!\is_resource($var)) {
            return;
        }
        $meta = \stream_get_meta_data($var);
        $rep = new Representation('Stream');
        $rep->implicit_label = true;
        $base_obj = new Value();
        $base_obj->depth = $o->depth;
        if ($o->access_path) {
            $base_obj->access_path = 'stream_get_meta_data(' . $o->access_path . ')';
        }
        $rep->contents = $this->parser->parse($meta, $base_obj);
        if (!\in_array('depth_limit', $rep->contents->hints, true)) {
            $rep->contents = $rep->contents->value->contents;
        }
        $o->addRepresentation($rep, 0);
        $o->value = $rep;
        $stream = new StreamValue($meta);
        $stream->transplant($o);
        $o = $stream;
    }
}