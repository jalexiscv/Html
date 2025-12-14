<?php

namespace SendGrid\Mail;

use JsonSerializable;

class SendAt implements JsonSerializable
{
    private $send_at;

    public function __construct($send_at = null)
    {
        if (isset($send_at)) {
            $this->setSendAt($send_at);
        }
    }

    public function setSendAt($send_at)
    {
        if (!is_int($send_at)) {
            throw new TypeException('$send_at must be of type int.');
        }
        $this->send_at = $send_at;
    }

    public function getSendAt()
    {
        return $this->send_at;
    }

    public function jsonSerialize()
    {
        return $this->getSendAt();
    }
}
