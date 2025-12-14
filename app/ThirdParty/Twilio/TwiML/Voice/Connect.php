<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Connect extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Connect', null, $attributes);
    }

    public function room($name, $attributes = []): Room
    {
        return $this->nest(new Room($name, $attributes));
    }

    public function autopilot($name): Autopilot
    {
        return $this->nest(new Autopilot($name));
    }

    public function stream($attributes = []): Stream
    {
        return $this->nest(new Stream($attributes));
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