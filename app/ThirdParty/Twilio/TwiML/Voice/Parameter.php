<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Parameter extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Parameter', null, $attributes);
    }

    public function setName($name): self
    {
        return $this->setAttribute('name', $name);
    }

    public function setValue($value): self
    {
        return $this->setAttribute('value', $value);
    }
}