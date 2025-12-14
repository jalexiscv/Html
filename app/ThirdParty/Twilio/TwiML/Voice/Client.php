<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Client extends TwiML
{
    public function __construct($identity = null, $attributes = [])
    {
        parent::__construct('Client', $identity, $attributes);
    }

    public function identity($clientIdentity): Identity
    {
        return $this->nest(new Identity($clientIdentity));
    }

    public function parameter($attributes = []): Parameter
    {
        return $this->nest(new Parameter($attributes));
    }

    public function setUrl($url): self
    {
        return $this->setAttribute('url', $url);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }

    public function setStatusCallbackEvent($statusCallbackEvent): self
    {
        return $this->setAttribute('statusCallbackEvent', $statusCallbackEvent);
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