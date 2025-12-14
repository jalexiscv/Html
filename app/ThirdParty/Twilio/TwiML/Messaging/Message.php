<?php

namespace Twilio\TwiML\Messaging;

use Twilio\TwiML\TwiML;

class Message extends TwiML
{
    public function __construct($body, $attributes = [])
    {
        parent::__construct('Message', $body, $attributes);
    }

    public function body($message): Body
    {
        return $this->nest(new Body($message));
    }

    public function media($url): Media
    {
        return $this->nest(new Media($url));
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