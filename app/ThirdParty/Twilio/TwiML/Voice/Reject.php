<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Reject extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Reject', null, $attributes);
    }

    public function setReason($reason): self
    {
        return $this->setAttribute('reason', $reason);
    }
}