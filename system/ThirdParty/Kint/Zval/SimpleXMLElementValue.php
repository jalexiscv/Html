<?php
declare(strict_types=1);

namespace Kint\Zval;
class SimpleXMLElementValue extends InstanceValue
{
    public $hints = ['object', 'simplexml_element'];
    protected $is_string_value = false;

    public function isStringValue(): bool
    {
        return $this->is_string_value;
    }

    public function setIsStringValue(bool $is_string_value): void
    {
        $this->is_string_value = $is_string_value;
    }

    public function getValueShort(): ?string
    {
        if ($this->is_string_value && ($rep = $this->value) && 'contents' === $rep->getName() && 'string' === \gettype($rep->contents)) {
            return '"' . $rep->contents . '"';
        }
        return null;
    }
}