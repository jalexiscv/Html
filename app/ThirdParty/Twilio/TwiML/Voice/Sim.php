<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Sim extends TwiML
{
    public function __construct($simSid)
    {
        parent::__construct('Sim', $simSid);
    }
}