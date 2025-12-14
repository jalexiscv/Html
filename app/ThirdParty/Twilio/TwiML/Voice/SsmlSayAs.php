<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlSayAs extends TwiML
{
    public function __construct($words, $attributes = [])
    {
        parent::__construct('say-as', $words, $attributes);
    }

    public function setInterpretAs($interpretAs): self
    {
        return $this->setAttribute('interpret-as', $interpretAs);
    }

    public function setRole($role): self
    {
        return $this->setAttribute('role', $role);
    }
}