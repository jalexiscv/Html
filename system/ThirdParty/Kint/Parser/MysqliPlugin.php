<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\Value;
use mysqli;
use ReflectionClass;
use Throwable;

class MysqliPlugin extends AbstractPlugin
{
    protected $always_readable = ['client_version' => true, 'connect_errno' => true, 'connect_error' => true,];
    protected $empty_readable = ['client_info' => true, 'errno' => true, 'error' => true,];
    protected $connected_readable = ['affected_rows' => true, 'error_list' => true, 'field_count' => true, 'host_info' => true, 'info' => true, 'insert_id' => true, 'server_info' => true, 'server_version' => true, 'sqlstate' => true, 'protocol_version' => true, 'thread_id' => true, 'warning_count' => true,];

    public function getTypes(): array
    {
        return ['object'];
    }

    public function getTriggers(): int
    {
        return Parser::TRIGGER_COMPLETE;
    }

    public function parse(&$var, Value &$o, int $trigger): void
    {
        if (!$var instanceof mysqli) {
            return;
        }
        try {
            $connected = \is_string(@$var->sqlstate);
        } catch (Throwable $t) {
            $connected = false;
        }
        try {
            $empty = !$connected && \is_string(@$var->client_info);
        } catch (Throwable $t) {
            $empty = false;
        }
        foreach ($o->value->contents as $key => $obj) {
            if (isset($this->connected_readable[$obj->name])) {
                if (!$connected) {
                    continue;
                }
            } elseif (isset($this->empty_readable[$obj->name])) {
                if (!$connected && !$empty) {
                    continue;
                }
            } elseif (!isset($this->always_readable[$obj->name])) {
                continue;
            }
            if ('null' !== $obj->type) {
                continue;
            }
            $param = $var->{$obj->name};
            if (null === $param) {
                continue;
            }
            $base = Value::blank($obj->name, $obj->access_path);
            $base->depth = $obj->depth;
            $base->owner_class = $obj->owner_class;
            $base->operator = $obj->operator;
            $base->access = $obj->access;
            $base->reference = $obj->reference;
            $o->value->contents[$key] = $this->parser->parse($param, $base);
        }
        if (KINT_PHP81) {
            $r = new ReflectionClass(mysqli::class);
            $basepropvalues = [];
            foreach ($r->getProperties() as $prop) {
                if ($prop->isStatic()) {
                    continue;
                }
                $pname = $prop->getName();
                $param = null;
                if (isset($this->connected_readable[$pname])) {
                    if ($connected) {
                        $param = $var->{$pname};
                    }
                } else {
                    $param = $var->{$pname};
                }
                $child = new Value();
                $child->depth = $o->depth + 1;
                $child->owner_class = mysqli::class;
                $child->operator = Value::OPERATOR_OBJECT;
                $child->name = $pname;
                if ($prop->isPublic()) {
                    $child->access = Value::ACCESS_PUBLIC;
                } elseif ($prop->isProtected()) {
                    $child->access = Value::ACCESS_PROTECTED;
                } elseif ($prop->isPrivate()) {
                    $child->access = Value::ACCESS_PRIVATE;
                }
                if ($this->parser->childHasPath($o, $child)) {
                    $child->access_path .= $o->access_path . '->' . $child->name;
                }
                $basepropvalues[] = $this->parser->parse($param, $child);
            }
            $o->value->contents = \array_merge($basepropvalues, $o->value->contents);
        }
    }
}