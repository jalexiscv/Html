<?php

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Stop extends TwiML
{
    public function __construct()
    {
        parent::__construct('Stop', null);
    }

    public function stream($attributes = []): Stream
    {
        return $this->nest(new Stream($attributes));
    }

    public function siprec($attributes = []): Siprec
    {
        return $this->nest(new Siprec($attributes));
    }
}