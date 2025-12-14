<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Queue extends TwiML
{
    public function __construct($name, $attributes = [])
    {
        parent::__construct('Queue', $name, $attributes);
    }

    public function setUrl($url): self
    {
        return $this->setAttribute('url', $url);
    }

    public function setMethod($method): self
    {
        return $this->setAttribute('method', $method);
    }

    public function setReservationSid($reservationSid): self
    {
        return $this->setAttribute('reservationSid', $reservationSid);
    }

    public function setPostWorkActivitySid($postWorkActivitySid): self
    {
        return $this->setAttribute('postWorkActivitySid', $postWorkActivitySid);
    }
}