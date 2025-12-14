<?php

namespace Twilio\TwiML\Video;

use Twilio\TwiML\TwiML;

class Room extends TwiML
{
    public function __construct($name)
    {
        parent::__construct('Room', $name);
    }
}