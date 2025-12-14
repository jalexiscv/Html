<?php

namespace SendGrid\Mail;

use JsonSerializable;

class Content implements JsonSerializable
{
    private $type;
    private $value;

    public function __construct($type = null, $value = null)
    {
        if (isset($type)) {
            $this->setType($type);
        }
        if (isset($value)) {
            $this->setValue($value);
        }
    }

    public function jsonSerialize(): mixed
    {
        return array_filter(['type' => $this->getType(), 'value' => $this->getValue()], function ($value) {
            return $value !== null;
        }) ?: null;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if (!is_string($type)) {
            throw new TypeException('$type must be of type string.');
        }
        $this->type = $type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        if (!is_string($value)) {
            throw new TypeException('$value must be of type string');
        }
        $this->value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}
