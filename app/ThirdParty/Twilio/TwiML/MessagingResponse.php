<?php

namespace Twilio\TwiML;
class MessagingResponse extends TwiML
{
    public function __construct()
    {
        parent::__construct('Response', null);
    }

    public function message($body, $attributes = []): Messaging\Message
    {
        return $this->nest(new Messaging\Message($body, $attributes));
    }

    public function redirect($url, $attributes = []): Messaging\Redirect
    {
        return $this->nest(new Messaging\Redirect($url, $attributes));
    }
}