<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Enqueue extends TwiML
{
    public function __construct($name = null, $attributes = [])
    {
        parent::__construct('Enqueue', $name, $attributes);
    }

    public function task($body, $attributes = []): Task
    {
        return $this->nest(new Task($body, $attributes));
    }

    public function setAction($action): self
    {
        return $this->setAttribute('action', $action);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }

    public function setWaitUrl($waitUrl): self
    {
        return $this->setAttribute('waitUrl', $waitUrl);
    }

    public function setWaitUrlMethod($waitUrlMethod): self
    {
        return $this->setAttribute('waitUrlMethod', $waitUrlMethod);
    }

    public function setWorkflowSid($workflowSid): self
    {
        return $this->setAttribute('workflowSid', $workflowSid);
    }
}