<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class ReferSip extends TwiML
{
    public function __construct($sipUrl)
    {
        parent::__construct('Sip', $sipUrl);
    }
}