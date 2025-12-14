<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Number extends TwiML
{
    public function __construct($phoneNumber, $attributes = [])
    {
        parent::__construct('Number', $phoneNumber, $attributes);
    }

    public function setSendDigits($sendDigits): self
    {
        return $this->setAttribute('sendDigits', $sendDigits);
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

    public function setByoc($byoc): self
    {
        return $this->setAttribute('byoc', $byoc);
    }
}