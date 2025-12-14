<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Room extends TwiML
{
    public function __construct($name, $attributes = [])
    {
        parent::__construct('Room', $name, $attributes);
    }

    public function setParticipantIdentity($participantIdentity): self
    {
        return $this->setAttribute('participantIdentity', $participantIdentity);
    }
}