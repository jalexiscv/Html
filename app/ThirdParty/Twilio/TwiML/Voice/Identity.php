<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Identity extends TwiML
{
    public function __construct($clientIdentity)
    {
        parent::__construct('Identity', $clientIdentity);
    }
}