<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Task extends TwiML
{
    public function __construct($body, $attributes = [])
    {
        parent::__construct('Task', $body, $attributes);
    }

    public function setPriority($priority): self
    {
        return $this->setAttribute('priority', $priority);
    }

    public function setTimeout($timeout): self
    {
        return $this->setAttribute('timeout', $timeout);
    }
}