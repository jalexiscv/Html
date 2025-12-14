<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlP extends TwiML
{
    public function __construct($words)
    {
        parent::__construct('p', $words);
    }
}