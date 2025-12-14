<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Autopilot extends TwiML
{
    public function __construct($name)
    {
        parent::__construct('Autopilot', $name);
    }
}