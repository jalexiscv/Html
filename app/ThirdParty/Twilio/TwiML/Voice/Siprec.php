<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Siprec extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Siprec', null, $attributes);
    }

    public function parameter($attributes = []): Parameter
    {
        return $this->nest(new Parameter($attributes));
    }

    public function setName($name): self
    {
        return $this->setAttribute('name', $name);
    }

    public function setConnectorName($connectorName): self
    {
        return $this->setAttribute('connectorName', $connectorName);
    }

    public function setTrack($track): self
    {
        return $this->setAttribute('track', $track);
    }
}