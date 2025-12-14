<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlEmphasis extends TwiML
{
    public function __construct($words, $attributes = [])
    {
        parent::__construct('emphasis', $words, $attributes);
    }

    public function setLevel($level): self
    {
        return $this->setAttribute('level', $level);
    }
}