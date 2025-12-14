<?php

namespace Twilio\TwiML\Messaging;

use Twilio\TwiML\TwiML;

class Body extends TwiML
{
    public function __construct($message)
    {
        parent::__construct('Body', $message);
    }
}