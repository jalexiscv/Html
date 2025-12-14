<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlW extends TwiML
{
    public function __construct($words, $attributes = [])
    {
        parent::__construct('w', $words, $attributes);
    }

    public function setRole($role): self
    {
        return $this->setAttribute('role', $role);
    }
}