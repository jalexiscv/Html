<?php
declare(strict_types=1);

namespace Kint\Parser;

use DOMNamedNodeMap;
use DOMNode;
use DOMNodeList;
use InvalidArgumentException;
use Kint\Zval\BlobValue;
use Kint\Zval\InstanceValue;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;

class DOMDocumentPlugin extends AbstractPlugin
{
    public static $blacklist = ['parentNode' => 'DOMNode', 'firstChild' => 'DOMNode', 'lastChild' => 'DOMNode', 'previousSibling' => 'DOMNode', 'nextSibling' => 'DOMNode', 'ownerDocument' => 'DOMDocument',];
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
        if (!$o instanceof InstanceValue) {
            return;
        }
        if ($var instanceof DOMNamedNodeMap || $var instanceof DOMNodeList) {
            $this->parseList($var, $o, $trigger);
            return;
        }
        if ($var instanceof DOMNode) {
            $this->parseNode($var, $o);
            return;
        }
    }

    protected function parseList($var, InstanceValue &$o, int $trigger): void
    {
        if (!$var instanceof DOMNamedNodeMap && !$var instanceof DOMNodeList) {
            return;
        }
        if ($trigger & Parser::TRIGGER_RECURSION) {
            return;
        }
        $o->size = $var->length;
        if (0 === $o->size) {
            $o->replaceRepresentation(new Representation('Iterator'));
            $o->size = null;
            return;
        }
        if ($this->parser->getDepthLimit() && $o->depth + 1 >= $this->parser->getDepthLimit()) {
            $b = new Value();
            $b->name = $o->classname . ' Iterator Contents';
            $b->access_path = 'iterator_to_array(' . $o->access_path . ')';
            $b->depth = $o->depth + 1;
            $b->hints[] = 'depth_limit';
            $r = new Representation('Iterator');
            $r->contents = [$b];
            $o->replaceRepresentation($r, 0);
            return;
        }
        $r = new Representation('Iterator');
        $o->replaceRepresentation($r, 0);
        foreach ($var as $key => $item) {
            $base_obj = new Value();
            $base_obj->depth = $o->depth + 1;
            $base_obj->name = $item->nodeName;
            if ($o->access_path) {
                if ($var instanceof DOMNamedNodeMap) {
                    $base_obj->access_path = $o->access_path . '->getNamedItemNS(';
                    $base_obj->access_path .= \var_export($item->namespaceURI, true);
                    $base_obj->access_path .= ', ';
                    $base_obj->access_path .= \var_export($item->name, true);
                    $base_obj->access_path .= ')';
                } else {
                    $base_obj->access_path = $o->access_path . '->item(' . \var_export($key, true) . ')';
                }
            }
            $r->contents[] = $this->parser->parse($item, $base_obj);
        }
    }

    protected function parseNode(DOMNode $var, InstanceValue &$o): void
    {
        $known_properties = ['nodeValue', 'childNodes', 'attributes',];
        if (self::$verbose) {
            $known_properties = ['nodeName', 'nodeValue', 'nodeType', 'parentNode', 'childNodes', 'firstChild', 'lastChild', 'previousSibling', 'nextSibling', 'attributes', 'ownerDocument', 'namespaceURI', 'prefix', 'localName', 'baseURI', 'textContent',];
        }
        $childNodes = null;
        $attributes = null;
        $rep = $o->value;
        foreach ($known_properties as $prop) {
            $prop_obj = $this->parseProperty($o, $prop, $var);
            $rep->contents[] = $prop_obj;
            if ('childNodes' === $prop) {
                $childNodes = $prop_obj->getRepresentation('iterator');
            } elseif ('attributes' === $prop) {
                $attributes = $prop_obj->getRepresentation('iterator');
            }
        }
        if (!self::$verbose) {
            $o->removeRepresentation('methods');
            $o->removeRepresentation('properties');
        }
        if (\in_array($o->classname, ['DOMAttr', 'DOMText', 'DOMComment'], true)) {
            $o = self::textualNodeToString($o);
            return;
        }
        if ($attributes) {
            $a = new Representation('Attributes');
            foreach ($attributes->contents as $attribute) {
                $a->contents[] = $attribute;
            }
            $o->addRepresentation($a, 0);
        }
        if ($childNodes) {
            $c = new Representation('Children');
            if (1 === \count($childNodes->contents) && ($node = \reset($childNodes->contents)) && \in_array('depth_limit', $node->hints, true)) {
                $n = new InstanceValue();
                $n->transplant($node);
                $n->name = 'childNodes';
                $n->classname = 'DOMNodeList';
                $c->contents = [$n];
            } else {
                foreach ($childNodes->contents as $node) {
                    if ($node instanceof BlobValue && '#text' === $node->name && (\ctype_space($node->value->contents) || '' === $node->value->contents)) {
                        continue;
                    }
                    $c->contents[] = $node;
                }
            }
            $o->addRepresentation($c, 0);
        }
        if ($childNodes) {
            $o->size = \count($childNodes->contents);
        }
        if (!$o->size) {
            $o->size = null;
        }
    }

    protected function parseProperty(InstanceValue $o, string $prop, DOMNode &$var): Value
    {
        $base_obj = new Value();
        $base_obj->depth = $o->depth + 1;
        $base_obj->owner_class = $o->classname;
        $base_obj->name = $prop;
        $base_obj->operator = Value::OPERATOR_OBJECT;
        $base_obj->access = Value::ACCESS_PUBLIC;
        if (null !== $o->access_path) {
            $base_obj->access_path = $o->access_path;
            if (\preg_match('/^[A-Za-z0-9_]+$/', $base_obj->name)) {
                $base_obj->access_path .= '->' . $base_obj->name;
            } else {
                $base_obj->access_path .= '->{' . \var_export($base_obj->name, true) . '}';
            }
        }
        if (!isset($var->{$prop})) {
            $base_obj->type = 'null';
        } elseif (isset(self::$blacklist[$prop])) {
            $b = new InstanceValue();
            $b->transplant($base_obj);
            $base_obj = $b;
            $base_obj->hints[] = 'blacklist';
            $base_obj->classname = self::$blacklist[$prop];
        } elseif ('attributes' === $prop) {
            if ($this->parser->getDepthLimit() && $this->parser->getDepthLimit() - 2 < $base_obj->depth) {
                $base_obj->depth = $this->parser->getDepthLimit() - 2;
            }
            $base_obj = $this->parser->parse($var->{$prop}, $base_obj);
        } else {
            $base_obj = $this->parser->parse($var->{$prop}, $base_obj);
        }
        return $base_obj;
    }

    protected static function textualNodeToString(InstanceValue $o): Value
    {
        if (empty($o->value) || empty($o->value->contents) || empty($o->classname)) {
            throw new InvalidArgumentException('Invalid DOMNode passed to DOMDocumentPlugin::textualNodeToString');
        }
        if (!\in_array($o->classname, ['DOMText', 'DOMAttr', 'DOMComment'], true)) {
            throw new InvalidArgumentException('Invalid DOMNode passed to DOMDocumentPlugin::textualNodeToString');
        }
        foreach ($o->value->contents as $property) {
            if ('nodeValue' === $property->name) {
                $ret = clone $property;
                $ret->name = $o->name;
                return $ret;
            }
        }
        throw new InvalidArgumentException('Invalid DOMNode passed to DOMDocumentPlugin::textualNodeToString');
    }
}