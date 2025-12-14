<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlBreak extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('break', null, $attributes);
    }

    public function setStrength($strength): self
    {
        return $this->setAttribute('strength', $strength);
    }

    public function setTime($time): self
    {
        return $this->setAttribute('time', $time);
    }
}