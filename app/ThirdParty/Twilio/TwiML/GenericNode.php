<?php

namespace Twilio\TwiML;
class GenericNode extends TwiML
{
    public function __construct(string $name, ?string $value, array $attributes)
    {
        parent::__construct($name, $value, $attributes);
        $this->name = $name;
        $this->value = $value;
    }
}