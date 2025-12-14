<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Echo_ extends TwiML
{
    public function __construct()
    {
        parent::__construct('Echo', null);
    }
}