<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlPhoneme extends TwiML
{
    public function __construct($words, $attributes = [])
    {
        parent::__construct('phoneme', $words, $attributes);
    }

    public function setAlphabet($alphabet): self
    {
        return $this->setAttribute('alphabet', $alphabet);
    }

    public function setPh($ph): self
    {
        return $this->setAttribute('ph', $ph);
    }
}