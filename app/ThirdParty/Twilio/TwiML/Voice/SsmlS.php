<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class SsmlS extends TwiML
{
    public function __construct($words)
    {
        parent::__construct('s', $words);
    }
}