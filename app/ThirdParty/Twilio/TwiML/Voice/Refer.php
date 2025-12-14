<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Refer extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Refer', null, $attributes);
    }

    public function sip($sipUrl): ReferSip
    {
        return $this->nest(new ReferSip($sipUrl));
    }

    public function setAction($action): self
    {
        return $this->setAttribute('action', $action);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }
}