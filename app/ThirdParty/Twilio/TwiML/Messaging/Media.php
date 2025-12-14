<?php

namespace Twilio\TwiML\Messaging;

use Twilio\TwiML\TwiML;

class Media extends TwiML
{
    public function __construct($url)
    {
        parent::__construct('Media', $url);
    }
}