<?php

namespace Twilio\TwiML;

use DOMDocument;
use DOMElement;
use function is_bool;
use function is_string;

abstract class TwiML
{
    protected $name;
    protected $attributes;
    protected $children;

    public function __construct(string $name, string $value = null, array $attributes = [])
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->children = [];
        if ($value !== null) {
            $this->children[] = $value;
        }
    }

    public function append($twiml): TwiML
    {
        $this->children[] = $twiml;
        return $this;
    }

    public function nest(TwiML $twiml): TwiML
    {
        $this->children[] = $twiml;
        return $twiml;
    }

    public function setAttribute(string $key, string $value): TwiML
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function addChild(string $name, string $value = null, array $attributes = []): TwiML
    {
        return $this->nest(new GenericNode($name, $value, $attributes));
    }

    public function asXML(): string
    {
        return (string)$this;
    }

    public function __toString(): string
    {
        return $this->xml()->saveXML();
    }

    private function buildElement(TwiML $twiml, DOMDocument $document): DOMElement
    {
        $element = $document->createElement($twiml->name);
        foreach ($twiml->attributes as $name => $value) {
            if (is_bool($value)) {
                $value = ($value === true) ? 'true' : 'false';
            }
            $element->setAttribute($name, $value);
        }
        foreach ($twiml->children as $child) {
            if (is_string($child)) {
                $element->appendChild($document->createTextNode($child));
            } else {
                $element->appendChild($this->buildElement($child, $document));
            }
        }
        return $element;
    }

    private function xml(): DOMDocument
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        $document->appendChild($this->buildElement($this, $document));
        return $document;
    }
}