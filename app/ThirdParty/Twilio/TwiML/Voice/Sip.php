<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Sip extends TwiML
{
    public function __construct($sipUrl, $attributes = [])
    {
        parent::__construct('Sip', $sipUrl, $attributes);
    }

    public function setUsername($username): self
    {
        return $this->setAttribute('username', $username);
    }

    public function setPassword($password): self
    {
        return $this->setAttribute('password', $password);
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