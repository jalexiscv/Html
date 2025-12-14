<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Start extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Start', null, $attributes);
    }

    public function stream($attributes = []): Stream
    {
        return $this->nest(new Stream($attributes));
    }

    public function siprec($attributes = []): Siprec
    {
        return $this->nest(new Siprec($attributes));
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