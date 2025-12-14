<?php
declare(strict_types=1);

namespace Kint\Parser;

use DOMDocument;
use Exception;
use Kint\Zval\Representation\Representation;
use Kint\Zval\Value;

class XmlPlugin extends AbstractPlugin
{
    public static $parse_method = 'SimpleXML';

    protected static function xmlToDOMDocument(string $var, ?string $parent_path): ?array
    {
        if (!self::xmlToSimpleXML($var, $parent_path)) {
            return null;
        }
        $xml = new DOMDocument();
        $xml->loadXML($var);
        if ($xml->childNodes->count() > 1) {
            $xml = $xml->childNodes;
            $access_path = 'childNodes';
        } else {
            $xml = $xml->firstChild;
            $access_path = 'firstChild';
        }
        if (null === $parent_path) {
            $access_path = null;
        } else {
            $access_path = '(function($s){$x = new \\DomDocument(); $x->loadXML($s); return $x;})(' . $parent_path . ')->' . $access_path;
        }
        $name = $xml->nodeName ?? null;
        return [$xml, $access_path, $name];
    }

    protected static function xmlToSimpleXML(string $var, ?string $parent_path): ?array
    {
        $errors = \libxml_use_internal_errors(true);
        try {
            $xml = \simplexml_load_string($var);
        } catch (Exception $e) {
            return null;
        } finally {
            \libxml_use_internal_errors($errors);
        }
        if (false === $xml) {
            return null;
        }
        if (null === $parent_path) {
            $access_path = null;
        } else {
            $access_path = 'simplexml_load_string(' . $parent_path . ')';
        }
        $name = $xml->getName();
        return [$xml, $access_path, $name];
    }

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
        if ('<?xml' !== \substr($var, 0, 5)) {
            return;
        }
        if (!\method_exists(\get_class($this), 'xmlTo' . self::$parse_method)) {
            return;
        }
        $xml = \call_user_func([\get_class($this), 'xmlTo' . self::$parse_method], $var, $o->access_path);
        if (empty($xml)) {
            return;
        }
        [$xml, $access_path, $name] = $xml;
        $base_obj = new Value();
        $base_obj->depth = $o->depth + 1;
        $base_obj->name = $name;
        $base_obj->access_path = $access_path;
        $r = new Representation('XML');
        $r->contents = $this->parser->parse($xml, $base_obj);
        $o->addRepresentation($r, 0);
    }
}