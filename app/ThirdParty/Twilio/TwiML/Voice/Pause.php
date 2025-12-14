<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Pause extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Pause', null, $attributes);
    }

    public function setLength($length): self
    {
        return $this->setAttribute('length', $length);
    }
}