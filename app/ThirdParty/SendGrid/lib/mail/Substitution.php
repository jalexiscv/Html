<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Substitution implements JsonSerializable
{
    private $key;
    private $value;

    public function __construct($key = null, $value = null)
    {
        if (isset($key)) {
            $this->setKey($key);
        }
        if (isset($value)) {
            $this->setValue($value);
        }
    }

    public function setKey($key)
    {
        if (!is_string($key)) {
            throw new TypeException('$key must be of type string.');
        }
        $this->key = (string)$key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setValue($value)
    {
        if (!is_string($value) && !is_array($value) && !is_object($value) && !is_bool($value) && !is_int($value)) {
            throw new TypeException('$value must be of type string, array or object.');
        }
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return array_filter(['key' => $this->getKey(), 'value' => $this->getValue()], function ($value) {
            return $value !== null;
        }) ?: null;
    }
}
