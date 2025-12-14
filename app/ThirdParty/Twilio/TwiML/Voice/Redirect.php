<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Redirect extends TwiML
{
    public function __construct($url, $attributes = [])
    {
        parent::__construct('Redirect', $url, $attributes);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }
}