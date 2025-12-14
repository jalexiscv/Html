<?php

namespace Twilio\TwiML;
class FaxResponse extends TwiML
{
    public function __construct()
    {
        parent::__construct('Response', null);
    }

    public function receive($attributes = []): Fax\Receive
    {
        return $this->nest(new Fax\Receive($attributes));
    }
}