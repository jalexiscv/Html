<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;

class SerializePlugin extends AbstractPlugin
{
    public static $safe_mode = true;
    public static $allowed_classes = false;

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
        $trimmed = \rtrim($var);
        if ('N;' !== $trimmed && !\preg_match('/^(?:[COabis]:\\d+[:;]|d:\\d+(?:\\.\\d+);)/', $trimmed)) {
            return;
        }
        $options = ['allowed_classes' => self::$allowed_classes];
        if (!self::$safe_mode || !\in_array($trimmed[0], ['C', 'O', 'a'], true)) {
            $data = @\unserialize($trimmed, $options);
            if (false === $data && 'b:0;' !== \substr($trimmed, 0, 4)) {
                return;
            }
        }
        $base_obj = new Value();
        $base_obj->depth = $o->depth + 1;
        $base_obj->name = 'unserialize(' . $o->name . ')';
        if ($o->access_path) {
            $base_obj->access_path = 'unserialize(' . $o->access_path;
            if (true === self::$allowed_classes) {
                $base_obj->access_path .= ')';
            } else {
                $base_obj->access_path .= ', ' . \var_export($options, true) . ')';
            }
        }
        $r = new Representation('Serialized');
        if (isset($data)) {
            $r->contents = $this->parser->parse($data, $base_obj);
        } else {
            $base_obj->hints[] = 'blacklist';
            $r->contents = $base_obj;
        }
        $o->addRepresentation($r, 0);
    }
}