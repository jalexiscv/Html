<?php
declare(strict_types=1);

namespace Kint\Parser;

use Kint\Zval\BlobValue;
use Kint\Zval\Representation\Representation;
use Kint\Zval\SimpleXMLElementValue;
use Kint\Zval\Value;
use SimpleXMLElement;

class SimpleXMLElementPlugin extends AbstractPlugin
{
    public static $verbose = false;

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
        if (!$var instanceof SimpleXMLElement) {
            return;
        }
        if (!self::$verbose) {
            $o->removeRepresentation('properties');
            $o->removeRepresentation('iterator');
            $o->removeRepresentation('methods');
        }
        if (!$var) {
            $o->size = null;
            return;
        }
        $x = new SimpleXMLElementValue();
        $x->transplant($o);
        $namespaces = \array_merge([null], $var->getDocNamespaces());
        $a = new Representation('Attributes');
        $base_obj = new Value();
        $base_obj->depth = $x->depth;
        if ($x->access_path) {
            $base_obj->access_path = '(string) ' . $x->access_path;
        }
        if ($this->parser->getDepthLimit() && $this->parser->getDepthLimit() - 2 < $base_obj->depth) {
            $base_obj->depth = $this->parser->getDepthLimit() - 2;
        }
        $attribs = [];
        foreach ($namespaces as $nsAlias => $nsUrl) {
            if ($nsAttribs = $var->attributes($nsUrl)) {
                $cleanAttribs = [];
                foreach ($nsAttribs as $name => $attrib) {
                    $cleanAttribs[(string)$name] = $attrib;
                }
                if (null === $nsUrl) {
                    $obj = clone $base_obj;
                    if ($obj->access_path) {
                        $obj->access_path .= '->attributes()';
                    }
                    $a->contents = $this->parser->parse($cleanAttribs, $obj)->value->contents;
                } else {
                    $obj = clone $base_obj;
                    if ($obj->access_path) {
                        $obj->access_path .= '->attributes(' . \var_export($nsAlias, true) . ', true)';
                    }
                    $cleanAttribs = $this->parser->parse($cleanAttribs, $obj)->value->contents;
                    foreach ($cleanAttribs as $attribute) {
                        $attribute->name = $nsAlias . ':' . $attribute->name;
                        $a->contents[] = $attribute;
                    }
                }
            }
        }
        if ($a->contents) {
            $x->addRepresentation($a, 0);
        }
        $c = new Representation('Children');
        foreach ($namespaces as $nsAlias => $nsUrl) {
            $thisNs = $var->getNamespaces();
            if (isset($thisNs['']) && $thisNs[''] === $nsUrl) {
                continue;
            }
            if ($nsChildren = $var->children($nsUrl)) {
                $nsap = [];
                foreach ($nsChildren as $name => $child) {
                    $obj = new Value();
                    $obj->depth = $x->depth + 1;
                    $obj->name = (string)$name;
                    if ($x->access_path) {
                        if (null === $nsUrl) {
                            $obj->access_path = $x->access_path . '->children()->';
                        } else {
                            $obj->access_path = $x->access_path . '->children(' . \var_export($nsAlias, true) . ', true)->';
                        }
                        if (\preg_match('/^[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]+$/', (string)$name)) {
                            $obj->access_path .= (string)$name;
                        } else {
                            $obj->access_path .= '{' . \var_export((string)$name, true) . '}';
                        }
                        if (isset($nsap[$obj->access_path])) {
                            ++$nsap[$obj->access_path];
                            $obj->access_path .= '[' . $nsap[$obj->access_path] . ']';
                        } else {
                            $nsap[$obj->access_path] = 0;
                        }
                    }
                    $value = $this->parser->parse($child, $obj);
                    if ($value->access_path && 'string' === $value->type) {
                        $value->access_path = '(string) ' . $value->access_path;
                    }
                    $c->contents[] = $value;
                }
            }
        }
        $x->size = \count($c->contents);
        if ($x->size) {
            $x->addRepresentation($c, 0);
        } else {
            $x->size = null;
            if (\strlen((string)$var)) {
                $base_obj = new BlobValue();
                $base_obj->depth = $x->depth + 1;
                $base_obj->name = $x->name;
                if ($x->access_path) {
                    $base_obj->access_path = '(string) ' . $x->access_path;
                }
                $value = (string)$var;
                $s = $this->parser->parse($value, $base_obj);
                $srep = $s->getRepresentation('contents');
                $svalrep = $s->value && 'contents' == $s->value->getName() ? $s->value : null;
                if ($srep || $svalrep) {
                    $x->setIsStringValue(true);
                    $x->value = $srep ?: $svalrep;
                    if ($srep) {
                        $x->replaceRepresentation($srep, 0);
                    }
                }
                $reps = \array_reverse($s->getRepresentations());
                foreach ($reps as $rep) {
                    $x->addRepresentation($rep, 0);
                }
            }
        }
        $o = $x;
    }
}