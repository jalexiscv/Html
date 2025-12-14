<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Play extends TwiML
{
    public function __construct($url = null, $attributes = [])
    {
        parent::__construct('Play', $url, $attributes);
    }

    public function setLoop($loop): self
    {
        return $this->setAttribute('loop', $loop);
    }

    public function setDigits($digits): self
    {
        return $this->setAttribute('digits', $digits);
    }
}