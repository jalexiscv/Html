<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Stream extends TwiML
{
    public function __construct($attributes = [])
    {
        parent::__construct('Stream', null, $attributes);
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

    public function setUrl($url): self
    {
        return $this->setAttribute('url', $url);
    }

    public function setTrack($track): self
    {
        return $this->setAttribute('track', $track);
    }

    public function setStatusCallback($statusCallback): self
    {
        return $this->setAttribute('statusCallback', $statusCallback);
    }

    public function setStatusCallbackMethod($statusCallbackMethod): self
    {
        return $this->setAttribute('statusCallbackMethod', $statusCallbackMethod);
    }
}