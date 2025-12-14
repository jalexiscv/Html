<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Hangup extends TwiML
{
    public function __construct()
    {
        parent::__construct('Hangup', null);
    }
}