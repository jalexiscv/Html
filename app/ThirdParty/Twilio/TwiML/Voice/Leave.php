<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Leave extends TwiML
{
    public function __construct()
    {
        parent::__construct('Leave', null);
    }
}