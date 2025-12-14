<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Sms extends TwiML
{
    public function __construct($message, $attributes = [])
    {
        parent::__construct('Sms', $message, $attributes);
    }

    public function setTo($to): self
    {
        return $this->setAttribute('to', $to);
    }

    public function setFrom($from): self
    {
        return $this->setAttribute('from', $from);
    }

    public function setAction($action): self
    {
        return $this->setAttribute('action', $action);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }

    public function setStatusCallback($statusCallback): self
    {
        return $this->setAttribute('statusCallback', $statusCallback);
    }
}